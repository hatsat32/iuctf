<?php namespace App\Entities;

use CodeIgniter\Entity;

class Team extends Entity
{
	protected $attributes = [
		'id'        => null,
		'leader_id' => null,
		'name'      => null,
		'auth_code' => null,
		'is_banned' => null,
	];

	protected $casts = [
		'id'        => 'int',
		'leader_id' => 'int',
		'is_banned' => 'boolean',
	];

	public function leader()
	{
		$userModel = new \App\Models\UserModel();

		return $userModel->find($this->attributes['leader_id']);
	}
}
