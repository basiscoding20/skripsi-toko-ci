<?php

namespace App\Controllers\Front;
use App\Controllers\BaseController;

class HomeController extends BaseController
{
	protected $cart;
	public function __construct(){
		$this->cart = \Config\Services::cart();
	}

	public function index()
	{
		// return view('home');
		$categoryProduct = $this->categoryModel->where('status', 'active')->where('deleted_at IS NULL')->where('type', 'product')->get()->getResult();
		$categoryService = $this->categoryModel->where('status', 'active')->where('deleted_at IS NULL')->where('type', 'service')->get()->getResult();

		$products = $this->productModel->select('products.*, users.name as seller, categories.title as category, categories.slug as categoryslug')
					 ->join('users', 'users.id = products.seller_id')
					 ->join('categories', 'categories.id = products.category_id')
					 ->where('products.deleted_at IS NULL')
					 ->where('products.type', 'product')
					 ->where('products.status', 'published')
					 ->limit(8)
					 ->orderBy('id', 'DESC')
					 ->get()->getResult();
		$services = $this->productModel->select('products.*, users.name as seller, categories.title as category, categories.slug as categoryslug')
					 ->join('users', 'users.id = products.seller_id')
					 ->join('categories', 'categories.id = products.category_id')
					 ->where('products.deleted_at IS NULL')
					 ->where('products.type', 'service')
					 ->where('products.status', 'published')
					 ->limit(8)
					 ->orderBy('id', 'DESC')
					 ->get()->getResult();

		$carts = $this->cart;

		$data = [
			"title" => "Home",
			"categoryProduct" => $categoryProduct,
			"categoryService" => $categoryService,
			"products" => $products,
			"services" => $services,
			"carts" => $carts,
		];
		return view('front/home', $data);
	}

	public function about()
	{
		// return view('home');
		$categoryProduct = $this->categoryModel->where('status', 'active')->where('deleted_at IS NULL')->where('type', 'product')->get()->getResult();
		$categoryService = $this->categoryModel->where('status', 'active')->where('deleted_at IS NULL')->where('type', 'service')->get()->getResult();

		$products = $this->productModel->select('products.*, users.name as seller, categories.title as category, categories.slug as categoryslug')
					 ->join('users', 'users.id = products.seller_id')
					 ->join('categories', 'categories.id = products.category_id')
					 ->where('products.deleted_at IS NULL')
					 ->where('products.type', 'product')
					 ->where('products.status', 'published')
					 ->limit(8)
					 ->orderBy('id', 'DESC')
					 ->get()->getResult();
		$services = $this->productModel->select('products.*, users.name as seller, categories.title as category, categories.slug as categoryslug')
					 ->join('users', 'users.id = products.seller_id')
					 ->join('categories', 'categories.id = products.category_id')
					 ->where('products.deleted_at IS NULL')
					 ->where('products.type', 'service')
					 ->where('products.status', 'published')
					 ->limit(8)
					 ->orderBy('id', 'DESC')
					 ->get()->getResult();

		$carts = $this->cart;
		$data = [
			"title" => "About",
			"categoryProduct" => $categoryProduct,
			"categoryService" => $categoryService,
			"products" => $products,
			"services" => $services,
			"carts" => $carts,
		];
		return view('front/about', $data);
	}

	public function contact()
	{
		// return view('home');
		$categoryProduct = $this->categoryModel->where('status', 'active')->where('deleted_at IS NULL')->where('type', 'product')->get()->getResult();
		$categoryService = $this->categoryModel->where('status', 'active')->where('deleted_at IS NULL')->where('type', 'service')->get()->getResult();

		$products = $this->productModel->select('products.*, users.name as seller, categories.title as category, categories.slug as categoryslug')
					 ->join('users', 'users.id = products.seller_id')
					 ->join('categories', 'categories.id = products.category_id')
					 ->where('products.deleted_at IS NULL')
					 ->where('products.type', 'product')
					 ->where('products.status', 'published')
					 ->limit(8)
					 ->orderBy('id', 'DESC')
					 ->get()->getResult();
		$services = $this->productModel->select('products.*, users.name as seller, categories.title as category, categories.slug as categoryslug')
					 ->join('users', 'users.id = products.seller_id')
					 ->join('categories', 'categories.id = products.category_id')
					 ->where('products.deleted_at IS NULL')
					 ->where('products.type', 'service')
					 ->where('products.status', 'published')
					 ->limit(8)
					 ->orderBy('id', 'DESC')
					 ->get()->getResult();

		$carts = $this->cart;
		$data = [
			"title" => "Contact",
			"categoryProduct" => $categoryProduct,
			"categoryService" => $categoryService,
			"products" => $products,
			"services" => $services,
			"carts" => $carts,
		];
		return view('front/contact', $data);
	}
	
