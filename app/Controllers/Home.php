<?php namespace App\Controllers;

use \App\Models\ChallengeModel;
use \App\Models\CategoryModel;
use Myth\Auth\Config\Services;

class Home extends BaseController
{
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
}
