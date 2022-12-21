<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoggedInUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!session()->has('admin_user')){
            return redirect('admin/login');
        }

        /* To Cross Check User Login Session */
		$IsActive = "Yes";
        $login_session_key = Session::get('admin_user')['login_session_key'];
        $user_data = DB::table('users')->select('id','user_status', 'last_activity')->where('remember_token', $login_session_key)->first();
        if(empty($user_data)){
			Session::put('error','Session disconnected, please login.');
			$IsActive = "No";
		}elseif ($user_data && $user_data->user_status == 'Pending') {
            Session::put('error',"You have not activated your account yet, please verify your email address first.");
            $IsActive = "No";
        }elseif ($user_data && $user_data->user_status == 'Blocked') {
            Session::put('error',"Your account has been blocked. Please contact the Admin for more info.");
            $IsActive = "No";
        }elseif($user_data && (strtotime(date('Y-m-d H:i:s')) - strtotime($user_data->last_activity)) >= (Config::get('app.session_expiration_hours') * 3600)){
        	Session::put('error','Session disconnected, please login.');
            $IsActive = "No";
        }

        /* Is User Active */
        if($IsActive == 'No'){

        	/* Delete Session Key */
			if(!empty($login_session_key)){
                DB::table('users')->where('id', $user_data->id)->update(['remember_token' => NULL, 'last_activity' => NULL]);
			}
			
            /* Destroy Session */
        	Session::forget('admin_user');
        	Session::forget('configurations');
            session()->flash('logout', 'Yes');
        	return redirect('admin/login');
        }

        /* Update Last Activity */
        DB::table('users')->where('id', $user_data->id)->update(['last_activity' => date('Y-m-d H:i:s')]);

        return $next($request);
    }
}
