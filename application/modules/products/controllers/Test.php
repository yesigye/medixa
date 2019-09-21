<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// if (ENVIRONMENT=='production') show_404();

class Test extends MX_Controller {

	function __construct() 
    {
		parent::__construct();
		
		$this->load->library('unit_test');

		$this->load->database();
		$this->unit->use_strict(TRUE);
		$this->load->model('product_model', 'item');

		// Stores data used by view pages.
		$this->data = array();
	}

	public function index($value='')
	{
		var_dump($this->get_users());
		// $this->unit->run($this->user->current(), 'is_array', 'Get current user', '');
		// $this->unit->run($this->user->details(1), 'is_array', 'Get a user\'s details', '');
		echo $this->unit->report();
	}
	
	public function get_users()
	{
		$this->unit->run($this->item->all([]), 'is_array', 'Get all users in the database', '');
	}

	/**
	 * Saving random users.
	 *
	 * @param	int $num number of users to save 
	 *
	 * @return	null
	 */
	public function save($num = 1) {
		$this->load->library(['faker', 'ion_auth']);
		$faker = Faker\Factory::create();
		
		for ($i=0; $i < $num; $i++) {
			// Create fake user
			$details = [
				'avatar' => '',
				'first_name' => $faker->firstName,
				'last_name' => $faker->lastName,
				'address' => $faker->address,
				'phone' => $faker->phoneNumber
			];

			$email = $faker->email;

			$reg = $this->ion_auth->register($email, 'password', $email, $details, [2]);

			// Test register a user
			$this->unit->run($reg, 'is_array', 'Register user',
				json_encode($details).'<br>'.$this->ion_auth->errors() // show what happened
			);
			// Test get user id immediately after registering
			$this->unit->run($reg['id'], 'is_string', 'Get id of registered user', '');
			// Delete created user
			// $this->ion_auth->delete_user($reg['id']);
		}

		echo $this->unit->report();
	}
}

/* End of file Users.php */
/* Location: ./application/modules/users/controllers/Users.php */