<?php

// execute with no limit
set_time_limit(0);

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generate extends CI_Controller {

    function __construct() 
    {
		parent::__construct();
		
		if (ENVIRONMENT !== 'development') show_404();
		
		$this->load->database();
		$this->load->library(['faker', 'users/ion_auth']);
		$this->faker = Faker\Factory::create('en_UG');
	}

	public function hospitals($num = 0)
	{
		if($num === 0) exit("No number defined");

		// Uganda geocodes
		$geocodes = [
			['address'=> 'Kanoni', 'latitude'=> '0.1717469504412474', 'longitude'=> '31.906528472900394'],
			['address'=> 'Lyamutundwe', 'latitude'=> '0.10132307493503484', 'longitude'=> '32.51219272613526'],
			['address'=> 'Kololo', 'latitude'=> '0.33336451314490245', 'longitude'=> '32.59540557861329'],
			['address'=> 'Lubiri', 'latitude'=> '0.2946339973291204', 'longitude'=> '32.56887316703797'],
			['address'=> 'Nsambya', 'latitude'=> '0.29113644247137116', 'longitude'=> '32.59162902832032'],
			['address'=> 'Ntare, Mbarara', 'latitude'=> '-0.6062966679651817', 'longitude'=> '30.646362304687504'],
		];
		// Dumping data in table 'doctor_specialities'
        if ($this->db->count_all('doctor_specialities') == 0) {
            $this->db->insert_batch('doctor_specialities', array(
                [
                    'id' => '1',
                    'name' => 'Dentist',
                    'code' => 'dentist',
                    'description' => 'Treats diseases of the teeth, gums and mouth in general',
                    'created_on' => time(),
                ],
                [
                    'id' => '2',
                    'name' => 'Cardiologists',
                    'code' => 'cardiologists',
                    'description' => 'Specializes in the heart, veins and related organs',
                    'created_on' => time(),
                ],
                [
                    'id' => '3',
                    'name' => 'Pediatricians',
                    'code' => 'pediatricians',
                    'description' => 'Physicians specializing in pediatrics work to diagnose and treat patients from infancy through adolescence',
                    'created_on' => time(),
                ],
                [
                    'id' => '4',
                    'name' => 'Dermatologist',
                    'code' => 'dermatologist',
                    'description' => 'Dermatologists are physicians who treat adult and pediatric patients with disorders of the skin, hair, nails, and adjacent mucous membranes.',
                    'created_on' => time(),
                ],
            ));
        }

        // Dumping data in table 'company_types'
        if ($this->db->count_all('company_types') == 0) {
			$this->db->insert('company_types', array(
				'id' => '1',
                'name' => 'General Hospital',
                'code' => 'GNH',
                'description' => 'Place for general health care treatment',
                'created_on' => time(),
            ));
            $this->db->insert('company_types', array(
				'id' => '2',
                'name' => 'University/College Hospital',
                'code' => 'UNIH',
                'description' => 'Teaching hospital that offer medical services',
                'created_on' => time(),
            ));
            $this->db->insert('company_types', array(
				'id' => '3',
                'name' => 'Specialty Hospital',
                'code' => 'STYH',
                'description' => 'Care and treatment of patients with a cardiac, orthopedic condition or any other condition requiring surgical procedures',
                'created_on' => time(),
            ));
		}
		
        // Dumping data in table 'company_facilities'
		if ($this->db->count_all('company_facilities') == 0) {
			$this->db->insert('company_facilities', array(
				'id' => '1',
				'name' => 'Pharmacy',
				'code' => 'PHY',
				'description' => '',
			));
		}

		$this->load->helper(['url', 'text']);

		$types = $this->db->select('id')->get('company_types')->result();
		$locations = $this->db->select('id')->get('locations')->result();
		$facilities = $this->db->select('id')->get('company_facilities')->result();
		
		for ($i=0; $i < $num; $i++) {
			// Get doctors
			$users = $this->db->select('user_id')->order_by('user_id', 'RANDOM')->limit(5)->get('doctors_profiles')->result();
			
			shuffle($types);
			shuffle($locations);
			shuffle($facilities);
			shuffle($users);
			
			if (!empty($locations)) $insert['location_id'] = $locations[0]->id;

			$insert['name'] = $this->faker->company;
			$insert['slug'] = convert_accented_characters(url_title($insert['name'].$num, '-', true));
			$insert['logo'] = '300-150.png';
			$insert['preview'] = '300-150.png';
			$insert['slogan'] = $this->faker->sentence;
			$insert['description'] = $this->faker->paragraph;
			$insert['phone'] = $this->faker->phoneNumber;
			$insert['email'] = $this->faker->email;
			$insert['open_hrs'] = '8:00am to 5:00pm';
			$insert['address'] = $this->faker->cityName;
			// $insert['latitude'] = $this->faker->latitude($min = 0, $max = -35);
			// $insert['longitude'] = $this->faker->longitude($min = 150, $max = 152);
			// $insert['latitude'] = mt_rand(-0.6062966679651817, mt_getrandmax() - 0.1717469504412474) / mt_getrandmax();
			$insert['latitude'] = $this->_randomFloat(-0.6062966679651817, 0.1717469504412474);
			$insert['longitude'] = $this->_randomFloat(30.646362304687504, 32.59540557861329);
			$insert['active'] = 1;
			
			$this->db->insert('companies', $insert);
			$company_id = $this->db->insert_id();

			if ($company_id) {
				// Adding hospital users
				foreach ($users as $row) {
					$this->db->insert('companies_users', array(
						'company_id' => $company_id,
						'user_id' => $row->user_id,
					));
				}

				// Adding hospital types
				if (!empty($types)) {
					$this->db->insert('companies_types', array(
						'company_id' => $company_id,
						'company_type_id' => $types[0]->id,
					));
				}

				// Adding hospital facilities
				for ($f=1; $f < ( rand(1, count($facilities)) ); $f++) { 
					$this->db->insert('companies_facilities', array(
						'company_id' => $company_id,
						'company_facility_id' => $facilities[$f]->id,
					));
				}
				
				// Adding hospital images
				$this->db->insert('companies_files', array(
					'company_id' => $company_id,
					'caption' => 'A clean environment',
					'url' => '71b369a774e0778461a8367286b6a9a7.jpg',
				));
				$this->db->insert('companies_files', array(
					'company_id' => $company_id,
					'caption' => 'Mordern environment',
					'url' => '90b15516c2feb5f50a2dd2504c05bc13.jpg',
				));

				$this->db->reset_query();
			}
		}

		echo 'done';
	}

	public function users($num = 0)
	{
		if($num > 0) {
			for ($i=0; $i < $num; $i++) {
				
				$user = $this->ion_auth->register(
					$this->faker->username,
					'$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O',
					$this->faker->email,
					[
						'thumbnail' => 'user.png',
						'avatar' => 'user.png',
						'first_name' => $this->faker->firstname,
						'last_name' => $this->faker->lastname,
						'phone' => $this->faker->phoneNumber,
						'address' => $this->faker->address,
					],
					[4]
				);

				if($this->faker->numberBetween(0, 1)) $this->ion_auth->activate($user['id']);
			}
		} else {
			exit("No number defined");
		}
	}

	public function doctors($num = 0)
	{
		if($num > 0) {

			for ($i=0; $i < $num; $i++) {
				$speciality = $this->db->get('doctor_specialities')->result();

				$this->db->insert('users', array(
					'ip_address' =>	$this->faker->ipv4,
					'username' => $this->faker->username,
					'password' => '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O',
					'email' => $this->faker->email,
					'created_on' =>	1484753802,
					'active' => 1,
					'thumbnail' => 'doc.png',
					'avatar' => 'doc.png',
					'first_name' => $this->faker->firstname,
					'last_name' => $this->faker->lastname,
					'phone' => $this->faker->phoneNumber,
					'address' => $this->faker->address,
					// 'birth_date' => $this->faker->date('Y-m-d', '1985'),
				));

				if ($this->db->affected_rows()) {
					$user_id = $this->db->insert_id();

					$this->db->insert('users_groups', array(
						'user_id' => $user_id,
						'group_id' => 2,
					));
					$this->db->insert('doctors_profiles', array(
						'user_id' => $user_id,
						'reg_no' => $user_id.$this->faker->numberBetween($min = 100, $max = 999),
						'description' => $this->faker->paragraph,
						'first_qualification' => $this->faker->sentence,
						'other_qualification' => $this->faker->sentence,
						'speciality_id' => $speciality[array_rand($speciality)]->id,
						'is_mobile' => $this->faker->numberBetween(0, 1),
					));

					if (!empty($companies)) {
						$this->db->where('companies_users.user_id !=', $user_id);
						$this->db->where('companies_users.user_id !=', 1);
						$companies = $this->db->get('companies_users')->result();

						$this->db->insert('companies_users', array(
							'user_id' => $user_id,
							'company_id' => $companies[array_rand($companies)]->company_id,
						));
					}
				}
			}
		} else {
			exit("No number defined");
		}
	}

	public function appointments($num = 0)
	{
		$users = $this->ion_auth->users('users')->result();
		$doctors = $this->ion_auth->users('doctors')->result();

		if(empty($users)) $this->users(10);
		if(empty($doctors)) $this->doctors(10);

		if($num > 0) {
			for ($i=0; $i < $num; $i++) {

				$date_object = $this->faker->dateTimeBetween('now', '2019-11-20');
				$sart_date = date('Y-m-d H:m:i', $date_object->getTimestamp());
				$end_date = date('Y-m-d H:m:i', $date_object->getTimestamp()+3600); // Add an hour

				$this->db->insert('appointments', array(
					'user_id' => $users[array_rand($users)]->id,
					'doctor_id' => $doctors[array_rand($doctors)]->id,
					'title' =>	$this->faker->text,
					'message' => $this->faker->paragraph,
					'approved' => $this->faker->numberBetween(0, 1),
					'viewed' => $this->faker->numberBetween(0, 1),
					'start_date' =>	$sart_date,
					'end_date' =>	$end_date,
					'created_on' =>	now(),
				));
			}
		} else {
			exit("No number defined");
		}
	}

	public function questions($num = 0)
	{
		if($num > 0)
		{
			for ($i=0; $i < $num; $i++)
			{
				$question = array(
					'user_id' => $this->faker->numberBetween($min = 170, $max = 176),
					'speciality' => 1,
					'title' => $this->faker->sentence,
					'question' => $this->faker->paragraph,
				);
				$question['slug'] = url_title($question['title']);

				$this->db->insert('questions', $question);

				if ($this->db->affected_rows())
				{
					$qn_id = $this->db->insert_id();

					for ($i=0; $i < $this->faker->numberBetween($min = 0, $max = 7); $i++)
					{
						$this->db->insert('question_answers', array(
							'user_id' => $this->faker->numberBetween($min = 37, $max = 50),
							'question_id' => $qn_id,
							'answer' => $this->faker->paragraph,
						));
					}
				}
				$this->db->insert('question_votes', array(
					'user_id' => $this->faker->numberBetween($min = 28, $max = 50),
					'answer_id' => $this->faker->numberBetween($min = 1, $max = 80),
					'liked' => $this->faker->numberBetween($min = 0, $max = 1),
				));
			}
		}
		else
		{
			exit("No number defined");
		}
	}

	/**
	 * Randomize float numbers.
	 * I use this to get geocodes by knowing the highest and the lowest points
	 * of an area on a map and then i use this function to randomize between the two points
	 *
	 * @param $min minimum float value
	 * @param $max maximum float value
	 * 
	 * @return	float
	 */
	private function _randomFloat($min, $max) {
		return random_int($min, $max - 1) + (random_int(0, PHP_INT_MAX - 1) / PHP_INT_MAX);
	}
}