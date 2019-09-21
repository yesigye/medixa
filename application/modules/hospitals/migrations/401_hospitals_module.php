<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Hospitals_Module extends CI_Migration {

	public function up()
	{
		$this->load->helper('date');
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
		// Dumping data for table 'doctor_specialities'
		if ($this->db->count_all('doctor_specialities') == 0) {
			$this->db->insert_batch('doctor_specialities', array(
				[
					"id" => 1,
					'name' => 'Dermatologist',
					'code' => 'DMT',
					'description' => 'Dermatologists are physicians who treat adult and pediatric patients with disorders of the skin, hair, nails, and adjacent mucous membranes.',
					"created_on" => now()
				],
				[
					"id" => 2,
					'name' => 'Optician',
					'code' => 'OPT',
					'description' => 'Physicians specializing in ophthalmology develop comprehensive medical and surgical care of the eyes',
					"created_on" => now()
				],
				[
					"id" => 3,
					'name' => 'Pediatrician',
					'code' => 'PDT',
					'description' => 'Physicians specializing in pediatrics work to diagnose and treat patients from infancy through adolescence',
					"created_on" => now()
				],
				[
					"id" => 4,
					'name' => 'Psychiatrist',
					'code' => 'PSYC',
					'description' => 'Physicians specializing in psychiatry devote their careers to mental health and its associated mental and physical ramifications.',
					"created_on" => now()
				],
				[
					"id" => 5,
					'name' => 'Dentist',
					'code' => 'DST',
					'description' => 'Physicians specializing in treatment of diseases affecting the teeth, mouth and gums.',
					"created_on" => now()
				],
			));
		}
		
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
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('reg_no', TRUE);
		$this->dbforge->create_table('doctors_profiles', TRUE);

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
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('location_type_id', TRUE);
		$this->dbforge->create_table('company_types', TRUE);
		// Dumping data for table 'company_types'
		if ($this->db->count_all('company_types') == 0) {
			$this->db->insert('company_types', array(
				"id" => 1,
				"name" => "General Hospital",
				"code" => "GHSP",
				"description" => "A non-specialized hospital, treating patients suffering from all types of medical condition",
				"created_on" => now()
			));
			$this->db->insert('company_types', array(
				"id" => 2,
				"name" => "Specialty Hospital",
				"code" => "SHSP",
				"description" => "A hospital that is primarily or exclusively engaged in the care and treatment of patients with a cardiac condition, orthopedic condition, a condition requiring a surgical procedure and “any other specialized category of services",
				"created_on" => now()
			));
			$this->db->insert('company_types', array(
				"id" => 3,
				"name" => "College/ University Hospital",
				"code" => "CHSP",
				"description" => "A university hospital is an institution which combines the services of a hospital with the education of medical students and with medical research",
				"created_on" => now()
			));
			$this->db->insert('company_types', array(
				"id" => 4,
				"name" => "Government Hospital",
				"code" => "CHSP",
				"description" => "A public hospital or government hospital is a hospital which is owned by a government and receives government funding",
				"created_on" => now()
			));
		}
		
		// Table structure for table 'company_facilities'
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
				'constraint' => '50',
			),
			'description' => array(
				'type' => 'VARCHAR',
				'constraint' => '220',
				'null' => TRUE,
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('company_facilities', TRUE);
		// Dumping data for table 'company_types'
		if ($this->db->count_all('company_facilities') == 0) {
			$this->db->insert_batch('company_facilities', array(
				[
					'id' => 1,
					'name' => 'Dental facility',
					'code' => 'DNTL',
					'description' => 'An experienced Dental surgeon provides procedures like Dental Extractions, RCT, Scaling /Cleaning, Fillings, Local curettage.',
				],
				[
					'id' => 2,
					'name' => 'Ambulance Services',
					'code' => 'AMBL',
					'description' => 'Hospital has a patient transport vehicle available',
				],
				[
					'id' => 3,
					'name' => 'Pharmacy',
					'code' => 'PHM',
					'description' => 'Quality medicines are available to patients on doctor prescription',
				],
				[
					'id' => 4,
					'name' => 'Laboratory services',
					'code' => 'LAB',
					'description' => 'Trained laboratory staff are available for carrying out specialised tests',
				],
				[
					'id' => 5,
					'name' => 'Radiology/X-ray facility',
					'code' => 'XRAY',
					'description' => 'Facility for diagnosing and treating injuries and diseases using medical imaging (radiology) procedures',
				],
			));
		}
		
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
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('location_type_id', TRUE);
		$this->dbforge->create_table('companies_files', TRUE);
	}
	
	public function down()
	{
		$this->dbforge->drop_table('companies');
		$this->dbforge->drop_table('companies_users');
		$this->dbforge->drop_table('companies_types');
		$this->dbforge->drop_table('companies_facilities');
		$this->dbforge->drop_table('company_types');
		$this->dbforge->drop_table('company_facilities');
		$this->dbforge->drop_table('companies_files');
		
		$this->dbforge->drop_table('doctors_profiles');
		$this->dbforge->drop_table('doctor_specialities');
	}
}
