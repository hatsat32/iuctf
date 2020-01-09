<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use App\Models\UserModel;
use App\Models\TeamModel;

class UserController extends AdminController
{
	/** @var UserModel **/
	private $userModel;
	/** @var TeamModel **/
	private $teamModel;

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->userModel = new UserModel();
		$this->teamModel = new TeamModel();
	}

	//--------------------------------------------------------------------

	public function index()
	{
		$viewData['users'] = $this->userModel->findAll();
		return $this->render('user/index', $viewData);
	}

	//--------------------------------------------------------------------

	public function new()
	{
		$viewData['teams'] = $this->teamModel->findAll();
		return $this->render('user/new', $viewData);
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

		return $this->render('user/detail', $viewData);
	}

	//--------------------------------------------------------------------

	public function create()
	{
		$data = [
			'username'      => $this->request->getPost('username'),
			'email'         => $this->request->getPost('email'),
			'name'          => $this->request->getPost('name'),
			'team_id'       => $this->request->getPost('team_id'),
			'password_hash' => password_hash(
				base64_encode(
					hash('sha384', $this->request->getPost('password'), true)
				),
				PASSWORD_ARGON2I
			),
		];

		$rules = array_merge($this->userModel->getValidationRules(['only' => ['email', 'username']]), [
			'password'         => 'required|strong_password',
			'password-confirm' => 'required|matches[password]',
		]);

		if (! $this->validate($rules))
		{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$result = $this->userModel->insert($data);

		if (! $result)
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

		$user->fill($this->request->getPost());

		$result = $this->userModel->update($id, $user);

		if (! $result)
		{
			$errors = $this->userModel->errors();
			return redirect()->to("/admin/users/$id")->with('errors', $errors);
		}

		return redirect()->to("/admin/users/$id")->with('message', lang('admin/User.updatedSuccessfully'));
	}

	//--------------------------------------------------------------------

	public function changePassword($user_id = null)
	{
		$authUserModel = new \Myth\Auth\Models\UserModel();
		$user = $authUserModel->find($user_id);

		$rules = [
			'password'         => 'required|strong_password',
			'password-confirm' => 'required|matches[password]',
		];

		if (! $this->validate($rules))
		{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$user->password = $this->request->getPost('password');
		$authUserModel->save($user);

		return redirect()->back()->with('success', 'Password updated successfully');
	}

	//--------------------------------------------------------------------

	public function addAdmin($user_id = null)
	{
		$authorize = \Myth\Auth\Config\Services::authorization();

		$authorize->addUserToGroup($user_id, 'admin');

		return redirect()->to("/admin/users/$user_id");
	}

	//--------------------------------------------------------------------

	public function rmAdmin($user_id = null)
	{
		$authorize = \Myth\Auth\Config\Services::authorization();

		$authorize->removeUserFromGroup($user_id, 'admin');

		return redirect()->to("/admin/users/$user_id");
	}

	//--------------------------------------------------------------------

	public function ban($id = null)
	{
		$authUserModel = new \Myth\Auth\Models\UserModel();
		$user = $authUserModel->find($id);

		$user->ban('');
		$result = $authUserModel->save($user);

		if (! $result)
		{
			$errors = $this->authUserModel->errors();
			return redirect()->to("/admin/users/$id")->with('errors', $errors);
		}

		return redirect()->to("/admin/users/$id");
	}

	//--------------------------------------------------------------------

	public function unBan($id = null)
	{
		$authUserModel = new \Myth\Auth\Models\UserModel();
		$user = $authUserModel->find($id);

		$user->unBan();
		$result = $authUserModel->save($user);

		if (! $result)
		{
			$errors = $this->authUserModel->errors();
			return redirect()->to("/admin/users/$id")->with('errors', $errors);
		}

		return redirect()->to("/admin/users/$id");
	}

	//--------------------------------------------------------------------
}