	public function data($list = "", $category = "")
	{
		if($list){
			if($list != 'product' && $list != 'service'){
				return redirect()->to('/');
			}
		}else{
			return redirect()->to('/');
		}
		$product = $this->productModel->select('products.*, users.name as seller, categories.title as category, categories.slug as categoryslug')
					 ->join('users', 'users.id = products.seller_id')
					 ->join('categories', 'categories.id = products.category_id')
					 ->where('products.deleted_at IS NULL')
					 ->where('products.status', 'published');
		if($list){
			$product = $product->where('products.type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/');
			}
		}
		if($category){
			$product = $product->where('categories.slug', $category);
		}
		$products = $product->orderBy('id', 'DESC');

		$categorys = $this->categoryModel->where('deleted_at IS NULL');
		if($list){
			$categorys = $categorys->where('type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/');
			}
		}
		$categories = $categorys->get()->getResult();

		if($category){
			$detailCategory = $this->categoryModel->where('deleted_at IS NULL')->where('slug', $category);
			if($list){
				$detailCategory = $detailCategory->where('type', $list);

				if($list != 'product' && $list != 'service'){
					return redirect()->to('/');
				}
			}
			$detailCategories = $detailCategory->get()->getRow();
		}else{
			$detailCategories = array();
		}
		$title = ($category)?" Category ".$detailCategories->title:"";

		$carts = $this->cart;
		$data = [
			"title" => ucwords($list).$title,
			"products" => $products->paginate(12, 'list'),
			"pager" => $products->pager,
			"categories" => $categories,
			"detailCategories" => $detailCategories,
			"category" => $category,
			"list" => $list,
			"carts" => $carts,
		];
		return view('front/products', $data);
	}
	
	public function details($list = "", $category = null, $slug = null)
	{
		if($list){
			if($list != 'product' && $list != 'service'){
				return redirect()->to('/');
			}
		}else{
			return redirect()->to('/');
		}
		if($category == null){
			return redirect()->to('/data/'.$list);
		}
		if($slug == null){
			if($category == null){
				return redirect()->to('/data/'.$list);
			}else{
				return redirect()->to('/data/'.$list.'/'.$category);
			}
		}
		$product = $this->productModel->select('products.*, users.name as seller, categories.title as category, categories.slug as categoryslug')
					 ->join('users', 'users.id = products.seller_id')
					 ->join('categories', 'categories.id = products.category_id')
					 ->where('products.deleted_at IS NULL')
					 ->where('products.status', 'published');
		if($list){
			$product = $product->where('products.type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/');
			}
		}
		if($category){
			$product = $product->where('categories.slug', $category);
		}
		if($slug){
			$product = $product->where('products.slug', $slug);
		}
		$products = $product->get()->getRow();
		
		if(empty($products)){
			return redirect()->to('/')->with('error', 'Data not found.');
		}

		$categorys = $this->categoryModel->where('deleted_at IS NULL');
		if($list){
			$categorys = $categorys->where('type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/');
			}
		}
		$categories = $categorys->get()->getResult();

		if($category){
			$detailCategory = $this->categoryModel->where('deleted_at IS NULL')->where('slug', $category);
			if($list){
				$detailCategory = $detailCategory->where('type', $list);

				if($list != 'product' && $list != 'service'){
					return redirect()->to('/');
				}
			}
			$detailCategories = $detailCategory->get()->getRow();
		}else{
			$detailCategories = array();
		}

		$carts = $this->cart;
		$data = [
			"title" => ucwords(strtolower($products->title)),
			"products" => $products,
			"categories" => $categories,
			"detailCategories" => $detailCategories,
			"slug" => $slug,
			"category" => $category,
			"list" => $list,
			"carts" => $carts,
		];
		return view('front/product', $data);
	}

	public function cart()
	{
		if(!in_groups(['user'])){
			return redirect()->to('/')->with('error', 'You do not have permission on this page.');
		}
		$carts = $this->cart;
		$result = $carts->contents();
		$total = $carts->totalItems();
		$data = [
			"title" => "Cart",
			"cart" => $result,
			"total" => $total,
			"carts" => $carts,
		];
		return view('front/cart', $data);
	}

	public function addtocart()
	{
		if(!in_groups(['user'])){
			return redirect()->to('/')->with('error', 'You do not have permission on this page.');
		}
		$id = $this->request->getPost('id')?$this->request->getPost('id'):0;
		$qty = $this->request->getPost('qty')?$this->request->getPost('qty'):1;
		$date = $this->request->getPost('date')?$this->request->getPost('date'):'';
		$time = $this->request->getPost('time')?$this->request->getPost('time'):'';
		$products = $this->productModel->select('products.*, users.name as seller, categories.title as category, categories.slug as categoryslug')
					 ->join('users', 'users.id = products.seller_id')
					 ->join('categories', 'categories.id = products.category_id')
					 ->where('products.deleted_at IS NULL')
					 ->where('products.status', 'published')
					 ->where('products.id', $id)
					 ->get()->getRow();
		
		if(empty($products)){
			return redirect()->to('/')->with('error', 'Data not found.');
		}

		if($products->type == 'service' && $date < date('Y-m-d')){
			return redirect()->back()->withInput()->with('errors', ['date' => 'The date field not valid value.']);
		}

		$options = [
			'type' => $products->type, 
			'category_id' => $products->category_id, 
			'photo' => $products->photo, 
			'date' => $date, 
			'time' => $time,
		];

		$data = [
		   'id'      => $products->id,
		   'qty'     => $qty,
		   'price'   => $products->price_sale,
		   'name'    => $products->title,
		   'options' => $options,
		];

		$this->cart->insert($data);
		return redirect()->back()->with('message', 'Data successfully add to cart.');
	}

	public function cartclear()
	{
		if(!in_groups(['user'])){
			return redirect()->to('/')->with('error', 'You do not have permission on this page.');
		}
		$this->cart->destroy();
		return redirect()->back()->with('message', 'Data all cart successfully deleted.');
	}

	public function cartdestroy($row_id = "")
	{
		if(!in_groups(['user'])){
			return redirect()->to('/')->with('error', 'You do not have permission on this page.');
		}
		if($row_id){
			$this->cart->remove($row_id);
			return redirect()->back()->with('message', 'Data cart successfully deleted.');
		}else{
			return redirect()->back()->with('error', 'Data cart not found.');
		}
	}

	public function cartupdate()
	{
		if(!in_groups(['user'])){
			return redirect()->to('/')->with('error', 'You do not have permission on this page.');
		}
		$carts = $this->cart;
		if(@count($carts)>0){
			foreach($carts->contents() as $row){
				$id = $this->request->getPost('id'.$row['rowid'])?$this->request->getPost('id'.$row['rowid']):0;
				$qty = $this->request->getPost('qty'.$row['rowid'])?$this->request->getPost('qty'.$row['rowid']):1;
				$date = $this->request->getPost('date'.$row['rowid'])?$this->request->getPost('date'.$row['rowid']):'';
				$time = $this->request->getPost('time'.$row['rowid'])?$this->request->getPost('time'.$row['rowid']):'';
				$products = $this->productModel->select('products.*, users.name as seller, categories.title as category, categories.slug as categoryslug')
							 ->join('users', 'users.id = products.seller_id')
							 ->join('categories', 'categories.id = products.category_id')
							 ->where('products.deleted_at IS NULL')
							 ->where('products.status', 'published')
							 ->where('products.id', $id)
							 ->get()->getRow();
				if(!empty($products)){
					$options = [
						'type' => $products->type, 
						'category_id' => $products->category_id, 
						'photo' => $products->photo, 
						'date' => $date, 
						'time' => $time,
					];

					$data = [
					   'rowid'   => $row['rowid'],
					   'id'      => $products->id,
					   'qty'     => $qty,
					   'price'   => $products->price_sale,
					   'name'    => $products->title,
					   'options' => $options,
					];
					$carts->update($data);
				}
			}
			return redirect()->back()->with('message', 'Data all cart successfully updated.');
		}
		return redirect()->to('/')->with('error', 'You do not have product on this cart.');
	}

	public function checkout()
	{
		if(!in_groups(['user'])){
			return redirect()->to('/')->with('error', 'You do not have permission on this page.');
		}
		$carts = $this->cart;
		$result = $carts->contents();
		$total = $carts->totalItems();
		if($total == 0){
			return redirect()->to('/')->with('error', 'You do not have product on this cart.');
		}
		$uniqueID = 'REF-'.date('YmdHis');
	    $data = [
	    	'code' => $uniqueID,
	    	'user_id' => user()->id,
	    	'status' => 'order',
	    	'total' => $carts->total(),
	    ];
	    $order = $this->orderModel->insert($data);
		$orders = $this->orderModel->where('code', $uniqueID)->where('deleted_at IS NULL')->where('status', 'order')->get()->getRow();
		$orderproductid = $orders->id;
		$totalorderproduct = 0;
		foreach($result as $row){
			$products = $this->productModel->select('products.*, users.name as seller, categories.title as category, categories.slug as categoryslug')
						 ->join('users', 'users.id = products.seller_id')
						 ->join('categories', 'categories.id = products.category_id')
						 ->where('products.deleted_at IS NULL')
						 ->where('products.status', 'published')
						 ->where('products.id', $row['id'])
						 ->get()->getRow();
			if(!empty($products)){
		        if($row['options']['type'] == 'product'){
			        $datadetail = [
			        	'order_id' => $orders->id,
			        	'product_id' => $products->id,
			        	'quantity' => $row['qty'],
			        	'price' => $row['price'],
			        	'type' => $row['options']['type'],
			        	'category_id' => $row['options']['category_id'],
			        ];
			        $this->orderDetailModel->insert($datadetail);
		        	$dataproduct['quantity'] = $products->quantity-$row['qty'];
		        	$this->productModel->update($products->id,$dataproduct);
		        	$totalorderproduct += ($row['qty']+$row['price']);
		        }elseif($row['options']['type'] == 'service'){
					$uniqueID = 'REF-'.time();
				    $data = [
				    	'code' => $uniqueID,
				    	'user_id' => user()->id,
				    	'status' => 'order',
				    	'total' => ($row['qty']*$row['price']),
				    ];
				    $order = $this->orderModel->insert($data);
					$orders = $this->orderModel->where('code', $uniqueID)->where('deleted_at IS NULL')->where('status', 'order')->get()->getRow();
			        $datadetail = [
			        	'order_id' => $orders->id,
			        	'product_id' => $products->id,
			        	'quantity' => $row['qty'],
			        	'price' => $row['price'],
			        	'type' => $row['options']['type'],
			        	'category_id' => $row['options']['category_id'],
			        	'datetime' => $row['options']['date'].' '.$row['options']['time'],
			        ];
			        $this->orderDetailModel->insert($datadetail);
		        }
			}
		}
		$datatotal['total'] = $totalorderproduct;
		$this->orderModel->update($orderproductid,$datatotal);

		$this->cart->destroy();

		$cartsz = $this->cart;
		$datacekout = [
			"title" => "Checkout",
			"carts" => $cartsz,
			"messages" => "All cart data ordered successfully. Please set the order status to paid in menu order if you are paying for this order.",
		];
		return view('front/checkout', $datacekout);
	}
}
