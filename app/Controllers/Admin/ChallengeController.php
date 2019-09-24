<?php namespace App\Controllers\Admin;

use \App\Models\ChallengeModel;
use \App\Models\CategoryModel;
use \App\Models\FlagModel;

class ChallengeController extends \App\Controllers\BaseController
{
	protected $challengeModel = null;

	public function __construct()
	{
		$this->challengeModel = new ChallengeModel();
		$this->categoryModel = new CategoryModel();
		$this->flagModel = new FlagModel();
	}

	//--------------------------------------------------------------------

	public function index()
	{
		$viewData['challenges'] = $this->challengeModel->findAll();
		return view('admin/challenge/index', $viewData);
	}

	//--------------------------------------------------------------------

	public function new()
	{
		$viewData['categories'] = $this->categoryModel->findAll();
		return view('admin/challenge/new', $viewData);
	}

	//--------------------------------------------------------------------

	public function edit($id = null)
	{
		
	}

	//--------------------------------------------------------------------

	public function show($id = null)
	{
		$challenge = $this->challengeModel->find($id);
		$viewData['categories']	= $this->categoryModel->findAll();
		$viewData['flags'] = $this->flagModel->where('challenge_id', $id)->findAll();
		$viewData['challenge'] = $challenge;
		return view('admin/challenge/detail', $viewData);
	}

	//--------------------------------------------------------------------

	public function create()
	{
		$data = [
			'category_id'	=> $this->request->getPost('category_id'),
			'name'			=> $this->request->getPost('name'),
			'description'	=> $this->request->getPost('description'),
			'point'			=> $this->request->getPost('point'),
			'max_attempts'	=> $this->request->getPost('max_attempts'),
			'type'			=> $this->request->getPost('type'),
			'is_active'		=> $this->request->getPost('is_active'),
		];
		
		$result = $this->challengeModel->insert($data);

		if (! $result)
		{
			$viewData['errors'] 	= $this->challengeModel->errors();
			$viewData['categories']	= $this->categoryModel->findAll();
			return view('admin/challenge/new', $viewData);
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
		$team = $this->challengeModel->find($id);
		$data = [
			'category_id' => $this->request->getPost('category_id'),
			'name' => $this->request->getPost('name'),
			'description' => $this->request->getPost('description'),
			'point' => $this->request->getPost('point'),
			'max_attempts' => $this->request->getPost('max_attempts'),
			'type' => $this->request->getPost('type'),
			'is_active' => $this->request->getPost('is_active'),
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
