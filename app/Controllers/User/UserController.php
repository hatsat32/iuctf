<?php namespace App\Controllers\User;

use \App\Models\ChallengeModel;
use \App\Models\CategoryModel;
use \App\Models\FlagModel;
use \App\Models\SolvesModel;
use Myth\Auth\Config\Services;

class UserController extends \App\Controllers\BaseController
{
	public function __construct()
	{
		$this->challengeModel = new ChallengeModel();
		$this->categorygeModel = new CategoryModel();
		$this->flagModel = new FlagModel();

		$this->auth = Services::authentication();
		$this->authorize = Services::authorization();
	}

	//--------------------------------------------------------------------

	public function challenges($id = null)
	{
		$challenges = $this->challengeModel->findAll();
		$categories = $this->categorygeModel->findAll();

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

		if($id !== null)
		{
			$viewData['challenge'] = $challenges = $this->challengeModel->find($id);
		}
		
		return view('darky/challenges', $viewData);
	}

	//--------------------------------------------------------------------

	public function flagSubmit($challengeID = null)
	{
		$flags = $this->flagModel->where('challenge_id', $challengeID)->findAll();
		$submited_flag = $this->request->getPost('flag');

		$result = false;
		foreach ($flags as $flag) {
			if($flag['content'] === $submited_flag)
			{
				$result = true;
				break;
			}
		}

		if($result)
		{
			$solvesModel = new SolvesModel();

			$data = [
				'challenge_id'	=> $challengeID,
				'user_id'		=> $this->auth->id(),
				'team_id'		=> "1",
			];

			$db_result = $solvesModel->insert($data);
		}
	}
}