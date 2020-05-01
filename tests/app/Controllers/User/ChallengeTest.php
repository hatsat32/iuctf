<?php namespace App\Controllers\User;

use Tests\Support\FeatureTestCase;
use Config\Services;

class ChallengeTest extends FeatureTestCase
{
	protected $user;

	/**
	 * @var LocalAuthenticator
	 */
	protected $auth;

	public function setUp(): void
	{
		parent::setUp();

		$this->auth = Services::authentication();
		$this->auth->attempt(['username' => 'hatsat32', 'password' => 'hatsat32'], false);
		$this->user = $this->auth->user();
	}

	public function tearDown(): void
	{
		parent::tearDown();
	}

	public function testGetChallenges()
	{
		$response = $this->get(route_to('challenges'));
		$response->assertOk();
	}

	public function testGetChallenge()
	{
		$response = $this->get(route_to('challenge-detail', 1));
		$response->assertOk();
	}

	public function testSubmitFlag()
	{
		$this->post('/challenges/1', [
			'flag' => 'linux100',
		]);

		$this->seeInDatabase('solves', [
			'team_id'      => $this->user->team_id,
			'challenge_id' => 1,
			'user_id'      => $this->user->id,
		]);
	}
}
