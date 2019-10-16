<?php namespace App\Models;

use CodeIgniter\Model;

class HintModel extends Model
{
	protected $table      = 'hints';
	protected $primaryKey = 'id';

	protected $allowedFields = [
		'challenge_id', 'content', 'cost', 'is_active'
	];

	protected $validationRules = [
        'challenge_id'	=> 'required|numeric',
        'content'		=> 'required',
        'cost'			=> 'required|numeric',
        'is_active'		=> 'required|numeric|in_list[0,1]',
	];
	
	protected $validationMessages = [];
	protected $skipValidation = false;
}
