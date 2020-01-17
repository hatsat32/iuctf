<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use \App\Models\HintModel;

class HintController extends AdminController
{
	/** @var HintModel **/
	private $hintModel;

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->hintModel = new HintModel();
	}

	//--------------------------------------------------------------------

	public function create($challengeID = null)
	{
		$data = [
			'challenge_id' => $challengeID,
			'cost'         => $this->request->getPost('cost'),
			'content'      => $this->request->getPost('content'),
			'is_active'    => $this->request->getPost('is_active'),
		];

		$result = $this->hintModel->insert($data);

		if (! $result)
		{
			$errors = $this->hintModel->errors();
			return redirect()->route('admin-challenges-show', [$challengeID])->with('hint-errors', $errors);
		}

		return redirect()->route('admin-challenges-show', [$challengeID])
				->with('hint-message', lang('admin/Challenge.hintCreated'));
	}

	//--------------------------------------------------------------------

	public function delete($challengeID = null, $hintID = null)
	{
		$result = $this->hintModel->delete($hintID);

		if (! $result)
		{
			return redirect()->back()->with('hint-errors', $this->hintModel->errors());
		}

		return redirect()->back()->with('hint-message', lang('admin/Challenge.hintDeleted'));
	}

	//--------------------------------------------------------------------

	public function update($challengeID = null, $id = null)
	{
		$data = [
			'cost'      => $this->request->getPost('cost'),
			'content'   => $this->request->getPost('content'),
			'is_active' => $this->request->getPost('is_active'),
		];

		$result = $this->hintModel->update($id, $data);

		if (! $result)
		{
			return redirect()->back()->with('errors', $this->hintModel->errors());
		}

		return redirect()->back()->with('hint-message', lang('admin/Challenge.hintUpdated'));
	}

	//--------------------------------------------------------------------
}
