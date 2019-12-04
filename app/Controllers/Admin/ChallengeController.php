<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use \App\Models\ChallengeModel;
use \App\Models\CategoryModel;
use \App\Models\FlagModel;
use \App\Models\HintModel;
use \App\Models\FileModel;

class ChallengeController extends AdminController
{
	protected $challengeModel;
	protected $categoryModel;

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->challengeModel = new ChallengeModel();
		$this->categoryModel = new CategoryModel();
	}

	//--------------------------------------------------------------------

	public function index()
	{
		$viewData['challenges'] = $this->challengeModel->findAll();
		return $this->render('challenge/index', $viewData);
	}

	//--------------------------------------------------------------------

	public function new()
	{
		$viewData['categories'] = $this->categoryModel->findAll();
		return $this->render('challenge/new', $viewData);
	}

	//--------------------------------------------------------------------

	public function edit($id = null)
	{

	}

	//--------------------------------------------------------------------

	public function show($id = null)
	{
		$hintModel = new HintModel();
		$fileModel = new FileModel();
		$flagModel = new FlagModel();
	
		$viewData['challenge']  = $this->challengeModel->find($id);
		$viewData['categories'] = $this->categoryModel->findAll();
		$viewData['flags']      = $flagModel->where('challenge_id', $id)->findAll();
		$viewData['hints']      = $hintModel->where('challenge_id', $id)->findAll();
		$viewData['files']      = $fileModel->where('challenge_id', $id)->findAll();
	
		return $this->render('challenge/detail', $viewData);
	}

	//--------------------------------------------------------------------

	public function create()
	{
		$data = [
			'category_id'  => $this->request->getPost('category_id'),
			'name'         => $this->request->getPost('name'),
			'description'  => $this->request->getPost('description'),
			'point'        => $this->request->getPost('point'),
			'max_attempts' => empty($this->request->getPost('max_attempts')) ? 0 : $this->request->getPost('max_attempts'),
			'type'         => $this->request->getPost('type'),
			'is_active'    => $this->request->getPost('is_active'),
		];

		$result = $this->challengeModel->insert($data);

		if (! $result)
		{
			$viewData['errors']     = $this->challengeModel->errors();
			$viewData['categories'] = $this->categoryModel->findAll();
			return redirect()->to('/admin/challenges/new')->withInput();
		}

		return redirect()->to('/admin/challenges');
	}

	//--------------------------------------------------------------------

	public function delete($id = null)
	{
		$result = $this->challengeModel->delete($id);

		if (! $result)
		{
			$viewData['errors'] = $this->challengeModel->errors();
			return redirect()->to("/admin/challenges/$id", $viewData);
		}

		return redirect()->to('/admin/challenges');
	}

	//--------------------------------------------------------------------

	public function update($id = null)
	{
		$data = [
			'category_id'  => $this->request->getPost('category_id'),
			'name'         => $this->request->getPost('name'),
			'description'  => $this->request->getPost('description'),
			'point'        => $this->request->getPost('point'),
			'max_attempts' => empty($this->request->getPost('max_attempts')) ? 0 : $this->request->getPost('max_attempts'),
			'type'         => $this->request->getPost('type'),
			'is_active'    => $this->request->getPost('is_active'),
		];

		$result = $this->challengeModel->update($id, $data);
		if (! $result)
		{
			$viewData['errors'] = $this->challengeModel->errors();
			return redirect()->to("/admin/challenges/$id");
		}
		return redirect()->to("/admin/challenges/$id");
	}
}
