<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Iuctf extends BaseConfig
{
	/**
	 * The current version of Iuctf Platform
	 */
	const IUCTF_VERSION = null;

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
