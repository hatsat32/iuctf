<?php namespace App\Controllers\User;

use App\Core\UserController;
use App\Models\ChallengeModel;
use App\Models\HintUnlockModel;
use App\Models\SolvesModel;
use App\Models\TeamModel;
use App\Libraries\Flag;

class UserUtilityController extends UserController
{
	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);
	}

	//--------------------------------------------------------------------

	public function notifications()
	{
		$notificationModel = new \App\Models\NotificationModel();
		$viewData['notifications'] = $notificationModel
									->orderBy('created_at', 'DESC')
									->findAll();
		return $this->render('notifications', $viewData);
	}

	//--------------------------------------------------------------------

	public function hash()
	{
		return $this->render('hash');
	}

	//--------------------------------------------------------------------

	public function gethash()
	{
		if (empty($this->request->getPost('hash')))
		{
			return $this->render('hash');
		}

		$hash =  hash('sha256', $this->request->getPost('hash'));

		return $this->render('hash', ['hash' => $hash]);
	}

	//--------------------------------------------------------------------
}
