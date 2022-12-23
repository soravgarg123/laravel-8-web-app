<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Configurations;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Str;
use Stripe\StripeClient;

class UserController extends Controller
{
    /**
	 * Function Name: payment
	 * Description:   To submit user payment
	 */
    public function payment(Request $request)
    {
        /* Validate Request */
        $validator = Validator::make($request->post(), [
            'name'         => 'required',
            'email'        => 'required|email',
            'phone_number' => 'required',
            'amount'       => 'required|integer|min:1|max:'.Config::get('app.max_amount_limit'),
            'account_no'   => 'required',
            'stripe_token' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                    'status' => 500, 
                    'message' => $validator->errors()->first()
                ], 200);
        }

        /* Get Configs */
        $configurations = array_column(Configurations::all()->toArray(), 'configuration_value', 'configuration_name');

        /* Stripe Client */
        $stripe = new StripeClient($configurations['stripe_secret_key']);

        /* Stripe Charge Payment */
        try {

            /* Create Customer */
            $customer = $stripe->customers->create([
                'name' => $request->post('name'),
                'email' => $request->post('email'),
                'phone' => $request->post('phone_number'),
                'source' => $request->post('stripe_token')
            ]);
            $resposnse_json_ecoded = json_encode($customer);
            $customer_response = json_decode($resposnse_json_ecoded, true);

            /* Make Payment */
            $charge = $stripe->charges->create([
                'amount' => $request->post('amount') * 100,
                'customer' => $customer_response['id'],
                'currency' => $configurations['stripe_currency'],
                'description' => $configurations['description'],
                'statement_descriptor' => $configurations['statement_descriptor']
            ]);
            $resposnse_json_ecoded = json_encode($charge);
            $stripe_response = json_decode($resposnse_json_ecoded, true);

            /* Insert Order */
            $order = new Orders();
            $order->order_guid = get_guid();
            $order->name = $request->post('name');
            $order->email = $request->post('email');
            $order->phone_number = $request->post('phone_number');
            $order->zip_code = $stripe_response['source']['address_zip'];
            $order->amount = $request->post('amount');
            $order->currency = Str::upper($stripe_response['currency']);
            $order->account_no = $request->post('account_no');
            $order->client_ip = $request->post('client_ip');
            $order->stripe_token = $request->post('stripe_token');
            $order->stripe_transaction_id = $stripe_response['id'];
            $order->stripe_payload = $resposnse_json_ecoded;
            $order->order_status = ($stripe_response['status'] == 'succeeded') ? 'Success' : 'Failed';
            $order->created_at = date('Y-m-d H:i:s');
            $order->save();

            /* Return Success */
            return response()->json([
                'status' => 200, 
                'message' => $request->post('amount').' '.Str::upper($stripe_response['currency']).' payment succeeded'
            ], 200);

        } catch (Exception $e) {

            /* Return Response */
            return response()->json([
                'status' => 500, 
                'message' => $e->getMessage()
            ], 200);
        }
    }
}
