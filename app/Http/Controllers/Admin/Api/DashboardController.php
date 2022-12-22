<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Configurations;
use App\Models\User;
use App\Rules\ValidateUserCurrentPassword;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Rules\ValidateGuid;
use Illuminate\Support\Facades\Hash;

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
            'user_guid' => ['required', 'uuid', new ValidateGuid('users','id')],
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
}
