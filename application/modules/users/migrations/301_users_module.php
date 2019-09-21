<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Users_Module extends CI_Migration {

	public function up()
	{
		// Table structure for table 'login_attempts'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => '16'
			),
			'login' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE
			),
			'time' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'null' => TRUE
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('login_attempts', TRUE);

		// Table structure for table 'users'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => '16'
			),
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'unique' => TRUE,
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => '80',
			),
			'salt' => array(
				'type' => 'VARCHAR',
				'constraint' => '40'
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => '100'
			),
			'activation_code' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
				'null' => TRUE
			),
			'forgotten_password_code' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
				'null' => TRUE
			),
			'forgotten_password_time' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'null' => TRUE
			),
			'remember_code' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
				'null' => TRUE
			),
			'created_on' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
			'last_login' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'null' => TRUE
			),
			'active' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'unsigned' => TRUE,
			),
			'avatar' => array(
				'type' => 'VARCHAR',
				'constraint' => '220',
				'null' => TRUE
			),
			'thumbnail' => array(
				'type' => 'VARCHAR',
				'constraint' => '220',
				'null' => TRUE
			),
			'first_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
			),
			'last_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
			),
			'address' => array(
				'type' => 'VARCHAR',
				'constraint' => '220',
				'null' => TRUE
			),
			'phone' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('users', TRUE);
		// Dumping data for table 'users'
		if ($this->db->count_all('users') == 0) {
			$this->db->insert('users', array(
				'id' => '1',
				'ip_address' => '127.0.0.1',
				'username' => 'admin',
				'password' => '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36',
				'salt' => '',
				'email' => 'admin@admin.com',
				'activation_code' => '',
				'forgotten_password_code' => NULL,
				'created_on' => '1268889823',
				'last_login' => '1268889823',
				'active' => '1',
			));
		}

		// Table structure for table 'groups'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
			),
			'description' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('groups', TRUE);
		// Dumping data for table 'groups'
		if ($this->db->count_all('groups') == 0) {
			$this->db->insert_batch('groups', array(
				array(
					'id' => '1',
					'name' => 'admin',
					'description' => 'Administrator'
				),
				array(
					'id' => '2',
					'name' => 'doctors',
					'description' => 'Medical Practitioner'
				),
				array(
					'id' => '3',
					'name' => 'manager',
					'description' => 'Hospital Administrator'
				),
				array(
					'id' => '4',
					'name' => 'users',
					'description' => 'General User'
				)
			));
		}

		// Table structure for table 'permissions'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'perm_key' => array(
				'type' => 'VARCHAR',
				'constraint' => '30',
			),
			'perm_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('perm_key');
		$this->dbforge->create_table('permissions', TRUE);
		// Dumping data for table 'permissions'
		if ($this->db->count_all('permissions') == 0) {
			$this->db->insert_batch('permissions', array(
				array(
					'perm_key' => 'OP',
					'perm_name' => 'All permissions'
				),
				array(
					'perm_key' => 'UD1',
					'perm_name' => 'Read doctors'
				),
				array(
					'perm_key' => 'UD2',
					'perm_name' => 'Create doctors'
				),
				array(
					'perm_key' => 'UD4',
					'perm_name' => 'Update doctors'
				),
				array(
					'perm_key' => 'UD8',
					'perm_name' => 'Delete doctors'
				),
			));
		}

		// Table structure for table 'users_groups'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE
			),
			'group_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('users_groups', TRUE);
		// Dumping data for table 'users_groups'
		if ($this->db->count_all('users_groups') == 0) {
			$this->db->insert('users_groups', array(
				'id' => '1',
				'user_id' => '1',
				'group_id' => '1',
			));
		}

		// Table structure for table 'users_permissions'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'user_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE
			),
			'perm_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE
			),
			'value' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'created_at' => array(
				'type' => 'INT',
				'constraint' => '11',
			),
			'updated_at' => array(
				'type' => 'INT',
				'constraint' => '11',
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('user_id');
		$this->dbforge->add_key('perm_id');
		$this->dbforge->create_table('users_permissions', TRUE);
		// Dumping data for table 'users_permissions'
		if ($this->db->count_all('users_permissions') == 0) {
			$this->db->insert('users_permissions', array(
				'id' => '1',
				'user_id' => '1',
				'perm_id' => '1',
			));
		}

		// Table structure for table 'groups_permissions'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'group_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE
			),
			'perm_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE
			),
			'value' => array(
				'type' => 'TINYINT',
				'constraint' => '4',
				'default' => '0'
			),
			'created_at' => array(
				'type' => 'INT',
				'constraint' => '11',
			),
			'updated_at' => array(
				'type' => 'INT',
				'constraint' => '11',
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('user_id');
		$this->dbforge->add_key('perm_id');
        $this->dbforge->create_table('groups_permissions', TRUE);
	}
	
	public function down()
	{
		$this->dbforge->drop_table('login_attempts');
		$this->dbforge->drop_table('groups_permissions');
		$this->dbforge->drop_table('users_permissions');
		$this->dbforge->drop_table('users_groups');
		$this->dbforge->drop_table('permissions');
		$this->dbforge->drop_table('groups');
		$this->dbforge->drop_table('users');
	}
}
