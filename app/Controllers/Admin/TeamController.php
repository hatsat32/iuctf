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
		$team = $this->teamModel->find($id);
		$viewData['team'] = $team;
		return view('admin/team/detail', $viewData);
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
			return redirect()->to('/admin/teams/new');
		}

		return redirect()->to('/admin/teams');
	}

	//--------------------------------------------------------------------

	public function delete($id = null)
	{
		$result = $this->teamModel->delete($id);

		if (! $result)
		{
			$viewData['errors'] = $this->teamModel->errors();
			return redirect()->to("/admin/teams/$id", $viewData);
		}

		return redirect()->to('/admin/teams');
	}

	//--------------------------------------------------------------------

	public function update($id = null)
	{
		$team = $this->teamModel->find($id);
		$data = [
			'name' => $this->request->getPost('name'),
		];

		$result = $this->teamModel->update($id, $data);
		if (! $result)
		{
			$viewData['errors'] = $this->teamModel->errors();
			return redirect()->to("/admin/teams/$id", $viewData);
		}
		return redirect()->to("/admin/teams/$id");
	}

	//--------------------------------------------------------------------

	public function changeAuthCode($id = null)
	{
		$data = [
			'auth_code'	=> bin2hex(random_bytes(32)),
		];

		$result = $this->teamModel->update($id, $data);

		if (! $result)
		{
			$viewData['errors'] = $this->teamModel->errors();
			return redirect()->to("/admin/teams/$id", $viewData);
		}
		return redirect()->to("/admin/teams/$id");
	}
}
