<?php namespace App\Controllers\User;

use \App\Models\TeamModel;
use \App\Models\UserModel;
use Myth\Auth\Config\Services;

class TeamController extends \App\Controllers\BaseController
{
	public function __construct()
	{
		$this->teamModel = new TeamModel();
		$this->userModel = new UserModel();

		$this->auth = Services::authentication();
		$this->authorize = Services::authorization();
	}

	//--------------------------------------------------------------------
	
	public function index()
	{
		if (user()->team_id === null)
		{
			$viewData['no_team'] = true;
			return view('darky/team', $viewData);
		}

		$team = $this->teamModel->asObject('App\Entities\Team')->find(user()->team_id);
		$team_members = $this->userModel->where('team_id', user()->team_id)->findAll();

		$viewData['team'] = $team;
		$viewData['team_members'] = $team_members;

		return view('darky/team', $viewData);
	}

	//--------------------------------------------------------------------

	public function createTeam()
	{
		if (user()->team_id !== null)
		{
			redirect()->to('/team');
		}

		$data = [
			'leader_id' => user()->id,
			'name'		=> $this->request->getPost('name'),
			'is_banned'	=> '0',
			'auth_code'	=> bin2hex(random_bytes(32)),
		];

		$team_id = $this->teamModel->insert($data);

		$result = $this->userModel->update(user()->id, ['team_id'=> $team_id]);

		if ((! $team_id) && (! $result))
		{
			$errors = $this->teamModel->errors();
			return redirect()->to('/createteam')->withInput()->with('errors', $errors);
		}

		return redirect()->to('/team');
	}

	//--------------------------------------------------------------------

	public function joinTeam()
	{
		if (user()->team_id !== null)
		{
			redirect()->to('/team');
		}

		$auth_code = $this->request->getPost('auth_code');
		
		$team = $this->teamModel->where('auth_code', $auth_code)->first();
		
		$result = $this->userModel->update(user()->id, ['team_id'=> $team['id']]);

		if (! $result)
		{
			$errors = $this->teamModel->errors();
			return redirect()->to('/createteam')->withInput();
		}

		return redirect()->to('/team');
	}

	//--------------------------------------------------------------------
}