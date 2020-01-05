<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use App\Models\SettingsModel;
use ZipArchive;

class SettingsController extends AdminController
{
	/** @var SettingsModel */
	protected $SettingsModel;

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->SettingsModel = new SettingsModel();
	}

	//--------------------------------------------------------------------

	public function index()
	{
		$viewData['config'] = [];

		foreach ($this->SettingsModel->findAll() as $row) {
			$viewData['config'][$row->key] = $row->value;
		}

		return $this->render('settings/index', $viewData);
	}

	//--------------------------------------------------------------------

	public function general()
	{
		$settings = new \stdClass();

		foreach ($this->SettingsModel->findAll() as $row)
		{
			$settings->{$row->key} = $row->value;
		}

		return $this->render('settings/general', ['settings' => $settings]);
	}

	//--------------------------------------------------------------------

	public function generalUpdate()
	{
		$rules = [
			'competition_name' => [
				'label' => lang('admin/Settings.ctfName'),
				'rules' => 'required|min_length[3]'
			],
			'team_member_limit' => [
				'label' => lang('admin/Settings.memberLimit'),
				'rules' => 'required|integer|max_length[10]'
			],
			'theme' => [
				'label' => lang('admin/Settings.theme'),
				'rules' => 'required'
			],
			'allow_register' => [
				'label' => lang('admin/Settings.allowRegister'),
				'rules' => 'required|in_list[allow,disallow]'
			],
			'need_hash' => [
				'label' => lang('admin/Settings.needHashTitle'),
				'rules' => 'required|in_list[true,false]'
			],
			'hash_secret_key' => [
				'label' => lang('admin/Settings.hashSecretKey'),
				'rules' => 'required'
			],
		];

		$data = [
			[
				'key'   => 'competition_name',
				'value' => $this->request->getPost('competition_name')
			],
			[
				'key'   => 'team_member_limit',
				'value' => $this->request->getPost('team_member_limit')
			],
			[
				'key'   => 'theme',
				'value' => $this->request->getPost('theme')
			],
			[
				'key'   => 'allow_register',
				'value' => $this->request->getPost('allow_register')
			],
			[
				'key'   => 'need_hash',
				'value' => $this->request->getPost('need_hash')
			],
			[
				'key'   => 'hash_secret_key',
				'value' => $this->request->getPost('hash_secret_key')
			],
		];

		if (! $this->validate($rules))
		{
			return redirect('admin-settings-general')->withInput()->with('errors', $this->validator->getErrors());
		}

		$result = $this->SettingsModel->updateBatch($data, 'key');

		if(! $result)
		{
			return redirect('admin-settings-general')->with('errors', $this->SettingsModel->errors());
		}

		return redirect('admin-settings-general')->with('message', lang('admin/Settings.updatedSuccessfully'));
	}

	//--------------------------------------------------------------------

	public function timer()
	{
		$settings = new \stdClass();

		foreach ($this->SettingsModel->findAll() as $row)
		{
			$settings->{$row->key} = $row->value;
		}

		return $this->render('settings/timer', ['settings' => $settings]);
	}

	//--------------------------------------------------------------------

	public function timerUpdate()
	{
		$rules = [
			'timer' => [
				'label' => lang('admin/Settings.timer'),
				'rules' => 'required|in_list[on,off]'
			],
			'start_time' => [
				'label' => lang('admin/Settings.startTime'),
				'rules' => 'permit_empty|valid_date'
			],
			'end_time' => [
				'label' => lang('admin/Settings.endTime'),
				'rules' => 'permit_empty|valid_date'
			],
		];

		if (! $this->validate($rules))
		{
			return redirect('admin-settings-timer')->withInput()->with('errors', $this->validator->getErrors());
		}

		$updateData = [
			[
				'key' => 'competition_timer',
				'value' => $this->request->getPost('timer')
			],
		];

		if (isset($_POST['start_time']) && isset($_POST['end_time']))
		{
			$updateData = array_merge($updateData, [
				[
					'key' => 'competition_start_time',
					'value' => $this->request->getPost('start_time')
				],
				[
					'key' => 'competition_end_time',
					'value' => $this->request->getPost('end_time')
				],
			]);
		}

		$result = $this->SettingsModel->updateBatch($updateData, 'key');

		if (! $result)
		{
			return redirect('admin-settings-timer')->with('errors', $this->SettingsModel->errors());
		}

		return redirect('admin-settings-timer')->with('message', lang('admin/Settings.updatedSuccessfully'));
	}

	//--------------------------------------------------------------------

	public function data()
	{
		helper('filesystem');

		$backups = directory_map(WRITEPATH.'backups'.DIRECTORY_SEPARATOR);

		if (($key = array_search('index.html', $backups)) !== false)
		{
			unset($backups[$key]);
		}

		return $this->render('settings/data', ['backups' => $backups]);
	}

	//--------------------------------------------------------------------

	public function backupData()
	{
		$zip = new ZipArchive();

		$path = WRITEPATH.'backups'.DIRECTORY_SEPARATOR.'backup_'.date('d-m-Y_H-i-s').'.zip';
		if ($zip->open($path, ZipArchive::CREATE) === true)
		{
			$zip->addGlob(
				FCPATH.'uploads'.DIRECTORY_SEPARATOR.'*',
				GLOB_BRACE,
				['add_path' => 'uploads/', 'remove_all_path' => TRUE]
			);
		}
		$zip->close();

		return redirect('admin-settings-data')->with('message', lang('admin/Settings.backupSuccessful'));
	}

	//--------------------------------------------------------------------

	public function delete($file = null)
	{
		$filePath = WRITEPATH . 'backups' . DIRECTORY_SEPARATOR . $file.'.zip';

		if (file_exists($filePath) && ! unlink($filePath))
		{
			return redirect('admin-settings-data')->with('error', lang('admin/Settings.deleteError'));
		}

		return redirect('admin-settings-data')->with('message', lang('admin/Settings.deletedSuccessfully'));
	}

	//--------------------------------------------------------------------

	public function download($file = null)
	{
		$path = WRITEPATH.'backups'.DIRECTORY_SEPARATOR.$file.'.zip';

		if (! file_exists($path))
		{
			return redirect('admin-settings-data')->with('error', lang('admin/Settings.fileNotExist', ['file' => "${file}.zip"]));
		}

		return $this->response->download($path, NULL);
	}

	//--------------------------------------------------------------------

	public function resetData()
	{
		return redirect('admin-settings-data')->with('reset-error', 'NOT IMPLEMENTED YET');
	}

	//--------------------------------------------------------------------
}
