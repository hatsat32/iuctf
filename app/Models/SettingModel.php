<?php namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Setting;

class SettingModel extends Model
{
	protected $table      = 'settings';
	protected $primaryKey = 'id';
	protected $returnType = Setting::class;

	protected $allowedFields = [
		'key', 'value'
	];

	protected $validationRules = [
		'key'   => 'required|string',
		'value' => 'required',
	];
	
	protected $useTimestamps = true;

	//--------------------------------------------------------------------

	public function getAllSettings()
	{
		$settings = new \stdClass();

		foreach ($this->findAll() as $setting) {
			$settings->{$setting->key} = $setting->value;
		}

		return $settings;
	}

	//--------------------------------------------------------------------
}
