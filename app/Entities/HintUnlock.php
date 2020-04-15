<?php namespace App\Entities;

use CodeIgniter\Entity;

class HintUnlock extends Entity {

	protected $casts = [
		'id'           => 'int',
		'hint_id'      => 'int',
		'user_id'      => 'int',
		'team_id'      => 'int',
		'challenge_id' => 'int',
	];

}
