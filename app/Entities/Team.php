<?php namespace App\Entities;

use CodeIgniter\Entity;

class Team extends Entity
{
	protected $id;
	protected $leader_id;
	protected $name;
	protected $auth_code;
	protected $is_banned;

	public function leader()
	{
		$userModel = new \App\Models\UserModel();
		// var_dump($userModel->first($this->leader_id));die;
		return $userModel->first($this->leader_id);
	}
}