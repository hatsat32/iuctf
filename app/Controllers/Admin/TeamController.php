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
		$data = [
			'leader_id' => $this->request->getPost('leader_id'),
			'name'		=> $this->request->getPost('name'),
			'is_banned'	=> '0',
			'auth_code'	=> bin2hex(random_bytes(32)),
		];
		
		$result = $this->teamModel->insert($data);

		if (! $result)
		{
			$errors = $this->teamModel->errors();
			var_dump($errors);die();
			return redirect()->to('/admin/teams/new');
		}

		return redirect()->to('/admin/teams');
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
