<?php namespace App\Controllers\User;

use \App\Models\ChallengeModel;
use \App\Models\CategoryModel;
use \App\Models\FlagModel;
use \App\Models\SolvesModel;
use \App\Models\TeamModel;
use \App\Models\HintModel;
use \App\Models\HintUnlockModel;
use \App\Models\FileModel;

use Myth\Auth\Config\Services;

class UserController extends \App\Controllers\BaseController
{
	private $challengeModel;
	private $categorygeModel;
	private $flagModel;
	private $solvesModel;
	private $teamModel;
	private $hintModel;

	private $auth;
	private $authorize;

	public function __construct()
	{
		$this->challengeModel = new ChallengeModel();
		$this->categorygeModel = new CategoryModel();
		$this->flagModel = new FlagModel();
		$this->solvesModel = new SolvesModel();
		$this->teamModel = new TeamModel();
		$this->hintModel = new HintModel();
		$this->fileModel = new FileModel();

		$this->auth = Services::authentication();
		$this->authorize = Services::authorization();
	}

	//--------------------------------------------------------------------

	public function challenges($id = null)
	{
		$challenges = $this->challengeModel->findAll();
		$categories = $this->categorygeModel->findAll();
		$viewData['solves'] = $this->solvesModel->where('team_id', user()->team_id)->findColumn('challenge_id') ?? [];

		foreach ($categories as $c_key => $c_val) {
			$arr = array_filter($challenges, function($challenge) use ($c_val) {
				return $challenge['category_id'] == $c_val['id'];
			});

			if(! empty($arr))
			{
				$categories[$c_key]['challenges'] = $arr;
			}
		}

		$viewData['categories'] = $categories;

		if ($id !== null)
		{
			$viewData['challenge'] = $this->challengeModel->find($id);
			$viewData['hints'] = $this->hintModel
								->where('challenge_id', $id)
								->where('is_active', "1")
								->orderBy('id')
								->findAll();
			$viewData['hints_unlocks'] = (new HintUnlockModel())
										->where('challenge_id', $id)
										->where('team_id', user()->team_id)
										->findColumn('hint_id') ?? [];
			$viewData['firstblood'] = $this->solvesModel
										->select(['teams.name', 'solves.created_at'])
										->from('teams')
										->where('challenge_id', $id)
										->where('solves.team_id', 'teams.id', false)
										->orderBy('solves.created_at')
										->first();
			$viewData['files'] = $this->fileModel->where('challenge_id', $id)->findAll();
		}

		return view('darky/challenges', $viewData);
	}

	//--------------------------------------------------------------------

	public function flagSubmit($challengeID = null)
	{
		$flags = $this->flagModel->where('challenge_id', $challengeID)->findAll();
		$submited_flag = $this->request->getPost('flag');

		$result = false;
		foreach ($flags as $flag)
		{
			if ($flag['type'] === 'static' && $flag['content'] === $submited_flag)
			{
				$result = true;
				break;
			}
			else if ($flag['type'] === 'regex' && preg_match("/{$flag['content']}/", $submited_flag))
			{
				$result = true;
				break;
			}
		}

		$submitModel = new \App\Models\SubmitModel();
		$data = [
			'challenge_id'  => $challengeID,
			'user_id'		=> user()->id,
			'team_id'		=> user()->team_id,
			'ip'			=> $this->request->getIPAddress(),
			'provided'		=> $submited_flag,
			'type'			=> $result ? '1':'0',
		];
		$submitModel->insert($data);

		if (! $result)
		{
			return redirect()->to("/challenges/$challengeID")->with('result', $result);
		}

		$data = [
			'challenge_id'	=> $challengeID,
			'team_id'		=> user()->team_id,
		];

		$solved_before = $this->solvesModel->where($data)->find();

		if (empty($solved_before) && user()->team_id !== null)
		{
			$data['user_id'] = $this->auth->id();

			$db_result = $this->solvesModel->insert($data);

			if ($db_result)
			{
				return redirect()->to("/challenges/$challengeID")->with('result', $result);
			}
			else
			{
				$errors = $this->solvesModel->errors();
				return redirect()->to("/challenges/$challengeID")->with('result', $result)->with('errors', $errors);
			}
		}

		return redirect()->to("/challenges/$challengeID")->with('result', $result);
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
		select teams.name, (SUM(challenges.point) - costs.s) AS point, max(solves.id)
		from teams
		inner join solves on solves.team_id = teams.id
		inner join challenges on challenges.id = solves.challenge_id
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
		return view('darky/scoreboard', $viewData);
	}

	//--------------------------------------------------------------------

	public function notifications()
	{
		$notificationModel = new \App\Models\NotificationModel();
		$viewData['notifications'] = $notificationModel
									->orderBy('created_at', 'DESC')
									->findAll();
		return view('darky/notifications', $viewData);
	}

	//--------------------------------------------------------------------

	public function hash()
	{
		return view('darky/hash');
	}

	//--------------------------------------------------------------------

	public function gethash()
	{
		if (empty($this->request->getPost('hash')))
		{
			return view('darky/hash');
		}

		$hash =  hash('sha256', $this->request->getPost('hash'));

		return view('darky/hash', ['hash' => $hash]);
	}

	//--------------------------------------------------------------------

	public function hint($challengeID = null, $hintID = null)
	{
		$hintUnlockModel = new HintUnlockModel();

		$data = [
			'hint_id'		=> $hintID,
			'user_id'		=> user()->id,
			'team_id'		=> user()->team_id,
			'challenge_id'	=> $challengeID,
		];

		$result = $hintUnlockModel->insert($data);

		if (! $result)
		{
			$errors = $hintUnlockModel->errors();
			return redirect()->to("/challenges/$challengeID")->with('errors', $errors);
		}

		return redirect()->to("/challenges/$challengeID");
	}

	//--------------------------------------------------------------------
}
