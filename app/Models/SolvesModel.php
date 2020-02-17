<?php namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Entity;


class SolvesModel extends Model
{
	protected $table      = 'solves';
	protected $primaryKey = 'id';
	protected $returnType = Entity::class;

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

	/**
	 * return true if team solved the challenge, else false
	 * 
	 * @param mixed $teamID
	 * @param mixed $challengeID
	 * @return bool
	 */
	public function isSolved($teamID, $challengeID)
	{
		$solve = $this->where('team_id', $teamID)->where('challenge_id', $challengeID)->find();

		return ! empty($solve);
	}
}
