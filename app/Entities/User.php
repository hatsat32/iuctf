<?php namespace App\Entities;

use CodeIgniter\Entity;

class User extends Entity
{
	protected $attributes = [
		'team_id'   => null,
		'username'  => null,
		'email'     => null,
		'name'      => null,
	];

	protected $casts = [
		'id'      => 'int',
		'team_id' => 'int',
		'active'  => 'boolean',
	];

	public function team()
	{
		$teamModel = new \App\Models\TeamModel();

		return $teamModel->find($this->attributes['team_id']);
	}
}
