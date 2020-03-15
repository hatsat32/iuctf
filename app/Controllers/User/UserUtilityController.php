<?php namespace App\Controllers\User;

use App\Core\UserController;
use App\Models\NotificationModel;

class UserUtilityController extends UserController
{
	public function notifications()
	{
		$notificationModel = new NotificationModel();
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

		$flaglib = new \App\Libraries\Flag();
		$hash =  $flaglib->hash($this->request->getPost('hash'));

		return $this->render('hash', ['hash' => $hash]);
	}

	//--------------------------------------------------------------------
}
