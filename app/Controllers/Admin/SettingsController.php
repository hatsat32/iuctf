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
		return redirect('admin-settings-general');
	}

	//--------------------------------------------------------------------

	public function general()
	{
		helper('filesystem');
		$settings = ss();

		$themes = \App\Core\ThemeTrait::list();

		return $this->render('settings/general', [
			'settings' => $settings,
			'themes'   => $themes,
		]);
	}

	//--------------------------------------------------------------------

	public function generalUpdate()
	{
		$rules = [
			'ctf_name' => [
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
				'rules' => 'required|in_list[true,false]'
			],
			'need_hash' => [
				'label' => lang('admin/Settings.needHashTitle'),
				'rules' => 'required|in_list[true,false]'
			],
			'hash_secret_key' => [
				'label' => lang('admin/Settings.hashSecretKey'),
				'rules' => 'permit_empty|in_list[on,off]'
			],
		];

		$data = [
			[
				'key'   => 'ctf_name',
				'value' => $this->request->getPost('ctf_name')
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
		];

		if ($this->request->getPost('hash_secret_key') === 'on')
		{
			$data[] = [
				'key'   => 'hash_secret_key',
				'value' => bin2hex(random_bytes(8)),
			];
		}

		if (! $this->validate($rules))
		{
			return redirect('admin-settings-general')->withInput()->with('errors', $this->validator->getErrors());
		}

		$result = $this->SettingsModel->skipValidation()->updateBatch($data, 'key');

		if(! $result)
		{
			return redirect('admin-settings-general')->with('errors', $this->SettingsModel->errors());
		}

		return redirect('admin-settings-general')->with('message', lang('admin/Settings.updatedSuccessfully'));
	}

	//--------------------------------------------------------------------

	public function timer()
	{
		$settings = ss();

		return $this->render('settings/timer', ['settings' => $settings]);
	}

	//--------------------------------------------------------------------

	public function timerUpdate()
	{
		$rules = [
			'ctf_timer' => [
				'label' => lang('admin/Settings.timer'),
				'rules' => 'required|in_list[on,off]'
			],
		];

		if ($this->request->getPost('ctf_timer') === 'on')
		{
			$rules = array_merge($rules, [
				'ctf_start_time' => [
					'label' => lang('admin/Settings.startTime'),
					'rules' => 'required|valid_date'
				],
				'ctf_end_time' => [
					'label' => lang('admin/Settings.endTime'),
					'rules' => 'required|valid_date'
				]
			]);
		}

		if (! $this->validate($rules))
		{
			return redirect('admin-settings-timer')->withInput()->with('errors', $this->validator->getErrors());
		}

		$updateData = [
			[
				'key' => 'ctf_timer',
				'value' => $this->request->getPost('ctf_timer')
			],
		];

		if (isset($_POST['ctf_start_time']) && isset($_POST['ctf_end_time']))
		{
			$updateData = array_merge($updateData, [
				[
					'key' => 'ctf_start_time',
					'value' => $this->request->getPost('ctf_start_time')
				],
				[
					'key' => 'ctf_end_time',
					'value' => $this->request->getPost('ctf_end_time')
				],
			]);
		}

		$result = $this->SettingsModel->skipValidation()->updateBatch($updateData, 'key');

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
		$db = db_connect();
		$db_backup = [];

		// fetch all database
		foreach ($db->listTables() as $table)
		{
			$table_data = $db->table($table)->get()->getResultArray();
			$db_backup[$table] = $table_data;
		}

		// create zip file
		$path = WRITEPATH.'backups'.DIRECTORY_SEPARATOR.'backup_'.date('d-m-Y_H-i-s').'.zip';
		if ($zip->open($path, ZipArchive::CREATE) !== true)
		{
			return redirect('admin-settings-data')->with('error', lang('admin/Settings.zipOpenErr'));
		}

		// backup uploaded files
		$zip->addGlob(
			FCPATH.'uploads'.DIRECTORY_SEPARATOR.'*',
			GLOB_BRACE,
			['add_path' => 'uploads/', 'remove_all_path' => TRUE]
		);

		// backup database
		$zip->addFromString('database.json', json_encode($db_backup));

		// if home page customized, back it up
		if (file_exists(WRITEPATH.'home_page_custom.html'))
		{
			$zip->addFile(WRITEPATH.'home_page_custom.html', 'home_page_custom.html');
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

	public function homePage()
	{
		if (file_exists(WRITEPATH.'home_page_custom.html'))
		{
			$content = file_get_contents(WRITEPATH.'home_page_custom.html');
			return $this->render('settings/home', ['content' => $content]);
		}

		if (file_exists(WRITEPATH.'home_page.html'))
		{
			$content = file_get_contents(WRITEPATH.'home_page.html');
			return $this->render('settings/home', ['content' => $content]);
		}

		return $this->render('settings/home', ['content' => '']);
	}

	//--------------------------------------------------------------------

	public function homePageUpdate()
	{
		helper('filesystem');

		$filePath = WRITEPATH.'home_page_custom.html';

		$content = $this->request->getPost('content');

		if (! write_file($filePath, $content))
		{
			return redirect('admin-settings-homepage')->withInput()->with('error', lang('admin/Settings.pageChangeError'));
		}

		return redirect('admin-settings-homepage')->with('message', lang('admin/Settings.pageChanged'));
	}

	//--------------------------------------------------------------------

	public function theme()
	{
		$themes = \App\Core\ThemeTrait::list();

		return $this->render('settings/theme', ['themes' => $themes]);
	}
	//--------------------------------------------------------------------

	public function themeUpdate()
	{
		if(ss()->theme === $this->request->getPost('theme'))
		{
			return redirect('admin-settings-theme');
		}

		$rules = [
			'theme' => [
				'label' => lang('admin/Settings.theme'),
				'rules' => 'required'
			],
		];

		if (! $this->validate($rules))
		{
			return redirect('admin-settings-theme')->withInput()->with('errors', $this->validator->getErrors());
		}

		$result = $this->SettingsModel->skipValidation()->where('key', 'theme')
				->set('value', $this->request->getPost('theme'))->update();

		if(! $result)
		{
			return redirect('admin-settings-theme')->with('errors', $this->SettingsModel->errors());
		}

		return redirect('admin-settings-theme')->with('message', lang('admin/Settings.updatedSuccessfully'));
	}

	//--------------------------------------------------------------------

	public function themeImport()
	{
		$zip = new ZipArchive();
		$file = $this->request->getFile('file');

		if (! $file->isValid())
		{
			throw new \RuntimeException($file->getErrorString().'('.$file->getError().')');
		}

		// check file is zip and validate
		$rules = [
			'file' => 'uploaded[file]|mime_in[file,application/zip]|ext_in[file,zip]'
		];
		if (! $this->validate($rules))
		{
			return redirect('admin-settings-theme')->with('theme-errors', $this->validator->getErrors() );
		}

		if (! $zip->open($file->getRealPath()))
		{
			return redirect('admin-settings-theme')->with('theme-error', lang('admin/Settings.fileOpenErr'));
		}

		if (! $zip->extractTo(THEMEPATH))
		{
			return redirect('admin-settings-theme')->with('theme-error', lang('admin/Settings.fileMoveErr'));
		}

		$zip->close();

		// check file paths
		// NO DIRECTORY TRAVERSAL

		return redirect('admin-settings-theme')->with('theme-message', lang('admin/Settings.themeImported'));
	}

	//--------------------------------------------------------------------

	public function themeDelete()
	{
		$theme = $this->request->getPost('theme');

		// can not delete default theme
		if ($theme == 'default')
		{
			return redirect('admin-settings-theme')->with('theme-error', lang('admin/Settings.defaultThemeErr'));
		}

		// validation
		if (! in_array($theme, \App\Core\ThemeTrait::list()))
		{
			return redirect('admin-settings-theme')->with('theme-error', lang('admin/Settings.themeValidationErr'));
		}

		// can not delete current theme
		if ($theme == ss()->theme)
		{
			return redirect('admin-settings-theme')->with('theme-error', lang('admin/Settings.currentThemeErr'));
		}

		helper('filesystem');

		if (file_exists(THEMEPATH.$theme) && is_dir(THEMEPATH.$theme))
		{
			delete_files(THEMEPATH.$theme, true);
			rmdir(THEMEPATH.$theme);
		}

		if (file_exists(THEMEPUBPATH.$theme) && is_dir(THEMEPUBPATH.$theme))
		{
			delete_files(THEMEPUBPATH.$theme, true);
			rmdir(THEMEPUBPATH.$theme);
		}

		return redirect('admin-settings-theme')->with('theme-message', lang('admin/Settings.themeDeleted'));
	}

	//--------------------------------------------------------------------
}
