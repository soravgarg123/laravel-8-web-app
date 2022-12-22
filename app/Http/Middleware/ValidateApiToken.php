<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ValidateApiToken
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
        /**
         * @var mixed $Headers
         */
        $Headers = $request->header();
        if(empty($Headers['authorization'])){
            return response()->json(['status'=> 502,'message' => 'Auth Token Missing'], 502);
        }

        $login_session_key = $Headers['authorization'];
        $user_data = DB::table('users')->select('id','user_status', 'last_activity')->where('remember_token', $login_session_key)->first();
        if(empty($user_data)){
			return response()->json(['status'=> 502,'message' => 'Session disconnected, please re-login.'], 502);
		}elseif ($user_data && $user_data->user_status == 'Pending') {
            return response()->json(['status'=> 502,'message' => 'You have not activated your account yet, please verify your email address first.'], 502);
        }elseif ($user_data && $user_data->user_status == 'Blocked') {
            return response()->json(['status'=> 502,'message' => 'Your account has been blocked. Please contact the Admin for more info.'], 502);
        }elseif($user_data && (strtotime(date('Y-m-d H:i:s')) - strtotime($user_data->last_activity)) >= (Config::get('app.session_expiration_hours') * 3600)){
        	return response()->json(['status'=> 502,'message' => 'Session expired, please re-login.'], 502);
        }

        $request->merge(['user_id' => $user_data->id]);

        /* Update Last Activity */
        DB::table('users')->where('id', $user_data->id)->update(['last_activity' => date('Y-m-d H:i:s')]);
        
        return $next($request);

    }
}
