<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Iuctf extends BaseConfig
{
	/**
	 * List of available locales.
	 * Default English
	 */
	public $locales = [
		'en' => 'English',
		'tr' => 'Türkçe',
	];

	/**
	 * Team's auth code size in bytes
	 */
	public $authCodeSize = 16;
}