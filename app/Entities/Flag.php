<?php namespace App\Entities;

use CodeIgniter\Entity;

class Flag extends Entity
{
	protected $attributes = [
		'challenge_id' => null,
		'type'         => null,
		'content'      => null,
	];
}
