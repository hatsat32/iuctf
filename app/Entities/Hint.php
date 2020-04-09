<?php namespace App\Entities;

use CodeIgniter\Entity;

class Hint extends Entity
{
	protected $attributes = [
		'challenge_id' => null,
		'content'      => null,
		'cost'         => null,
		'is_active'    => null,
	];

	protected $casts = [
		'id'           => 'int',
		'challenge_id' => 'int',
		'cost'         => 'int',
		// 'is_active'    => 'boolean',
	];
}
