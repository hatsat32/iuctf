<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use \App\Models\TeamModel;
use \App\Models\UserModel;
use \App\Models\ChallengeModel;
use \App\Models\SolvesModel;

class TeamController extends AdminController
{
	private $teamModel;
	private $userModel;
	private $challengeModel;

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->teamModel = new TeamModel();
		$this->userModel = new UserModel();
		$this->challengeModel = new ChallengeModel();
	}

	//--------------------------------------------------------------------

	public function index()
	{
		$viewData['teams'] = $this->teamModel->findAll();

		return $this->render('team/index', $viewData);
	}

	//--------------------------------------------------------------------

	public function new()
	{
		return $this->render('team/new');
	}

	//--------------------------------------------------------------------

	public function edit($id = null)
	{

	}

	//--------------------------------------------------------------------

	public function show($id = null)
	{
		$team = $this->teamModel->find($id);
		$teamMembers = $this->userModel->where('team_id', $id)->findAll();
		$challenges = $this->challengeModel
				->select(['challenges.id', 'challenges.name', 'solves.id AS solves_id', 'solves.user_id AS solves_user',
						'users.username AS solves_username', 'solves.team_id AS team_id', 'solves.created_at AS solves_at'])
				->join('solves', "(challenges.id = solves.challenge_id AND solves.team_id = $id)", 'left')
				->join('users', 'solves.user_id = users.id', 'left')
				->findAll();

		$viewData = [
			'team'        => $team,
			'teamMembers' => $teamMembers,
			'challenges'  => $challenges,
		];

		return $this->render('team/detail', $viewData);
	}

	//--------------------------------------------------------------------

	public function create()
	{
		$data = [
			'leader_id' => $this->request->getPost('leader_id'),
			'name'		=> $this->request->getPost('name'),
			'is_banned'	=> '0',
			'auth_code'	=> bin2hex(random_bytes(32)),
		];

		$result = $this->teamModel->insert($data);

		if (! $result)
		{
			$errors = $this->teamModel->errors();
			return redirect()->to('/admin/teams/new');
		}

		return redirect()->to('/admin/teams');
	}

	//--------------------------------------------------------------------

	public function delete($id = null)
	{
		$result = $this->teamModel->delete($id);

		if (! $result)
		{
			$viewData['errors'] = $this->teamModel->errors();
			return redirect()->to("/admin/teams/$id", $viewData);
		}

		return redirect()->to('/admin/teams');
	}

	//--------------------------------------------------------------------

	public function update($id = null)
	{
		$teamMembers = $this->userModel->where('team_id', $id)->findColumn('id') ?? [];

		$data = [
			'name'		=> $this->request->getPost('name'),
			'leader_id'	=> $this->request->getPost('leader_id'),
		];

		if (! in_array($this->request->getPost('leader_id'), $teamMembers))
		{
			return redirect()->to("/admin/teams/$id");
		}

		$result = $this->teamModel->update($id, $data);

		if (! $result)
		{
			$viewData['errors'] = $this->teamModel->errors();
			return redirect()->to("/admin/teams/$id", $viewData);
		}

		return redirect()->to("/admin/teams/$id");
	}

	//--------------------------------------------------------------------

	public function changeAuthCode($id = null)
	{
		$data = [
			'auth_code'	=> bin2hex(random_bytes(32)),
		];

		$result = $this->teamModel->update($id, $data);

		if (! $result)
		{
			$viewData['errors'] = $this->teamModel->errors();
			return redirect()->to("/admin/teams/$id", $viewData);
		}
		return redirect()->to("/admin/teams/$id");
	}

	//--------------------------------------------------------------------

	public function markAsSolved($id = null)
	{
		$solvesModel = new SolvesModel();

		$data = [
			'team_id'		=> $id,
			'challenge_id'	=> $this->request->getPost('challenge_id'),
			'user_id'		=> $this->request->getPost('user_id'),
		];

		$result = $solvesModel->insert($data);

		if (! $result)
		{
			$errors = $solvesModel->errors();
			return redirect()->to("/admin/teams/$id")->with('errors', $errors);
		}

		return redirect()->to("/admin/teams/$id");
	}

	//--------------------------------------------------------------------

	public function markAsUnsolved($teamID = null, $solvesID = null)
	{
		$solvesModel = new SolvesModel();

		$result = $solvesModel->delete($solvesID);

		if (! $result)
		{
			$errors = $solvesModel->errors();
			return redirect()->to("/admin/teams/$teamID")->with('errors', $errors);
		}

		return redirect()->to("/admin/teams/$teamID");
	}

	//--------------------------------------------------------------------

	public function ban($id = null)
	{
		$result = $this->teamModel->update($id, ['is_banned' => '1']);

		if (! $result)
		{
			$errors = $this->teamModel->errors();
			return redirect()->to("/admin/teams/$id")->with('errors', $errors);
		}

		// ban all the users
		$result = $this->userModel->where('team_id', $id)->set('status', 'banned')->update();

		if (! $result)
		{
			$errors = $this->userModel->errors();
			return redirect()->to("/admin/teams/$id")->with('errors', $errors);
		}

		return redirect()->to("/admin/teams/$id");
	}

	//--------------------------------------------------------------------

	public function unBan($id = null)
	{
		$result = $this->teamModel->update($id, ['is_banned' => '0']);

		if (! $result)
		{
			$errors = $this->teamModel->errors();
			return redirect()->to("/admin/teams/$id")->with('errors', $errors);
		}

		// unban all the users
		$result = $this->userModel->where('team_id', $id)->set(['status' => null])->update();

		if (! $result)
		{
			$errors = $this->userModel->errors();
			return redirect()->to("/admin/teams/$id")->with('errors', $errors);
		}

		return redirect()->to("/admin/teams/$id");
	}

	//--------------------------------------------------------------------
}
