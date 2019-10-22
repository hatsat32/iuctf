<?php namespace App\Controllers\User;

use \App\Models\ChallengeModel;
use \App\Models\CategoryModel;
use \App\Models\FlagModel;
use \App\Models\SolvesModel;
use \App\Models\TeamModel;
use \App\Models\HintModel;
use \App\Models\HintUnlockModel;
use Myth\Auth\Config\Services;

class UserController extends \App\Controllers\BaseController
{
	public function __construct()
	{
		$this->challengeModel = new ChallengeModel();
		$this->categorygeModel = new CategoryModel();
		$this->flagModel = new FlagModel();
		$this->solvesModel = new SolvesModel();
		$this->teamModel = new TeamModel();
		$this->hintModel = new HintModel();

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
										->findColumn('hint_id') ?? [];
			$viewData['firstblood'] = $this->solvesModel
										->select(['teams.name', 'solves.created_at'])
										->from('teams')
										->where('challenge_id', $id)
										->where('solves.team_id', 'teams.id', false)
										->orderBy('solves.created_at')
										->first();
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
			if ($flag['type'] === 'static')
			{
				if ($flag['content'] === $submited_flag)
				{
					$result = true;
					break;
				}
			}
			else if ($flag['type'] === 'regex')
			{
				if (preg_match("/{$flag['content']}/", $submited_flag))
				{
					$result = true;
					break;
				}
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

		if($result)
		{
			$data = [
				'challenge_id'	=> $challengeID,
				'team_id'		=> user()->team_id,
			];

			$solved_before = $this->solvesModel->where($data)->find();
			
			if(empty($solved_before))
			{
				$data['user_id'] = $this->auth->id();

				if (user()->team_id !== null)
				{
					$db_result = $this->solvesModel->insert($data);
				}

				if($db_result)
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
		else
		{
			return redirect()->to("/challenges/$challengeID")->with('result', $result);
		}
	}
	//--------------------------------------------------------------------

	public function scoreboard()
	{
		/*
		SELECT teams.name, SUM(challenges.point) 
		FROM challenges, solves, teams 
		WHERE teams.id=solves.team_id AND solves.challenge_id = challenges.id
		GROUP BY name
		*/

		$db = db_connect();
		$builder = $db->table(['teams', 'challenges', 'solves']);
		$builder->select(['teams.name', 'SUM(challenges.point) as point']);
		$builder->where('teams.id', 'solves.team_id', false);
		$builder->where('solves.challenge_id', 'challenges.id', false);
		$builder->groupBy('name');
		$builder->orderBy('point', 'DESC');

		// var_dump($builder->getCompiledSelect());
		$scores = $builder->get()->getResultArray();
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
			
		}

		return redirect()->to("/challenges/$challengeID");
	}

	//--------------------------------------------------------------------
}