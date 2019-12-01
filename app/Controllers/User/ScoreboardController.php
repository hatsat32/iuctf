<?php namespace App\Controllers\User;

use App\Core\UserController;
use App\Models\ChallengeModel;
use App\Models\SolvesModel;
use App\Models\TeamModel;

class ScoreboardController extends UserController
{
	protected $challengeModel;
	protected $teamModel;
	protected $solvesModel;
	
	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->challengeModel = new ChallengeModel();
		$this->teamModel      = new TeamModel();
		$this->solvesModel    = new SolvesModel();
	}

	//--------------------------------------------------------------------

	public function index()
	{
		/**
		 * this implementation will sucks
		 * but before that time I will research better implementation
		 */

		$challenges = $this->challengeModel
				->select(['challenges.id', 'challenges.name', 'challenges.point', 'challenges.type', 'challenges.is_active'])
				->selectCount('solves.id', 'solve_count')
				->join('solves', 'solves.challenge_id = challenges.id', 'left')
				->join('teams', 'teams.id = solves.team_id', 'left')
				->where('teams.is_banned', '0')
				->where('teams.deleted_at', null)
				->groupBy('challenges.id')
				->findAll();
		$teamScores = $this->teamModel
				->select(['teams.id', 'teams.name', ])->selectSum('hints.cost', 'cost_sum')->selectMax('solves.id', 'lastsolve')
				->join('hint_unlocks', 'teams.id = hint_unlocks.team_id', 'left')
				->join('hints', 'hints.id = hint_unlocks.hint_id', 'left')
				->join('solves', 'solves.team_id = teams.id', 'left')
				->groupBy('teams.id')
				->where('teams.is_banned', '0')
				->where('teams.deleted_at', null)
				->findAll();
		$solves = $this->solvesModel
				->select(['solves.*'])
				->join('teams', 'solves.team_id = teams.id', 'left')
				->where('teams.is_banned', '0')
				->where('teams.deleted_at', null)
				->findAll();

		foreach ($challenges as $ch => $challenge)
		{
			$challenges[$ch]['d_point'] = $this->calculatePoint($challenge['point'], $challenge['solve_count']);
		}

		foreach ($teamScores as $tm => $team)
		{
			$total_point = 0;

			$team_solves = array_column($this->teamSolves($solves, $team['id']), 'challenge_id');

			foreach ($challenges as $ch => $challenge)
			{
				if (in_array($challenge['id'], $team_solves))
				{
					if ($challenge['type'] === 'dynamic')
					{
						$total_point += $challenge['d_point'];
					}
					else
					{
						$total_point += $challenge['point'];
					}
				}
			}

			$teamScores[$tm]['total_point'] = $total_point;

			$teamScores[$tm]['final'] = $teamScores[$tm]['total_point'] - $teamScores[$tm]['cost_sum'];
		}

		// sort by rating or solve time
		usort($teamScores, function($a, $b) {
			$retval =  $b['final'] <=> $a['final'];

			if ($retval == 0)
			{
				$retval = $a['lastsolve'] <=> $b['lastsolve'];
			}

			return $retval;
		});

		$viewData['scores'] = $teamScores;
		return $this->render('scoreboard', $viewData);
	}

	//--------------------------------------------------------------------

	/**
	 * calculates dynamic point for challenge.
	 * 
	 * @param int $point
	 * @param int $solveCount
	 * @param int $decay
	 * 
	 * @return int
	 */
	protected function calculatePoint(int $point, int $solveCount, int $decay = 5)
	{
		$minimum = $point / 2;
		$solveCount -= 1;

		$value = (
			($minimum - $point) / ($decay ** 2) * ($solveCount ** 2)
		) + $point;

		if ($value < $minimum)
		{
			$value = $minimum;
		}

		return ceil($value);
	}

	//--------------------------------------------------------------------

	/**
	 * return solved challenges for certain team
	 * 
	 * @param array $solves
	 * @param int $teamID
	 * 
	 * @return array
	 */
	protected function teamSolves(array $solves, int $teamID)
	{
		$teamSolves = array_filter($solves, function ($solve) use ($teamID) {
			return $solve['team_id'] == $teamID;
		});

		return $teamSolves;
	}

	//--------------------------------------------------------------------
}
