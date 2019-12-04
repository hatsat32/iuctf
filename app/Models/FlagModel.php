<?php namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Flag;

class FlagModel extends Model
{
	protected $table      = 'flags';
	protected $primaryKey = 'id';
	protected $returnType = Flag::class;

	protected $allowedFields = [
		'challenge_id', 'type', 'content'
	];

	protected $validationRules = [
		'challenge_id' => 'numeric',
		'type'         => 'required|in_list[static,regex]',
		'content'      => 'required|min_length[3]',
	];
	
	protected $useTimestamps = true;
}
