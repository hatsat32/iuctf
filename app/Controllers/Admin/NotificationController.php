<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use App\Models\NotificationModel;
use CodeIgniter\Entity;


class NotificationController extends AdminController
{
	/** @var NotificationModel **/
	protected $notificationModel = null;

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->notificationModel = new NotificationModel();
	}

	//--------------------------------------------------------------------

	public function index()
	{
		$viewData['notifications'] = $this->notificationModel->findAll();
		return $this->render('notification/index', $viewData);
	}

	//--------------------------------------------------------------------

	public function new()
	{
		return $this->render('notification/new');
	}

	//--------------------------------------------------------------------

	public function show($id = null)
	{
		$viewData['notification'] = $this->notificationModel->find($id);

		return $this->render('notification/detail', $viewData);
	}

	//--------------------------------------------------------------------

	public function create()
	{
		$notification = new Entity();

		$notification->title = $this->request->getPost('title');
		$notification->content = $this->request->getPost('content');

		$result = $this->notificationModel->insert($notification);

		if (! $result)
		{
			$errors = $this->notificationModel->errors();
			return redirect('admin-notf-new')->withInput()->with('errors', $errors);
		}

		cache()->delete('notifications');
		return redirect()->route('admin-notf-show', [$result])->with('message', lang('admin/Notification.created'));
	}

	//--------------------------------------------------------------------

	public function delete($id = null)
	{
		$result = $this->notificationModel->delete($id);

		if (! $result)
		{
			$errors = $this->notificationModel->errors();
			return redirect()->route("admin-notf-show", [$id])->with('errors', $errors);
		}

		cache()->delete('notifications');
		return redirect('admin-notf')->with('message', lang('admin/Notification.deleted'));
	}

	//--------------------------------------------------------------------

	public function update($id = null)
	{
		$notification = $this->notificationModel->find($id);

		$notification->fill($this->request->getPost(['title', 'content']));

		if (! $notification->hasChanged())
		{
			return redirect()->route('admin-notf-show', [$id])->with('warning', lang('General.notChanged'));
		}

		$result = $this->notificationModel->save($notification);

		if (! $result)
		{
			$errors = $this->notificationModel->errors();
			return redirect()->route('admin-notf-show', [$id])->with('errors', $errors);
		}

		cache()->delete('notifications');
		return redirect()->route('admin-notf-show', [$id])->with('message', lang('admin/Notification.updated'));
	}
}
