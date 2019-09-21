<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Locations_Module extends CI_Migration {

	public function up()
	{
		// Table structure for table 'location_zones'
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
			'description' => array(
				'type' => 'text',
				'null' => TRUE
			),
			'status' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'unsigned' => TRUE,
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('location_zones', TRUE);

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
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('locations', TRUE);

		// Dumping data in table 'location_types'
		if ($this->db->count_all('location_types') == 0) {
			$this->db->insert('location_types', array(
				'id' => '1',
				'name' => 'Country',
				'code' => 'CNT',
				'created_on' => time(),
			));
			$this->db->insert('location_types', array(
				'id' => '2',
				'parent_id' => '1',
				'name' => 'State',
				'code' => 'STT',
				'created_on' => time(),
			));
			$this->db->insert('location_types', array(
				'id' => '3',
				'parent_id' => '2',
				'name' => 'City',
				'code' => 'CTY',
				'created_on' => time(),
			));
		}
		// Dumping data in table 'locations'
		if ($this->db->count_all('locations') == 0) {
			$this->db->insert('locations', array(
				'id' => '1',
				'location_type_id' => '1',
				'name' => 'United States',
				'code' => 'US',
				'created_on' => time(),
			));
			$this->db->insert('locations', array(
				'id' => '2',
				'parent_id' => '1',
				'location_type_id' => '2',
				'name' => 'California',
				'code' => 'CLF',
				'created_on' => time(),
			));
			$this->db->insert('locations', array(
				'id' => '3',
				'parent_id' => '1',
				'location_type_id' => '2',
				'name' => 'Florida',
				'code' => 'FLD',
				'created_on' => time(),
			));
			$this->db->insert('locations', array(
				'id' => '4',
				'parent_id' => '1',
				'location_type_id' => '2',
				'name' => 'New York',
				'code' => 'NY',
				'created_on' => time(),
			));
			$this->db->insert('locations', array(
				'id' => '5',
				'parent_id' => '2',
				'location_type_id' => '3',
				'name' => 'Los Angeles',
				'code' => 'LA',
				'created_on' => time(),
			));
			$this->db->insert('locations', array(
				'id' => '6',
				'parent_id' => '2',
				'location_type_id' => '3',
				'name' => 'San Francisco',
				'code' => 'SA',
				'created_on' => time(),
			));
			$this->db->insert('locations', array(
				'id' => '7',
				'parent_id' => '3',
				'location_type_id' => '3',
				'name' => 'Miami',
				'code' => 'MIM',
				'created_on' => time(),
			));
			$this->db->insert('locations', array(
				'id' => '8',
				'parent_id' => '4',
				'location_type_id' => '3',
				'name' => 'Albany',
				'code' => 'ALB',
				'created_on' => time(),
			));
			$this->db->insert('locations', array(
				'id' => '9',
				'parent_id' => '4',
				'location_type_id' => '3',
				'name' => 'New York City',
				'code' => 'NYC',
				'created_on' => time(),
			));
		}
	}
	
	public function down()
	{
		$this->dbforge->drop_table('locations');
		$this->dbforge->drop_table('location_types');
		$this->dbforge->drop_table('location_zones');
	}
}
