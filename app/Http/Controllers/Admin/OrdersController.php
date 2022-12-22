<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;

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
        $data['orders'] = Orders::select('order_id', 'name', 'email', 'phone_number', 'zip_code', 'amount', 'currency', 'stripe_transaction_id', 'order_status', 'created_at')->orderBy('order_id', 'DESC')->get()->toArray();
		return view('admin/orders/list')->with($data);
	}
}
