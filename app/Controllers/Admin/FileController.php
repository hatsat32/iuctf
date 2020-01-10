<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use \App\Models\FileModel;

class FileController extends AdminController
{
	protected $fileModel = null;

	//--------------------------------------------------------------------
	
	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->fileModel = new FileModel();
	}

	//--------------------------------------------------------------------
	
	public function create($challengeID = null)
	{
		$file = $this->request->getFile('file');

		// php file extension forbidden
		if (preg_match('/php/', $file->getExtension()) === 1)
		{
			return redirect()->to("/admin/challenges/$challengeID")->with('file-error', lang('admin/Challenge.fileUploadPhpError'));
		}

		$name = $file->getRandomName();

		if (! $file->isValid() || file_exists(FCPATH.'uploads'.DIRECTORY_SEPARATOR.$name))
		{
			return redirect()->to("/admin/challenges/$challengeID")->with('file-errors', lang('admin/Challenge.FileUploadError'));
		}

		$file->move(FCPATH.'uploads', $name);

		$data = [
			'challenge_id' => $challengeID,
			'location'     => $name,
		];

		if (! $this->fileModel->insert($data))
		{
			return redirect()->to("/admin/challenges/$challengeID")->with('file-errors', lang('admin/Challenge.FileUploadError'));
		}

		return redirect()->to("/admin/challenges/$challengeID")->with('file-message', lang('admin/Challenge.fileUploadSuccessful'));
	}

	//--------------------------------------------------------------------
	
	public function delete($challengeID = null, $fileID = null)
	{
		$file = $this->fileModel->find($fileID);

		$filePath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . $file['location'];

		if (file_exists($filePath) && unlink($filePath))
		{
			$this->fileModel->delete($fileID);

			return redirect()->to("/admin/challenges/$challengeID");
		}

		return redirect()->to("/admin/challenges/$challengeID");
	}

	//--------------------------------------------------------------------
}
