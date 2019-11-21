<?php namespace App\Controllers\User;

use App\Core\UserController;

class UserUtilityController extends UserController
{
	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);
	}

	//--------------------------------------------------------------------

	public function scoreboard()
	{
		/**
		 * I know this is not good solution.
		 * but i cant find any better solution for yet!
		 * when i find, i update this function.
		 * for now let function run this way.
		 */

		$sql = "
		select teams.name, (SUM(IFNULL(challenges.point, 0)) - costs.s) AS point, max(IFNULL(solves.id,0)) AS tie
		from teams
		left join solves on solves.team_id = teams.id
		left join challenges on challenges.id = solves.challenge_id
		left join (
			SELECT teams.name, IFNULL(SUM(hints.cost),0) as s
			FROM teams
				left join hint_unlocks on teams.id = hint_unlocks.team_id
				left join hints on hints.id = hint_unlocks.hint_id
			GROUP BY name
		) as costs on costs.name = teams.name
		GROUP by teams.name
		ORDER BY `point` DESC, `solves`.`id` DESC
		";

		$db = db_connect();
		$query = $db->query($sql);
		$scores = $query->getResultArray();

		$viewData['scores'] = $scores;
		return $this->render('scoreboard', $viewData);
	}

	//--------------------------------------------------------------------

	public function notifications()
	{
		$notificationModel = new \App\Models\NotificationModel();
		$viewData['notifications'] = $notificationModel
									->orderBy('created_at', 'DESC')
									->findAll();
		return $this->render('notifications', $viewData);
	}

	//--------------------------------------------------------------------

	public function hash()
	{
		return $this->render('hash');
	}

	//--------------------------------------------------------------------

	public function gethash()
	{
		if (empty($this->request->getPost('hash')))
		{
			return $this->render('hash');
		}

		$hash =  hash('sha256', $this->request->getPost('hash'));

		return $this->render('hash', ['hash' => $hash]);
	}

	//--------------------------------------------------------------------
}
