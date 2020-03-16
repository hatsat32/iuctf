<?php namespace App\Controllers;

use Tests\Support\FeatureTestCase;

class HomeTest extends FeatureTestCase
{
	public function setUp(): void
	{
		parent::setUp();
	}

	public function tearDown(): void
	{
		parent::tearDown();
	}

	public function testGetHome()
	{
		$response = $this->get('/');
		$response->assertOK();
		$response->assertSee(lang('General.challenges'));
	}

	public function testGetLanguage()
	{
		#TODO: fix parameter pass error
		$response = $this->withSession([
			'language' => 'en',
		])->get('language', [
			'language' => 'tr',
		]);

		$response->assertRedirect();
		$response->assertSessionHas('language', 'tr');
	}
}
