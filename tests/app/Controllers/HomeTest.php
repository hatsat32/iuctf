<?php namespace App\Controllers;

use Tests\Support\FeatureTestCase;

class HomeTest extends FeatureTestCase
{
	public function testGetHome()
	{
		$response = $this->get('/');
		$response->assertOK();
		$response->assertSee(lang('General.challenges'));
	}

	public function testChangeLanguage()
	{
		$params = ['language' => 'tr'];
		$response = $this->withSession(['language' => 'en'])->get('/language', $params);
		$response->assertTrue($response->isRedirect());
		$response->assertSessionHas('language', 'tr');
	}

	public function testChangeLanguageInvalidLocale()
	{
		$params = ['language' => 'fr'];
		$response = $this->withSession(['language' => 'tr'])->get('/language', $params);
		$response->assertSessionHas('language', 'tr');
	}
}
