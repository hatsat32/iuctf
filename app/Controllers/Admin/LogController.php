<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use App\Models\SubmissionModel;

class LogController extends AdminController
{
	//--------------------------------------------------------------------

	public function index()
	{
		return redirect('admin-dashboard');
	}

	//--------------------------------------------------------------------

	public function submission()
	{
		$submissionModel = new SubmissionModel();

		$submissionModel->select(['submissions.*', 'users.username', 'users.id', 'teams.name AS team_name',
				'teams.id AS team_id', 'challenges.name AS ch_name', 'challenges.id AS ch_id'])
				->join('users', 'submissions.user_id = users.id')
				->join('teams', 'submissions.team_id = teams.id')
				->join('challenges', 'submissions.challenge_id = challenges.id')
				->orderBy('submissions.created_at', 'DESC');

		$viewData = [
			'submissions' => $submissionModel->paginate(100),
			'pager'       => $submissionModel->pager,
		];

		return $this->render('log/submission', $viewData);
	}

	//--------------------------------------------------------------------

	public function login()
	{
		$loginModel = new \Myth\Auth\Models\LoginModel();
		$loginModel->select(['auth_logins.*', 'users.username'])
				->join('users', 'auth_logins.user_id = users.id', 'left')
				->orderBy('date', 'DESC');

		$viewData = [
			'logins' => $loginModel->paginate(100),
			'pager'  => $loginModel->pager,
		];

		return $this->render('log/logins', $viewData);
	}

	//--------------------------------------------------------------------
}
