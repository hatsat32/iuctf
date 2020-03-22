<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use App\Models\UserModel;
use App\Models\TeamModel;

class UserController extends AdminController
{
	/** @var UserModel **/
	protected $userModel;

	/** @var TeamModel **/
	protected $teamModel;

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->userModel = new UserModel();
		$this->teamModel = new TeamModel();
	}

	//--------------------------------------------------------------------

	public function index()
	{
		$users = $this->userModel
				->select(['users.*', 'teams.name AS team_name'])
				->join('teams', 'users.team_id = teams.id', 'left');

		return $this->render('user/index', [
			'users' => $users->paginate(20),
			'pager' => $users->pager,
		]);
	}

	//--------------------------------------------------------------------

	public function new()
	{
		$viewData['teams'] = $this->teamModel->findAll();
		return $this->render('user/new', $viewData);
	}

	//--------------------------------------------------------------------

	public function show($id = null)
	{
		$user = $this->userModel->find($id);

		if (empty($user))
		{
			return redirect('admin-users');
		}

		$viewData['user'] = $user;
		$viewData['teams'] = $this->teamModel->findAll();

		return $this->render('user/detail', $viewData);
	}

	//--------------------------------------------------------------------

	public function create()
	{
		$data = [
			'username'      => $this->request->getPost('username'),
			'email'         => $this->request->getPost('email'),
			'name'          => $this->request->getPost('name'),
			'team_id'       => $this->request->getPost('team_id'),
			'password_hash' => password_hash(
				base64_encode(
					hash('sha384', $this->request->getPost('password'), true)
				),
				PASSWORD_ARGON2I
			),
		];

		$rules = array_merge($this->userModel->getValidationRules(['only' => ['email', 'username']]), [
			'password'         => 'required|strong_password',
			'password-confirm' => 'required|matches[password]',
		]);

		if (! $this->validate($rules))
		{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$result = $this->userModel->insert($data);

		if (! $result)
		{
			return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
		}

		// success
		return redirect('admin-users');
	}

	//--------------------------------------------------------------------

	public function delete($id = null)
	{
		$result = $this->userModel->delete($id);

		if (! $result)
		{
			$errors = $this->userModel->errors();
			return redirect()->route('admin-users-show', [$id])->with('errors', $errors);
		}

		return redirect('admin-users');
	}

	//--------------------------------------------------------------------

	public function update($id = null)
	{
		$user = $this->userModel->find($id);

		$user->fill($this->request->getPost());

		$result = $this->userModel->update($id, $user);

		if (! $result)
		{
			$errors = $this->userModel->errors();
			return redirect()->route('admin-users-show', [$id])->with('errors', $errors);
		}

		return redirect()->route('admin-users-show', [$id])->with('message', lang('admin/User.updatedSuccessfully'));
	}

	//--------------------------------------------------------------------

	public function changePassword($user_id = null)
	{
		$authUserModel = new \Myth\Auth\Models\UserModel();
		$user = $authUserModel->find($user_id);

		if ($this->request->getPost('email') !== $user->email)
		{
			return redirect()->back();
		}

		$rules = [
			'password'         => 'required|strong_password',
			'password-confirm' => 'required|matches[password]',
		];

		if (! $this->validate($rules))
		{
			return redirect()->back()->withInput()->with('chpass-errors', $this->validator->getErrors());
		}

		$user->password = $this->request->getPost('password');
		$authUserModel->save($user);

		return redirect()->back()->with('chpass-message', 'Password updated successfully');
	}

	//--------------------------------------------------------------------

	public function addAdmin($user_id = null)
	{
		$authorize = \Myth\Auth\Config\Services::authorization();

		$authorize->addUserToGroup($user_id, 'admin');

		return redirect()->route('admin-users-show', [$user_id]);
	}

	//--------------------------------------------------------------------

	public function rmAdmin($user_id = null)
	{
		$authorize = \Myth\Auth\Config\Services::authorization();

		if ($user_id == user()->id)
		{
			return redirect()->back()->with('error', lang('admin/User.rmadminError'));
		}

		$authorize->removeUserFromGroup($user_id, 'admin');

		return redirect()->route('admin-users-show', [$user_id]);
	}

	//--------------------------------------------------------------------

	public function ban($id = null)
	{
		$authUserModel = new \Myth\Auth\Models\UserModel();
		$user = $authUserModel->find($id);

		$user->ban('');
		$result = $authUserModel->save($user);

		if (! $result)
		{
			$errors = $authUserModel->errors();
			return redirect()->route('admin-users-show', [$id])->with('errors', $errors);
		}

		return redirect()->route('admin-users-show', [$id]);
	}

	//--------------------------------------------------------------------

	public function unBan($id = null)
	{
		$authUserModel = new \Myth\Auth\Models\UserModel();
		$user = $authUserModel->find($id);

		$user->unBan();
		$result = $authUserModel->save($user);

		if (! $result)
		{
			$errors = $authUserModel->errors();
			return redirect()->route('admin-users-show', [$id])->with('errors', $errors);
		}

		return redirect()->route('admin-users-show', [$id]);
	}

	//--------------------------------------------------------------------

	public function activate($id = null)
	{
		$authUserModel = new \Myth\Auth\Models\UserModel();
		$user = $authUserModel->find($id);
		$user->activate();

		if (! $authUserModel->save($user))
		{
			return redirect()->route('admin-users-show', [$id])->with('errors', $authUserModel->errors());
		}

		return redirect()->route('admin-users-show', [$id])->with('message', lang('admin/User.activated'));
	}

	//--------------------------------------------------------------------

	public function removeFromTeam($id = null)
	{
		$user = $this->userModel->find($id);
		$team = $this->teamModel->find($user->team_id);

		// 1 -> remove team_id field from user
		$user->team_id = null;
		if (! $this->userModel->save($user))
		{
			return redirect()->back()->with('error', lang('admin/User.removeFromTeamError'));
		}


		// 2 -> if user is the team_leader, edit team leader
		if ($team->leader_id === $user->id)
		{
			$new_leader = $this->userModel->where('team_id', $team->id)->first();

			// 3 -> if no team member found, delete the team
			if ($new_leader === null)
			{
				if (! $this->teamModel->delete($team->id, true))
				{
					return redirect()->back()->with('error', lang('admin/User.removeFromTeamError'));
				}

				return redirect()->back()->with('message', lang('admin/User.userRemovedFromTeam'));
			}

			// 4 -> change team leader
			$team->leader_id = $new_leader->id;
			if (! $this->teamModel->save($team))
			{
				return redirect()->back()->with('error', lang('admin/User.removeFromTeamError'));
			}
		}

		return redirect()->back()->with('message', lang('admin/User.userRemovedFromTeam'));
	}

	//--------------------------------------------------------------------
}
