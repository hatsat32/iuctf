<?php namespace App\Models;

use CodeIgniter\Model;

class SubmitModel extends Model
{
	protected $table      = 'submits';
	protected $primaryKey = 'id';

	protected $allowedFields = [
		'challenge_id', 'user_id', 'team_id', 'ip', 'provided', 'type'
	];

	protected $validationRules = [
        'challenge_id'  => 'required|numeric',
        'user_id'		=> 'required|numeric',
        'team_id'		=> 'required|numeric',
        'ip'			=> 'required|valid_ip[ipv4,ipv6]',
        'provided'		=> 'required|string',
        'type'			=> 'required|in_list[0,1]',
	];
	
	protected $validationMessages = [];
	protected $skipValidation = false;
}
