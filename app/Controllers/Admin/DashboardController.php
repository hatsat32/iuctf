<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use App\Models\SolvesModel;

class DashboardController extends AdminController
{
	//--------------------------------------------------------------------

	public function index()
	{
		$db = db_connect();
		$status = $db->query('SHOW TABLE STATUS')->getResult();

		foreach ($status as $key => $value) {
			$status[$value->Name] = $value;
			unset($status[$key]);
		}

		$viewData = [
			'status' => $status,
		];

		return $this->render('dashboard', $viewData);
	}

	//--------------------------------------------------------------------
}
