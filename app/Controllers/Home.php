<?php namespace App\Controllers;

use App\Core\ThemeTrait;

class Home extends BaseController
{
	use ThemeTrait;

	//--------------------------------------------------------------------

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->theme = ss()->theme;
	}

	//--------------------------------------------------------------------

	public function index()
	{
		$content = null;

		if (file_exists(WRITEPATH.'home_page_custom.html'))
		{
			$content = file_get_contents(WRITEPATH.'home_page_custom.html');
		}

		if ($content === null && file_exists(WRITEPATH.'home_page.html'))
		{
			$content = file_get_contents(WRITEPATH.'home_page.html');
		}

		return $this->render('index', ['content' => $content ?? '']);
	}

	//--------------------------------------------------------------------

	public function language()
	{
		$language = $this->request->getGet('language');

		if (! in_array($language, ['en', 'tr'], true))
		{
			return redirect()->back();
		}

		session()->set('language', $language);

		return redirect()->back();
	}

	//--------------------------------------------------------------------
}
