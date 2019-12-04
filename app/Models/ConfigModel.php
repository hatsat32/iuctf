<?php namespace App\Models;

use CodeIgniter\Model;

class ConfigModel extends Model
{
	protected $table      = 'config';
	protected $primaryKey = 'id';

	protected $allowedFields = [
		'key', 'value'
	];

	protected $validationRules = [
		'key'         => 'required|alpha_numeric',
		'description' => 'required',
	];
	
	protected $validationMessages = [];
	protected $skipValidation = false;
}
