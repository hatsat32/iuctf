<?php namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Entity;


class SubmissionModel extends Model
{
	protected $table      = 'submissions';
	protected $primaryKey = 'id';
	protected $returnType = Entity::class;

	protected $allowedFields = [
		'challenge_id', 'user_id', 'team_id', 'ip', 'provided', 'type'
	];

	protected $validationRules = [
		'challenge_id' => 'required|numeric',
		'user_id'      => 'required|numeric',
		'team_id'      => 'required|numeric',
		'ip'           => 'required|valid_ip[ipv4,ipv6]',
		'provided'     => 'required|string',
		'type'         => 'required|in_list[0,1]',
	];

	protected $useTimestamps = true;
	protected $updatedField  = null; // no need for update_at when logs submissions
}
