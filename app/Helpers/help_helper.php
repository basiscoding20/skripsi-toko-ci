<?php

use Config\Database;

if (! function_exists('unique_slug'))
{
	function unique_slug($string,$table,$field='slug',$key=NULL,$value=NULL)
	{
	    $t = Database::connect();
	    $slug = url_title($string, '-', TRUE);
	    $slug = strtolower($slug);
	    $i = 0;
	    $params = array ();
	    $params[$field] = $slug;
	 
	    if($key){ $params["$key !="] = $value; }
	    while ($t->table($table)->where($params)->countAllResults())
	    {   
	        if (!preg_match ('/-{1}[0-9]+$/', $slug )){
	            $slug .= '-' . ++$i;
	        }
	        else{
	            $slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
	        }
	         
	        $params [$field] = $slug;
	    }   
	    return $slug;   
	}
}

if (! function_exists('notif'))
{
	function notif()
	{
	    $t = Database::connect();

		$order_id = array();
		if(in_groups(['seller'])){
			$orderDetails = $t->table('order_details')->select('order_details.*, users.name as seller, products.seller_id')
						 ->join('products', 'products.id = order_details.product_id')
						 ->join('users', 'users.id = products.seller_id')
						 ->where('order_details.deleted_at IS NULL')
						 ->where('products.seller_id', user()->id)
						 ->get()->getResult();
			if(@count($orderDetails)>0){
				foreach ($orderDetails as $row) {
					array_push($order_id, $row->order_id);
				}
			}
		}

		$order = $t->table('orders')->select('orders.*, users.name as customer')
					  ->join('users', 'users.id = orders.user_id')
					  ->where('orders.deleted_at IS NULL');
		if(in_groups(['user'])){
			$order = $order->where('orders.user_id', user()->id)->whereIn('orders.status', array('order','receive'));
		}
		if(in_groups(['seller'])){
			if(@count($order_id)>0){
				$order = $order->whereIn('orders.id', $order_id)->whereIn('orders.status', array('paid','receive'));
			}
		}
		if(in_groups(['kurir', 'teknisi'])){
			$order = $order->where('orders.kurir_teknisi', user()->id)->where('orders.status', 'on progress');
		}
		if(in_groups(['admin'])){
			$order = $order->whereIn('orders.status', array('order','paid'));
		}
		$orders = $order->limit(3)->orderBy('id', 'DESC')->get()->getResult();
	    return $orders;   
	}
}

if (! function_exists('notifcount'))
{
	function notifcount()
	{
	    $t = Database::connect();

		$order_id = array();
		if(in_groups(['seller'])){
			$orderDetails = $t->table('order_details')->select('order_details.*, users.name as seller, products.seller_id')
						 ->join('products', 'products.id = order_details.product_id')
						 ->join('users', 'users.id = products.seller_id')
						 ->where('order_details.deleted_at IS NULL')
						 ->where('products.seller_id', user()->id)
						 ->get()->getResult();
			if(@count($orderDetails)>0){
				foreach ($orderDetails as $row) {
					array_push($order_id, $row->order_id);
				}
			}
		}

		$order = $t->table('orders')->select('orders.*, users.name as customer')
					  ->join('users', 'users.id = orders.user_id')
					  ->where('orders.deleted_at IS NULL');
		if(in_groups(['user'])){
			$order = $order->where('orders.user_id', user()->id)->whereIn('orders.status', array('order','receive'));
		}
		if(in_groups(['seller'])){
			if(@count($order_id)>0){
				$order = $order->whereIn('orders.id', $order_id)->whereIn('orders.status', array('paid','receive'));
			}
		}
		if(in_groups(['kurir', 'teknisi'])){
			$order = $order->where('orders.kurir_teknisi', user()->id)->where('orders.status', 'on progress');
		}
		if(in_groups(['admin'])){
			$order = $order->whereIn('orders.status', array('order','paid'));
		}
		$orders = $order->countAllResults();
	    return $orders;   
	}
}

