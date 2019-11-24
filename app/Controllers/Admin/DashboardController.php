<?php namespace App\Controllers\Admin;

use App\Core\AdminController;

class DashboardController extends AdminController
{
	//--------------------------------------------------------------------

	public function index()
	{
		return $this->render('dashboard');
	}

	//--------------------------------------------------------------------
}
