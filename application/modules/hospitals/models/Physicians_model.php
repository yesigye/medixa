<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Physicians_model extends CI_Model
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

	/**
	 * id of user object
	 *
	 * some functions like add() set this variable and
	 * it should be called after such functions execute.
	 *
	 * @var int
	 **/
	public $id = 0;

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
	 * Return all users objects.
	 *
	 * options parameter may be used to filter or limited the objects returned.
	 *
	 * @param	array $options an array of options used to filter users results 
	 * @return	array
	 */
	public function getAll($options = array())
	{
		// Set default options
		if (!isset($options['start'])) $options['start'] = 0;
		
		// We cache because we need to remember our filter/where clauses.
		// This allows us to get both the row count and the query objects
		// otherwise the CI query builder would reset after getting the row count.
		$this->db->start_cache();
		
		$this->db->from('users');
		
		$this->db->group_by('users.id');
		
		$this->db->select('users.id');
        $this->db->select('users.thumbnail');
        $this->db->select('users.avatar');
        $this->db->select('users.username');
        $this->db->select('users.first_name');
        $this->db->select('users.last_name');
        $this->db->select('users.email');
        $this->db->select('users.active');
        $this->db->select('FROM_UNIXTIME(users.created_on, "%W %d-%m-%Y") AS created_on');
        // // Doctor profile
        $this->db->select('doctors_profiles.reg_no');
        $this->db->select('doctors_profiles.is_mobile');
        $this->db->select('doctors_profiles.first_qualification AS educ');
        $this->db->join('doctors_profiles', 'doctors_profiles.user_id = users.id', 'left');
        // // Doctor speciality
        $this->db->select('doctor_specialities.name speciality');
        $this->db->join('doctor_specialities', 'doctor_specialities.id = doctors_profiles.speciality_id', 'left');
        // Location
        $this->db->select('locations.name AS location');
        $this->db->group_by('locations.name');
        $this->db->join('locations', 'doctors_profiles.location_id = locations.id', 'left');
		// User group
        $this->db->where('groups.name', 'doctors');
		$this->db->join('users_groups', 'users_groups.user_id = users.id', 'left');
		$this->db->join('groups', 'groups.id = users_groups.group_id', 'left');

		// Filter result objects using the user options
		if (isset($options['speciality'])) {
			$this->db->where('doctor_specialities.code', $options['speciality']);
		}

		// Filter users depending on a particular hospital
		if (isset($options['in_hospital']) || isset($options['out_hospital'])) {
			// Query users companies
			$this->db->group_by('companies_users.user_id');
			$this->db->join('companies_users', 'companies_users.user_id = users.id', 'left');
			$this->db->join('companies', 'companies.id = companies_users.company_id', 'left');
			
			if (isset($options['in_hospital'])) $this->db->where('companies.id', $options['in_hospital']);
			
			if (isset($options['out_hospital'])) {
				$this->db->where("(companies.id != ".$options['out_hospital']." OR companies.id IS NULL)", null, false);
			}
		}

		if (isset($options['show_appointments'])) {
			// Query users appintments number
			$this->db->select('IFNULL(appointmentsJoin.appointments, 0) appointments');
			$this->db->join(
				'(
					SELECT doctor_id, COUNT(*) appointments
					FROM appointments
					GROUP BY doctor_id
				) appointmentsJoin',
				'appointmentsJoin.doctor_id = users.id', 'left'
			);
		}

		// where not
		if (isset($options['except'])) {
			$this->db->where_not_in('doctors_profiles.reg_no', $options['except']);
		}
		
		// Status
		if (!isset($options['ignore_status'])) {
			// $this->db->where('users.active', 1);
		}
		
		// Query groups by search
		if (isset($options['search']) && $options['search'] !== '') {
			// Load porterstemmmer library to trim search terms
			$this->load->library('search/porterStemmer');
			
			$search_string = strtolower($options['search']);
			
			// Flag some characters and words to remove.($flag_words and $flag_chars)
			$flag_chars = array('\'s', '.', ',', '\'', '!', '?', '"');
			$flag_words = array("the", "and", "a", "to", "of", "in", "i", "is", "that", "it", "on", "you", "this",
			"for", "but", "with", "who", "are", "have", "be", "at", "or", "as", "was", "so", "if", "out", "not");
			
			// Removes flagged symbols, then extracts words
			$search_words = explode(" ", str_replace($flag_chars, "", $search_string));
			
			foreach ($search_words as $key => $search_word) {
				if (in_array($search_word, $flag_words)) {
					unset($search_words[$key]);
				} else {
					$stem = PorterStemmer::Stem($search_word);
					
					if (in_array($stem, $flag_words)) {
						// Remove if stemmed word is flagged
						unset($search_words[$key]);
					} else {
						// Replace search word with stem
						$search_words[$key] = $stem;
					}
				}
			}
			
			// Create a string in mysql result for search word matching.
			$searchColumn = 'LOWER(CONCAT(
				users.email, " ",
				users.username, " ",
				users.first_name, " ",
				users.last_name, " ",
				users.address, " ",
				doctor_specialities.name, " ",
				doctor_specialities.description, " ",
				IF(doctors_profiles.is_mobile, \'mobile\', 0), " ",
				doctors_profiles.first_qualification, " ",
				doctors_profiles.other_qualification
			))';
			foreach ($search_words as $key => $word) {
				if($key < 1) $this->db->like($searchColumn, $word);
				if($key > 0) $this->db->or_like($searchColumn, $word);
			}
		}
		
		// Count the items before applying pagination.
		$this->count = $this->db->count_all_results();
		
		// Return number
		if (isset($options['count'])) {
			$this->db->stop_cache();
			$this->db->flush_cache();
			return $this->count;
		}

		// Apply ordering
		if (isset($options['order'])) {
			if ($options['order']['column'] == 'group') {
				$this->db->order_by('group_join.name', $options['order']['dir']);
			} else {
				$this->db->order_by('users.'.$options['order']['column'], $options['order']['dir']);
			}
		}
		
		if (isset($options['limit'])) $this->db->limit($options['limit'], $options['start']);
		
		$result = $this->db->get()->result_array();
		
		// Don't forget to stop and clear the cache.
		$this->db->stop_cache();
		$this->db->flush_cache();
		
		return $result;
    }

    public function full_details($reg_no)
    {
        $this->db->from('doctors_profiles');
		
		$this->db->where('doctors_profiles.reg_no', $reg_no);
        
        $this->db->select('doctors_profiles.reg_no');
        $this->db->select('doctors_profiles.description');
        $this->db->select('doctors_profiles.first_qualification');
        $this->db->select('doctors_profiles.other_qualification');
        $this->db->select('doctors_profiles.is_mobile');
        $this->db->select('doctors_profiles.location_id');
		
        // User details
		$this->db->select('users.id');
        $this->db->select('users.avatar');
        $this->db->select('users.first_name');
        $this->db->select('users.last_name');
        $this->db->select('users.phone');
        $this->db->select('users.address');
		$this->db->select('users.email');
		$this->db->select('users.active');
        $this->db->join('users', 'users.id = doctors_profiles.user_id');
        // Doctor speciality
        $this->db->select('doctor_specialities.id speciality_id');
        $this->db->select('doctor_specialities.name speciality');
        $this->db->select('doctor_specialities.code speciality_code');
        $this->db->select('doctor_specialities.description speciality_description');
        $this->db->join('doctor_specialities', 'doctor_specialities.id = doctors_profiles.speciality_id', 'left');
        // Location
        $this->db->select('locations.name location');
        $this->db->select('locations.code location_code');
        $this->db->join('locations', 'doctors_profiles.location_id = locations.id', 'left');

        $row = $this->db->get()->result_array();

        return (!empty($row)) ? $row[0] : $row;
	}

	public function details($user_id)
    {
        $this->db->where('users.id', $user_id);
        
        $this->db->from('users');
		
		$this->db->select('users.id');
        // Doctor profile
        $this->db->select('doctors_profiles.reg_no');
        $this->db->select('doctors_profiles.description');
        $this->db->select('doctors_profiles.first_qualification');
        $this->db->select('doctors_profiles.other_qualification');
        $this->db->select('doctors_profiles.is_mobile');
        $this->db->select('doctors_profiles.location_id');
        $this->db->join('doctors_profiles', 'doctors_profiles.user_id = users.id', 'left');
        // Doctor speciality
        $this->db->select('doctor_specialities.id speciality_id');
        $this->db->select('doctor_specialities.name speciality');
        $this->db->join('doctor_specialities', 'doctor_specialities.id = doctors_profiles.speciality_id', 'left');
        // Location
        $this->db->select('locations.name location');
        $this->db->select('locations.code location_code');
        $this->db->join('locations', 'doctors_profiles.location_id = locations.id', 'left');

        $row = $this->db->get()->result_array();

        return (!empty($row)) ? $row[0] : $row;
	}
	
	public function save($user_id, $data = [])
	{
		if (empty($data)) {
			// Setting data.
			$data = [
				'reg_no' => $this->input->post('reg_no'),
				'speciality_id' => $this->input->post('speciality'),
				'description' => $this->input->post('description'),
				'first_qualification' => $this->input->post('first_qualification'),
				'other_qualification' => $this->input->post('other_qualification'),
			];
			if ($this->input->post('first_qualification')) {
				$data['first_qualification'] = $this->input->post('first_qualification');
			}
			if ($this->input->post('other_qualification')) {
				$data['other_qualification'] = $this->input->post('other_qualification');
			}
			if ($this->input->post('is_mobile')) {
				$data['is_mobile'] = $this->input->post('is_mobile');
			}
			if ($this->input->post('location_id')) {
				$data['location_id'] = $this->input->post('location_id');
			}
		}
		
		// Check for existing data
		$existing = $this->db->where('user_id', $user_id)->count_all_results('doctors_profiles');
		
		if ($existing > 0) {
			// Record exists, so let's update.
			$this->db->where('user_id', $user_id);
			$this->db->update('doctors_profiles', $data);
		} else {
			$data['user_id'] = $user_id;
			$this->db->insert('doctors_profiles', $data);
		}

		return $this->db->affected_rows();
	}

	/**
	 * Search all users objects.
	 *
	 * options parameter may be used to filter or limited the objects returned.
	 *
	 * @param	array $options an array of options used to filter users results 
	 * @return	array
	 */
	public function search($q, $options = array())
	{
		// Cache query
		if (isset($options['cache'])) $this->db->cache_on();

		// Load Library porterstemmmer search algorithm
		$this->load->library('search/porterStemmer');

		// Remove some characters and words.($flag_words and $flag_chars)
		$flag_words 	= array("the", "and", "a", "to", "of", "in", "i", "is",
		"that", "it", "on", "you", "this", "for", "but",
		"with", "are", "have", "be", "at", "or", "as",
		"was", "so", "if", "out", "not");
		$flag_chars 	= array('\'s', '.', ',', '\'', '!', '?', '"');

		$searchTerms 	= explode(" ", str_replace($flag_chars, "", $q));
		$stemmerTerms 	= array();
		foreach ($searchTerms as $searchTerm) {
			$stem = PorterStemmer::Stem($searchTerm);
			if (!in_array($stem, $flag_words)) {
				$stemmerTerms[] = $stem;
			}
		}

		// Set default options
		if (!isset($options['start'])) $options['start'] = 0;
		
		// We cache because we need to remember our filter/where clauses.
		// This allows us to get both the row count and the query objects
		// otherwise the CI query builder would reset after getting the row count.
		$this->db->start_cache();
		
		$this->db->from('users');

		$this->db->where('users.active', 1);
		
		$this->db->group_by('users.id');
		
		$this->db->select('users.id');
        $this->db->select('users.username');
        $this->db->select('users.email');
        $this->db->select('users.active');
        $this->db->select('users.avatar');
        $this->db->select('users.thumbnail');
        $this->db->select('users.last_name');
        $this->db->select('users.first_name');
        $this->db->select('FROM_UNIXTIME(users.created_on, \'%W %e-%m-%Y\') AS created_on');
        // Doctor profile
        $this->db->select('doctors_profiles.reg_no');
        $this->db->select('doctors_profiles.is_mobile');
        $this->db->select('doctors_profiles.first_qualification AS educ');
        $this->db->join('doctors_profiles', 'doctors_profiles.user_id = users.id');
        // Doctor speciality
        $this->db->select('doctor_specialities.name speciality');
        $this->db->join('doctor_specialities', 'doctor_specialities.id = doctors_profiles.speciality_id');
        // Location
        $this->db->select('locations.name location');
		$this->db->join('locations', 'doctors_profiles.location_id = locations.id', 'left');
		
		// Create a string in mysql result for the search engine to match and rate against.
		$searchColumn = 'LOWER(CONCAT(
			users.email, " ",
			users.username, " ",
			users.first_name, " ",
			users.last_name, " ",
			users.address, " ",
			doctor_specialities.name, " ",
			doctor_specialities.description, " ",
			doctors_profiles.first_qualification, " ",
			doctors_profiles.other_qualification
		))';
		$this->db->select($searchColumn.' AS searchtext');
		
		foreach ($stemmerTerms as $i => $term) {
			if ($i == 0) {
				$this->db->like($searchColumn, $term);
			} else {
				$this->db->or_like($searchColumn, $term);
			}
		}
		
		// Filter result objects using the user options
		if (isset($options['speciality'])) {
			$this->db->where('doctor_specialities.code', $options['speciality']);
		}
		// Filter result objects by order
		if (isset($options['order'])) {

			switch ($options['order']) {
				case 'recent':
					$this->db->order_by('user.id', 'DESC');
					break;
					
				default:
					$this->db->order_by('user.id', 'ASC');
					break;
			}
		}

		// Filter users of particular hospital
		if (isset($options['company']) || isset($options['not_company'])) {
			$this->db->select('companies.id company_id');
			$this->db->select('companies.slug company_slug');
			
			if (isset($options['company'])) {
				$this->db->where('companies.id', $options['company']);
			}
			if (isset($options['not_company'])) {
				$this->db->where('companies.id !=', $options['not_company']);
			}
			// JOIN 'companies' to 'user' table using 'companies_users' as a pivot table
			$this->db->join('companies_users', 'companies_users.user_id = users.id', 'left');
			$this->db->join('companies', 'companies.id = companies_users.company_id', 'left');
		}
		
		if (isset($options['search'])) {
			// $this->db->like('users.username', $options['search']);
			// $this->db->or_like('users.email', $options['search']);
		}

		// where not
		if (isset($options['except'])) {
			$this->db->where_not_in('doctors_profiles.reg_no', $options['except']);
		}
		
		$this->db->where('users.active', 1);
		
		// Count the items before applying pagination.
		$this->count = $this->db->count_all_results();
		
		// Return number
		if (isset($options['count'])) {
			$this->db->stop_cache();
			$this->db->flush_cache();
			return $this->count;
		}
		
		// Limit number of objects in the results.
		// This is primarily for pagination purposes.
		if ($options['start'] > 0) {
			$options['start'] = $options['start'] - 1;
		}
		if (isset($options['limit'])) $this->db->limit($options['limit'], $options['start']);
		
		$result = $this->db->get()->result_array();
		
		// Don't forget to stop and clear the cache.
		$this->db->stop_cache();
		$this->db->flush_cache();

		foreach ($result as $key => $value) {
			$result[$key]["match_count"] = 0; // match count
			$result[$key]["score"] = 0; // Accurracy rating

	    	// Remove symbols 
			$words 		= str_replace($flag_chars, " ", $value['searchtext']);
			$words 		= explode(" ", $words);
			$stem_words = array();
			
			foreach($words as $word) {
				$stem = strtolower(PorterStemmer::Stem($word));

				if(!in_array($stem, $flag_words)) {
					$stem_words[] = $stem;
					// Increament match count
					if(in_array($stem, $stemmerTerms)) $result[$key]['match_count']++;
				}
			}
			if ($result[$key]['match_count'] > 0) {
			    // Generate a score
				$result[$key]['score'] = ( $result[$key]['match_count'] / count( $stem_words ) ) * 100;
			}
		}
    	// Sort the results
		usort($result, function($a, $b) {
			return $b['score'] - $a['score'];
		});

		// end caching
		if (isset($options['cache'])) $this->db->cache_off();

		return $result;
    }
}

?>