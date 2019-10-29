<?php namespace App\Controllers;

use \App\Models\ChallengeModel;
use \App\Models\CategoryModel;
use Myth\Auth\Config\Services;

class Home extends BaseController
{
	protected $challengeModel;
	protected $categorygeModel;
	protected $auth;
	protected $authorize;

	public function __construct()
	{
		$this->challengeModel = new ChallengeModel();
		$this->categorygeModel = new CategoryModel();

		$this->auth = Services::authentication();
		$this->authorize = Services::authorization();
	}

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
