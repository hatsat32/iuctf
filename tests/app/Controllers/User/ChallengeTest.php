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
		$response->assertSee('linux100');
	}

	public function testGetChallenge()
	{
		$response = $this->get('/challenges/1');
		$response->assertOk();
		$response->assertSee('linux100', 'h3');
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

	public function testSubmitWrongFlag()
	{
		$response = $this->post('/challenges/1', [
			'flag' => 'InvalidFlag',
		]);

		$this->dontSeeInDatabase('solves', [
			'team_id'      => $this->user->team_id,
			'challenge_id' => 1,
			'user_id'      => $this->user->id,
		]);
		$response->assertSessionHas('result', false);
	}
}