if (! function_exists('statusicon'))
{
	function statusicon($status="")
	{
		if($status == 'order'){
			$icon = 'fa-file-alt';
			$color = 'primary';
		}elseif($status == 'paid'){
			$icon = 'fa-donate';
			$color = 'info';
		}elseif($status == 'on progress'){
			$icon = 'fa-spinner';
			$color = 'warning';
		}elseif($status == 'receive'){
			$icon = 'fa-inbox';
			$color = 'success';
		}elseif($status == 'completed'){
			$icon = 'fa-check-square-o';
			$color = 'success';
		}elseif($status == 'rejected'){
			$icon = 'fa-times';
			$color = 'danger';
		}else{
			$icon = 'fa-file-alt';
			$color = 'dark';
		}
		$result = [
			'icon' => $icon,
			'color'	=> $color
		];

	    return $result;   
	}
}

if (! function_exists('changeorder'))
{
	function changeorder($status="")
	{
		$result = false;
		if(in_groups(['seller']) && in_array($status, array('paid','receive'))){
			$result = true;
		}elseif(in_groups(['user']) && in_array($status, array('order','receive'))){
			$result = true;
		}elseif(in_groups(['kurir', 'teknisi']) && in_array($status, array('on progress'))){
			$result = true;
		}
	    return $result;   
	}
}

if (! function_exists('choicestatus'))
{
	function choicestatus($status="")
	{
		$result = array();
		if(in_groups(['user']) && in_array($status, array('order','receive'))){
			if($status == 'order'){
				array_push($result, 'order');
				array_push($result, 'paid');
				array_push($result, 'rejected');
			}elseif($status == 'receive'){
				array_push($result, 'receive');
				array_push($result, 'completed');
				array_push($result, 'rejected');
			}
		}elseif(in_groups(['seller']) && in_array($status, array('paid','receive'))){
			if($status == 'paid'){
				array_push($result, 'paid');
				array_push($result, 'on progress');
				array_push($result, 'rejected');
			}elseif($status == 'receive'){
				array_push($result, 'receive');
				array_push($result, 'completed');
				array_push($result, 'rejected');
			}
		}elseif(in_groups(['kurir']) && in_array($status, array('on progress'))){
			array_push($result, 'on progress');
			array_push($result, 'receive');
			array_push($result, 'rejected');
		}elseif(in_groups(['teknisi']) && in_array($status, array('on progress'))){
			array_push($result, 'on progress');
			array_push($result, 'completed');
			array_push($result, 'rejected');
		}
	    return $result;   
	}
}

if (! function_exists('orderreport'))
{
	function orderreport($status="")
	{
	    $t = Database::connect();

		$order_id = array();
		if(in_groups(['seller'])){
			$orderDetails = $t->table('order_details')->select('order_details.*, users.name as seller, products.seller_id')
						 ->join('products', 'products.id = order_details.product_id')
						 ->join('users', 'users.id = products.seller_id')
						 ->where('order_details.deleted_at IS NULL')
						 ->where('products.seller_id', user()->id)
						 ->get()->getResult();
			if(@count($orderDetails)>0){
				foreach ($orderDetails as $row) {
					array_push($order_id, $row->order_id);
				}
			}
		}

		$order = $t->table('orders')->select('orders.*, users.name as customer')
					  ->join('users', 'users.id = orders.user_id')
					  ->where('orders.deleted_at IS NULL');
		if(in_groups(['user'])){
			$order = $order->where('orders.user_id', user()->id);
		}
		if(in_groups(['seller'])){
			if(@count($order_id)>0){
				$order = $order->whereIn('orders.id', $order_id);
			}
		}
		if(in_groups(['kurir', 'teknisi'])){
			$order = $order->where('orders.kurir_teknisi', user()->id);
		}
		if($status){
			$order = $order->where('orders.status', $status);
		}
		$orders = $order->get()->getResult();
		$countorder = @count($orders);
		$total = 0;
		if($countorder>0){
			foreach ($orders as $row) {
				$total += $row->total;
			}
		}
		$data = [
			"total" => "Rp".number_format($total,0,",","."),
			"count" => $countorder,
		];
	    return $data;   
	}
}
