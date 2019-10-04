<?php namespace App\Controllers\Admin;

use \App\Models\NotificationModel;
use \App\Entities\Notification;


class NotificationController extends \App\Controllers\BaseController
{
	protected $notificationModel = null;

	public function __construct()
	{
		$this->notificationModel = new NotificationModel();
	}

	//--------------------------------------------------------------------

	public function index()
	{
		$viewData['notifications'] = $this->notificationModel->findAll();
		return view('admin/notification/index', $viewData);
	}

	//--------------------------------------------------------------------

	public function new()
	{
		return view('admin/notification/new');
	}

	//--------------------------------------------------------------------

	public function edit($id = null)
	{

	}

	//--------------------------------------------------------------------

	public function show($id = null)
	{
		$viewData['notification'] = $this->notificationModel->find($id);

		return view('admin/notification/detail', $viewData);
	}

	//--------------------------------------------------------------------

	public function create()
	{
		$notification = new Notification();

		$notification->title = $this->request->getPost('title');
		$notification->content = $this->request->getPost('content');

		$result = $this->notificationModel->save($notification);

		if (! $result)
		{
			$errors = $this->notificationModel->errors();
			return redirect()->to('/admin/notifications/new')->withInput()->with('errors', $errors);
		}

		return redirect()->to('/admin/notifications');
	}

	//--------------------------------------------------------------------

	public function delete($id = null)
	{
		$result = $this->notificationModel->delete($id);

		if (! $result)
		{
			$errors = $this->notificationModel->errors();
			return redirect()->to("admin/notifications/$id")->with('errors', $errors);
		}

		return redirect()->to("/admin/notifications");
	}

	//--------------------------------------------------------------------

	public function update($id = null)
	{
		$notification = $this->notificationModel->find($id);

		$notification->title = $this->request->getPost('title');
		$notification->content = $this->request->getPost('content');

		$result = $this->notificationModel->save($notification);

		if (! $result)
		{
			$errors = $this->notificationModel->errors();
			return redirect()->to("/admin/notifications/$id")->with('errors', $errors);
		}

		return redirect()->to("/admin/notifications/$id");
	}
}
