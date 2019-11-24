<?php namespace App\Controllers\Admin;

use \App\Models\SubmitModel;

class LogController extends \App\Controllers\BaseController
{
	public function __construct()
	{

	}

	//--------------------------------------------------------------------

	public function index()
	{
		return redirect()->to('/admin');
	}

	//--------------------------------------------------------------------

	public function submits()
	{
		$submitModel = new SubmitModel();

		$submitBuilder = $submitModel->builder();
		$query = $submitBuilder->select(['submits.id', 'users.username', 'submits.ip',
											'submits.provided', 'submits.type', 'submits.created_at'])
								->select('teams.name as tname', false)
								->select('challenges.name as chname', false)
								->from(['users', 'teams', 'challenges'])
								->where('submits.user_id', 'users.id', false)
								->where('submits.team_id', 'teams.id', false)
								->where('submits.challenge_id', 'challenges.id', false)
								->orderBy('submits.created_at', 'DESC');

		$viewData = [
			'submits'	=> $query->paginate(100),
			'pager'		=> $query->pager,
		];

		return view('/admin/log/submits', $viewData);
	}

	//--------------------------------------------------------------------

	public function login()
	{
		$loginModel = new \Myth\Auth\Models\LoginModel();
		$loginModel->asArray();

		$viewData = [
			'logins'	=> $loginModel->paginate(100),
			'pager'		=> $loginModel->pager,
		];

		return view('/admin/log/logins', $viewData);
	}

	//--------------------------------------------------------------------
}
