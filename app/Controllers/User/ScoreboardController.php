<?php namespace App\Controllers\User;

use App\Core\UserController;
use App\Libraries\Scoreboard;

class ScoreboardController extends UserController
{
	//--------------------------------------------------------------------

	public function index()
	{
		$scoreboard = new Scoreboard();

		if (! $scores = cache('scores'))
		{
			$scores = $scoreboard->scores();
			cache()->save("scores", $scores, MINUTE * 5);
		}

		return $this->render('scoreboard', ['scores' => $scores]);
	}

	//--------------------------------------------------------------------
}
