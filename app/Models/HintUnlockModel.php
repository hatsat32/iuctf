<?php namespace App\Models;


use CodeIgniter\Model;
use App\Entities\HintUnlock;


class HintUnlockModel extends Model
{
	protected $table      = 'hint_unlocks';
	protected $primaryKey = 'id';
	protected $returnType = HintUnlock::class;

	protected $allowedFields = [
		'hint_id', 'user_id', 'team_id', 'challenge_id'
	];

	protected $validationRules = [
		'hint_id'      => 'required|numeric',
		'user_id'      => 'required|numeric',
		'team_id'      => 'required|numeric',
		'challenge_id' => 'required|numeric',
	];

	protected $useTimestamps = true;
	protected $updatedField  = null; // no need for update_at when logs solves
}
