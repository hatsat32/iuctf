<?php namespace App\Controllers\Admin;

use \App\Models\FlagModel;

class FlagController extends \App\Controllers\BaseController
{
	private $flagModel;

	public function __construct()
	{
		$this->flagModel = new FlagModel();
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
            'challenge_id'  => $challengeID,
            'type'          => $this->request->getPost('type'),
            'content'       => $this->request->getPost('content'),
        ];

        $result = $this->flagModel->insert($data);

        if (! $result)
        {
            $errors = $this->flagModel->errors();
            return redirect()->to("/admin/challenges/$challengeID");
        }

        return redirect()->to("/admin/challenges/$challengeID");
	}

	//--------------------------------------------------------------------

	public function delete($challengeID = null, $flagID = null)
	{
        $result = $this->flagModel->delete($flagID);

        if (! $result)
        {
            $errors = $this->flagModel->errors();
            return redirect()->to("/admin/challenges/$challengeID");
        }

        return redirect()->to("/admin/challenges/$challengeID");
	}

	//--------------------------------------------------------------------

	public function update($id = null)
	{

	}
}
