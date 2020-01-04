<?php namespace App\Entities;

use CodeIgniter\Entity;

class Settings extends Entity
{
	protected $attributes = [
		'key'   => null,
		'value' => null
	];

	protected $dates = ['created_at', 'updated_at'];

	public function setKey(string $key)
	{
		$this->attributes['key'] = $key;

		return $this;
	}

	public function setValue(string $value)
	{
		$this->attributes['value'] = $value;

		return $this;
	}
}
