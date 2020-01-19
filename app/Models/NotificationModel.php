<?php namespace App\Models;


use CodeIgniter\Model;
use CodeIgniter\Entity;


class NotificationModel extends Model
{
	protected $table      = 'notifications';
	protected $primaryKey = 'id';
	protected $returnType = Entity::class;

	protected $allowedFields = [
		'title', 'content',
	];

	protected $validationRules = [
		'title'   => 'required|string',
		'content' => 'required|string',
	];
	
	protected $validationMessages = [];
	protected $skipValidation = false;
	
	protected $useTimestamps = true;
}
