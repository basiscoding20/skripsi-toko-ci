<?php

namespace App\Controllers\Back;
use App\Controllers\BaseController;

class HomeController extends BaseController
{
	public function __construct(){
		//
	}
	
	public function index()
	{
		$data = [
			"title" => "Dashboard"
		];
		return view('back/home', $data);
	}
}
