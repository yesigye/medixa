<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		$this->load->config('app');
		$this->app = $this->config->item('app');
	}

	public function current()
	{
		$users = $this->ion_auth->user()->result();

		if ( ! empty($users))
		{
			$users[0]->type = 'person';
			return $users[0];
		}
	}

	public function owner()
	{
		$this->db->where('name', 'admin');
		$group = $this->db->get('groups')->result();

		// Data needed from users table
		$this->db->select('users.id');
		$this->db->select('users.username');
		$this->db->select('users.email');
		$this->db->select('users.phone');
		$this->db->select('users.address');
		$this->db->select('users.postal');
		$this->db->select('users.avatar AS logo');
		$this->db->select('users.first_name AS name');

		if ( ! empty($group))
		{
			// Only get users of specified group
			$this->db->where('group_id', $group[0]->id);
		}

		$this->db->from('users_groups');
		$this->db->join('users', 'users.id = users_groups.user_id');

		$users = $this->db->get()->result();

		if (! empty($users))
			$users = $users[0];

		return $users;
	}

	public function users($options = array())
	{
		$result = new stdClass();

		// Set option defaults
		$options['start'] = ( isset($options['start']) ) ? $options['start'] : 0;

		// We will need to cache (remember) our where clauses.
		// This allows us to get the result row count and the result object array
		// without reapeating the same query building process
		$this->db->start_cache();

		// Exclude the admin
		$this->db->where('users_groups.group_id !=', 1);
		
		// Unless otherwise defined, get only active user
		if ( ! isset($options['ignore_status'])) $this->db->where_in('users.active', 1);
		
		// Query by ascending or descending order.
		if (isset($options['order']))
		{
			if ($options['order'] === 'asc')
			{
				$this->db->order_by('users.id', 'ACS');
			}
			elseif ($options['order'] === 'desc')
			{
				$this->db->order_by('users.id', 'DESC');
			}
		}
		
		// Extra select fields.
		if (isset($options['select']))
		{
			foreach($options['select'] as $selectField)
			{
				$this->db->select('users.'.$selectField);
			}
		}
		

		// Data needed from users table
		$this->db->select('users.id');
		$this->db->select('users.avatar');
		$this->db->select('users.username');
		$this->db->select('users.email');
		$this->db->select('users.active');

		// Specific user by their ID numbers
		if (isset($options['ids'])) $this->db->where_in('users.id', $options['ids']);
		
		// Exclude user by their ID numbers
		if (isset($options['exclude'])) $this->db->where_not_in('users.id', $options['exclude']);

		if (isset($options['status']))
		{
			if ($options['status'] === 'active')
			{
				$this->db->where_in('users.active', 1);
			}
			elseif ($options['status'] === 'inactive')
			{
				$this->db->where_in('users.active', 0);
			}
		}

		if (isset($options['search']))
		{
			$this->db->like('users.username', $options['search']);
			$this->db->or_like('users.email', $options['search']);
		}

		$this->db->from('users_groups');
		$this->db->join('users', 'users.id = users_groups.user_id');

		// Count the items before applying pagination and limits.
		$result->count = $this->db->count_all_results();

		// Limit number of results results.
		if (isset($options['limit'])) $this->db->limit($options['limit'], $options['start']);

		$result->users = $this->db->get()->result();

		$this->db->stop_cache();
		$this->db->flush_cache();

		return $result;
	}

	public function get_details($user_id)
	{
		// Data needed from users table
		$this->db->select('users.id');
		$this->db->select('users.username');
		$this->db->select('users.email');
		$this->db->select('users.phone');
		$this->db->select('users.address');
		$this->db->select('users.postal');
		$this->db->select('users.active');
		$this->db->select('users.avatar');
		$this->db->select('users.first_name');
		$this->db->select('users.last_name');

		$this->db->where('users.id', $user_id);
		$this->db->from('users');

		$user = $this->db->get()->result();

		if (!empty($user)) $user = $user[0];

		return $user;
	}
}
