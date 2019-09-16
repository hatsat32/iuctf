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
		$viewData['users'] = $this->userModel->findAll();
		return view('admin/user/index', $viewData);
	}

	//--------------------------------------------------------------------
	
	public function new()
	{
		$viewData['teams'] = $this->teamModel->findAll();
		return view('admin/user/new', $viewData);
	}

	//--------------------------------------------------------------------
	
	public function edit($id = null)
	{
		
	}

	//--------------------------------------------------------------------
	
	public function show($id = null)
	{
		$user = $this->userModel->find($id);

		if (empty($user))
		{
			return redirect()->to('/admin/users');
		}

		$viewData['user'] = $user;
		$viewData['teams'] = $this->teamModel->findAll();

		return view('admin/user/detail', $viewData);
	}

	//--------------------------------------------------------------------
	
	public function create()
	{
		$data = [
			'username' => $this->request->getPost('username'),
			'email' => $this->request->getPost('email'),
			'name' => $this->request->getPost('name'),
			'team_id' => $this->request->getPost('team_id'),
			'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_ARGON2I),
		];

		$rules = array_merge($this->userModel->getValidationRules(['only' => ['email', 'username']]), [
			'password'	 => 'required|strong_password',
			'password-confirm' => 'required|matches[password]',
		]);

		if (! $this->validate($rules))
		{
			return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
		}

		$result = $this->userModel->insert($data);

		if ($result)
		{
			return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
		}

		// success
		return redirect()->to('/admin/users');
	}

	//--------------------------------------------------------------------
	
	public function delete($id = null)
	{
		$result = $this->userModel->delete($id);

		if (! $result)
		{
			$errors = $this->userModel->errors();
			return redirect()->to("admin/users/$id");
		}

		return redirect()->to("/admin/users");
	}

	//--------------------------------------------------------------------
	
	public function update($id = null)
	{
		$user = $this->userModel->find($id);
		$data = [
			'username' => $this->request->getPost('username'),
			'email' => $this->request->getPost('email'),
			'name' => $this->request->getPost('name'),
			'team_id' => $this->request->getPost('team_id'),
		];

		$result = $this->userModel->update($id, $data);
		if (! $result)
		{
			$errors = $this->userModel->errors();
			return redirect()->to("/admin/users/$id");
		}
		return redirect()->to("/admin/users/$id");
	}

	//--------------------------------------------------------------------
}
