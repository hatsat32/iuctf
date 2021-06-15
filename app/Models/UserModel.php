<?php namespace App\Models;

use Myth\Auth\Models\UserModel as MythUserModel;
use App\Entities\User;

class UserModel extends MythUserModel
{
	protected $table      = 'users';
	protected $primaryKey = 'id';
	protected $returnType = User::class;

	protected $allowedFields = [
		'team_id', 'username', 'email', 'name', 'password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash',
		'status', 'status_message', 'active', 'force_pass_reset', 'permissions', 'deleted_at',
	];

	protected $validationRules = [
		'username'      => 'required|alpha_numeric_punct|min_length[3]|max_length[30]|is_unique[users.username,id,{id}]',
		'email'         => 'required|valid_email|is_unique[users.email,id,{id}]',
		'name'          => 'required|min_length[3]|max_length[100]|string',
		'password_hash' => 'required',
	];

	protected $useTimestamps = true;
	protected $useSoftDeletes = true;
}
