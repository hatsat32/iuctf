<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use League\CommonMark\CommonMarkConverter;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
	// public static function example($getShared = true)
	// {
	//     if ($getShared)
	//     {
	//         return static::getSharedInstance('example');
	//     }
	//
	//     return new \CodeIgniter\Example();
	// }

	public static function settings(bool $getShared = true)
	{
		if ($getShared)
		{
			return static::getSharedInstance('settings');
		}

		if (! $settings = cache("settings"))
		{
			$settings = config('Settings');

			cache()->save("settings", $settings, MINUTE * 5);
		}

		return $settings;
	}

	/**
	 * @param boolean $secure - secure markdown processing
	 * @param boolean $getShared
	 * 
	 * @return \League\CommonMark\CommonMarkConverter
	 */
	public static function markdown(bool $secure = true, bool $getShared = true)
	{
		if ($getShared)
		{
			return static::getSharedInstance('markdown', $secure);
		}

		$config = (! $secure) ? [] : [
			'html_input' => 'strip',
			'allow_unsafe_links' => false,
		];

		return new CommonMarkConverter($config);
	}
}
