<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use \App\Models\SubmissionModel;

class LogController extends AdminController
{
	//--------------------------------------------------------------------

	public function index()
	{
		return redirect()->to('/admin');
	}

	//--------------------------------------------------------------------

	public function submission()
	{
		$submissionModel = new SubmissionModel();

		$submissionBuilder = $submissionModel->builder();
		$submissionBuilder->select(['submissions.id', 'users.username', 'submissions.ip', 'submissions.provided', 
					'submissions.type', 'submissions.created_at'])
				->select('teams.name as tname', false)
				->select('challenges.name as chname', false)
				->from(['users', 'teams', 'challenges'])
				->where('submissions.user_id', 'users.id', false)
				->where('submissions.team_id', 'teams.id', false)
				->where('submissions.challenge_id', 'challenges.id', false)
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
		$loginModel->asArray();

		$viewData = [
			'logins' => $loginModel->paginate(100),
			'pager'  => $loginModel->pager,
		];

		return $this->render('log/logins', $viewData);
	}

	//--------------------------------------------------------------------
}
