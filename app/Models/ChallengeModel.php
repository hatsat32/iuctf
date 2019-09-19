<?php namespace App\Models;

use CodeIgniter\Model;

class ChallengeModel extends Model
{
	protected $table      = 'challenges';
	protected $primaryKey = 'id';

	protected $allowedFields = [
		'category_id', 'name', 'point', 'description', 'max_attempts', 'type', 'is_active'
	];

	protected $validationRules = [
        'category_id'   => 'numeric',
        'name'          => 'required|min_length[2]',
        'point'         => 'required|numeric',
        'description'   => 'required|alpha_numeric_space',
        'max_attempts'  => 'numeric',
        'type'          => 'required|in_list[static,dynamic]',
        'is_active'     => 'required|in_list[0,1]',
	];
	
	protected $validationMessages = [];
	protected $skipValidation = false;
}