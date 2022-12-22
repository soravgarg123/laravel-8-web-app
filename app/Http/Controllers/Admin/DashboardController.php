<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    /**
	 * Function Name: dashboard
	 * Description:   To admin dashboard
	 */
    public function index()
    {
        $data['title']  = "Dashboard";
		$data['module'] = "dashboard";
		$data['js']     =  array(
								'../assets/admin/js/custom/dashoard.js'
							);
        $data['statics']['total_success_orders'] = DB::table('orders')->where('order_status', "Success")->count();
        $data['statics']['total_failed_orders']  = DB::table('orders')->where('order_status', "Failed")->count();
        return view('admin/dashboard/dashboard')->with($data);
    }

    /**
	 * Function Name: edit_profile
	 * Description:   To edit profile view
	 */
	public function edit_profile()
	{
		$data['title']  = "Edit Profile";
		$data['module'] = "profile";
		$data['css']   = array(
							'../assets/admin/vendors/chosen_v1.4.2/chosen.min.css'
						);
		$data['js']    = array(
			                '../assets/admin/vendors/chosen_v1.4.2/chosen.jquery.min.js',
							'../assets/admin/js/custom/dashoard.js'
						);	

		/* To Get My Profile Details */
        $data['details'] = DB::table('users')->select('user_guid','name', 'email', 'phone_number', 'gender')->where('id', session()->get('admin_user')['user_id'])->first();
        return view('admin/dashboard/edit-profile')->with($data);
	}

    /**
     * Function Name: logout
     * Description:   To admin logout
     */
    public function logout($login_session_key = NULL)
    {
        /* Delete Session Key */
        if(!empty($login_session_key)){
            DB::table('users')->where('remember_token', $login_session_key)->update(['remember_token' => NULL, 'last_activity' => NULL]);
        }

        /* Destroy Session */
        Session::forget('admin_user');
        Session::forget('configurations');
        session()->flash('logout', 'Yes');
        return redirect('admin/login');
    }


}
