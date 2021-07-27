<?php

namespace App\Controllers\Back;
use App\Controllers\BaseController;

class DataController extends BaseController
{
	public function __construct(){
		//
	}
	
	public function index($list = "")
	{
		if(!in_groups(['admin', 'seller'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}
		$product = $this->productModel->select('products.*, users.name as seller, categories.title as category')
					 ->join('users', 'users.id = products.seller_id')
					 ->join('categories', 'categories.id = products.category_id')
					 ->where('products.deleted_at IS NULL');
		if($list){
			$product = $product->where('products.type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		if(in_groups(['seller'])){
			$product = $product->where('products.seller_id', user()->id);
		}
		$products = $product->orderBy('products.id', 'DESC')->get()->getResult();
		$data = [
			"title" => "Data ".ucwords($list),
			"products" => $products,
			"list" => $list,
		];
		return view('back/products/index', $data);
	}
	
	public function create($list = "")
	{	
		if(!in_groups(['admin', 'seller'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}
		if($list){
			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
			$lists = array($list);
		}else{
			$lists = array('product', 'service');
		}
		$category = $this->categoryModel->where('status', 'active')->where('deleted_at IS NULL');
		if($list){
			$category = $category->where('type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		$categories = $category->get()->getResult();
		$user = $this->userModel->select('users.*, auth_groups.name as rolename')
					 ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
					 ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
					 ->where('auth_groups.name', 'seller');
		if(!in_groups(['admin'])){
			$user = $user->where('users.id', user()->id);
		}
		$users = $user->findAll();
		$data = [
			"title" => "Create Data ".ucwords($list),
			"categories" => $categories,
			"users" => $users,
			"lists" => $lists,
			"list" => $list,
		];
		return view('back/products/create', $data);
	}
	
	public function store($list = "")
	{
		if(!in_groups(['admin', 'seller'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}
		if($list){
			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}

		$rules = [
			'title'			=> 'required',
			'type'  		=> 'required',
			'description'	=> 'required',
			'photo'			=> 'uploaded[photo]|max_size[photo,1024]|ext_in[photo,jpg,jpeg,png]',
			'seller_id'			=> 'required|numeric',
			'category_id'  		=> 'required|numeric',
			'price'	=> 'required|decimal',
			'price_sale'	=> 'required|decimal',
			'quantity'	=> 'required|decimal',
		];

		if (! $this->validate($rules))
		{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
		$title = $this->request->getPost('title');
		$type = $this->request->getPost('type');
		if($list){
			if($list == 'product' || $list == 'service'){
				if($type != $list){
					return redirect()->back()->withInput()->with('errors', ['type' => 'The type field not valid value.']);					
				}
			}
		}

		if($type != 'product' && $type != 'service'){
			return redirect()->back()->withInput()->with('errors', ['type' => 'The type field not valid value.']);	
		}

		$photo = $this->request->getFile('photo');
		$newName = "";
        if($photo) {
            if ($photo->isValid() && ! $photo->hasMoved()) {
               // Get photo name and extension
               $name = $photo->getName();
               $ext = $photo->getClientExtension();

               // Get random photo name
               $newName = $photo->getRandomName(); 

               // Store photo in public/uploads/ folder
               $photo->move(ROOTPATH . 'public/upload/products', $newName);

               // File path to display preview
               $filepath = base_url()."/upload/products/".$newName;
            }
        }
        if($this->request->getPost('status')){
        	$status = 'published';
        }else{
        	$status = 'draft';
        }
        $slug       = unique_slug($title.' '.$type, 'products');
        $data = [
        	'title' => $title,
        	'type' => $type,
        	'description' => $this->request->getPost('description'),
        	'status' => $status,
        	'photo' => $newName,
        	'slug' => $slug,
        	'seller_id' => $this->request->getPost('seller_id'),
        	'category_id' => $this->request->getPost('category_id'),
        	'price' => $this->request->getPost('price'),
        	'price_sale' => $this->request->getPost('price_sale'),
        	'quantity' => $this->request->getPost('quantity'),
        ];
        $this->productModel->insert($data);
        $lists = $list?$list:$type;
		return redirect()->to('/dashboard/data/'.$lists)->with('message', 'Data saved successfully');
	}
	
	public function show($id = 0, $list = "")
	{
		if(!in_groups(['admin', 'seller'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}
		$product = $this->productModel->select('products.*, users.name as seller, categories.title as category')
					 ->join('users', 'users.id = products.seller_id')
					 ->join('categories', 'categories.id = products.category_id')
					 ->where('products.deleted_at IS NULL')->where('products.id', $id);
		if($list){
			$product = $product->where('products.type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		if(in_groups(['seller'])){
			$product = $product->where('products.seller_id', user()->id);
		}
		$products = $product->get()->getRow();
		if($list){
			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
			$lists = array($list);
		}else{
			$lists = array('product', 'service');
		}
		$category = $this->categoryModel->where('status', 'active')->where('deleted_at IS NULL');
		if($list){
			$category = $category->where('type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		$categories = $category->get()->getResult();
		$user = $this->userModel->select('users.*, auth_groups.name as rolename')
					 ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
					 ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
					 ->where('auth_groups.name', 'seller');
		if(!in_groups(['admin'])){
			$user = $user->where('users.id', user()->id);
		}
		$users = $user->findAll();
		if(empty($products)){
			if(in_groups(['admin', 'seller'])){
				return redirect()->to('/dashboard')->with('error', 'Data not found.');
			}else{
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		$data = [
			"title" => "Data ".ucwords($list)." Detail",
			"products" => $products,
			"categories" => $categories,
			"users" => $users,
			"lists" => $lists,
			"list" => $list,
			"id" => $id,
		];
		return view('back/products/show', $data);
	}
	
	public function edit($id = 0, $list = "")
	{
		if(!in_groups(['admin', 'seller'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}
		$product = $this->productModel->select('products.*, users.name as seller, categories.title as category')
					 ->join('users', 'users.id = products.seller_id')
					 ->join('categories', 'categories.id = products.category_id')
					 ->where('products.deleted_at IS NULL')->where('products.id', $id);
		if($list){
			$product = $product->where('products.type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		if(in_groups(['seller'])){
			$product = $product->where('products.seller_id', user()->id);
		}
		$products = $product->get()->getRow();
		if($list){
			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
			$lists = array($list);
		}else{
			$lists = array('product', 'service');
		}
		$category = $this->categoryModel->where('status', 'active')->where('deleted_at IS NULL');
		if($list){
			$category = $category->where('type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		$categories = $category->get()->getResult();
		$user = $this->userModel->select('users.*, auth_groups.name as rolename')
					 ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
					 ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
					 ->where('auth_groups.name', 'seller');
		if(!in_groups(['admin'])){
			$user = $user->where('users.id', user()->id);
		}
		$users = $user->findAll();
		if(empty($products)){
			if(in_groups(['admin', 'seller'])){
				return redirect()->to('/dashboard')->with('error', 'Data not found.');
			}else{
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		$data = [
			"title" => "Edit ".ucwords($list)." Detail",
			"products" => $products,
			"categories" => $categories,
			"users" => $users,
			"lists" => $lists,
			"list" => $list,
			"id" => $id,
		];
		return view('back/products/edit', $data);
	}
	
	public function update($id = 0, $list = "")
	{
		if(!in_groups(['admin', 'seller'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}
		if($list){
			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		$product = $this->productModel->select('products.*, users.name as seller, categories.title as category')
					 ->join('users', 'users.id = products.seller_id')
					 ->join('categories', 'categories.id = products.category_id')
					 ->where('products.deleted_at IS NULL')->where('products.id', $id);
		if($list){
			$product = $product->where('products.type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		if(in_groups(['seller'])){
			$product = $product->where('products.seller_id', user()->id);
		}
		$products = $product->get()->getRow();
		if(empty($products)){
			if(in_groups(['admin', 'seller'])){
				return redirect()->to('/dashboard')->with('error', 'Data not found.');
			}else{
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}

		$rules = [
			'title'			=> 'required',
			'type'  		=> 'required',
			'description'	=> 'required',
			'seller_id'			=> 'required|numeric',
			'category_id'  		=> 'required|numeric',
			'price'	=> 'required|decimal',
			'price_sale'	=> 'required|decimal',
			'quantity'	=> 'required|decimal',
		];
		$photos = $this->request->getPost('photo');
		if($photos){
			$rules['photo'] = 'uploaded[photo]|max_size[photo,1024]|ext_in[photo,jpg,jpeg,png]';
		}

		if (! $this->validate($rules))
		{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
		$title = $this->request->getPost('title');
		$type = $this->request->getPost('type');
		if($list){
			if($list == 'product' || $list == 'service'){
				if($type != $list){
					return redirect()->back()->withInput()->with('errors', ['type' => 'The type field not valid value.']);					
				}
			}
		}

		if($type != 'product' && $type != 'service'){
			return redirect()->back()->withInput()->with('errors', ['type' => 'The type field not valid value.']);	
		}

		$photo = $this->request->getFile('photo');
		$newName = "";
        if($photo) {
            if ($photo->isValid() && ! $photo->hasMoved()) {
               // Get photo name and extension
               $name = $photo->getName();
               $ext = $photo->getClientExtension();

               // Get random photo name
               $newName = $photo->getRandomName(); 

               // Store photo in public/uploads/ folder
               $photo->move(ROOTPATH . 'public/upload/products', $newName);

               // File path to display preview
               $filepath = base_url()."/upload/products/".$newName;
            }
        }
        $data = [
        	'title' => $title,
        	'type' => $type,
        	'description' => $this->request->getPost('description'),
        	'seller_id' => $this->request->getPost('seller_id'),
        	'category_id' => $this->request->getPost('category_id'),
        	'price' => $this->request->getPost('price'),
        	'price_sale' => $this->request->getPost('price_sale'),
        	'quantity' => $this->request->getPost('quantity'),
        ];
        if($this->request->getPost('status')){
        	$data['status'] = 'published';
        }else{
        	$data['status'] = 'draft';
        }
        if($products->type != $type || $products->title != $title){
        	$data['slug']       = unique_slug($title.' '.$type, 'products', 'slug', 'id', $id);
        }

		if($newName){
			$data['photo'] = $newName;
			if($products->photo && file_exists('upload/products/'.$products->photo)){
				unlink("upload/products/".$products->photo);
			}
		}
        $this->productModel->update($id,$data);
        $lists = $list?$list:$type;
		return redirect()->to('/dashboard/data/'.$lists)->with('message', 'Data updated successfully');
	}

	public function destroy($id = 0, $list = "")
	{
		if(!in_groups(['admin', 'seller'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}
		if($list){
			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		$product = $this->productModel->select('products.*, users.name as seller, categories.title as category')
					 ->join('users', 'users.id = products.seller_id')
					 ->join('categories', 'categories.id = products.category_id')
					 ->where('products.deleted_at IS NULL')->where('products.id', $id);
		if($list){
			$product = $product->where('products.type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		if(in_groups(['seller'])){
			$product = $product->where('products.seller_id', user()->id);
		}
		$products = $product->get()->getRow();
		if(empty($products)){
			if(in_groups(['admin', 'seller'])){
				return redirect()->to('/dashboard')->with('error', 'Data not found.');
			}else{
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}else{
	        $lists = $list?$list:$products->type;
			$this->productModel->where('id', $id)->delete();
			return redirect()->to('/dashboard/data/'.$lists)->with('message', 'Data deleted successfully');
		}
    }
}
