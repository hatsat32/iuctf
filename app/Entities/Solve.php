<?php namespace App\Entities;

use CodeIgniter\Entity;

class Solve extends Entity {

	protected $casts = [
		'id'           => 'int',
		'team_id'      => 'int',
		'challenge_id' => 'int',
		'user_id'      => 'int',
	];

}
