<?php namespace Tests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Config\Database;

class TestSeeder extends Seeder
{
	public function run()
	{
		$seeder = Database::seeder();
		$seeder->setSilent(true);
		$seeder->call('InstallSeeder');
		$seeder->call('DevSeeder');
	}
}
