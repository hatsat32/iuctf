<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InitialTables extends Migration
{
	public function up()
	{
		// config
		$this->forge->addField([
			'id' 	=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'key'	=> ['type' => 'varchar', 'constraint' => '50'],
			'value' => ['type' => 'varchar', 'constraint' => '100'],
			'created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at TIMESTAMP NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('config');

		// teams
		$this->forge->addField([
			'id' 		=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'leader_id' => ['type' => 'INT', 'unsigned' => true],
			'name' 		=> ['type' => 'varchar', 'constraint' => '100'],
			'auth_code' => ['type' => 'varchar', 'constraint' => '100'],
			'is_banned' => ['type' => 'ENUM', 'constraint' => ['0', '1'], 'default' => '0'],
			'created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at TIMESTAMP NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('teams');

		// users
        $this->forge->addField([
			'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'team_id' 		   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'username'         => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
			'email'            => ['type' => 'varchar', 'constraint' => 255],
			'name'			   => ['type' => 'varchar', 'constraint' => '100'],
            'password_hash'    => ['type' => 'varchar', 'constraint' => 255],
            'reset_hash'       => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'reset_time'       => ['type' => 'datetime', 'null' => true],
            'activate_hash'    => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'status'           => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'status_message'   => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'active'           => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'force_pass_reset' => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'permissions'      => ['type' => 'text', 'null' => true],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('team_id','teams','id');
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('users', true);

        // Auth Login Attempts
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'email'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'user_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true], // Only for successful logins
            'date'       => ['type' => 'datetime'],
            'success'    => ['type' => 'tinyint', 'constraint' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('email');
        $this->forge->addKey('user_id');
        // NOTE: Do NOT delete the user_id or email when the user is deleted for security audits
        $this->forge->createTable('auth_logins', true);

        // Auth Tokens
        $this->forge->addField([
            'id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'selector'        => ['type' => 'varchar', 'constraint' => 255],
            'hashedValidator' => ['type' => 'varchar', 'constraint' => 255],
            'user_id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'expires'         => ['type' => 'datetime'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('selector');
        $this->forge->addForeignKey('user_id', 'users', 'id', false, 'CASCADE');
        $this->forge->createTable('auth_tokens', true);

        // Auth Password Reset Table
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'email'      => ['type' => 'varchar', 'constraint' => 255],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255],
            'user_agent' => ['type' => 'varchar', 'constraint' => 255],
            'token'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'datetime', 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_reset_attempts');

        // Auth Groups Table
        $fields = [
            'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'varchar', 'constraint' => 255],
            'description' => ['type' => 'varchar', 'constraint' => 255],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_groups', true);

        // Auth Permissions Table
        $fields = [
            'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'varchar', 'constraint' => 255],
            'description' => ['type' => 'varchar', 'constraint' => 255],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_permissions', true);


        // Auth Groups/Permissions Table
        $fields = [
            'group_id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'permission_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey(['group_id', 'permission_id']);
        $this->forge->addForeignKey('group_id', 'auth_groups', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('permission_id', 'auth_permissions', 'id', false, 'CASCADE');
        $this->forge->createTable('auth_groups_permissions', true);

        // Auth Users/Groups Table
        $fields = [
            'group_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'user_id'  => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey(['group_id', 'user_id']);
        $this->forge->addForeignKey('group_id', 'auth_groups', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', false, 'CASCADE');
        $this->forge->createTable('auth_groups_users', true);

        // Auth Users/Permissions Table
        $fields = [
            'user_id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'permission_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey(['user_id', 'permission_id']);
        $this->forge->addForeignKey('user_id', 'users', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('permission_id', 'auth_permissions', 'id', false, 'CASCADE');
		$this->forge->createTable('auth_users_permissions');
		
		$this->forge->addField([
			'id' 			=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'name' 			=> ['type' => 'varchar', 'constraint' => '100'],
			'description' 	=> ['type' => 'varchar', 'constraint' => '250'],
			'created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at TIMESTAMP NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('categories');


		$this->forge->addField([
			'id' 			=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'category_id' 	=> ['type' => 'INT', 'unsigned' => true],
			'name' 			=> ['type' => 'varchar', 'constraint' => '100', 'unique' => true],
			'point' 		=> ['type' => 'INT', 'unsigned' => true],
			'description' 	=> ['type' => 'varchar', 'constraint' => '250'],
			'max_attempts' 	=> ['type' => 'INT'],
			'type' 			=> ['type' => 'ENUM', 'constraint' => ['static', 'dynamic'], 'default' => 'static'],
			'is_active' 	=> ['type' => 'ENUM', 'constraint' => ['0', '1'], 'default' => '0'],
			'created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at TIMESTAMP NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('category_id','categories','id');
		$this->forge->createTable('challenges');


		$this->forge->addField([
			'id' 			=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'challenge_id' 	=> ['type' => 'INT', 'unsigned' => true],
			'user_id' 		=> ['type' => 'INT', 'unsigned' => true],
			'team_id' 		=> ['type' => 'INT', 'unsigned' => true],
			'created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('challenge_id','challenges','id');
		$this->forge->addForeignKey('user_id','users','id');
		$this->forge->addForeignKey('team_id','teams','id');
		$this->forge->createTable('solves');


		$this->forge->addField([
			'id' 			=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'challenge_id' 	=> ['type' => 'INT', 'unsigned' => true],
			'user_id' 		=> ['type' => 'INT', 'unsigned' => true],
			'team_id' 		=> ['type' => 'INT', 'unsigned' => true],
			'ip' 			=> ['type' => 'varchar', 'constraint' => '15'],
			'provided' 		=> ['type' => 'varchar', 'constraint' => '100'],
			'type' 			=> ['type' => 'ENUM','constraint' => ['0', '1'],'default' => '0'],
			'created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
		]);
		$this->forge->addForeignKey('challenge_id','challenges','id');
		$this->forge->addForeignKey('user_id','users','id');
		$this->forge->addForeignKey('team_id','teams','id');
		$this->forge->addKey('id', true);
		$this->forge->createTable('submits');


		$this->forge->addField([
			'id' 			=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'challenge_id' 	=> ['type' => 'INT', 'unsigned' => true],
			'type' 			=> ['type' => 'ENUM', 'constraint' => ['static', 'regex'], 'default' => 'static'],
			'content' 		=> ['type' => 'varchar', 'constraint' => '100'],
			'created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at TIMESTAMP NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP',
		]);
		$this->forge->addForeignKey('challenge_id','challenges','id');
		$this->forge->addKey('id', true);
		$this->forge->createTable('flags');


		$this->forge->addField([
			'id' 		=> ['type' => 'INT','unsigned' => true,'auto_increment' => true],
			'title' 	=> ['type' => 'varchar','constraint' => '100'],
			'content' 	=> ['type' => 'text'],
			'created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at TIMESTAMP NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('notifications');


		$this->forge->addField([
			'id' 			=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'challenge_id' 	=> ['type' => 'INT', 'unsigned' => true],
			'content' 		=> ['type' => 'text'],
			'cost'			=> ['type' => 'INT'],
			'is_active' 	=> ['type' => 'ENUM', 'constraint' => ['0', '1'], 'default' => '0'],
			'created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at TIMESTAMP NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP',
		]);
		$this->forge->addForeignKey('challenge_id','challenges','id');
		$this->forge->addKey('id', true);
		$this->forge->createTable('hints');


		$this->forge->addField([
			'id' 		=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'hint_id' 	=> ['type' => 'INT', 'unsigned' => true],
			'user_id' 	=> ['type' => 'INT', 'unsigned' => true],
			'team_id' 	=> ['type' => 'INT', 'unsigned' => true],
			'created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
		]);
		$this->forge->addForeignKey('hint_id','hints','id');
		$this->forge->addForeignKey('user_id','users','id');
		$this->forge->addForeignKey('team_id','teams','id');
		$this->forge->addKey('id', true);
		$this->forge->createTable('hint_unlocks');


		$this->forge->addField([
			'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'challenge_id' => ['type' => 'INT', 'unsigned' => true],
			'location' => ['type' => 'varchar', 'constraint' => '500'],
			'created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at TIMESTAMP NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('challenge_id','challenges','id');
		$this->forge->createTable('files');


		$this->forge->addField([
			'id' 		=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'type' 		=> ['type' => 'ENUM', 'constraint' => ['login']],
			'ip' 		=> ['type' => 'varchar', 'constraint' => '500'],
			'user_id' 	=> ['type' => 'INT', 'unsigned' => true],
			'created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('user_id','users','id');
		$this->forge->createTable('tracking');


		$this->forge->addField([
			'id' 			=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'challenge_id' 	=> ['type' => 'INT', 'unsigned' => true],
			'min_value' 	=> ['type' => 'INT', 'unsigned' => true],
			'max_value' 	=> ['type' => 'INT', 'unsigned' => true],
			'decay_limit' 	=> ['type' => 'INT', 'unsigned' => true],
			'created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at TIMESTAMP NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('challenge_id','challenges','id');
		$this->forge->createTable('dynamic_challenges');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->db->disableForeignKeyConstraints();

		$this->forge->dropTable('config', true);
		$this->forge->dropTable('teams', true);

		$this->forge->dropTable('users', true);
		$this->forge->dropTable('auth_logins', true);
		$this->forge->dropTable('auth_tokens', true);
		$this->forge->dropTable('auth_reset_attempts', true);
		$this->forge->dropTable('auth_groups', true);
		$this->forge->dropTable('auth_permissions', true);
		$this->forge->dropTable('auth_groups_permissions', true);
		$this->forge->dropTable('auth_groups_users', true);
		$this->forge->dropTable('auth_users_permissions', true);

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
