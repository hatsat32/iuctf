<?php namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Services;

class Install extends BaseController
{
	//--------------------------------------------------------------------

	public function index()
	{
		$db = db_connect();

		// install check
		if ($db->tableExists('settings'))
		{
			return redirect('installed')->with('message', lang('Install.alreadyInstalled'));
		}

		return view('install/install');
	}

	//--------------------------------------------------------------------

	public function installed()
	{
		if (! session()->has('message'))
		{
			session()->setFlashdata('message', lang('Install.alreadyInstalled'));
		}

		return view('install/installed');
	}

	//--------------------------------------------------------------------

	public function install()
	{
		$db = db_connect();

		// install check
		// if settings table exist, platform already installed
		if ($db->tableExists('settings'))
		{
			return redirect('installed');
		}

		$users = new \Myth\Auth\Models\UserModel();
		$rules = [
			'username'         => 'required|alpha_numeric_space|min_length[3]',
			'email'            => 'required|valid_email',
			'password'         => 'required|strong_password',
			'password-confirm' => 'required|matches[password]',
		];
		if (! $this->validate($rules))
		{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		// run database migratios
		$migrate = \Config\Services::migrations();
		try
		{
			$migrate->latest();
		}
		catch (\Exception $e)
		{
			return redirect()->back()->with('errors', [
				lang('Install.migrationRunError'),
				$e->getMessage(),
			]);
		}

		// run seeds
		$seeder = \Config\Database::seeder();
		$seeder->call('InstallSeeder');

		// create admin user
		$user = new \Myth\Auth\Entities\User($this->request->getPost());
		$user->activate();

		// save admin user
		if (! $admin_id = $users->save($user))
		{
			return redirect()->back()->withInput()->with('errors', $users->errors());
		}

		// add user to admin group
		$auth  = Services::authorization();
		try
		{
			$auth->addUserToGroup($admin_id, 'admin');
		}
		catch (\Exception $e)
		{
			return redirect()->back()->with('errors', [
				lang('Install.addUserToAdminGroupError'),
				$e->getMessage(),
			]);
		}

		// and login
		$auth  = Services::authentication();
		$credentials = [
			'username' => $this->request->getPost('username'),
			'password' => $this->request->getPost('password'),
		];
		if (! $auth->attempt($credentials, false))
		{
			return redirect()->back()->withInput()->with('error', $auth->error() ?? lang('Auth.badAttempt'));
		}

		// success
		return redirect('installed')->with('message', lang('Install.installationSuccessfull'));
	}

	//--------------------------------------------------------------------
}
