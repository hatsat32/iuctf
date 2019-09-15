<?php namespace App\Controllers\Admin;

use \App\Models\TeamModel;

class TeamController extends \App\Controllers\BaseController
{
	public function __construct()
	{
		$this->teamModel = new TeamModel();
	}

	//--------------------------------------------------------------------

	public function index()
	{
		$viewData['teams'] = $this->teamModel->findAll();

		return view('admin/team/index', $viewData);
	}

	//--------------------------------------------------------------------
	
	public function new()
	{
		return view('admin/team/new');
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
