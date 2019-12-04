<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use \App\Models\ConfigModel;

class ConfigController extends AdminController
{
	private $configModel;
	private $validation;

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->configModel = new ConfigModel();
		$this->validation  =  \Config\Services::validation();
	}

	//--------------------------------------------------------------------

	public function index()
	{
		$viewData['config'] = [];

		foreach ($this->configModel->findAll() as $row) {
			$viewData['config'][$row['key']] = $row['value'];
		}

		return $this->render('config/index', $viewData);
	}

	//--------------------------------------------------------------------

	public function competitionTimer()
	{
		$timer = $this->request->getPost('timer');

		$rules = [
			'timer' => 'required|in_list[on,off]'
		];

		if (! $this->validate($rules))
		{
			$errors = $this->validator->getErrors();
			return redirect('admin-config')->with('errors', $errors);
		}

		$result = $this->configModel
					->where('key', 'competition_timer')
					->set(['value' => $timer])
					->update();

		if ($result)
		{
			return redirect('admin-config')->with('errors', 'ekleme sırasında hata oluştu');
		}

		return redirect('admin-config');
	}

	//--------------------------------------------------------------------

	public function competitionTimes()
	{
		
	}

	//--------------------------------------------------------------------

	public function new()
	{

	}

	//--------------------------------------------------------------------

	public function edit($id = null)
	{

	}

	//--------------------------------------------------------------------

	public function show($id = null)
	{

	}

	//--------------------------------------------------------------------

	public function create()
	{

	}

	//--------------------------------------------------------------------

	public function delete($id = null)
	{

	}

	//--------------------------------------------------------------------

	public function update($id = null)
	{

	}
}
