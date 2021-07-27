<?php

namespace App\Controllers\Back;
use App\Controllers\BaseController;
use Myth\Auth\Password;

class UsersController extends BaseController
{
	protected $db, $builderuser, $builderrole, $builderroleuser;
	public function __construct(){
		$this->db = \Config\Database::connect();
		$this->builderuser = $this->db->table('users');
		$this->builderrole = $this->db->table('auth_groups');
		$this->builderroleuser = $this->db->table('auth_groups_users');
	}
	
	public function index()
	{
		if(!in_groups(['admin'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}
		$user = $this->userModel->select('users.*, auth_groups.name as rolename')
					 ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
					 ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
					 ->where('users.id !=', user()->id);
		if(!in_groups(['admin'])){
			$user = $user->where('users.id', user()->id);
		}
		$users = $user->orderBy('users.id', 'DESC')->findAll();
		$data = [
			"title" => "Data Users",
			"users" => $users,
		];
		return view('back/users/index', $data);
	}
	
	public function create()
	{	
		if(!in_groups(['admin'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}
		$role = $this->builderrole->get();
		$data = [
			"title" => "Create Users",
			"role" => $role->getResult(),
		];
		return view('back/users/create', $data);
	}
	
	public function store()
	{
		if(!in_groups(['admin'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}
		$rules = [
			'nik'  	=> 'required|numeric|min_length[16]|max_length[16]|is_unique[users.nik]',
			'name'			=> 'required',
			'email'			=> 'required|valid_email|is_unique[users.email]',
			'phone'  	=> 'required|numeric|min_length[9]|max_length[13]|is_unique[users.phone]',
			'address'			=> 'required',
			'role'			=> 'required',
			'username'  	=> 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
			'password'			=> 'required|strong_password',
			'photo'			=> 'uploaded[photo]|max_size[photo,1024]|ext_in[photo,jpg,jpeg,png]',
		];

		if (! $this->validate($rules))
		{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
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
               $photo->move(ROOTPATH . 'public/upload/users', $newName);

               // File path to display preview
               $filepath = base_url()."/upload/users/".$newName;
            }
        }
        if($this->request->getPost('active')){
        	$active = 1;
        }else{
        	$active = 0;
        }
        $password = $this->request->getPost('password');
        $role = $this->request->getPost('role');
        $data = [
        	'nik' => $this->request->getPost('nik'),
        	'name' => $this->request->getPost('name'),
        	'email' => $this->request->getPost('email'),
        	'phone' => $this->request->getPost('phone'),
        	'address' => $this->request->getPost('address'),
        	'username' => $this->request->getPost('username'),
        	'password_hash' => Password::hash($password),
        	'active' => $active,
        	'photo' => $newName,
        ];
        $this->userModel->withGroup($role)->insert($data);
		return redirect()->route('dashboard/users')->with('message', 'Data saved successfully');
	}
	
	public function show($id = 0)
	{
		if(!in_groups(['admin'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}
		$user = $this->userModel->select('users.*, auth_groups.name as rolename')
					 ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
					 ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
		if(!in_groups(['admin'])){
			$user = $user->where('users.id', user()->id);
		}
		$users = $user->find($id);
		if(empty($users)){
			if(in_groups(['admin'])){
				return redirect()->to('/dashboard/users')->with('error', 'Data not found.');
			}else{
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		$data = [
			"title" => "User Details",
			"users" => $users,
		];
		return view('back/users/show', $data);
	}
	
	public function edit($id = 0)
	{
		if(!in_groups(['admin'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}
		$user = $this->userModel->select('users.*, auth_groups.name as rolename')
					 ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
					 ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
		if(!in_groups(['admin'])){
			$user = $user->where('users.id', user()->id);
		}
		$users = $user->find($id);
		if(empty($users)){
			if(in_groups(['admin'])){
				return redirect()->to('/dashboard/users')->with('error', 'Data not found.');
			}else{
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		$role = $this->builderrole->get();
		$data = [
			"title" => "Edit User Details",
			"users" => $users,
			"role" => $role->getResult(),
		];
		return view('back/users/edit', $data);
	}
	
	public function update($id = 0)
	{
		if(!in_groups(['admin'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}
		$user = $this->userModel->select('users.*, auth_groups.name as rolename')
					 ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
					 ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
		if(!in_groups(['admin'])){
			$user = $user->where('users.id', user()->id);
		}
		$users = $user->find($id);
		if(empty($users)){
			if(in_groups(['admin'])){
				return redirect()->to('/dashboard/users')->with('error', 'Data not found.');
			}else{
				return redirect()->to('/dashboard')->with('error', 'Data not valid.');
			}
		}
		$rules = [
			'nik'  	=> 'required|numeric|min_length[16]|max_length[16]|is_unique[users.nik,id,'.$id.']',
			'name'			=> 'required',
			'role'			=> 'required',
			'email'			=> 'required|valid_email|is_unique[users.email,id,'.$id.']',
			'phone'  	=> 'required|numeric|min_length[9]|max_length[13]|is_unique[users.phone,id,'.$id.']',
			'address'			=> 'required',
			'username'  	=> 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username,id,'.$id.']',
		];
		$password = $this->request->getPost('password');
		if($password){
			$rules['password'] = 'required|strong_password';
		}
		$photos = $this->request->getPost('photo');
		$photo = $this->request->getFile('photo');
		if($photos){
			$rules['photo'] = 'uploaded[photo]|max_size[photo,1024]|ext_in[photo,jpg,jpeg,png]';
		}

		if (! $this->validate($rules))
		{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$newName = "";
        if($photo) {
            if ($photo->isValid() && ! $photo->hasMoved()) {
               // Get photo name and extension
               $name = $photo->getName();
               $ext = $photo->getClientExtension();

               // Get random photo name
               $newName = $photo->getRandomName(); 

               // Store photo in public/uploads/ folder
               $photo->move(ROOTPATH . 'public/upload/users', $newName);

               // File path to display preview
               $filepath = base_url()."/upload/users/".$newName;
            }
        }
        if($this->request->getPost('active')){
        	$active = 1;
        }else{
        	$active = 0;
        }
        $data = [
        	'nik' => $this->request->getPost('nik'),
        	'name' => $this->request->getPost('name'),
        	'email' => $this->request->getPost('email'),
        	'phone' => $this->request->getPost('phone'),
        	'address' => $this->request->getPost('address'),
        	'username' => $this->request->getPost('username'),
        	'active' => $active,
        ];
		if($password){
			$data['password_hash'] = Password::hash($password);
		}

		if($newName){
			$data['photo'] = $newName;
			if($users->photo && file_exists('upload/users/'.$users->photo)){
				unlink("upload/users/".$users->photo);
			}
		}
		$this->builderuser->where('id', $id)->update($data);
		$rolesusers = $this->builderrole->where('name', $users->rolename)->get()->getRow();
		$this->builderroleuser->where('group_id', $rolesusers->id)->where('user_id', $id)->delete();
        $role = $this->request->getPost('role');
		$roles = $this->builderrole->where('name', $role)->get()->getRow();
        $datarole = [
        	'group_id' => $roles->id,
        	'user_id' => $id
        ];
		$this->builderroleuser->insert($datarole);
		return redirect()->route('dashboard/users')->with('message', 'Data updated successfully');
	}

	public function destroy($id=0)
	{
		if(!in_groups(['admin'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}
		$user = $this->userModel->select('users.*, auth_groups.name as rolename')
					 ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
					 ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
					 ->where('users.id !=', user()->id);
		if(!in_groups(['admin'])){
			$user = $user->where('users.id', user()->id);
		}
		$users = $user->find($id);
		if(empty($users)){
			if(in_groups(['admin'])){
				return redirect()->to('/dashboard/users')->with('errors', 'Data Not Found');
			}else{
				return redirect()->to('/dashboard')->with('errors', 'Data Not valid');
			}
		}else{
	        $data = [
	        	'deleted_at' => date('Y-m-d H:i:s')
	        ];
			$this->builderuser->where('id', $id);
			$this->builderuser->update($data);
			return redirect()->route('dashboard/users')->with('message', 'Data deleted successfully');
		}
    }
	
	public function profile()
	{
		$users = $this->userModel->select('users.*, auth_groups.name as rolename')
					 ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
					 ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
					 ->where('active', 1)->find(user()->id);
		if(empty($users)){
			return redirect()->to('/dashboard')->with('error', 'Data not valid.');
		}
		$data = [
			"title" => "Profile User",
			"users" => $users,
		];
		return view('back/users/profile/index', $data);
	}
	
	public function profileedit()
	{
		$users = $this->userModel->select('users.*, auth_groups.name as rolename')
					 ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
					 ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
					 ->where('active', 1)->find(user()->id);
		if(empty($users)){
			return redirect()->to('/dashboard')->with('error', 'Data not valid.');
		}
		$data = [
			"title" => "Edit Profile User",
			"users" => $users,
		];
		return view('back/users/profile/edit', $data);
	}
	
	public function profileupdate()
	{
		$users = $this->userModel->select('users.*, auth_groups.name as rolename')
					 ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
					 ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
					 ->where('active', 1)->find(user()->id);
		if(empty($users)){
			return redirect()->to('/dashboard')->with('error', 'Data not valid.');
		}
		$rules = [
			'nik'  	=> 'required|numeric|min_length[16]|max_length[16]|is_unique[users.nik,id,'.$users->id.']',
			'name'			=> 'required',
			'email'			=> 'required|valid_email|is_unique[users.email,id,'.$users->id.']',
			'phone'  	=> 'required|numeric|min_length[9]|max_length[13]|is_unique[users.phone,id,'.$users->id.']',
			'address'			=> 'required',
			'username'  	=> 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username,id,'.$users->id.']',
		];
		$password = $this->request->getPost('password');
		if($password){
			$rules['password'] = 'required|strong_password';
		}
		$photos = $this->request->getPost('photo');
		$photo = $this->request->getFile('photo');
		if($photos){
			$rules['photo'] = 'uploaded[photo]|max_size[photo,1024]|ext_in[photo,jpg,jpeg,png]';
		}

		if (! $this->validate($rules))
		{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$newName = "";
        if($photo) {
            if ($photo->isValid() && ! $photo->hasMoved()) {
               // Get photo name and extension
               $name = $photo->getName();
               $ext = $photo->getClientExtension();

               // Get random photo name
               $newName = $photo->getRandomName(); 

               // Store photo in public/uploads/ folder
               $photo->move(ROOTPATH . 'public/upload/users', $newName);

               // File path to display preview
               $filepath = base_url()."/upload/users/".$newName;
            }
        }
        // if($this->request->getPost('active')){
        // 	$active = 1;
        // }else{
        // 	$active = 0;
        // }
        $data = [
        	'nik' => $this->request->getPost('nik'),
        	'name' => $this->request->getPost('name'),
        	'email' => $this->request->getPost('email'),
        	'phone' => $this->request->getPost('phone'),
        	'address' => $this->request->getPost('address'),
        	'username' => $this->request->getPost('username'),
        	'active' => $active,
        ];
		if($password){
			$data['password_hash'] = Password::hash($password);
		}

		if($newName){
			$data['photo'] = $newName;
			if($users->photo && file_exists('upload/users/'.$users->photo)){
				unlink("upload/users/".$users->photo);
			}
		}
		$this->builderuser->where('id', $users->id);
		$this->builderuser->update($data);
		return redirect()->route('dashboard/profile')->with('message', 'Data updated successfully');
	}
}
