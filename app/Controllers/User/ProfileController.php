<?php namespace App\Controllers\User;

use App\Core\UserController;
use App\Models\UserModel;
use Myth\Auth\Config\Services;


class ProfileController extends UserController
{
	/** @var UserModel **/
	protected $userModel;

	protected $auth;

	//--------------------------------------------------------------------

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->auth = Services::authentication();

		$this->userModel = new UserModel();
	}

	//--------------------------------------------------------------------

	public function index()
	{
		$viewData['user'] = $this->userModel->find(user_id());

		return $this->render('profile', $viewData);
	}

	//--------------------------------------------------------------------

	public function updateProfile()
	{
		$credentials = [
			'username' => user()->username,
			'password' => $this->request->getPost('password')
		];

		if (! $this->auth->validate($credentials))
		{
			return redirect('profile')->with('profile-errors', [lang('Home.wrongPassword')]);
		}

		$data = [
			'username' => $this->request->getPost('username'),
			'email'    => $this->request->getPost('email'),
			'name'     => $this->request->getPost('name'),
		];

		$result = $this->userModel->update(user()->id, $data);

		if (! $result)
		{
			return redirect('profile')->with('profile-errors', $this->userModel->errors());
		}

		return redirect('profile')->with('profile-success', lang('Home.updatedSuccessfully'));
	}

	//--------------------------------------------------------------------

	public function updatePassword()
	{
		$users = new \Myth\Auth\Models\UserModel();
		$user = user();

		if ($this->request->getPost('email') !== user()->email)
		{
			return redirect()->back();
		}

		$rules = [
			'password-old'     => 'required',
			'password'         => 'required|strong_password',
			'password-confirm' => 'required|matches[password]',
		];

		if (! $this->validate($rules))
		{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$credentials = [
			'username' => user()->username,
			'password' => $this->request->getPost('password-old')
		];

		if (! $this->auth->validate($credentials))
		{
			return redirect()->back()->withInput()->with('errors', [lang('Home.wrongPassword')]);
		}

		$user->password = $this->request->getPost('password');

		if (! $users->save($user))
		{
			return redirect()->back()->with('errors', $users->errors());
		}

		return redirect()->back()->with('success', lang('Home.passwordChanged'));
	}

	//--------------------------------------------------------------------
}
