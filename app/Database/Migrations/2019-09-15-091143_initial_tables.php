<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InitialTables extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'key'        => ['type' => 'varchar', 'constraint' => '50', 'unique' => true],
			'value'      => ['type' => 'varchar', 'constraint' => '100', 'null' => true],
			'created_at' => ['type' => 'datetime', 'null' => true],
			'updated_at' => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('config');

		//--------------------------------------------------------------------

		$this->forge->addField([
			'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'leader_id'  => ['type' => 'INT', 'unsigned' => true, 'unique' => true],
			'name'       => ['type' => 'varchar', 'constraint' => '100', 'unique' => true],
			'auth_code'  => ['type' => 'varchar', 'constraint' => '100', 'unique' => true],
			'is_banned'  => ['type' => 'ENUM', 'constraint' => ['0', '1'], 'default' => '0'],
			'created_at' => ['type' => 'datetime', 'null' => true],
			'updated_at' => ['type' => 'datetime', 'null' => true],
			'deleted_at' => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('teams');

		//--------------------------------------------------------------------

		// $this->forge->addForeignKey('team_id', 'teams', 'id');
		$this->forge->addColumn('users', [
			'team_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true, 'after' => 'id'],
			'name'    => ['type' => 'varchar', 'constraint' => '100', 'after' => 'username'],
		]);

		//--------------------------------------------------------------------

		$this->forge->addField([
			'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'name'        => ['type' => 'varchar', 'constraint' => '100', 'unique' => true],
			'description' => ['type' => 'varchar', 'constraint' => '250', 'null' => true],
			'created_at'  => ['type' => 'datetime', 'null' => true],
			'updated_at'  => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('categories');

		//--------------------------------------------------------------------

		$this->forge->addField([
			'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'category_id'  => ['type' => 'INT', 'unsigned' => true],
			'name'         => ['type' => 'varchar', 'constraint' => '100', 'unique' => true],
			'point'        => ['type' => 'INT', 'unsigned' => true],
			'description'  => ['type' => 'text'],
			'max_attempts' => ['type' => 'INT'],
			'type'         => ['type' => 'ENUM', 'constraint' => ['static', 'dynamic'], 'default' => 'static'],
			'is_active'    => ['type' => 'ENUM', 'constraint' => ['0', '1'], 'default' => '0'],
			'created_at'   => ['type' => 'datetime', 'null' => true],
			'updated_at'   => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('category_id', 'categories', 'id');
		$this->forge->createTable('challenges');

		//--------------------------------------------------------------------

		$this->forge->addField([
			'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'team_id'      => ['type' => 'INT', 'unsigned' => true],
			'challenge_id' => ['type' => 'INT', 'unsigned' => true],
			'user_id'      => ['type' => 'INT', 'unsigned' => true],
			'created_at'   => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->addUniqueKey(['team_id', 'challenge_id']);
		$this->forge->addForeignKey('challenge_id', 'challenges', 'id');
		$this->forge->addForeignKey('user_id', 'users', 'id');
		$this->forge->addForeignKey('team_id', 'teams', 'id');
		$this->forge->createTable('solves');

		//--------------------------------------------------------------------

		$this->forge->addField([
			'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'challenge_id' => ['type' => 'INT', 'unsigned' => true],
			'user_id'      => ['type' => 'INT', 'unsigned' => true],
			'team_id'      => ['type' => 'INT', 'unsigned' => true],
			'ip'           => ['type' => 'varchar', 'constraint' => '45'],
			'provided'     => ['type' => 'varchar', 'constraint' => '100'],
			'type'         => ['type' => 'ENUM', 'constraint' => ['0', '1']],
			'created_at'   => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('challenge_id', 'challenges', 'id');
		$this->forge->addForeignKey('user_id', 'users', 'id');
		$this->forge->addForeignKey('team_id', 'teams', 'id');
		$this->forge->createTable('submits');

		//--------------------------------------------------------------------

		$this->forge->addField([
			'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'challenge_id' => ['type' => 'INT', 'unsigned' => true],
			'type'         => ['type' => 'ENUM', 'constraint' => ['static', 'regex'], 'default' => 'static'],
			'content'      => ['type' => 'varchar', 'constraint' => '100'],
			'created_at'   => ['type' => 'datetime', 'null' => true],
			'updated_at'   => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('challenge_id', 'challenges', 'id');
		$this->forge->createTable('flags');

		//--------------------------------------------------------------------

		$this->forge->addField([
			'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'title'      => ['type' => 'varchar', 'constraint' => '100'],
			'content'    => ['type' => 'text'],
			'created_at' => ['type' => 'datetime', 'null' => true],
			'updated_at' => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('notifications');

		//--------------------------------------------------------------------

		$this->forge->addField([
			'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'challenge_id' => ['type' => 'INT', 'unsigned' => true],
			'content'      => ['type' => 'text'],
			'cost'         => ['type' => 'INT'],
			'is_active'    => ['type' => 'ENUM', 'constraint' => ['0', '1'], 'default' => '0'],
			'created_at'   => ['type' => 'datetime', 'null' => true],
			'updated_at'   => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('challenge_id', 'challenges', 'id');
		$this->forge->createTable('hints');

		//--------------------------------------------------------------------

		$this->forge->addField([
			'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'hint_id'      => ['type' => 'INT', 'unsigned' => true],
			'user_id'      => ['type' => 'INT', 'unsigned' => true],
			'team_id'      => ['type' => 'INT', 'unsigned' => true],
			'challenge_id' => ['type' => 'INT', 'unsigned' => true],
			'created_at'   => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->addUniqueKey(['hint_id', 'team_id']);
		$this->forge->addForeignKey('hint_id', 'hints', 'id');
		$this->forge->addForeignKey('user_id', 'users', 'id');
		$this->forge->addForeignKey('team_id', 'teams', 'id');
		$this->forge->createTable('hint_unlocks');

		//--------------------------------------------------------------------

		$this->forge->addField([
			'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'challenge_id' => ['type' => 'INT', 'unsigned' => true],
			'location'     => ['type' => 'varchar', 'constraint' => '500'],
			'created_at'   => ['type' => 'datetime', 'null' => true],
			'updated_at'   => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('challenge_id', 'challenges', 'id');
		$this->forge->createTable('files');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->db->disableForeignKeyConstraints();

		$this->forge->dropTable('config', true);
		$this->forge->dropTable('teams', true);

		$this->forge->dropColumn('users', 'team_id');
		$this->forge->dropColumn('users', 'name');

		$this->forge->dropTable('categories', true);
		$this->forge->dropTable('challenges', true);
		$this->forge->dropTable('solves', true);
		$this->forge->dropTable('submits', true);
		$this->forge->dropTable('flags', true);
		$this->forge->dropTable('notifications', true);
		$this->forge->dropTable('hints', true);
		$this->forge->dropTable('hint_unlocks', true);
		$this->forge->dropTable('files', true);
		$this->forge->dropTable('tracking', true);
		$this->forge->dropTable('dynamic_challenges', true);

		$this->db->enableForeignKeyConstraints();
	}
}
