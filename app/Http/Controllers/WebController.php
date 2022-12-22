<?php

namespace App\Http\Controllers;

use App\Models\Configurations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class WebController extends Controller
{
        /**
         * Function Name: index
         * Description:   To view payment form
         */
        public function index()
        {
                /* Get Configs */
                $data['configurations']   = array_column(Configurations::whereIn('configuration_name', array('stripe_mode', 'stripe_currency', 'stripe_publishable_key', 'website_name', 'website_logo'))->get()->toArray(), 'configuration_value', 'configuration_name');
                $data['max_amount_limit'] = Config::get('app.max_amount_limit');
                return view('front/index')->with($data);
        }
}
