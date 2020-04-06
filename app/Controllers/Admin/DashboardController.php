<?php namespace App\Controllers\Admin;

use App\Core\AdminController;

class DashboardController extends AdminController
{
	//--------------------------------------------------------------------

	public function index()
	{
		$db = db_connect();

		if (! $statistics = cache('statistics'))
		{
			$statistics = [
				'users'       => $db->table('users')->countAll(),
				'teams'       => $db->table('teams')->countAll(),
				'submissions' => $db->table('submissions')->countAll(),
				'solves'      => $db->table('solves')->countAll(),
			];

			cache()->save('statistics', $statistics, MINUTE);
		}

		return $this->render('dashboard', ['statistics' => $statistics]);
	}

	//--------------------------------------------------------------------
}
