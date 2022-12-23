<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configurations;
use App\Models\Orders;
use Illuminate\Support\Facades\Config;

class OrdersController extends Controller
{
    /**
	 * Function Name: list
	 * Description:   To view orders list
	*/
	public function list()
	{
		$data['title'] = 'Orders';
		$data['module']= "orders";
		$data['css']   = array(
							'../../assets/admin/css/dataTables.bootstrap.min.css'
						);
		$data['js']    = array(
							'../../assets/admin/js/jquery.dataTables.min.js',
							'../../assets/admin/js/dataTables.bootstrap.min.js',
							'../../assets/admin/js/custom/orders.js'
						);	

		/* Get Orders */
        $data['orders'] = Orders::select('order_id','order_guid', 'name', 'email', 'phone_number', 'zip_code', 'amount', 'currency', 'stripe_transaction_id', 'order_status', 'created_at')->orderBy('order_id', 'DESC')->get()->toArray();
		return view('admin/orders/list')->with($data);
	}

	/**
	 * Function Name: details
	 * Description:   To view order details
	*/
	public function details($order_guid) 
	{
		$data['title']  = 'View Order Details';
		$data['module'] = "orders";
		$data['css']   = array(
							'../../../assets/admin/vendors/bower_components/lightgallery/src/css/lightgallery.css'
						);
		$data['js']     = array(
							'../../../assets/admin/vendors/bower_components/lightgallery/src/js/lightgallery.js',
							'../../../assets/admin/js/custom/orders.js'
						);

		/*  To check order guid */
		$details = Orders::where('order_guid', $order_guid)->first();
		if(empty($details)){
			session()->flash('error', 'Order details not found !!');
			return redirect('admin/orders/list');
		}

		/* To Get Order Details */
        $data['details'] = $details;
		$data['max_amount_limit'] = Config::get('app.max_amount_limit');

        /* Get Configuration */
		$data['configurations'] = array_column(Configurations::where('configuration_name', 'stripe_currency')->get()->toArray(), 'configuration_value', 'configuration_name');
		return view('admin/orders/view-details')->with($data);
	}
}
