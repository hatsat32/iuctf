<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use \App\Models\FlagModel;

class FlagController extends AdminController
{
	/** @var FlagModel **/
	private $flagModel;

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->flagModel = new FlagModel();
	}

	//--------------------------------------------------------------------

	public function create($challengeID = null)
	{
		$data = [
			'challenge_id'  => $challengeID,
			'type'          => $this->request->getPost('type'),
			'content'       => $this->request->getPost('content'),
		];

		$result = $this->flagModel->insert($data);

		if (! $result)
		{
			return redirect()->back()->with('flag-errors', $this->flagModel->errors());
		}

		return redirect()->back()->with('flag-message', lang('admin/Challenge.flagCreated'));
	}

	//--------------------------------------------------------------------

	public function delete($challengeID = null, $flagID = null)
	{
		$result = $this->flagModel->delete($flagID);

		if (! $result)
		{
			return redirect()->back()->with('flag-errors', $this->flagModel->errors());
		}

		return redirect()->back()->with('flag-message', lang('admin/Challenge.flagDeleted'));
	}

	//--------------------------------------------------------------------
}
