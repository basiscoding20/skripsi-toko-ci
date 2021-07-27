<?php

namespace App\Controllers\Back;
use App\Controllers\BaseController;

class OrderController extends BaseController
{
	public function __construct(){
		//
	}
	
	public function index($list = "")
	{
		if(!in_groups(['admin', 'seller', 'user', 'kurir', 'teknisi'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}

		$orderDetail = $this->orderDetailModel->select('order_details.*, users.name as seller, products.seller_id')
					 ->join('products', 'products.id = order_details.product_id')
					 ->join('users', 'users.id = products.seller_id')
					 ->where('order_details.deleted_at IS NULL');
		if($list){
			$orderDetail = $orderDetail->where('products.type', $list)->where('order_details.type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		if(in_groups(['seller'])){
			$orderDetail = $orderDetail->where('products.seller_id', user()->id);
		}
		$orderDetails = $orderDetail->get()->getResult();
		$order_id = array();
		if(@count($orderDetails)>0){
			foreach ($orderDetails as $row) {
				array_push($order_id, $row->order_id);
			}
		}

		$order = $this->orderModel->select('orders.*, users.name as customer, users.address as customer_address, users.phone as customer_phone, users.email as customer_email, users.nik as customer_nik')
					  ->join('users', 'users.id = orders.user_id')
					  ->where('orders.deleted_at IS NULL');
		if(in_groups(['user'])){
			$order = $order->where('orders.user_id', user()->id);
		}
		if(in_groups(['kurir', 'teknisi'])){
			$order = $order->where('orders.kurir_teknisi', user()->id)->where('orders.status', 'on progress');
		}
		if(in_groups(['seller'])){
			if(@count($order_id)>0){
				$order = $order->whereIn('orders.id', $order_id);
			}
		}
		if($list){
			$order = $order->where('orders.status !=', 'completed');
			if(@count($order_id)>0){
				$order = $order->whereIn('orders.id', $order_id);
			}else{
				$order = $order->where('orders.id', 0);
			}
		}else{
			$order = $order->where('orders.status', 'completed');
		}
		$orders = $order->orderBy('orders.id', 'DESC')->get()->getResult();
		$data = [
			"title" => "Data Order ".ucwords($list),
			"orders" => $orders,
			"list" => $list,
		];
		return view('back/orders/index', $data);
	}
	
	public function show($id = 0, $list = "")
	{
		if(!in_groups(['admin', 'seller', 'user', 'kurir', 'teknisi'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}

		$orderDetail = $this->orderDetailModel->select('order_details.*, users.name as seller, products.seller_id, products.photo, products.title')
					 ->join('products', 'products.id = order_details.product_id')
					 ->join('users', 'users.id = products.seller_id')
					 ->where('order_details.deleted_at IS NULL')
					 ->where('order_details.order_id', $id);
		if($list){
			$orderDetail = $orderDetail->where('products.type', $list)->where('order_details.type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		if(in_groups(['seller'])){
			$orderDetail = $orderDetail->where('products.seller_id', user()->id);
		}
		$orderDetails = $orderDetail->get()->getResult();
		$order_id = array(); $seller_id = array();
		if(@count($orderDetails)>0){
			foreach ($orderDetails as $row) {
				array_push($order_id, $row->order_id);
				array_push($seller_id, $row->seller_id);
			}
		}

		$order = $this->orderModel->select('orders.*, users.name as customer, users.address as customer_address, users.phone as customer_phone, users.email as customer_email, users.nik as customer_nik')
					  ->join('users', 'users.id = orders.user_id')
					  ->where('orders.deleted_at IS NULL')
					  ->where('orders.id', $id);
		if(in_groups(['user'])){
			$order = $order->where('orders.user_id', user()->id);
		}
		if(in_groups(['kurir', 'teknisi'])){
			$order = $order->where('orders.kurir_teknisi', user()->id)->where('orders.status', 'on progress');
		}
		if(in_groups(['seller'])){
			if(@count($order_id)>0){
				$order = $order->whereIn('orders.id', $order_id);
			}
		}
		if($list){
			if(@count($order_id)>0){
				$order = $order->whereIn('orders.id', $order_id);
			}else{
				$order = $order->where('orders.id', 0);
			}
		}
		$orders = $order->get()->getRow();

		$user = $this->userModel->select('users.*, auth_groups.name as rolename')
					 ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
					 ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
		if(@count($seller_id)>0){
			$user = $user->whereIn('users.id', $seller_id);
		}else{
			$user = $user->where('users.id', 2);
		}
		$users = $user->findAll();

		$orderDtl = $this->orderDetailModel->select('order_details.*, users.name as seller, products.seller_id, products.photo, products.title')
					 ->join('products', 'products.id = order_details.product_id')
					 ->join('users', 'users.id = products.seller_id')
					 ->where('order_details.deleted_at IS NULL')
					 ->where('order_details.order_id', $id);
		if($list){
			$orderDtl = $orderDtl->where('products.type', $list)->where('order_details.type', $list);
		}
		$orderDtls = $orderDtl->get()->getResult();
		if(@count($orderDtls)==0){
			return redirect()->to('/dashboard/order/'.$list)->with('error', 'Data not found.');
		}
		$data = [
			"title" => "Show Data Order ".ucwords($list),
			"orders" => $orders,
			"id" => $id,
			"seller" => $users,
			"orderDetails" => $orderDtls,
			"list" => $list,
		];
		return view('back/orders/show', $data);
	}
	
	public function edit($id = 0, $list = "")
	{
		if(!in_groups(['seller', 'user', 'kurir', 'teknisi'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}

		$orderDetail = $this->orderDetailModel->select('order_details.*, users.name as seller, products.seller_id, products.photo, products.title')
					 ->join('products', 'products.id = order_details.product_id')
					 ->join('users', 'users.id = products.seller_id')
					 ->where('order_details.deleted_at IS NULL')
					 ->where('order_details.order_id', $id);
		if($list){
			$orderDetail = $orderDetail->where('products.type', $list)->where('order_details.type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		if(in_groups(['seller'])){
			$orderDetail = $orderDetail->where('products.seller_id', user()->id);
		}
		$orderDetails = $orderDetail->get()->getResult();
		$order_id = array(); $seller_id = array();
		if(@count($orderDetails)>0){
			foreach ($orderDetails as $row) {
				array_push($order_id, $row->order_id);
				array_push($seller_id, $row->seller_id);
			}
		}

		$order = $this->orderModel->select('orders.*, users.name as customer, users.address as customer_address, users.phone as customer_phone, users.email as customer_email, users.nik as customer_nik')
					  ->join('users', 'users.id = orders.user_id')
					  ->where('orders.deleted_at IS NULL')
					  ->where('orders.id', $id);
		if(in_groups(['user'])){
			$order = $order->where('orders.user_id', user()->id);
		}
		if(in_groups(['kurir', 'teknisi'])){
			$order = $order->where('orders.kurir_teknisi', user()->id)->where('orders.status', 'on progress');
		}
		if(in_groups(['seller'])){
			if(@count($order_id)>0){
				$order = $order->whereIn('orders.id', $order_id);
			}
		}
		if($list){
			if(@count($order_id)>0){
				$order = $order->whereIn('orders.id', $order_id);
			}else{
				$order = $order->where('orders.id', 0);
			}
		}
		$orders = $order->get()->getRow();
		$status = changeorder($orders->status);
		if($status == false){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}

		$user = $this->userModel->select('users.*, auth_groups.name as rolename')
					 ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
					 ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
		if(@count($seller_id)>0){
			$user = $user->whereIn('users.id', $seller_id);
		}else{
			$user = $user->where('users.id', 2);
		}
		$users = $user->findAll();

		$orderkurtek = $this->orderModel->select('orders.*, users.name as customer, users.address as customer_address, users.phone as customer_phone, users.email as customer_email, users.nik as customer_nik')
					  ->join('users', 'users.id = orders.user_id')
					  ->where('orders.deleted_at IS NULL')
					  ->where('orders.status', 'on progress')
					  ->get()->getResult();
		$idkurtek = array();
		if(@count($orderkurtek)>0){
			foreach ($orderkurtek as $row) {
				array_push($idkurtek, $row->kurir_teknisi);
			}
		}

		$kurir = $this->userModel->select('users.*, auth_groups.name as rolename')
					 ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
					 ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
					 ->where('auth_groups.name', 'kurir');
		if(in_groups(['kurir', 'teknisi'])){
			$kurir = $kurir->where('users.id', user()->id);
		}
		if($orders->kurir_teknisi){
			$kurir = $kurir->where('users.id', $orders->kurir_teknisi);
		}
		if(@count($idkurtek)>0){
			$kurir = $kurir->whereNotIn('users.id', $idkurtek);
		}
		$kurirs = $kurir->findAll();

		$teknisi = $this->userModel->select('users.*, auth_groups.name as rolename')
					 ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
					 ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
					 ->where('auth_groups.name', 'teknisi');
		if(in_groups(['kurir', 'teknisi'])){
			$teknisi = $teknisi->where('users.id', user()->id);
		}
		if($orders->kurir_teknisi){
			$teknisi = $teknisi->where('users.id', $orders->kurir_teknisi);
		}
		if(@count($idkurtek)>0){
			$teknisi = $teknisi->whereNotIn('users.id', $idkurtek);
		}
		$teknisis = $teknisi->findAll();

		$orderDtl = $this->orderDetailModel->select('order_details.*, users.name as seller, products.seller_id, products.photo, products.title')
					 ->join('products', 'products.id = order_details.product_id')
					 ->join('users', 'users.id = products.seller_id')
					 ->where('order_details.deleted_at IS NULL')
					 ->where('order_details.order_id', $id);
		if($list){
			$orderDtl = $orderDtl->where('products.type', $list)->where('order_details.type', $list);
		}
		$orderDtls = $orderDtl->get()->getResult();
		if(@count($orderDtls)==0){
			return redirect()->to('/dashboard/order/'.$list)->with('error', 'Data not found.');
		}
		$kurtek = '';
		if(@count($orderDtls)>0){
			foreach ($orderDtls as $row) {
				$kurtek = $row->type;
			}
		}

		$data = [
			"title" => "Edit Data Order ".ucwords($list),
			"orders" => $orders,
			"id" => $id,
			"seller" => $users,
			"orderDetails" => $orderDtls,
			"kurir" => $kurirs,
			"teknisi" => $teknisis,
			"kurtek" => $kurtek,
			"list" => $list,
		];
		return view('back/orders/edit', $data);
	}
	
	public function update($id = 0, $list = "")
	{
		if(!in_groups(['seller', 'user', 'kurir', 'teknisi'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}

		$orderDetail = $this->orderDetailModel->select('order_details.*, users.name as seller, products.seller_id, products.photo, products.title')
					 ->join('products', 'products.id = order_details.product_id')
					 ->join('users', 'users.id = products.seller_id')
					 ->where('order_details.deleted_at IS NULL')
					 ->where('order_details.order_id', $id);
		if($list){
			$orderDetail = $orderDetail->where('products.type', $list)->where('order_details.type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		if(in_groups(['seller'])){
			$orderDetail = $orderDetail->where('products.seller_id', user()->id);
		}
		$orderDetails = $orderDetail->get()->getResult();
		$order_id = array(); $seller_id = array();
		if(@count($orderDetails)>0){
			foreach ($orderDetails as $row) {
				array_push($order_id, $row->order_id);
				array_push($seller_id, $row->seller_id);
			}
		}

		$order = $this->orderModel->select('orders.*, users.name as customer, users.address as customer_address, users.phone as customer_phone, users.email as customer_email, users.nik as customer_nik')
					  ->join('users', 'users.id = orders.user_id')
					  ->where('orders.deleted_at IS NULL')
					  ->where('orders.id', $id);
		if(in_groups(['user'])){
			$order = $order->where('orders.user_id', user()->id);
		}
		if(in_groups(['kurir', 'teknisi'])){
			$order = $order->where('orders.kurir_teknisi', user()->id)->where('orders.status', 'on progress');
		}
		if(in_groups(['seller'])){
			if(@count($order_id)>0){
				$order = $order->whereIn('orders.id', $order_id);
			}
		}
		if($list){
			if(@count($order_id)>0){
				$order = $order->whereIn('orders.id', $order_id);
			}else{
				$order = $order->where('orders.id', 0);
			}
		}
		$orders = $order->get()->getRow();
		if(empty($orders)){
			return redirect()->to('/dashboard/order/'.$list)->with('error', 'Data not found.');
		}
		$orderDtl = $this->orderDetailModel->select('order_details.*, users.name as seller, products.seller_id, products.photo, products.title')
					 ->join('products', 'products.id = order_details.product_id')
					 ->join('users', 'users.id = products.seller_id')
					 ->where('order_details.deleted_at IS NULL')
					 ->where('order_details.order_id', $id);
		if($list){
			$orderDtl = $orderDtl->where('products.type', $list)->where('order_details.type', $list);
		}
		$orderDtls = $orderDtl->get()->getResult();
		if(@count($orderDtls)==0){
			return redirect()->to('/dashboard/order/'.$list)->with('error', 'Data not found.');
		}

		$rules = [
			'status'			=> 'required',
		];

		$status = $this->request->getPost('status');
		if(in_groups(['seller'])){
			if($status == 'on progress'){
				$rules['kurir_teknisi'] = 'required';
			}
		}
		if(in_groups(['user']) && $orders->status == 'order'){
			$photos = $this->request->getPost('photo');
			if($photos){
				if($status == 'paid'){
					$rules['photo'] = 'required|uploaded[photo]|max_size[photo,1024]|ext_in[photo,jpg,jpeg,png]';
				}
			}
		}

		if (! $this->validate($rules))
		{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

        $data = [
        	'status' => $status,
        ];
		if(in_groups(['seller'])){
			if($status == 'on progress'){
				$data['kurir_teknisi'] = $this->request->getPost('kurir_teknisi');
			}
		}
		if(in_groups(['user']) && $orders->status == 'order'){
			$photo = $this->request->getFile('photo');
			$newName = "";
	        if($photo) {
	        	if($status == 'paid'){
		            if ($photo->isValid() && ! $photo->hasMoved()) {
		               // Get photo name and extension
		               $name = $photo->getName();
		               $ext = $photo->getClientExtension();

		               // Get random photo name
		               $newName = $photo->getRandomName(); 

		               // Store photo in public/uploads/ folder
		               $photo->move(ROOTPATH . 'public/upload/orders', $newName);

		               // File path to display preview
		               $filepath = base_url()."/upload/orders/".$newName;
		            }
		        }
	        }

			if($newName){
				$data['photo'] = $newName;
				if($orders->photo && file_exists('upload/orders/'.$orders->photo)){
					unlink("upload/orders/".$orders->photo);
				}
			}
	    }
        $this->orderModel->update($id,$data);
        if($status == 'rejected'){
			if(@count($orderDtls)>0){
				foreach ($orderDtls as $row) {
					if($row->type == 'product'){
						$products = $this->productModel->select('products.*, users.name as seller, categories.title as category, categories.slug as categoryslug')
									 ->join('users', 'users.id = products.seller_id')
									 ->join('categories', 'categories.id = products.category_id')
									 ->where('products.deleted_at IS NULL')
									 ->where('products.status', 'published')
									 ->where('products.id', $row->product_id)
									 ->where('products.type', $row->type)
									 ->get()->getRow();
						if(!empty($products)){
				        	$dataproduct['quantity'] = $products->quantity+$row->quantity;
				        	$this->productModel->update($products->id,$dataproduct);
					    }
					}
				}
			}
        }
		return redirect()->to('/dashboard/order/'.$list)->with('message', 'Data updated successfully');
	}
}
