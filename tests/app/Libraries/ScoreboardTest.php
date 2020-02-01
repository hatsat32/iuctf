<?php namespace App\Libraries;

use CodeIgniter\Test\CIUnitTestCase;
use App\Libraries\Scoreboard;
use CodeIgniter\Entity;

class ScoreboardTest extends CIUnitTestCase
{
	/** @var Scoreboard **/
	protected $scoreboardlib = null;

	//--------------------------------------------------------------------

	public function setUp(): void
	{
		parent::setUp();

		$this->scoreboardlib = new Scoreboard();
	}

	//--------------------------------------------------------------------

	public function tearDown(): void
	{
		parent::tearDown();
	}

	//--------------------------------------------------------------------

	/**
	 * @dataProvider calculatePointProvider
	 */
	public function testCalculatePoint($point, $solveCount, $result)
	{
		$r = $this->scoreboardlib->calculatePoint($point, $solveCount);

		$this->assertSame($r, $result);
	}

	public function calculatePointProvider()
	{
		return [
			[100, 0, 100],
			[100, 1, 100],
			[100, 5, 68],
			[100, 10, 50],
		];
	}

	//--------------------------------------------------------------------

	/**
	 * @dataProvider teamSolvesProvider
	 */
	public function testTeamSolves($solves, $teamID, $result)
	{
		$r = $this->scoreboardlib->teamSolves($solves, $teamID);

		$res = array_map(function($r1, $r2) {
			return  $r1->challenge_id === $r2->challenge_id &&
					$r1->user_id === $r2->user_id &&
					$r1->team_id === $r2->team_id;
		}, $r, $result);

		$this->assertTrue(in_array(false, $res) === false);
	}

	public function teamSolvesProvider()
	{
		$solve1 = new Entity();
		$solve1->challenge_id = 1;
		$solve1->user_id = 1;
		$solve1->team_id = 1;

		$solve2 = new Entity();
		$solve2->challenge_id = 3;
		$solve2->user_id = 1;
		$solve2->team_id = 1;

		$solve3 = new Entity();
		$solve3->challenge_id = 3;
		$solve3->user_id = 2;
		$solve3->team_id = 2;

		$solves = [$solve1, $solve2, $solve3];

		return [
			[$solves, 1, [$solve1, $solve2]],
			[$solves, 2, [2 => $solve3]],
		];
	}

	//--------------------------------------------------------------------
}