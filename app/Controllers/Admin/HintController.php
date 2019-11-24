<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use \App\Models\HintModel;

class HintController extends AdminController
{
	private $hintModel;

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->hintModel = new HintModel();
	}

	//--------------------------------------------------------------------

	public function index()
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

	public function create($challengeID = null)
	{
		$data = [
			'challenge_id'	=> $challengeID,
			'cost'			=> $this->request->getPost('cost'),
			'content'		=> $this->request->getPost('content'),
			'is_active'		=> $this->request->getPost('is_active'),
		];

		$result = $this->hintModel->insert($data);

		if (! $result)
        {
            $errors = $this->hintModel->errors();
            return redirect()->to("/admin/challenges/$challengeID");
        }

        return redirect()->to("/admin/challenges/$challengeID");
	}

	//--------------------------------------------------------------------

	public function delete($challengeID = null, $hintID = null)
	{
		$result = $this->hintModel->delete($hintID);

		if (! $result)
        {
            $errors = $this->hintModel->errors();
            return redirect()->back()->with('errors', $errors);
        }

        return redirect()->back();
	}

	//--------------------------------------------------------------------

	public function update($challengeID = null, $id = null)
	{
		$data = [
			'cost'			=> $this->request->getPost('cost'),
			'content'		=> $this->request->getPost('content'),
			'is_active'		=> $this->request->getPost('is_active'),
		];

		$result = $this->hintModel->update($id, $data);

		if (! $result)
        {
            $errors = $this->hintModel->errors();
            return redirect()->back()->with('errors', $errors);
        }

        return redirect()->to("/admin/challenges/$challengeID");
	}
}
