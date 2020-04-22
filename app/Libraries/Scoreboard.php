<?php namespace App\Libraries;

use App\Models\ChallengeModel;
use App\Models\SolvesModel;
use App\Models\TeamModel;

class Scoreboard
{
	/**
	 * @var float
	 */
	public $minRate = 0.5;

	/**
	 * @var int
	 */
	public $decay = 5;

	//--------------------------------------------------------------------

	public function __construct($minRate = 0.5, $decay = 5)
	{
		$this->minRate = $minRate;
		$this->decay   = $decay;
	}

	//--------------------------------------------------------------------

	public function scores()
	{
		$teams = $this->getTeams();
		$hintUnlocks = $this->getHintUnlocks();
		$solves = $this->getSolves();

		$solves = $this->cacculateChallengePoints($solves);

		$subscores = $this->calculateTeamScores($teams, $solves, $hintUnlocks);

		$subscores = $this->sort($subscores);

		$subscores = array_filter($subscores, function($score) {
			return $score->final != 0;
		});

		return $subscores;
	}

	//--------------------------------------------------------------------

	public function sort($scores)
	{
		// sort by rating or solve time
		usort($scores, function($a, $b) {
			$retval =  $b->final <=> $a->final;

			// if points are equal, team who solves before considered as tie-winner
			if ($retval == 0)
			{
				$retval = $a->lastsolve <=> $b->lastsolve;
			}

			return $retval;
		});

		return $scores;
	}

	//--------------------------------------------------------------------

	/**
	 * calculate teams points
	 *
	 * @param array $teams
	 * @param array $challenges
	 * @param array $solves
	 * @return array
	 */
	public function calculateTeamScores(array $teams, array $solves, array $hintUnlocks)
	{
		$entities = array_merge($solves, $hintUnlocks);

		usort($entities, function($a, $b) {
			return $b->created_at->isBefore($a->created_at);
		});

		if (count($entities) > 0)
		{
			$first_time = $entities[0]->created_at->subHours(1)->toDateTimeString();
		}
		else
		{
			$first_time = (new \CodeIgniter\I18n\Time())->now()->subHours(1)->toDateTimeString();
		}

		foreach ($teams as $team)
		{
			$solves = [[
				'sub_point' => 0,
				'event'     => 0,
				'date'      => $first_time,
			]];
			$tmp_point = 0;
			$tmp_cost = 0;
			$tmp_score = 0;

			foreach ($entities as $entiti)
			{
				if ($team->id == $entiti->team_id && $entiti instanceof \App\Entities\Solve)
				{
					$point = $entiti->type === 'dynamic' ? $entiti->d_point : $entiti->point;

					array_push($solves, [
						'sub_point' => $tmp_point + $point,
						'event'     => (int)$point,
						'date'      => $entiti->created_at->toDateTimeString(),
					]);

					$tmp_point += $point;
					$tmp_score += $point;
				}
				else if ($team->id == $entiti->team_id && $entiti instanceof \App\Entities\HintUnlock)
				{
					array_push($solves, [
						'sub_point' => $tmp_point - $entiti->cost,
						'event'     => -(int)$entiti->cost,
						'date'      => $entiti->created_at->toDateTimeString(),
					]);

					$tmp_point -= $entiti->cost;
					$tmp_cost += $entiti->cost;
				}
			}

			$team->solves = $solves;
			$team->cost_sum = $tmp_cost;
			$team->point_sum = $tmp_score;
			$team->final = $tmp_point;
		}

		return $teams;
	}

	//--------------------------------------------------------------------

	/**
	 * calculated each challenges points
	 *
	 * @param array $solves
	 * @return array
	 */
	public function cacculateChallengePoints($solves)
	{
		foreach ($solves as $i => $solve) {
			$solves[$i]->d_point = $this->calculatePoint($solve->point, $solve->solve_count);
		}

		return $solves;
	}

	//--------------------------------------------------------------------

	/**
	 * calculates dynamic point for challenge.
	 *
	 * @param int $point
	 * @param int $solveCount
	 *
	 * @return int
	 */
	public function calculatePoint(int $point, int $solveCount)
	{
		$minimum = $point * $this->minRate;

		if ($solveCount > 0)
		{
			$solveCount -= 1;
		}

		$value = (
			($minimum - $point) / ($this->decay ** 2) * ($solveCount ** 2)
		) + $point;

		if ($value < $minimum)
		{
			$value = $minimum;
		}

		return intval( ceil($value) );
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
	public function teamSolves(array $solves, int $teamID)
	{
		return array_filter($solves, function ($solve) use ($teamID) {
			return $solve->team_id == $teamID;
		});
	}

	//--------------------------------------------------------------------

	/**
	 * get teams and sum of hint costs for each team
	 *
	 * each team has fallowing fields
	 *   - id -> team id
	 *   - name -> team name
	 *   - cost_sum -> sum of hint costs
	 *   - lastsolve -> last solve id. Required for sorting
	 *
	 * @return array
	 */
	public function getTeams()
	{
		$teamModel = new TeamModel();

		return $teamModel
				->select(['teams.id', 'teams.name', ])
				->selectMax('solves.id', 'lastsolve')
				->join('solves', 'solves.team_id = teams.id', 'left')
				->groupBy('teams.id')
				->where('teams.is_banned', '0')
				->findAll();
	}

	//--------------------------------------------------------------------

	/**
	 * Get all solves with related challenge point and solve count of each challenge
	 *
	 * @return array|null
	 */
	public function getSolves()
	{
		$solvesModel = new SolvesModel();

		return $solvesModel->select(['solves.*', 'challenges.name', 'challenges.point', 'challenges.type'])
			->selectCount('S.id', 'solve_count')
			->join('challenges', 'solves.challenge_id = challenges.id', 'left')
			->join('solves S', 'S.challenge_id = challenges.id', 'left')
			->groupBy('solves.id, challenges.id, solves.team_id')
			->findAll();
	}

	//--------------------------------------------------------------------

	/**
	 * Returns all hint unlocks with hint cost
	 *
	 * @return array|null
	 */
	public function getHintUnlocks()
	{
		$hintUnlockModel = new \App\Models\HintUnlockModel();

		return $hintUnlockModel
				->select(['hint_unlocks.*', 'hints.cost'])
				->join('hints', 'hint_unlocks.hint_id = hints.id', 'left')
				->findAll();
	}

	//--------------------------------------------------------------------
}
