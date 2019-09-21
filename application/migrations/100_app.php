<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_App extends CI_Migration {

	public function up()
	{
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
				'type' => 'text',
				'default' => '',
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('timestamp');
		$this->dbforge->create_table('ci_sessions', TRUE);

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
			'site_language' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
				'default' => 'english',
			),
			'pagination_limit' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
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
				'site_language' => 'english',
			));
		}
	}

	public function down()
	{
		$this->dbforge->drop_table('settings', TRUE);
	}
}