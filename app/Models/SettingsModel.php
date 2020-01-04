<?php namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Settings;

class SettingsModel extends Model
{
	protected $table      = 'config';
	protected $primaryKey = 'id';
	protected $returnType = Settings::class;

	protected $allowedFields = [
		'key', 'value'
	];

	protected $validationRules = [
		'key'   => 'required|string',
		'value' => 'required',
	];
	
	protected $useTimestamps = true;
}
