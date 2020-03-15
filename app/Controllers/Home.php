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

		$rules = [
			'language' => 'required|in_list[en,tr]',
		];
		if (! $this->validate($rules))
		{
			return redirect()->back();
		}

		$session = session();
		$session->set('language', $language);

		return redirect()->back();
	}

	//--------------------------------------------------------------------
}
