<?php namespace App\Controllers\User;

use App\Core\UserController;
use App\Models\ChallengeModel;
use App\Models\SolvesModel;
use App\Models\TeamModel;
use App\Libraries\Scoreboard;

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

		$scorelib = new Scoreboard();

		if ($scores = cache('scores'))
		{
			return $this->render('scoreboard', ['scores' => $scores]);
		}

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

		$challenges = $scorelib->cacculateChallengePoint($challenges);

		$teamScores = $scorelib->calculateTeamScores($teamScores, $challenges, $solves);

		$scorelib->sort($teamScores);

		cache()->save("scores", $teamScores, MINUTE * 5);
		return $this->render('scoreboard', ['scores' => $teamScores]);
	}

	//--------------------------------------------------------------------
}
