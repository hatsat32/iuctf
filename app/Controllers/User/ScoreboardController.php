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

			$scores = array_filter($scores, function($score) {
				return $score->final != 0;
			});

			cache()->save("scores", $scores, MINUTE * 5);
		}

		$_scores = array_map(function($score) {
			return ['name' => $score->name, 'score' => $score->final];
		}, $scores);

		return $this->render('scoreboard', ['scores' => $scores, 'chartdata' => json_encode($_scores)]);
	}

	//--------------------------------------------------------------------
}
