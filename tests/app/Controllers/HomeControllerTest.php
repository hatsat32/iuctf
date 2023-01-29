<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class HomeControllerTest extends CIUnitTestCase
{
	use ControllerTestTrait;
    use DatabaseTestTrait;

	public function setUp(): void
	{
		parent::setUp();
	}

	public function testGetHome()
	{
		$response = $this->withUri(site_url('/'))
			->controller(Home::class)
			->execute('index');
		$this->assertTrue($response->isOk());
	}

	public function testChangeLanguage()
	{
		$data = ['language' => 'tr'];

		$globals = [
			'request' => $data,
			'get' => $data,
		];

		$request = service('request', null, false);
		$this->setPrivateProperty($request, 'globals', $globals);

		$response = $this->withUri('/language')
			->withRequest($request)
			->controller(Home::class)
			->execute('language');

		$this->assertTrue($response->isRedirect());
		$this->assertEquals('tr', $_SESSION['language']);
	}
}
