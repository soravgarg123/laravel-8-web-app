<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Configurations;
use App\Models\Orders;
use App\Models\User;
use App\Rules\ValidateUserCurrentPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Rules\ValidateGuid;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Str;
use Stripe\StripeClient;

class DashboardController extends Controller
{
    /**
	 * Function Name: update_configurations
	 * Description:   To update configuration
	 */
    public function update_configurations(Request $request)
    {
        /* Validate Request */
        $validator = Validator::make($request->post(), [
            'stripe_mode'     => ['required', Rule::in(['Test', 'Production'])],
            'stripe_currency' => 'required',
            'stripe_publishable_key' => 'required',
            'stripe_secret_key' => 'required',
            'statement_descriptor' => 'required|min:1|max:22',
            'description' => 'required',
            'website_name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                    'status' => 500, 
                    'message' => $validator->errors()->first()
                ], 200);
        }

        /* Validate Image Extension */
        if($request->file('image')){
            $img_validator = Validator::make($request->file(), [
                'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048'
            ]);
            if ($img_validator->fails()) {
                return response()->json([
                    'status' => 500, 
                    'message' => $img_validator->errors()->first()
                ], 200);
            }

            /* Upload Image */
            try {
                $file = $request->file('image');
                $request['website_logo'] = time().".".$request->file('image')->getClientOriginalExtension();
                $file->move(public_path('uploads/logo'),$request['website_logo']);
            } catch (Exception $e) {
                return response()->json([
                    'status' => 500, 
                    'message' => 'Failed to upload website logo'
                ], 200);
            }
        }

        /* Update batch */
        foreach($request->post() as $configuration_name => $configuration_value){
            Configurations::where('configuration_name', '=', $configuration_name)->update(['configuration_value' => $configuration_value]);
        }

        /* Re-Set Configurations Session */
        session()->put('configurations.website_name', $request->post('website_name'));
        
        /* Return Success */
        return response()->json([
            'status' => 200, 
            'message' => "Configurations updated successfully."
        ], 200);
    }

    /**
	 * Function Name: update_profile
	 * Description:   To update user profile
	 */
    public function update_profile(Request $request)
    {
        /* Validate Request */
        $validator = Validator::make($request->post(), [
            'user_guid' => ['required', 'uuid'],
            'name'      => 'required',
            'gender'    => ['required', Rule::in(['Male', 'Female', 'Other'])],
            'email'     => 'required|email',
            'phone_number' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                    'status' => 500, 
                    'message' => $validator->errors()->first()
                ], 200);
        }

        /* Update user */
        User::where('id', '=', $request->post('user_id'))->update([
                                    'name' => $request->post('name'),
                                    'gender' => $request->post('gender'),
                                    'email' => $request->post('email'),
                                    'phone_number' => $request->post('phone_number')
                                ]);

        /* Return Success */
        return response()->json([
            'status' => 200, 
            'message' => "Profile details updated successfully."
        ], 200);
    }

    /**
	 * Function Name: change_password
	 * Description:   To admin change password
	 */
    public function change_password(Request $request)
    {
        /* Validate Request */
        $validator = Validator::make($request->post(), [
            'current_password' => ['required', new ValidateUserCurrentPassword($request->post('user_id'))],
            'new_password'     => 'required|min:6|different:current_password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                    'status' => 500, 
                    'message' => $validator->errors()->first()
                ], 200);
        }

        /* Update user */
        User::where('id', '=', $request->post('user_id'))->update(['password' => Hash::make($request->post('new_password'))]);

        /* Return Success */
        return response()->json([
            'status' => 200, 
            'message' => "Password changed successfully."
        ], 200);
    }

    /**
	 * Function Name: reprocess_payment
	 * Description:   To re-process customer payment
	 */
    public function reprocess_payment(Request $request)
    {
        /* Validate Request */
        $validator = Validator::make($request->post(), [
            'order_guid' => ['required', 'uuid', new ValidateGuid('orders','order_id')],
            'amount'     => 'required|integer|min:1|max:'.Config::get('app.max_amount_limit'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                    'status' => 500, 
                    'message' => $validator->errors()->first()
                ], 200);
        }
        $order_id = session()->get('order_id');

        /* Get Configs */
        $configurations = array_column(Configurations::all()->toArray(), 'configuration_value', 'configuration_name');

        /*  To check order guid */
		$order_details = Orders::where('order_id', $order_id)->first();
        $stripe_payload = json_decode($order_details['stripe_payload'], TRUE);

        /* Stripe Client */
        $stripe = new StripeClient($configurations['stripe_secret_key']);
        
        /* Stripe Charge Payment */
        try {

            /* Make New Payment */
            $charge = $stripe->charges->create([
                'amount' => $request->post('amount') * 100,
                'customer' => $stripe_payload['customer'],
                'currency' => $configurations['stripe_currency'],
                'description' => 'Renew - '.$configurations['description'],
                'statement_descriptor' => $configurations['statement_descriptor']
            ]);
            $resposnse_json_ecoded = json_encode($charge);
            $stripe_response = json_decode($resposnse_json_ecoded, true);

            /* Insert Order */
            $order_guid = get_guid();
            $order = new Orders();
            $order->order_guid = $order_guid;
            $order->name = $order_details['name'];
            $order->email = $order_details['email'];
            $order->phone_number = $order_details['phone_number'];
            $order->zip_code = $stripe_response['source']['address_zip'];
            $order->amount = $request->post('amount');
            $order->currency = Str::upper($stripe_response['currency']);
            $order->account_no = $order_details['account_no'];
            $order->client_ip = $order_details['client_ip'];
            $order->stripe_transaction_id = $stripe_response['id'];
            $order->stripe_payload = $resposnse_json_ecoded;
            $order->order_status = ($stripe_response['status'] == 'succeeded') ? 'Success' : 'Failed';
            $order->reprocessed_by = $request->post('user_id');
            $order->created_at = date('Y-m-d H:i:s');
            $order->save();

            /* Return Success */
            return response()->json([
                'status' => 200, 
                'data' => array('order_guid' => $order_guid),
                'message' => $request->post('amount').' '.Str::upper($stripe_response['currency']).' amount re-processed successfully'
            ], 200);

        } catch (Exception $e) {

            /* Return Response */
            return response()->json([
                'status' => 500, 
                'message' => $e->getMessage()
            ], 200);
        }

        /* Return Success */
        return response()->json([
            'status' => 200, 
            'data' => $order_id,
            'message' => "Password changed successfully."
        ], 200);
    }
}
