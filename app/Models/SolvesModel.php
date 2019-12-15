<?php namespace App\Models;

use CodeIgniter\Model;

class SolvesModel extends Model
{
	protected $table      = 'solves';
	protected $primaryKey = 'id';
	// protected $returnType = \stdClass::class;

	protected $allowedFields = [
		'challenge_id', 'user_id', 'team_id'
	];

	protected $validationRules = [
		'challenge_id' => 'required|numeric',
		'user_id'      => 'required|numeric',
		'team_id'      => 'required|numeric',
	];

	protected $useTimestamps = true;
	protected $updatedField  = null; // no need for update_at when logs solves
}
