<?php namespace App\Database\Seeds;

class InstallSeeder extends \CodeIgniter\Database\Seeder
{
	public function run()
	{
		// default settings
		$builder = $this->db->table('settings');
		$builder->insertBatch([
			[
				'key'   => 'competition_name',
				'value' => 'IUCTF',
			],
			[
				'key'   => 'competition_logo',
				'value' => NULL,
			],
			[
				'key'   => 'theme',
				'value' => 'default',
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
			[
				'key'   => 'home_page',
				'value' => NULL,
			],
			[
				'key'   => 'need_hash',
				'value' => NULL,
			],
			[
				'key'   => 'team_member_limit',
				'value' => 4,
			],
			[
				'key'   => 'hash_secret_key',
				'value' => '',
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