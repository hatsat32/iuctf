<?php namespace App\Entities;

use CodeIgniter\Entity;

class Challenge extends Entity
{
	protected $attributes = [
		'challenge_id' => null,
		'type'         => null,
		'content'      => null,
	];
}
