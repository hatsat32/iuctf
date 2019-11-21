<?php namespace App\Core;

use App\Controllers\BaseController;

class AdminController extends BaseController
{
	protected $theme = 'admin';

	//--------------------------------------------------------------------

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);
	}

	//--------------------------------------------------------------------

	protected function render(string $view, array $data = [], array $options = [])
	{
		$view = $this->theme . DIRECTORY_SEPARATOR . $view;

		return view($view, $data, $options);
	}

	//--------------------------------------------------------------------
}
