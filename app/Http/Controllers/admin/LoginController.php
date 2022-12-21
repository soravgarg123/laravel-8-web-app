<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /**
     * Function Name: index
     * Description:   To admin login view
     */
    public function index()
    {
        $data = array('title' => 'Admin Login');

        /* Get Configuration */
        $data['configurations'] = array_column(DB::table('configurations')->whereIn('configuration_name', array('website_name', 'website_logo'))->get()->toArray(), 'configuration_value', 'configuration_name');
        return view('admin/login')->with($data);
    }

    /**
     * Function Name: login
     * Description:   To admin login
     */
    public function login(Request $request)
    {
        /* Validate Request */
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        /* Check Login Details In DB */
        $user_data = DB::table('users')->select('id','user_guid','user_type_id','password','user_status')->where('email', $data['email'])->first();
        if(empty($user_data) || !Hash::check($data['password'], $user_data->password)){
            return Redirect::back()->withErrors(['message' => 'Invalid login credentials.']);
        } elseif ($user_data && $user_data->user_status == 'Pending') {
            return Redirect::back()->withErrors(['message' => 'You have not activated your account yet, please verify your email address first.']);
        }elseif ($user_data && $user_data->user_status == 'Blocked') {
            return Redirect::back()->withErrors(['message' => 'Your account has been blocked. Please contact the Admin for more info..']);
        }elseif ($user_data && $user_data->user_type_id != 1) {
            return Redirect::back()->withErrors(['message' => 'Access restricted.']);
        } else {

            /* Update Data */
            $remember_token = get_guid();
            DB::table('users')->where('id', $user_data->id)->update([
                                            'remember_token' => $remember_token, 
                                            'last_login' => date('Y-m-d H:i:s'),
                                            'last_activity' => date('Y-m-d H:i:s')
                                        ]);

            /* Manage Response Data */
            $session_data = array();
            $session_data['login_session_key'] = $remember_token;
            $session_data['user_id']           = $user_data->id;
            $session_data['user_guid']         = $user_data->user_guid;
            $session_data['last_login']        = date('Y-m-d H:i:s');

            /* Set User Session */
            $request->session()->put('admin_user', $session_data);

            /* Get Configuration */
            $configurations = array_column(DB::table('configurations')->whereIn('configuration_name', array('website_name', 'website_logo'))->get()->toArray(), 'configuration_value', 'configuration_name');

            /* Set Configurations Session */
            $request->session()->put('configurations', $configurations);
            
            session()->flash('login_success', 'Logged-in successfully');
            return redirect('/admin/dashboard');
        }
    }
}
