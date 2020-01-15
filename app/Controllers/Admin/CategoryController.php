<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use \App\Models\CategoryModel;

class CategoryController extends AdminController
{
	/** @var CategoryModel **/
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

		try
		{
			$result = $this->categoryModel->insert($data);
		}
		catch (\Exception $e)
		{
			return redirect()->route('admin-categories-new')->withInput()
					->with('error', $e->getMessage());
		}

		if (! $result)
		{
			return redirect()->route('admin-categories-new')->withInput()
					->with('errors', $this->categoryModel->errors());
		}

		return redirect()->route('admin-categories-show', [$result])->with('message', lang('admin/Category.created'));
	}

	//--------------------------------------------------------------------

	public function delete($id = null)
	{
		$result = $this->categoryModel->delete($id);

		if (! $result)
		{
			return redirect()->route('admin-categories-show', [$id])->with('errors', $this->categoryModel->errors());
		}

		return redirect()->route('admin-categories')->with('message', lang('admin/Category.deleted'));
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
			return redirect()->route('admin-categories-show', [$id])->with('errors', $this->categoryModel->errors());
		}

		return redirect()->route('admin-categories-show', [$id])->with('message', lang('admin/Category.updated'));
	}

	//--------------------------------------------------------------------
}
