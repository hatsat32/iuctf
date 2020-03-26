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
		$challenges = $this->getChallenges();
		$teams      = $this->getTeams();
		$solves     = $this->getSolves();

		$challenges = $this->cacculateChallengePoints($challenges);
		$teamScores = $this->calculateTeamScores($teams, $challenges, $solves);

		$scores = $this->sort($teamScores);

		return $scores;
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
	public function calculateTeamScores($teams, $challenges, $solves)
	{
		foreach ($teams as $i => $team)
		{
			$total_point = 0;

			$team_solves = array_column($this->teamSolves($solves, $team->id), 'challenge_id');

			foreach ($challenges as $challenge)
			{
				if (in_array($challenge->id, $team_solves))
				{
					if ($challenge->type === 'dynamic')
					{
						$total_point += $challenge->d_point;
					}
					else
					{
						$total_point += $challenge->point;
					}
				}
			}

			$teams[$i]->total_point = $total_point;

			$teams[$i]->final = $teams[$i]->total_point - $teams[$i]->cost_sum;
		}

		return $teams;
	}

	//--------------------------------------------------------------------

	/**
	 * calculated each challenges points
	 * 
	 * @param array $challenges
	 * @return array
	 */
	public function cacculateChallengePoints($challenges)
	{
		foreach ($challenges as $i => $challenge)
		{
			$challenges[$i]->d_point = $this->calculatePoint($challenge->point, $challenge->solve_count);
		}

		return $challenges;
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
		$teamSolves = array_filter($solves, function ($solve) use ($teamID) {
			return $solve->team_id == $teamID;
		});

		return $teamSolves;
	}

	//--------------------------------------------------------------------

	/**
	 * get challenges and each challenge's solve count
	 *
	 * each challenge has fallowing fields
	 *   - id    -> id
	 *   - name  -> name
	 *   - point -> point
	 *   - type  -> static or dynamic
	 *   - is_active   -> 1 or 0
	 *   - solve_count -> number of solves
	 *
	 * @return array
	 */
	public function getChallenges()
	{
		$challengeModel = new ChallengeModel();

		$challenges = $challengeModel
				->select(['challenges.id', 'challenges.name', 'challenges.point', 'challenges.type', 'challenges.is_active'])
				->selectCount('solves.id', 'solve_count')
				->join('solves', 'solves.challenge_id = challenges.id', 'left')
				->join('teams', 'teams.id = solves.team_id', 'left')
				->where('teams.is_banned', '0')
				->where('teams.deleted_at', null)
				->groupBy('challenges.id')
				->findAll();

		return $challenges;
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

		$teamScores = $teamModel
				->select(['teams.id', 'teams.name', ])
				->selectSum('hints.cost', 'cost_sum')
				->selectMax('solves.id', 'lastsolve')
				->join('hint_unlocks', 'teams.id = hint_unlocks.team_id', 'left')
				->join('hints', 'hints.id = hint_unlocks.hint_id', 'left')
				->join('solves', 'solves.team_id = teams.id', 'left')
				->groupBy('teams.id')
				->where('teams.is_banned', '0')
				->where('teams.deleted_at', null)
				->findAll();

		return $teamScores;
	}

	//--------------------------------------------------------------------

	/**
	 * Get all solves
	 * - Except deleted and banned team solves
	 *
	 * @return array
	 */
	public function getSolves()
	{
		$solvesModel = new SolvesModel();

		$solves = $solvesModel
				->select(['solves.*'])
				->join('teams', 'solves.team_id = teams.id', 'left')
				->where('teams.is_banned', '0')
				->where('teams.deleted_at', null)
				->findAll();

		return $solves;
	}

	//--------------------------------------------------------------------
}
