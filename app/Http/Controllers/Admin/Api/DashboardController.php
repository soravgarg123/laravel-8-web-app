<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Configurations;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
}
