<?php namespace App\Entities;

use CodeIgniter\Entity;
use CodeIgniter\I18n\Time;

class Settings extends Entity
{
	protected $attributes = [
		'key'   => null,
		'value' => null
	];

	protected $dates = ['created_at', 'updated_at'];

	protected $boolValues = [
		'need_hash', 'allow_register', 'ctf_timer'
	];

	protected $intValues = [
		'team_member_limit'
	];

	protected $dateValues = [
		'ctf_start_time', 'ctf_end_time'
	];

	public function setKey(string $key)
	{
		$this->attributes['key'] = $key;

		return $this;
	}

	public function getValue()
	{
		if (in_array($this->attributes['key'], $this->boolValues))
		{
			return filter_var($this->attributes['value'], FILTER_VALIDATE_BOOLEAN);
		}

		if (in_array($this->attributes['key'], $this->intValues))
		{
			return filter_var($this->attributes['value'], FILTER_VALIDATE_INT);
		}

		if (in_array($this->attributes['key'], $this->dateValues) && $this->attributes['value'] !== null)
		{
			return Time::parse($this->attributes['value']);
		}

		return $this->attributes['value'];
	}
}
