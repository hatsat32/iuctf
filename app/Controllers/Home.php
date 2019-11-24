<?php namespace App\Controllers;

class Home extends BaseController
{
	//--------------------------------------------------------------------

	public function index()
	{
		return view('darky/index');
	}

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
}
