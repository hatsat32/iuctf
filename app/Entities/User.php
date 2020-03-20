<?php namespace App\Entities;

use CodeIgniter\Entity;

class User extends Entity
{
	protected $attributes = [
		'id'        => null,
		'team_id'   => null,
		'username'  => null,
		'email'     => null,
		'name'      => null,
	];

	protected $casts = [
		'id'      => 'int',
		'team_id' => 'int',
	];

	public function team()
	{
		$teamModel = new \App\Models\TeamModel();

		return $teamModel->find($this->attributes['team_id']);
	}
}
