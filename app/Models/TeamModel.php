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
		'leader_id' => 'required|numeric|is_unique[teams.leader_id,leader_id,{leader_id}]',
		'name'      => 'required|min_length[3]|alpha_numeric_space|is_unique[teams.name,name,{name}]',
		'auth_code' => 'required',
		'is_banned' => 'required',
	];

	protected $useSoftDeletes = true;
	protected $useTimestamps = true;
}
