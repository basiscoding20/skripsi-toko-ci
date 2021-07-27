<?php

namespace App\Controllers\Back;
use App\Controllers\BaseController;

class CategoriesController extends BaseController
{
	public function __construct(){
		//
	}
	
	public function index($list = "")
	{
		if(!in_groups(['admin'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}
		$category = $this->categoryModel->where('deleted_at IS NULL');
		if($list){
			$category = $category->where('type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		$categories = $category->orderBy('id', 'DESC')->get()->getResult();
		$data = [
			"title" => ucwords($list)." Categories",
			"categories" => $categories,
			"list" => $list,
		];
		return view('back/categories/index', $data);
	}
	
	public function create($list = "")
	{	
		if(!in_groups(['admin'])){
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
		$data = [
			"title" => "Create Category ".ucwords($list),
			"lists" => $lists,
			"list" => $list,
		];
		return view('back/categories/create', $data);
	}
	
	public function store($list = "")
	{
		if(!in_groups(['admin'])){
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
		$category = $this->categoryModel->where('title', $title)->where('type', $type)->findAll();
		if(@count($category)>0){
			return redirect()->back()->withInput()->with('errors', ['title' => 'The name field must contain a unique value.']);
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
               $photo->move(ROOTPATH . 'public/upload/categories', $newName);

               // File path to display preview
               $filepath = base_url()."/upload/categories/".$newName;
            }
        }
        if($this->request->getPost('status')){
        	$status = 'active';
        }else{
        	$status = 'inactive';
        }
        $slug       = unique_slug($title.' '.$type, 'categories');
        $data = [
        	'title' => $title,
        	'type' => $type,
        	'description' => $this->request->getPost('description'),
        	'status' => $status,
        	'photo' => $newName,
        	'slug' => $slug,
        ];
        $this->categoryModel->insert($data);
        $lists = $list?$list:$type;
		return redirect()->to('/dashboard/categories/'.$lists)->with('message', 'Data saved successfully');
	}
	
	public function show($id = 0, $list = "")
	{
		if(!in_groups(['admin'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}
		$category = $this->categoryModel->where('deleted_at IS NULL')->where('id', $id);
		if($list){
			$category = $category->where('type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		$categories = $category->get()->getRow();
		if($list){
			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
			$lists = array($list);
		}else{
			$lists = array('product', 'service');
		}
		if(empty($categories)){
			if(in_groups(['admin'])){
				return redirect()->to('/dashboard')->with('error', 'Data not found.');
			}else{
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		$data = [
			"title" => ucwords($list)." Category Detail",
			"categories" => $categories,
			"lists" => $lists,
			"list" => $list,
			"id" => $id,
		];
		return view('back/categories/show', $data);
	}
	
	public function edit($id = 0, $list = "")
	{
		if(!in_groups(['admin'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}
		$category = $this->categoryModel->where('deleted_at IS NULL')->where('id', $id);
		if($list){
			$category = $category->where('type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		$categories = $category->get()->getRow();
		if($list){
			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
			$lists = array($list);
		}else{
			$lists = array('product', 'service');
		}
		if(empty($categories)){
			if(in_groups(['admin'])){
				return redirect()->to('/dashboard')->with('error', 'Data not found.');
			}else{
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		$data = [
			"title" => ucwords($list)." Category Edit",
			"categories" => $categories,
			"lists" => $lists,
			"list" => $list,
			"id" => $id,
		];
		return view('back/categories/edit', $data);
	}
	
	public function update($id = 0, $list = "")
	{
		if(!in_groups(['admin'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}
		if($list){
			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		$category = $this->categoryModel->where('deleted_at IS NULL')->where('id', $id);
		if($list){
			$category = $category->where('type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		$categories = $category->get()->getRow();
		if(empty($categories)){
			if(in_groups(['admin'])){
				return redirect()->to('/dashboard')->with('error', 'Data not found.');
			}else{
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}

		$rules = [
			'title'			=> 'required',
			'type'  		=> 'required',
			'description'	=> 'required',
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
		$categorys = $this->categoryModel->where('title', $title)->where('type', $type)->where('id !=', $id)->findAll();
		if(@count($categorys)>0){
			return redirect()->back()->withInput()->with('errors', ['title' => 'The name field must contain a unique value.']);
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
               $photo->move(ROOTPATH . 'public/upload/categories', $newName);

               // File path to display preview
               $filepath = base_url()."/upload/categories/".$newName;
            }
        }
        $data = [
        	'title' => $title,
        	'type' => $type,
        	'description' => $this->request->getPost('description'),
        ];
        if($this->request->getPost('status')){
        	$data['status'] = 'active';
        }else{
        	$data['status'] = 'inactive';
        }
        if($categories->type != $type || $categories->title != $title){
        	$data['slug']       = unique_slug($title.' '.$type, 'categories', 'slug', 'id', $id);
        }

		if($newName){
			$data['photo'] = $newName;
			if($categories->photo && file_exists('upload/categories/'.$categories->photo)){
				unlink("upload/categories/".$categories->photo);
			}
		}
        $this->categoryModel->update($id,$data);
        $lists = $list?$list:$type;
		return redirect()->to('/dashboard/categories/'.$lists)->with('message', 'Data updated successfully');
	}

	public function destroy($id = 0, $list = "")
	{
		if(!in_groups(['admin'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}
		if($list){
			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		$category = $this->categoryModel->where('deleted_at IS NULL')->where('id', $id);
		if($list){
			$category = $category->where('type', $list);

			if($list != 'product' && $list != 'service'){
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		$categories = $category->get()->getRow();
		if(empty($categories)){
			if(in_groups(['admin'])){
				return redirect()->to('/dashboard')->with('error', 'Data not found.');
			}else{
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}else{
	        $lists = $list?$list:$categories->type;
			$this->categoryModel->where('id', $id)->delete();
			return redirect()->to('/dashboard/categories/'.$lists)->with('message', 'Data deleted successfully');
		}
    }
}
