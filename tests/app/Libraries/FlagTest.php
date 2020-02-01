<?php namespace App\Libraries;

use Tests\Support\DatabaseTestCase;
use App\Libraries\Flag;

class FlagTest extends DatabaseTestCase
{
	//--------------------------------------------------------------------

	public function setUp(): void
	{
		parent::setUp();
	}

	public function tearDown(): void
	{
		parent::tearDown();
	}

	//--------------------------------------------------------------------

	public function testLog()
	{
		$flaglib = new Flag();

		$data = [
			'challenge_id' => '1',
			'user_id'      => '2',
			'team_id'      => '1',
			'ip'           => '10.10.10.10',
			'provided'     => 'win100',
			'type'         => '0',
		];

		$flaglib->log($data);

		$this->seeInDatabase('submissions', $data);
	}

	//--------------------------------------------------------------------
}