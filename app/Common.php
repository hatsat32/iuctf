<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter4.github.io/CodeIgniter4/
 */

define('THEMEPUBPATH', FCPATH . 'themes' . DIRECTORY_SEPARATOR);
define('THEMEPATH', WRITEPATH . 'themes' . DIRECTORY_SEPARATOR);

use Config\Services;
use Config\Settings;


/**
 * Just wrapper for service('settings')
 * 
 * @param array  ...$params
 *
 * @return Settings
 */
function ss(...$params)
{
	return Services::settings(...$params);
}
