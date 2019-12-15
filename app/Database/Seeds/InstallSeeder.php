<?php namespace App\Database\Seeds;

class InstallSeeder extends \CodeIgniter\Database\Seeder
{
	public function run()
	{
		// default settings
		$builder = $this->db->table('config');
		$builder->insertBatch([
			[
				'key'   => 'competition_name',
				'value' => NULL,
			],
			[
				'key'   => 'competition_logo',
				'value' => NULL,
			],
			[
				'key'   => 'theme',
				'value' => NULL,
			],
			[
				'key'   => 'competition_timer',
				'value' => NULL,
			],
			[
				'key'   => 'competition_start_time',
				'value' => NULL,
			],
			[
				'key'   => 'competition_end_time',
				'value' => NULL,
			],
			[
				'key'   => 'allow_register',
				'value' => NULL,
			],
		]);

		// create admin group
		$builder = $this->db->table('auth_groups');
		$builder->insert([
			'name'        => 'admin',
			'description' => 'Admin Group',
		]);
	}
}