<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use \App\Models\CategoryModel;

class CategoryController extends AdminController
{
	protected $categoryModel = null;

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->categoryModel = new CategoryModel();
	}

	//--------------------------------------------------------------------

	public function index()
	{
		$viewData['categories'] = $this->categoryModel->findAll();
		return $this->render('category/index', $viewData);
	}

	//--------------------------------------------------------------------

	public function new()
	{
		return $this->render('category/new');
	}

	//--------------------------------------------------------------------

	public function edit($id = null)
	{

	}

	//--------------------------------------------------------------------

	public function show($id = null)
	{
		$viewData['category'] = $this->categoryModel->find($id);
		return $this->render('category/detail', $viewData);
	}

	//--------------------------------------------------------------------

	public function create()
	{
		$data = [
			'name'          => $this->request->getPost('name'),
			'description'   => $this->request->getPost('description'),
		];

		$result = $this->categoryModel->insert($data);

		if (! $result)
		{
			$errors = $this->categoryModel->errors();
			return redirect()->to('/admin/categories/new');
		}

		return redirect()->to('/admin/categories');
	}

	//--------------------------------------------------------------------

	public function delete($id = null)
	{
		$result = $this->categoryModel->delete($id);

		if (! $result)
		{
			$viewData['errors'] = $this->categoryModel->errors();
			return redirect()->to("/admin/categories/$id", $viewData);
		}

		return redirect()->to('/admin/categories');
	}

	//--------------------------------------------------------------------

	public function update($id = null)
	{
		$data = [
			'name'          => $this->request->getPost('name'),
			'description'   => $this->request->getPost('description'),
		];

		$result = $this->categoryModel->update($id, $data);
		if (! $result)
		{
			$viewData['errors'] = $this->categoryModel->errors();
			return redirect()->to("/admin/categories/$id", $viewData);
		}
		return redirect()->to("/admin/categories/$id");
	}
}
