<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model
{
	/**
	 * error message
	 *
	 * An error message generated within any function.
	 *
	 * @var string
	 **/
	public $error_message = '';

	/**
	 * number of result objects
	 *
	 * some functions like all() set this variable and
	 * it should be called after such functions execute.
	 *
	 * @var int
	 **/
	public $count = 0;

	public $id;
	public $avatar;
	public $thumbnail;
	public $first_name;
	public $last_name;
	public $address;
	public $phone;

	public function __construct()
	{
		$this->load->database();
	}

	/**
	 * Set any error that occurs
	 *
	 * @var	string $message error meassage to be set
	 **/
	public function set_error_message($message = '')
	{
		$this->error_message = $message;
	}

	/**
	 * Return error message
	 *
	 * @return string
	 **/
	public function error_message()
	{
		return $this->error_message;
	}

	/**
	 * Return the currently logged in user object.
	 *
	 * @param array $column value to return
	 *
	 * @return array
	 **/
	public function current($column = '')
	{
		if (isset($_SESSION['user_id'])) {
			if ($column) $this->ion_auth->select("users.$column");
			$this->ion_auth->where('users.id', $_SESSION['user_id']);

			$user = $this->ion_auth->user()->result_array();

			return (empty($user)) ? $user : ($column) ? $user[0][$column] : $user[0];
		}

		return null;
	}

	/**
	 * Return user row data
	 *
	 * @return	array
	 */
	public function row($id, $value)
	{
		$this->db->limit(1);
		$this->db->select($value);
		$this->db->where('id', $id);
		$user = $this->db->get('users')->result_array();
		if (! empty($user)) $user = $user[0];
		return $user[$value];
	}

	/**
	 * Return user row data
	 *
	 * @return	array
	 */
	public function rowData($id, $values)
	{
		$this->db->limit(1);

		foreach ($values as $key => $value) {
			$this->db->select($value);
		}

		$this->db->where('id', $id);
		return $this->db->get('users')->result_array();
	}

	/**
	 * Return all users objects.
	 *
	 * options parameter may be used to filter or limited the objects returned.
	 *
	 * @param	array $options an array of options used to filter users results 
	 * @return	array
	 */
	public function all($options = array())
	{
		$orderFields = ['username', 'email'];
		
		// Set default options
		if (!isset($options['start'])) $options['start'] = 10;
		
		// We cache because we need to remember our filter/where clauses.
		// This allows us to get both the row count and the query objects
		// otherwise the CI query builder would reset after getting the row count.
		$this->db->start_cache();
		
		$this->db->from('users');
		
		$this->db->select('users.id');
		$this->db->select('users.username');
		$this->db->select('users.email');
		$this->db->select('users.active');
		$this->db->select('group_join.name AS group_name');
		$this->db->select('users.thumbnail');
        $this->db->select("FROM_UNIXTIME(users.created_on, '%a %e-%m-%Y') AS created_on");
		
		// JOIN 'groups' to 'user' table using 'users_groups' as a pivot table
		$this->db->join('users_groups users_groups_pivot', 'users_groups_pivot.user_id = users.id', 'left');
		$this->db->join('groups group_join', 'group_join.id = users_groups_pivot.group_id', 'left');

		// Dont show the admin
		$this->db->where('group_join.name !=', 'admin');
		
		// Filter result objects using the user options
		if (isset($options['status'])) {
			$this->db->where('users.active', ($options['status'] == 'active') ? 1 : 0);
		}
		
		if (isset($options['group'])) {
			$this->db->where('group_join.name', $options['group']);
		}
		
		// Query users in the same group
		if (isset($options['in_group'])) {
			$this->db->where('group_join.id', $options['in_group']);
		}
		// Query users that are not in the same group
		if (isset($options['out_group'])) {
			$this->db->where('group_join.id !=', $options['out_group']);
			$this->db->or_where('group_join.id', null);
		}

		// Query groups by search
		if (isset($options['search']) && $options['search'] !== '') {
			$this->db->where("(
				users.first_name LIKE '%".$options['search']."%'
				OR users.last_name LIKE '%".$options['search']."%'
				OR users.username LIKE '%".$options['search']."%'
				OR users.email LIKE '%".$options['search']."%'
				OR group_join.name LIKE '%".$options['search']."%'
			)", null, false);
		}
		
		// Count the items before applying pagination.
		$this->count = $this->db->count_all_results();
		
		if (isset($options['count'])) {
			// Option is to return number of objects in the results.
			// Don't forget to stop and clear the cache.
			$this->db->stop_cache();
			$this->db->flush_cache();

			return $this->count;
		}
		
		// Limit number of objects in the results.
		// This is primarily for pagination purposes.
		if (isset($options['limit'])) $this->db->limit($options['limit'], $options['start']);
		
		// Apply ordering
		if (isset($options['order'])) {
			if ($options['order']['column'] == 'group') {
				$this->db->order_by('group_join.name', $options['order']['dir']);
			} else {
				$this->db->order_by('users.'.$options['order']['column'], $options['order']['dir']);
			}
		}
		
		$result = $this->db->get()->result_array();
		
		// Don't forget to stop and clear the cache.
		$this->db->stop_cache();
		$this->db->flush_cache();

		return $result;
	}

	/**
	 * Return count of all users
	 *
	 * @return Boolean
	 **/
	public function get_users_total()
	{
		$this->db->from('users');

		// Dont include the admin
		$this->db->where('group_join.name !=', 'admin');
		
		// JOIN 'groups' to 'user' table using 'users_groups' as a pivot table
		$this->db->join('users_groups users_groups_pivot', 'users_groups_pivot.user_id = users.id', 'left');
		$this->db->join('groups group_join', 'group_join.id = users_groups_pivot.group_id', 'left');

		return $this->db->count_all_results();
	}

	/**
	 * Return all users objects.
	 *
	 * options parameter may be used to filter or limited the objects returned.
	 *
	 * @param	array $options an array of options used to filter users results 
	 * @return	array
	 */
	public function groups($options = array())
	{
		$orderFields = ['username', 'email'];
		
		// Set default options
		if (!isset($options['start'])) $options['start'] = 10;
		
		// We cache because we need to remember our filter/where clauses.
		// This allows us to get both the row count and the query objects
		// otherwise the CI query builder would reset after getting the row count.
		$this->db->start_cache();
		
		$this->db->from('groups');
		$this->db->select('groups.id');
		$this->db->select('groups.name');
		$this->db->select('groups.description');
		
		$this->db->select('IFNULL(users_groups_pivot.users_count, 0) AS users_count');
		// JOIN 'users_groups' to 'groups' while selecting the 'user_count'(occurances of group_id)
		$this->db->join(
			'(
				SELECT group_id, COUNT(group_id) users_count
				FROM users_groups
				GROUP BY group_id
			) users_groups_pivot',
			'users_groups_pivot.group_id = groups.id', 'left');


		
		// Query by search
		if (isset($options['search']) && $options['search'] !== '') {
			$this->db->like('groups.name', $options['search']);
			$this->db->or_like('groups.description', $options['search']);
		}

		// Count the items before applying pagination.
		$this->count_groups = $this->db->count_all_results();
		
		// Limit number of objects in the results.
		// This is primarily for pagination purposes.
		if (isset($options['limit'])) $this->db->limit($options['limit'], $options['start']);
		
		// Query by ordering
		if (isset($options['order'])) {
			if ($options['order']['column'] == 'users_count') {
				$this->db->order_by('users_groups_pivot.'.$options['order']['column'], $options['order']['dir']);
			} else {
				$this->db->order_by('groups.'.$options['order']['column'], $options['order']['dir']);
			}
		}
		
		$result = $this->db->get()->result_array();
		
		// Don't forget to stop and clear the cache.
		$this->db->stop_cache();
		$this->db->flush_cache();

		return $result;
	}

	/**
	 * Return a user object data.
	 *
	 * @param	int $user_id a user object id
	 * @return	array
	 */
	public function details($ref, $isReg = false)
	{
		if ($isReg) {
			$this->db->where('doctor_details.reg_no', $ref);
		}else{
			$this->db->where('users.id', $ref);
		}

		$this->db->from('users');

		$this->db->select('users.id');
		$this->db->select('users.username');
		$this->db->select('users.email');
		$this->db->select('users.phone');
		$this->db->select('users.address');
		$this->db->select('from_unixtime(users.created_on, "%D %M %Y") AS created_on');
		$this->db->select('from_unixtime(users.last_login, "%D %M %Y") AS last_login');
		$this->db->select('users.active');
		$this->db->select('users.avatar');
		$this->db->select('users.first_name');
		$this->db->select('users.last_name');
		$this->db->select('groups.id AS group_id');
		$this->db->select('groups.name AS group_name');
		
		// JOIN 'groups' 'id' and 'name' to 'user' table using
		// 'users_groups' as a pivot table
		$this->db->join('users_groups', 'users_groups.user_id = users.id', 'left');
		$this->db->join('groups', 'groups.id = users_groups.group_id', 'left');

		$user = $this->db->get()->result_array();

		if (empty($user)) return null;

		return $user[0];
	}

	/**
	 * Add a new user object
	 *
	 * @param String $field_name name of the file form field, default is avatar
	 * 
	 * @return Boolean
	 **/
	public function uploadAvatar($field_name = 'avatar')
	{
		// Upload the user image if it was posted.
		if (isset($_FILES['avatar']['size']) && $_FILES['avatar']['size'] > 0) {
			
			$this->load->library('image');
			
			if ($this->image->upload(array('field'=> $field_name))) {
				
				$this->avatar = $this->image->filename;
				
				if ($this->input->post('crop_width') AND $this->input->post('crop_height')) {
					// Crop image to user defined properties.
					$this->image->crop(array(
						'width' => $this->input->post('crop_width'),
						'height' => $this->input->post('crop_height'),
						'x_axis' => $this->input->post('crop_x'),
						'y_axis' => $this->input->post('crop_y'),
					));
					
					// Resize image for a small footprint.
					$this->image->resize();
					
					// Create a tiny thumbnail.
					$this->image->thumbnail();
					$this->thumbnail = $this->image->filename;
				}

				return true;
			}
		}

		return false;
	}

	/**
	 * Edit an existing user object
	 *
	 * @param Int   $user_id   user identifier
	 * @param Array $user_data user details
	 * 
	 * @return Boolean
	 **/
	public function update($user_id)
	{
		$this->load->library('form_validation');
			// Set validation rules
			// Validation rules are set by config file at
			// ./application/modules/users/config/Form_validation.php
			$this->config->load('users/form_validate');
			$validation_rules = $this->config->item('profile_update');
			
			$this->form_validation->set_rules($validation_rules);

			if ($this->form_validation->run('profile_update') == true) {
				
				$user_data['first_name'] = $this->input->post('first_name');
				$user_data['last_name'] = $this->input->post('last_name');
				$user_data['username'] = $this->input->post('username');
				$user_data['address'] = $this->input->post('address');
				$user_data['email'] = $this->input->post('email');
				$user_data['phone'] = $this->input->post('phone');
				$user_data['active'] = (bool)$this->input->post('status');
				
				// Attempt to upload user avatar
				if ($_FILES['avatar']['size'] > 0 && $this->uploadAvatar()) {
					$user_data['avatar'] = $this->avatar;
					$user_data['thumbnail'] = $this->thumbnail;
				}

				
				$user_update = $this->ion_auth->update($user_id, $user_data);
				
				$userGroups = $this->ion_auth->get_users_groups($user_id)->result();
				$user_groups = array();
				foreach ($userGroups as $group) array_push($user_groups, $group->id);
				// Procced if the posted group is different than current user groups
				$group = $this->input->post('group');
				if ($group !== null AND !in_array($this->input->post('group'), $user_groups)) {
					// remove user from all groups
					$this->ion_auth->remove_from_group(null, $user_id);
					$this->ion_auth->add_to_group($group, $user_id);
				}

				if (!$user_update) {
					$message = $this->error_message ? $this->error_message : 'Profile could not be updated';
					$this->app->setAlert($message, 'error');
					return false;
				}

				return true;
			}
	}

	/**
	 * Deactivate multiple user objects
	 *
	 * @param Int $user_ids user identifiers
	 * @return Boolean
	 **/
	public function deactivate_multiple($user_ids)
	{
		foreach ($user_ids as $key => $id)
		{
			$this->ion_auth->deactivate($id);
		}

		if ($this->ion_auth->messages())
		{
			return true;
		}
		else
		{
			$this->set_error_message('User(s) could not be deactivated');
			return false;
		}
	}

	/**
	 * Activate multiple user objects
	 *
	 * @param Int $user_ids user identifiers
	 * @return Boolean
	 **/
	public function activate_multiple($user_ids)
	{
		foreach ($user_ids as $key => $id) {
			$this->ion_auth->activate($id);
		}

		if ($this->ion_auth->messages()) {
			return true;
		} else {
			$this->set_error_message('User(s) could not be activated');
			return false;
		}
	}

	/**
	 * Delete multiple user objects
	 *
	 * @param Int $user_ids user identifiers
	 * @return Boolean
	 **/
	public function delete_multiple($user_ids)
	{
		$deleted = false;
		foreach ($user_ids as $key => $id) {
			$deleted = $this->delete_user($id);
		}
		return $deleted;
	}

	/**
	 * Delete user object
	 *
	 * @param Int $id user identifier
	 * @return Boolean
	 **/
	public function delete_user($id)
	{
		$this->db->select('thumbnail, avatar')->where('id', $id);
		$profile = $this->db->get('users')->result();

		if (!empty($profile) AND $profile['id'] !== 1) {
			// Remove images
			$this->load->library('image');
			$this->image->delete($profile[0]->avatar);
			$this->image->delete($profile[0]->avatar);
			
			return $this->ion_auth->delete_user($id);
		}
		return false;
	}

	/**
	 * Return object of all users groups
	 *
	 * @return Boolean
	 **/
	public function get_users_groups()
	{
		$this->db->from('groups');
		
		$this->db->select('groups.id');
		$this->db->select('groups.name');
		$this->db->select('groups.description');
		$this->db->select('IFNULL(users_groups_pivot.users_count, 0) AS users_count');

		// JOIN 'users_groups' to 'groups'
		// while selecting the 'user_count': (occurances of group_id)
		$this->db->join(
			'(
				SELECT group_id, COUNT(group_id) users_count
				FROM users_groups
				GROUP BY group_id
			) users_groups_pivot',
			'users_groups_pivot.group_id = groups.id', 'left');

		return $this->db->get()->result_array();

	}

	/**
	 * Return count of all users groups
	 *
	 * @return Boolean
	 **/
	public function get_groups_total()
	{
		return $this->db->count_all_results('groups');
	}

	/**
	 * Does password belong to user.
	 *
	 * @param int    $id user id
	 * @param string $pass user password
	 *
	 * @return Boolean
	 **/
	private function password_check($id, $pass)
	{
		return $this->ion_auth->hash_password_db($id, $pass);
	}
}

/* End of file users.php */
/* Location: ./application/modules/users/models/users.php */