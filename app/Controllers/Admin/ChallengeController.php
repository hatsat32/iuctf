<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use \App\Models\ChallengeModel;
use \App\Models\CategoryModel;
use App\Entities\Challenge;

class ChallengeController extends AdminController
{
	/** @var ChallengeModel **/
	protected $challengeModel;
	/** @var CategoryModel **/
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
		$challenges = $this->challengeModel
				->select(['challenges.id', 'categories.id AS cat_id', 'categories.name AS cat_name',
						'challenges.name', 'challenges.point', 'challenges.is_active'])
				->join('categories', 'challenges.category_id = categories.id', 'left');

		return $this->render('challenge/index', [
			'challenges' => $challenges->paginate(20),
			'pager'      => $challenges->pager,
		]);
	}

	//--------------------------------------------------------------------

	public function new()
	{
		$viewData['categories'] = $this->categoryModel->findAll();
		return $this->render('challenge/new', $viewData);
	}

	//--------------------------------------------------------------------

	public function show($id = null)
	{
		$challange = $this->challengeModel->find($id);

		$viewData = [
			'challenge'  => $challange,
			'categories' => $this->categoryModel->findAll(),
			'flags'      => $challange->flags(),
			'hints'      => $challange->hints(),
			'files'      => $challange->files(),
		];

		return $this->render('challenge/detail', $viewData);
	}

	//--------------------------------------------------------------------

	public function create()
	{
		$challange = new Challenge();
		$challange->fill($this->request->getPost());

		try
		{
			$result = $this->challengeModel->insert($challange);
		}
		catch (\Exception $e)
		{
			return redirect()->route('admin-challenges-new')->withInput()->with('error', $e->getMessage());
		}

		if (! $result)
		{
			$errors = $this->challengeModel->errors();
			return redirect()->route('admin-challenges-new')->withInput()->with('errors', $errors);
		}

		cache()->delete('challenges-active');
		return redirect()->route('admin-challenges-show', [$result])->with('message', lang('admin/Challenge.created'));
	}

	//--------------------------------------------------------------------

	public function delete($id = null)
	{
		$result = $this->challengeModel->delete($id);

		if (! $result)
		{
			return redirect()->route('admin-challenges-show', [$id])->with('errors', $this->challengeModel->errors());
		}

		cache()->delete('challenges-active');
		return redirect('admin-challenges')->with('message', lang('admin/Challenge.deleted'));
	}

	//--------------------------------------------------------------------

	public function update($id = null)
	{
		$challange = $this->challengeModel->find($id);

		$challange->fill($this->request->getPost());

		$result = $this->challengeModel->save($challange);

		if (! $result)
		{
			return redirect()->route('admin-challenges-show', [$id])->with('errors', $this->challengeModel->errors());
		}

		cache()->delete('challenges-active');
		return redirect()->route('admin-challenges-show', [$id])->with('message', lang('admin/Challenge.updated'));
	}
}
