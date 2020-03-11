<?php namespace App\Models;

use CodeIgniter\Model;
use App\Entities\User;

class UserModel extends Model
{
	protected $table      = 'users';
	protected $primaryKey = 'id';
	protected $returnType = User::class;

	protected $allowedFields = [
		'team_id', 'username', 'email', 'name', 'password_hash', 'status', 'status_message', 'active'
	];

	protected $validationRules = [
		'username'      => 'required|min_length[3]|max_length[30]|alpha_numeric|is_unique[users.username,username,{username}]',
		'email'         => 'required|max_length[255]|valid_email|is_unique[users.email,email,{email}]',
		'name'          => 'required|min_length[3]|max_length[100]|string',
		'password_hash' => 'required',
	];

	protected $useTimestamps = true;
	protected $useSoftDeletes = true;
}
