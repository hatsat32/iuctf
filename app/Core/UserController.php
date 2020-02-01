<?php namespace App\Core;

use App\Controllers\BaseController;

class UserController extends BaseController
{
	use ThemeTrait;

	//--------------------------------------------------------------------

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->theme = ss()->theme;
	}

	//--------------------------------------------------------------------
}
