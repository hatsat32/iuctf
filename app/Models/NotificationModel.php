<?php namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
	protected $table      = 'notifications';
	protected $primaryKey = 'id';

	protected $returnType    = 'App\Entities\Notification';

	protected $allowedFields = [
		'title', 'content',
	];

	protected $validationRules = [
		'title'     => 'required|string',
		'content'	=> 'required|string',
	];
	
	protected $validationMessages = [];
	protected $skipValidation = false;
}
