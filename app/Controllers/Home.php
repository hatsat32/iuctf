<?php namespace App\Controllers;

use App\Core\ThemeTrait;

class Home extends BaseController
{
	use ThemeTrait;

	//--------------------------------------------------------------------

	public function index()
	{
		return $this->render('index');
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
