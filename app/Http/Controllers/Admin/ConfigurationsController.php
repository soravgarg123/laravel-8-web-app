<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configurations;

class ConfigurationsController extends Controller
{
    /**
	 * Function Name: index
	 * Description:   To manage admin configurations
	 */
    public function index() 
	{
		$data['title'] = "Configurations";
		$data['module']= "configurations";
		$data['css']   = array(
							'../assets/admin/vendors/chosen_v1.4.2/chosen.min.css'
						);
		$data['js']     = array(
							'../assets/admin/vendors/chosen_v1.4.2/chosen.jquery.min.js',
							'../assets/admin/vendors/fileinput/fileinput.min.js',
							'../assets/admin/js/custom/configurations.js'
						);

		/* Get Configs */
        $data['configurations'] = array_column(Configurations::all()->toArray(), 'configuration_value', 'configuration_name');
		return view('admin/configurations/list')->with($data);
	}
}
