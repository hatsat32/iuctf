<?php namespace App\Core;

use App\Controllers\BaseController;

class UserController extends BaseController
{
	// default theme for now
	protected $theme = 'default';

	//--------------------------------------------------------------------

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);
	}

	//--------------------------------------------------------------------

	protected function render(string $name, array $data = [], array $options = [])
	{
		$path = APPPATH.'Views'.DIRECTORY_SEPARATOR."$this->theme";
		$renderer = \Config\Services::renderer($path, null, false);

		$saveData = null;
		if (array_key_exists('saveData', $options) && $options['saveData'] === true)
		{
			$saveData = (bool) $options['saveData'];
			unset($options['saveData']);
		}

		return $renderer->setData($data, 'raw')->render($name, $options, $saveData);
	}

	//--------------------------------------------------------------------
}
