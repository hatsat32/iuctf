<?php namespace App\Controllers\User;

use App\Core\UserController;
use App\Libraries\Scoreboard;

class ScoreboardController extends UserController
{
	//--------------------------------------------------------------------

	public function index()
	{
		$scoreboard = new Scoreboard();

		$scores = $scoreboard->scores();

		$line_chart_scores = array_map(function($score) {
			return $score->toArray();
		}, $scores);

		$bar_chart_scores = array_map(function($score) {
			return ['name' => $score->name, 'score' => $score->final];
		}, $scores);

		return $this->render('scoreboard', [
			'scores'            => $scores,
			'bar_chart_scores'  => json_encode($bar_chart_scores),
			'line_chart_scores' => json_encode($line_chart_scores),
		]);
	}

	//--------------------------------------------------------------------
}
