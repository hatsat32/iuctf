<?php namespace App\Database\Seeds;

class InstallSeeder extends \CodeIgniter\Database\Seeder
{
	public function run()
	{
		$data = [
			[
				'key'	=> 'competition_name',
				'value'	=> NULL,
			],
			[
				'key'	=> 'competition_logo',
				'value'	=> NULL,
			],
			[
				'key'	=> 'theme',
				'value'	=> NULL,
			],
			[
				'key'	=> 'competition_timer',
				'value'	=> NULL,
			],
			[
				'key'	=> 'competition_start_time',
				'value'	=> NULL,
			],
			[
				'key'	=> 'competition_end_time',
				'value'	=> NULL,
			],
			[
				'key'	=> 'allow_register',
				'value'	=> NULL,
			],
		];

		$builder = $this->db->table('config');
		$builder->insertBatch($data);
	}
}