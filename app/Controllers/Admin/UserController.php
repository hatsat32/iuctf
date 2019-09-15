<?php namespace App\Controllers\Admin;

use \App\Models\UserModel;
use \App\Models\TeamModel;

class UserController extends \App\Controllers\BaseController
{
	public function __construct()
	{
		$this->userModel = new UserModel();
		$this->teamModel = new TeamModel();
	}

	//--------------------------------------------------------------------

	public function index()
	{

	}

	//--------------------------------------------------------------------
	
	public function new()
	{

	}

	//--------------------------------------------------------------------
	
	public function edit($id = null)
	{
		
	}

	//--------------------------------------------------------------------
	
	public function show($id = null)
	{
		
	}

	//--------------------------------------------------------------------
	
	public function create()
	{

	}

	//--------------------------------------------------------------------
	
	public function delete($id = null)
	{
		
	}

	//--------------------------------------------------------------------
	
	public function update($id = null)
	{
		
	}

	//--------------------------------------------------------------------
}
