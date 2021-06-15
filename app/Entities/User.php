<?php namespace App\Entities;

use Myth\Auth\Entities\User as MythUserEntity;

class User extends MythUserEntity
{
	protected $attributes = [
		'team_id'   => null,
		'username'  => null,
		'email'     => null,
		'name'      => null,
	];

	protected $casts = [
		'id'               => 'int',
		'team_id'          => 'int',
        'active'           => 'boolean',
        'force_pass_reset' => 'boolean',
    ];

	public function team()
	{
		$teamModel = new \App\Models\TeamModel();

		return $teamModel->find($this->attributes['team_id']);
	}
}
