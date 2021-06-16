<?php namespace App\Controllers;

use Tests\Support\ControllerTestCase;
Use Tests\Support\FeatureTestCase;
use App\Controllers\Home;

class HomeControllerTest extends FeatureTestCase
{
	public function setUp(): void
	{
		parent::setUp();
	}

	public function testGetHome()
	{
		// $response = $this->withUri(site_url('/'))
		// 	->controller(Home::class)
		// 	->execute('index');
		// $this->assertTrue($response->isOk());

		$response = $this->get("/");
		$response->assertOK();
	}

	public function testChangeLanguage()
	{
		$params = ['language' => 'tr'];
		$response = $this->withSession(['language' => 'en'])->get('/language', $params);
		$response->assertTrue($response->isRedirect());
		$response->assertEquals('tr', $params['language']);
	}
}
