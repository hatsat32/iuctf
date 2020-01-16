<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use \App\Models\FileModel;

class FileController extends AdminController
{
	/** @var FileModel **/
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
			return redirect()->back()->with('file-error', lang('admin/Challenge.fileUploadPhpError'));
		}

		$name = $file->getRandomName();

		if (! $file->isValid() || file_exists(FCPATH.'uploads'.DIRECTORY_SEPARATOR.$name))
		{
			return redirect()->back()->with('file-error', lang('admin/Challenge.FileUploadError'));
		}

		$file->move(FCPATH.'uploads', $name);

		$data = [
			'challenge_id' => $challengeID,
			'location'     => $name,
		];

		if (! $this->fileModel->insert($data))
		{
			return redirect()->back()->with('file-error', lang('admin/Challenge.FileUploadError'));
		}

		return redirect()->back()->with('file-message', lang('admin/Challenge.fileUploadSuccessful'));
	}

	//--------------------------------------------------------------------

	public function delete($challengeID = null, $fileID = null)
	{
		$file = $this->fileModel->find($fileID);

		$filePath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . $file['location'];

		if (file_exists($filePath) && unlink($filePath))
		{
			if (! $this->fileModel->delete($fileID))
			{
				return redirect()->back()->with('file-errors', $this->fileModel->errors());
			}
		}

		return redirect()->back()->with('file-message', lang('admin/Challenge.fileDeleted'));
	}

	//--------------------------------------------------------------------
}
