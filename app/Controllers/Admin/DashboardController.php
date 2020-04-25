<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use App\Models\SubmissionModel;
use App\Models\ChallengeModel;

class DashboardController extends AdminController
{
	//--------------------------------------------------------------------

	public function index()
	{
		$db = db_connect();

		if (! $statistics = cache('statistics'))
		{
			$statistics = [
				'user_count'       => $db->table('users')->countAll(),
				'team_count'       => $db->table('teams')->countAll(),
				'submission_count' => $db->table('submissions')->countAll(),
				'solve_count'      => $db->table('solves')->countAll(),
			];

			$submodel = new SubmissionModel();
			$statistics['submission_chart_data'] = $submodel
					->selectCount('id', 'total')
					->select('COUNT(IF(type = "0", 1, NULL)) correct', true)
					->select('COUNT(IF(type = "1", 1, NULL)) wrong', true)
					->asArray()
					->first();
					
			$challengeModel = new ChallengeModel();
			$statistics['challenge_chart_data'] = $challengeModel
					->select(['challenges.id', 'challenges.name'])
					->selectCount('solves.id', 'solve_count')
					->join('solves', 'challenges.id = solves.challenge_id', 'left')
					->groupBy('challenges.id')
					->orderBy('solve_count', 'DESC')
					->asArray()
					->limit(10)
					->findAll();

			cache()->save('statistics', $statistics, MINUTE);
		}

		return $this->render('dashboard', $statistics);
	}

	//--------------------------------------------------------------------
}
