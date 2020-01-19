<?php namespace App\Models;


use CodeIgniter\Model;
use CodeIgniter\Entity;


class HintUnlockModel extends Model
{
	protected $table      = 'hint_unlocks';
	protected $primaryKey = 'id';
	protected $returnType = Entity::class;

	protected $allowedFields = [
		'hint_id', 'user_id', 'team_id', 'challenge_id'
	];

	protected $validationRules = [
		'hint_id'      => 'required|numeric',
		'user_id'      => 'required|numeric',
		'team_id'      => 'required|numeric',
		'challenge_id' => 'required|numeric',
	];
}
