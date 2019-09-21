<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_App extends CI_Migration {

	public function up()
	{
		/*
		|-----------------------------------------------------------------------
		| App Settings
		|-----------------------------------------------------------------------
		*/
		// Table structure for table 'settings'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
			),
			'site_logo' => array(
				'type' => 'VARCHAR',
				'constraint' => '220',
				'default' => 'static/images/logo.png'
			),
			'site_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'default' => 'MEDDS'
			),
			'site_description' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'default' => 'Online Medical Directory and Services',
				'null' => true
			),
			'pagination_limit' => array(
				'type' => 'TINYINT',
				'constraint' => '4',
				'default' => 24
			),
			'upload_limit' => array(
				'type' => 'TINYINT',
				'constraint' => '4',
				'default' => 5
			),
			'no_reply' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => true
			),
			'privacy_policy' => array(
				'type' => 'TEXT',
				'null' => true
			),
			'terms_of_service' => array(
				'type' => 'TEXT',
				'null' => true
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('settings', TRUE);
		// Dumping data for table 'settings'
		if ($this->db->count_all('settings') == 0) {
			$this->db->insert('settings', array(
				'id' => '1',
				'pagination_limit' => 24,
				'upload_limit' => 5,
				'site_logo' => 'assets/images/logo.png',
				'site_name' => 'MEDDS',
				'site_description' => 'Online Medical Directory and Services',
			));
		}

		// Table structure for table 'settings'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
			),
			'site_logo' => array(
				'type' => 'VARCHAR',
				'constraint' => '220',
				'default' => 'static/images/logo.png'
			),
			'site_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'default' => 'MEDDS'
			),
			'site_description' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'default' => 'Online Medical Directory and Services',
				'null' => true
			),
			'pagination_limit' => array(
				'type' => 'TINYINT',
				'constraint' => '4',
				'default' => 24
			),
			'upload_limit' => array(
				'type' => 'TINYINT',
				'constraint' => '4',
				'default' => 5
			),
			'no_reply' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => true
			),
			'privacy_policy' => array(
				'type' => 'TEXT',
				'null' => true
			),
			'terms_of_service' => array(
				'type' => 'TEXT',
				'null' => true
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('settings', TRUE);
		// Dumping data for table 'settings'
		if ($this->db->count_all('settings') == 0) {
			$this->db->insert('settings', array(
				'id' => '1',
				'pagination_limit' => 24,
				'upload_limit' => 5,
				'site_logo' => 'assets/images/logo.png',
				'site_name' => 'MEDDS',
				'site_description' => 'Online Medical Directory and Services',
			));
		}

		/*
		|-----------------------------------------------------------------------
		| CodeIgniter session schema
		|-----------------------------------------------------------------------
		*/
		// Table structure for table 'ci_sessions'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
			),
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => '45',
			),
			'timestamp' => array(
				'type' => 'int',
				'constraint' => '10',
				'unsigned' => TRUE,
				'default' => '0',
			),
			'data' => array(
				'type' => 'BLOB',
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('timestamp');
		$this->dbforge->create_table('ci_sessions', TRUE);

		/*
		|-----------------------------------------------------------------------
		| User schema
		|----------------------------------------------------------------------
		*/
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
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE');
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
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (perm_id) REFERENCES permissions(id) ON DELETE CASCADE');
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
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE');
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (perm_id) REFERENCES permissions(id) ON DELETE CASCADE');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('user_id');
		$this->dbforge->add_key('perm_id');
		$this->dbforge->create_table('groups_permissions', TRUE);

		/*
		|-----------------------------------------------------------------------
		| Locations schema
		|----------------------------------------------------------------------
		*/
		// Table structure for table 'location_types'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'parent_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unsigned' => TRUE,
				'unique' => TRUE, // Could cause FK fail. not tested yet
				'null' => TRUE,
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
			),
			'code' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
			),
			'created_on' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
		));
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (parent_id) REFERENCES location_types(id) ON DELETE CASCADE');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('location_types', TRUE);
		// Table structure for table 'locations'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'parent_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unsigned' => TRUE,
				'null' => TRUE,
			),
			'location_type_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unsigned' => TRUE,
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
			),
			'code' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
			),
			'created_on' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
		));
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (parent_id) REFERENCES locations(id) ON DELETE CASCADE');
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (location_type_id) REFERENCES location_types(id) ON DELETE CASCADE');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('locations', TRUE);
		
		/*
		|-----------------------------------------------------------------------
		| Doctor schema
		|----------------------------------------------------------------------
		*/
		// Table structure for table 'doctor_specialities'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
			),
			'code' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
			),
			'description' => array(
				'type' => 'VARCHAR',
				'constraint' => '220',
				'null' => TRUE
			),
			'created_on' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('doctor_specialities', TRUE);
		// Table structure for table 'doctors_profiles'
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
				'unsigned' => TRUE,
				'unique' => TRUE
			),
			'location_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unsigned' => TRUE,
				'null' => TRUE,
			),
			'speciality_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unsigned' => TRUE,
				'null' => TRUE,
			),
			'reg_no' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
				'unique' => TRUE,
			),
			'description' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			),
			'first_qualification' => array(
				'type' => 'VARCHAR',
				'constraint' => '220',
			),
			'other_qualification' => array(
				'type' => 'TEXT',
			),
			'is_mobile' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'unsigned' => TRUE,
				'default' => 0,
			)
		));
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (location_id) REFERENCES locations(id) ON DELETE SET NULL');
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (speciality_id) REFERENCES doctor_specialities(id) ON DELETE SET NULL');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('reg_no', TRUE);
		$this->dbforge->create_table('doctors_profiles', TRUE);

		/*
		|-----------------------------------------------------------------------
		| Appointments schema
		|----------------------------------------------------------------------
		*/
		// Table structure for table 'appointments'
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
				'unsigned' => TRUE,
			),
			'doctor_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
			),
			'date' => array(
				'type' => 'TIMESTAMP',
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'message' => array(
				'type' => 'TEXT',
			),
			'approved' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'unsigned' => TRUE,
				'default' => 0,
			),
			'viewed' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'unsigned' => TRUE,
				'default' => 0,
			),
			'created_on' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
		));
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (doctor_id) REFERENCES users(id) ON DELETE CASCADE');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('appointments', TRUE);

		/*
		|-----------------------------------------------------------------------
		| Questions schema
		|----------------------------------------------------------------------
		*/
		// Table structure for table 'questions'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'null' => TRUE
			),
			'speciality_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unsigned' => TRUE,
				'null' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => '220',
			),
			'slug' => array(
				'type' => 'VARCHAR',
				'constraint' => '220',
			),
			'question' => array(
				'type' => 'TEXT',
			),
			'viewed' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'unsigned' => TRUE,
				'default' => 0,
			),
			'created_on' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
			'edited_on' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
		));
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL');
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (speciality_id) REFERENCES doctor_specialities(id) ON DELETE SET NULL');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('questions', TRUE);
		// Table structure for table 'questions_answers'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'parent_id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
			'user_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'null' => TRUE
			),
			'question_id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
			'answer' => array(
				'type' => 'TEXT',
			),
			'created_on' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
			'edited_on' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
		));
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (parent_id) REFERENCES questions_answers(id) ON DELETE CASCADE');
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL');
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('questions_answers', TRUE);
		// Table structure for table 'question_answers_votes'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'null' => TRUE
			),
			'answer_id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
			'liked' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'unsigned' => TRUE,
				'default' => 0,
			),
		));
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL');
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (answer_id) REFERENCES questions_answers(id) ON DELETE CASCADE');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('question_answers_votes', TRUE);
		
		/*
		|-----------------------------------------------------------------------
		| Company schema
		|----------------------------------------------------------------------
		*/
		// Table structure for table 'companies'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'location_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unsigned' => TRUE,
				'null' => TRUE,
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'slug' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'logo' => array(
				'type' => 'VARCHAR',
				'constraint' => '220',
				'null' => TRUE,
			),
			'preview' => array(
				'type' => 'VARCHAR',
				'constraint' => '220',
				'null' => TRUE,
			),
			'slogan' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE,
			),
			'description' => array(
				'type' => 'TEXT',
				'null' => TRUE
			),
			'phone' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE,
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE,
			),
			'address' => array(
				'type' => 'VARCHAR',
				'constraint' => '220',
				'null' => TRUE
			),
			'latitude' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
				'null' => TRUE
			),
			'longitude' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
				'null' => TRUE
			),
			'open_hrs' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE,
			),
			'for_profit' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '1',
			),
			'government' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0',
			),
			'active' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '1',
			),
			'created_on' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('companies', TRUE);
		
		// Table structure for table 'companies_users'
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
				'unsigned' => TRUE,
			),
			'company_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
			),
		));
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('companies_users', TRUE);
		
		// Table structure for table 'company_types'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'parent_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unsigned' => TRUE,
				'null' => TRUE,
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
			),
			'code' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
			),
			'description' => array(
				'type' => 'VARCHAR',
				'constraint' => '220',
				'null' => TRUE,
			),
			'created_on' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
		));
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (parent_id) REFERENCES company_types(id) ON DELETE CASCADE');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('location_type_id', TRUE);
		$this->dbforge->create_table('company_types', TRUE);
		
		// Table structure for table 'company_facilities'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'company_type_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unsigned' => TRUE,
				'null' => TRUE,
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
			),
			'code' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
			),
			'description' => array(
				'type' => 'VARCHAR',
				'constraint' => '220',
				'null' => TRUE,
			),
		));
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (company_type_id) REFERENCES company_types(id) ON DELETE CASCADE');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('company_facilities', TRUE);
		
		// Table structure for table 'company_types'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'parent_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unsigned' => TRUE,
				'null' => TRUE,
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
			),
			'code' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
			),
			'description' => array(
				'type' => 'VARCHAR',
				'constraint' => '220',
				'null' => TRUE,
			),
			'created_on' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
		));
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (parent_id) REFERENCES company_types(id) ON DELETE CASCADE');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('location_type_id', TRUE);
		$this->dbforge->create_table('company_types', TRUE);
		
		// Table structure for table 'companies_types'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'company_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'null' => TRUE,
			),
			'company_type_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unsigned' => TRUE,
				'null' => TRUE,
			),
		));
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE');
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (company_type_id) REFERENCES company_types(id) ON DELETE CASCADE');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('location_type_id', TRUE);
		$this->dbforge->create_table('companies_types', TRUE);
		
		// Table structure for table 'companies_facilities'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'company_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'null' => TRUE,
			),
			'company_facility_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unsigned' => TRUE,
				'null' => TRUE,
			),
		));
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE');
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (company_facility_id) REFERENCES company_facilities(id) ON DELETE CASCADE');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('location_type_id', TRUE);
		$this->dbforge->create_table('companies_facilities', TRUE);
		
		// Table structure for table 'companies_files'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'company_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'null' => TRUE,
			),
			'url' => array(
				'type' => 'VARCHAR',
				'constraint' => '220',
			),
			'type' => array(
				'type' => 'VARCHAR',
				'constraint' => '10',
			),
			'caption' => array(
				'type' => 'VARCHAR',
				'constraint' => '220',
			),
		));
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('location_type_id', TRUE);
		$this->dbforge->create_table('companies_files', TRUE);
	}

	public function down()
	{
		$tables = $this->db->list_tables();

		foreach($tables as $table) {
			if ($table == 'migration') continue;
			$this->dbforge->drop_table($table, TRUE);
		}
	}
}