<?php namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Team;

class TeamModel extends Model
{
	protected $table      = 'teams';
	protected $primaryKey = 'id';
	protected $returnType = Team::class;

	protected $allowedFields = [
		'leader_id', 'name', 'auth_code', 'is_banned'
	];

	protected $validationRules = [
		'leader_id' => 'required|numeric',
		'name'      => 'required|min_length[3]|alpha_numeric_space',
		'auth_code' => 'required',
		'is_banned' => 'required',
	];
	
	protected $useSoftDeletes = true;
	protected $useTimestamps = true;
}
