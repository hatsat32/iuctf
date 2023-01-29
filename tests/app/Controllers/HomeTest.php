<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class HomeTest extends CIUnitTestCase
{
	use ControllerTestTrait;
    use DatabaseTestTrait;

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

	public function testChangeLanguage()
	{
		$response = $this->get('/language?language=tr');
		$response->assertSessionHas('language', 'tr');
	}

	public function testChangeLanguageInvalidLocale()
	{
		$response = $this->withSession(['language' => 'tr'])->get('/language?language=gg');
		$response->assertSessionHas('language', 'tr');
	}
}
