<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Appointments_Module extends CI_Migration {

	public function up()
	{
		// Table structure for table 'appointments'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => 8,
				'unsigned' => true,
				'auto_increment' => true
			),
			'user_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => 8,
				'unsigned' => true,
			),
			'doctor_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => 8,
				'unsigned' => true,
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'message' => array(
				'type' => 'TEXT',
			),
			'approved' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => true,
				'default' => 0,
			),
			'viewed' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => true,
				'default' => 0,
			),
			'created_on' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
			),
		));
		
		// I went with TIMESTAMP over UNSIGNED INT for date comparisons and range queries
		$this->dbforge->add_field("start_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
		$this->dbforge->add_field("end_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
		
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('appointments', true);
	}
	
	public function down()
	{
		$this->dbforge->drop_table('appointments');
	}
}
