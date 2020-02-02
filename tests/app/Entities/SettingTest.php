<?php namespace App\Entities;

use CodeIgniter\Test\CIUnitTestCase;
use App\Entities\Settings;
use CodeIgniter\I18n\Time;

class SettingTest extends CIUnitTestCase
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

	/**
	 * @dataProvider boolValueProvider
	 */
	public function testGetBoolValue($data, $result)
	{
		$setting = new Settings($data);

		$this->assertIsBool($setting->value);
		$this->assertSame($setting->value, $result);
	}

	public function boolValueProvider()
	{
		return [
			[
				['key' => 'ctf_timer', 'value' => 'on'],
				true,
			],
			[
				['key' => 'allow_register', 'value' => 'true'],
				true,
			],
			[
				['key' => 'need_hash', 'value' => 'false'],
				false,
			],
		];
	}

	//--------------------------------------------------------------------

	/**
	 * @dataProvider intValueProvider
	 */
	public function testGetIntValue($data, $result)
	{
		$setting = new Settings($data);

		$this->assertIsInt($setting->value);
		$this->assertSame($setting->value, $result);
	}

	public function intValueProvider()
	{
		return [
			[
				['key' => 'team_member_limit', 'value' => '4'],
				4
			],
		];
	}

	//--------------------------------------------------------------------

	/**
	 * @dataProvider dateValueProvider
	 */
	public function testDateValue($data, $result)
	{
		$setting = new Settings($data);

		$this->assertTrue($setting->value instanceof Time || $setting->value === null);

		if ($setting->value === null)
		{
			$this->assertNull($setting->value);
		}
		else
		{
			$this->assertTrue($setting->value->equals($result));
		}
	}

	public function dateValueProvider()
	{
		return [
			[
				['key'   => 'ctf_start_time', 'value' => '2019-12-20T10:00'],
				'2019-12-20T10:00'
			],
			[
				['key'   => 'ctf_end_time', 'value' => '2020-01-10T22:00'],
				'2020-01-10T22:00'
			],
			[
				['key'   => 'ctf_start_time', 'value' => null],
				null
			],
			[
				['key'   => 'ctf_end_time', 'value' => null],
				null
			],
		];
	}

	//--------------------------------------------------------------------
}