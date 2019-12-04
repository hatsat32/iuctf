<?php namespace App\Controllers\User;

use App\Core\UserController;
use \App\Models\TeamModel;
use \App\Models\UserModel;
use Myth\Auth\Config\Services;


class ProfileController extends UserController
{
	private $teamModel;
	private $userModel;

	private $auth;

	//--------------------------------------------------------------------

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->auth = Services::authentication();

		$this->teamModel = new TeamModel();
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
			return redirect()->back()->with('profile-errors', ['error' => 'Parola Hatalı']);
		}

		$data = [
			'username' => $this->request->getPost('username'),
			'email'    => $this->request->getPost('email'),
			'name'     => $this->request->getPost('name'),
		];

		$result = $this->userModel->update(user()->id, $data);

		if (! $result)
		{
			$errors = $this->userModel->errors();
			return redirect()->to("/profile")->with('profile-errors', $errors);
		}

		return redirect()->to('profile')->with('profile-success', 'Profil Bilgileri Başarı İle Güncellendi');
	}

	//--------------------------------------------------------------------

	public function updatePassword()
	{
		$users = new \Myth\Auth\Models\UserModel();
		$user = user();

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
			return redirect()->back()->withInput()->with('errors', ['error' => 'incorrect password']);
		}

		$user->password = $this->request->getPost('password');
		$users->save($user);

		return redirect()->to('/profile')->with('success', 'Parola Başarı İle Değiştirildi');
	}

	//--------------------------------------------------------------------
}
