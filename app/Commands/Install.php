<?php namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Config\Services;
use \App\Models\UserModel;

class Install extends BaseCommand
{
	protected $group       = 'Iuctf';
	protected $name        = 'iuctf:install';
	protected $description = 'Install the platform from command line.';
	protected $usage     = "iuctf:install username email";
	protected $arguments = [
		'username' => 'Username of the admin',
		'email'    => 'Email of the admin',
	];


	public function run(array $params)
	{
		//FIXME validate admin creds
		//FIXME run migrations
		//FIXME run seeds
		//FIXME save admin user
		//FIXME add admin to admin group
	}
}