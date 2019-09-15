<?php namespace App\Controllers\Admin;

class Admin extends \App\Controllers\BaseController
{
	//--------------------------------------------------------------------

	public function index()
	{
		return view('admin/dashboard');
	}

	//--------------------------------------------------------------------
}
