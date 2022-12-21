<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $data['website_name'] = session('configurations')['website_name'];
		$data['js']     =  array(
								'../assets/admin/js/custom/dashoard.js'
							);
        $data['statics']['total_success_orders'] = DB::table('orders')->where('order_status', "Success")->count();
        $data['statics']['total_failed_orders']  = DB::table('orders')->where('order_status', "Failed")->count();
        return view('admin/dashboard/dashboard')->with($data);
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