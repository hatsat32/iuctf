<?php namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Entity;

class HintModel extends Model
{
	protected $table      = 'hints';
	protected $primaryKey = 'id';
	protected $returnType = Entity::class;

	protected $allowedFields = [
		'challenge_id', 'content', 'cost', 'is_active'
	];

	protected $validationRules = [
		'challenge_id' => 'required|numeric',
		'content'      => 'required',
		'cost'         => 'required|numeric',
		'is_active'    => 'required|numeric|in_list[0,1]',
	];
}
