<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hospitals_model extends CI_Model
{
	/**
	 * @var int
	 **/
	public $count = 0;

	/**
	 *
	 * @var int
	 **/
	public $id = 0;
	
	/**
	 * @var string
	 **/
	public $ame = '';
	
	/**
	 * @var string
	 **/
	public $logo = '';

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
	 * Return error message
	 *
	 * @return string
	 **/
	public function get_hospitals($options = array(), $start = 0, $limit = 0)
	{
		$this->db->where('email', 'semo@group.com')->delete('companies');
		$this->db->where('email', 'semo@group.com')->delete('users');
		// Initialize query start point. Defaulting to 0.
		$options['start'] = ( isset($options['start']) ) ? $options['start'] : 0;

		// We cache because we need to remember our filter/where clauses.
		// This allows us to get both the row count and the query objects
		// otherwise the CI query builder would reset after getting the row count.
		$this->db->start_cache();
		
		$this->db->from('companies company');

		$this->db->select('company.id');
		$this->db->select('company.name');
		$this->db->select('company.slug');
		$this->db->select('company.logo');
		$this->db->select('company.preview');
		$this->db->select('company.email');
		$this->db->select('company.phone');
		$this->db->select('company.active');
		$this->db->select('company.latitude');
		$this->db->select('company.longitude');
		// Get and Join the location
		$this->db->select('locations.id AS location_id');
		$this->db->select('locations.name AS address');
		$this->db->join('locations', 'locations.id = company.location_id', 'left');
		// Get and Join the doctors count
		$this->db->select('IFNULL(hospitalDoctors.num, 0) doctors');
		$this->db->join(
			'(
				SELECT company_id, COUNT(*) num  
				FROM companies_users docs
				JOIN users_groups ON users_groups.user_id = docs.user_id
				WHERE users_groups.group_id = "2"
				GROUP BY company_id
				) hospitalDoctors',
			'hospitalDoctors.company_id = company.id', 'left'
		);
		// Get and Join the facilities count
		$this->db->select('IFNULL(hospitalFacilities.facilities, 0) facilities');
		$this->db->join(
			'(
				SELECT company_id, COUNT(*) facilities
				FROM companies_facilities
				GROUP BY company_id
			) hospitalFacilities',
			'hospitalFacilities.company_id = company.id', 'right'
		);
		
		if (isset($options['type'])) {
			$this->db->where('company_types.code', $options['type']);
			$this->db->select('company_types.id AS companyType_id');
			// $this->db->group_by('companies_types.company_id');
			$this->db->join('companies_types', 'companies_types.company_id = company.id');
			$this->db->join('company_types', 'company_types.id = companies_types.company_type_id');
		}
		
		if (isset($options['spec']) && $spec = $options['spec']) {
			$this->db->join(
				"(
					SELECT companies_users.company_id, doctor_specialities.code
					FROM companies_users
					JOIN doctors_profiles ON doctors_profiles.user_id = companies_users.user_id
					JOIN doctor_specialities ON doctor_specialities.id = doctors_profiles.speciality_id
					WHERE doctor_specialities.code = '$spec'
					GROUP BY companies_users.company_id
				) specs",
				"specs.company_id = company.id", "left"
			);
			$this->db->where('specs.code', $options['spec']);
		}

		if (isset($options['fac'])) {
			$this->db->where('company_facilities.code', $options['fac']);
			$this->db->select('company_facilities.id AS companyType_id');
			// $this->db->group_by('companies_facilities.company_id');
			$this->db->join('companies_facilities', 'companies_facilities.company_id = company.id');
			$this->db->join('company_facilities', 'company_facilities.id = companies_facilities.company_facility_id');
		}
	
		// Query by the location id.
		if (isset($options['location_id'])) $this->db->where('location_id', $options['location_id']);

		// Exclude a hospital from the Query.
		if (isset($options['except'])) $this->db->where('company.id !=', $options['except']);

		// Unless otherwise (ignore_status), query active users.
		if (!isset($options['ignore_status'])) $this->db->where('company.active', 1);

		// Query by search
		if (isset($options['search']) && $options['search'] !== '') {
			$this->db->where("(
				company.name LIKE '%".$options['search']."%'
				OR company.email LIKE '%".$options['search']."%'
				OR hospitalDoctors.num LIKE '%".$options['search']."%'
			)", null, false);
		}
		
		$this->count = $this->db->count_all_results();

		
		// Limit number of objects in the results.
		// This is primarily for pagination purposes.
		if (isset($options['limit'])) $this->db->limit($options['limit'], $options['start']);
		
		// Apply ordering
		if (isset($options['order'])) {
			switch ($options['order']['column']) {
				case 'physicians':
					$this->db->order_by('inner_1.physicians', $options['order']['dir']);
				break;
				case 'facilities':
					$this->db->order_by('inner_2.facilities', $options['order']['dir']);
				break;
				default:
					$this->db->order_by('company.'.$options['order']['column'], $options['order']['dir']);
				break;
			}
		}
		
		$result = $this->db->get()->result_array();
		// Don't forget to stop and clear the cache.
		$this->db->stop_cache()->flush_cache();

		return $result;
	}

	public function map_hospitals($options = array(), $start = 0, $limit = 0)
	{
		// We cache because we need to remember our filter/where clauses.
		// This allows us to get both the row count and the query objects
		// otherwise the CI query builder would reset after getting the row count.
		$this->db->start_cache();
		
		$this->db->from('companies company');

		$this->db->select('company.id');
		$this->db->select('company.name');
		$this->db->select('company.slug');
		$this->db->select('company.address');
		$this->db->select('company.preview');
		$this->db->select('company.latitude');
		$this->db->select('company.longitude');
		// Get and Join the doctors count
		$this->db->select('IFNULL(inner_1.physicians, 0) doctors');
		$this->db->join(
			'(
			SELECT company_id, COUNT(*) physicians  
			FROM companies_users docs 
			GROUP BY company_id
			) inner_1',
			'inner_1.company_id = company.id', 'left'
		);
		// Get and Join the facilities count
		$this->db->select('IFNULL(inner_2.facilities, 0) facilities');
		$this->db->join(
			'(
				SELECT company_id, COUNT(*) facilities
				FROM companies_facilities
				GROUP BY company_id
			) inner_2',
			'inner_2.company_id = company.id', 'left'
		);
		
		$this->db->where('company.latitude !=', null);
		$this->db->where('company.longitude !=', null);
		
		$this->count = $this->db->count_all_results();

		$result = $this->db->get()->result_array();
		
		// Don't forget to stop and clear the cache.
		$this->db->stop_cache()->flush_cache();

		return $result;
	}

	public function count()
	{
		$this->db->reset_query();
		$this->db->where('active', 1);
		return $this->db->from('companies')->count_all_results();
	}

	public function userHospital($id)
	{
		$this->db->select('companies.id');
		$this->db->select('companies.name');
		$this->db->select('companies.logo');
		$this->db->where('user_id', $id);
		$this->db->join('companies', 'companies.id = companies_users.company_id', 'left');
		$query = $this->db->get('companies_users')->result_array();
		
		return (!empty($query)) ? $query[0] : [];
	}

	public function getName($id)
	{
		$this->db->select('name');
		$this->db->where('id', $id);
		$query = $this->db->get('companies')->result();
		
		return (!empty($query)) ? $query[0]->name : '';
	}

	public function details($options = array())
	{
		// Query by specific company id.
		if (isset($options['id'])) {
			$this->db->where('companies.id', $options['id']);
		}
		// Query by specific company slug.
		if (isset($options['slug'])) {
			$this->db->where('companies.slug', $options['slug']);
		}

		$this->db->select('companies.id');
		$this->db->select('companies.logo');
		$this->db->select('companies.preview');
		$this->db->select('companies.name');
		$this->db->select('companies.slug');
		$this->db->select('companies.slogan');
		$this->db->select('companies.description');
		$this->db->select('companies.open_hrs');
		$this->db->select('companies.email');
		$this->db->select('companies.phone');
		$this->db->select('companies.address');
		$this->db->select('companies.longitude');
		$this->db->select('companies.latitude');
		$this->db->select('companies.active');
		
		$this->db->from('companies');
		
		// Get and Join the doctors count
		$this->db->join(
			'(
				SELECT company_id, COUNT(*) physicians  
				FROM companies_users docs
				GROUP BY company_id
			) doc_count',
			'doc_count.company_id = companies.id', 'left');
		// Get and Join the location
		$this->db->select('locations.id AS location_id');
		$this->db->select('locations.name AS location_name');
		$this->db->join('locations', 'locations.id = companies.location_id', 'left');

		$hospital = $this->db->get()->result_array();

		return (empty($hospital)) ? $hospital : $hospital[0];
	}

	public function get_hospital_images($id)
	{
		// Get images of this hospital.
		$this->db->select('id, caption, url');
		$this->db->from('companies_files');
		$this->db->where('company_id', $id);
		
		return $this->db->get()->result_array();
	}

	public function update_hospital_images($id)
	{
		$company = $this->db->get_where('companies', array(
			'id' => $id
		))->result();

		// Get images of this hospital.
		$this->db->select('companies_files.id, companies_files.image_url');
		$this->db->from('companies_files');
		$this->db->where('company_id', $id);

		// Upload the user image if it was posted.
		if ($_FILES['userfile']['size'] > 0)
		{
			$this->load->library('image');

			if ($this->image->upload(array('field'=>'userfile')))
			{
				if ($this->input->post('crop_width') AND $this->input->post('crop_height'))
				{
					// Crop image to user defined properties.
					$this->image->crop(array(
						'width' => $this->input->post('crop_width'),
						'height' => $this->input->post('crop_height'),
						'x_axis' => $this->input->post('crop_x'),
						'y_axis' => $this->input->post('crop_y'),
					));
					
					// Resize image for a small footprint.
					$this->image->resize();
					
					// Delete previous image.
					if (!empty($company)) $this->image->delete($company[0]->logo);
				}

				// Update the hospital data with logo.
				$update['logo'] = $this->image->filename;
			}
			else
			{
				// An error occured while uploading image.
				$this->set_error_message($this->image->error_message());
				return false;
			}
		}

		$this->db->where('id', $id);
		$this->db->update('companies', $update);
		
		return $this->db->get()->result();
	}

	public function add()
	{
		$this->load->helper('text');

		$insert['name'] = $this->input->post('name');
		$insert['slug'] = convert_accented_characters(url_title(strtolower($this->input->post('name'))));
		$insert['logo'] = $this->input->post('logo');
		$insert['slogan'] = $this->input->post('slogan');
		$insert['description'] = $this->input->post('about');
		$insert['phone'] = $this->input->post('phone');
		$insert['email'] = $this->input->post('email');
		$insert['open_hrs'] = $this->input->post('open_hours');
		$insert['address'] = $this->input->post('address');
		$insert['location_id'] = $this->input->post('location_id');
		$insert['latitude'] = $this->input->post('latitude');
		$insert['longitude'] = $this->input->post('longitude');
		$insert['active'] = (bool) $this->input->post('active');

		// Upload the user image if it was posted.
		if (isset($_FILES['userfile']) && $_FILES['userfile']['size'] > 0)
		{
			$this->load->library('image');

			if ($this->image->upload(array('field'=>'userfile')))
			{
				if ($this->input->post('crop_width') AND $this->input->post('crop_height'))
				{
					// Crop image to user defined properties.
					$this->image->crop(array(
						'width' => $this->input->post('crop_width'),
						'height' => $this->input->post('crop_height'),
						'x_axis' => $this->input->post('crop_x'),
						'y_axis' => $this->input->post('crop_y'),
					));
					
					// Resize image for a small footprint.
					$this->image->resize();
				}

				// Update the hospital info with logo.
				$insert['logo'] = $this->image->filename;
			}
		}
		// Upload the preview image if it was posted.
		if (isset($_FILES['preview']) && $_FILES['preview']['size'] > 0)
		{
			$this->load->library('image');

			if ($this->image->upload(array('field'=>'preview')))
			{
				if ($this->input->post('crop_width2') AND $this->input->post('crop_height2'))
				{
					// Crop image to user defined properties.
					$this->image->crop(array(
						'width' => $this->input->post('crop_width2'),
						'height' => $this->input->post('crop_height2'),
						'x_axis' => $this->input->post('crop_x2'),
						'y_axis' => $this->input->post('crop_y2'),
					));
					
					// Resize image for a small footprint.
					$this->image->resize();
				}

				// Update the hospital info with preview image.
				$insert['preview'] = $this->image->filename;
			}
		}

		$this->db->insert('companies', $insert);

		if ($this->db->affected_rows()) {
			$this->id = $this->db->insert_id();

			$types = $this->input->post('types');
			if (!empty($types)) {
				foreach ($types as $key => $type_id) {
					
					// Save the company types.
					$this->db->insert('companies_types', array(
						'company_id' => $this->id,
						'company_type_id' => $type_id
					));
				}
			}

			return true;
		} else {
			return false;
		}
	}

	/**
	 * Save hospital object to database
	 *
	 * @param array $data object to be saved
	 * @param int   $id id of object we are updating. required for updates
	 *
	 * @return boolean
	 **/
	public function save(Array $data, Int $id = null)
	{
		if ($id) {
			// Update existing object
			$this->db->where('id', $id);
			$this->db->update('companies', $data);
		} else {
			// New object
			$this->db->insert('companies', $data);
			$this->id = $this->db->insert_id();
		}

		return $this->db->affected_rows();
	}

	public function update($id)
	{
		$this->load->helper('text');
		
		// Get previous company logo
		$this->db->limit(1);
		$this->db->select('logo');
		$this->db->where('id', $id);
		$company = $this->db->get('companies')->result();

		$update['name'] = $this->input->post('name');
		$update['slug'] = convert_accented_characters(url_title(strtolower($this->input->post('name'))));
		$update['slogan'] = $this->input->post('slogan');
		$update['description'] = $this->input->post('about');
		$update['phone'] = $this->input->post('phone');
		$update['email'] = $this->input->post('email');
		$update['open_hrs'] = $this->input->post('open_hrs');
		$update['address'] = $this->input->post('address');
		$update['latitude'] = $this->input->post('latitude');
		$update['longitude'] = $this->input->post('longitude');

		$this->load->library('ion_auth');
		if ($this->ion_auth->is_admin()) {
			$update['active'] = (bool) $this->input->post('active');
		}

		// Updating the location.
		if ($this->input->post('location_id')) {
			$update['location_id'] = $this->input->post('location_id');
		}

		// Updating the type.
		$typeIDs = $this->input->post('types');
		
		if ($typeIDs) {
			foreach ($typeIDs as $type_id) {
				// Get old type.
				$this->db->where('company_id', $id);
				$this->db->where('company_type_id', $type_id);

				if ($this->db->count_all_results('companies_types') == 0) {
					// Add type if it does not exit.
					$this->db->insert('companies_types', array(
						'company_id' => $id,
						'company_type_id' => $type_id
					));
				}
			}
		}
		$types_updated = $this->db->affected_rows();
		
		// Updating the facilities.
		$facilityIDs = $this->input->post('facilities');
		if ($facilityIDs) {
			$facilities_updated = FALSE;
			foreach ($facilityIDs as $type_id) {
				// Get old facilities.
				$this->db->where('company_id', $id);
				$this->db->where('company_facility_id', $type_id);

				if ($this->db->count_all_results('companies_facilities') == 0) {
					// Add facilities if it does not exit.
					$this->db->insert('companies_facilities', array(
						'company_id' => $id,
						'company_facility_id' => $type_id
					));
				}
			}
		}
		// Remove other types that are not in post data
		$this->db->where_in('company_id', $id);
		$this->db->where_not_in('company_facility_id', $facilityIDs);
		$this->db->delete('companies_facilities');
		$facilities_updated = $this->db->affected_rows();

		// Upload the user image if it was posted.
		if ($_FILES['userfile']['size'] > 0) {
			$this->load->library('image');

			if ($this->image->upload(array('field'=>'userfile'))) {
				
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
				}
				// Delete previous image.
				if (!empty($company)) $this->image->delete($company[0]->logo);
				// Update the hospital data with logo.
				$update['logo'] = $this->image->filename;
			} else {
				// An error occured while uploading image.
				$this->set_error_message($this->image->error_message());
				return false;
			}
		}
		
		// Upload the preview image if it was posted.
		if (isset($_FILES['preview']) && $_FILES['preview']['size'] > 0)
		{
			$this->load->library('image');

			if ($this->image->upload(array('field'=>'preview')))
			{
				if ($this->input->post('crop_width2') AND $this->input->post('crop_height2'))
				{
					// Crop image to user defined properties.
					$this->image->crop(array(
						'width' => $this->input->post('crop_width2'),
						'height' => $this->input->post('crop_height2'),
						'x_axis' => $this->input->post('crop_x2'),
						'y_axis' => $this->input->post('crop_y2'),
					));
				}

				// Update the hospital info with preview image.
				$update['preview'] = $this->image->filename;
			}
		}

		$this->db->where('id', $id);
		$this->db->update('companies', $update);
		$data_updated = $this->db->affected_rows();

		if ($data_updated OR $types_updated OR $facilities_updated) {

			return true;
		} else {
			// An error occured while updating hospital data.
			$this->set_error_message('Hospital could not be updated.');
			return false;
		}
	}

	public function activate_hospital($id)
	{
		$this->db->where('id', $id);
		$this->db->update('companies', array('active' => 1));

		if ($this->db->affected_rows())
		{
			return array(
				'alert' => array(
					'type' 	  => 'success',
					'message' => 'hospital was activated.'
				)
			);
		}
		else
		{
			return array(
				'alert' => array(
					'type' 	  => 'danger',
					'message' => 'hospital could not be activated.'
				)
			);
		}
	}

	public function deactivate_hospital($id)
	{
		$this->db->where('id', $id);
		$this->db->update('companies', array('active' => 0));

		if ($this->db->affected_rows())
		{
			return array(
				'alert' => array(
					'type' 	  => 'success',
					'message' => 'hospital was deactivated.'
				)
			);
		}
		else
		{
			return array(
				'alert' => array(
					'type' 	  => 'danger',
					'message' => 'hospital could not be deactivated.'
				)
			);
		}
	}

	public function images($id, $count = false)
	{
		$this->db->where('company_id', $id);
		$this->db->from('companies_files');

		if ($count) return $this->db->count_all_results();

		return $this->db->get()->result_array();
	}

	public function upload_hospital_images($company_id)
	{
		$this->load->library('image');

		$images = $this->image->upload_multi(array('field'=>'files'));
		
		if ( !empty($images)) {
			$captions = $this->input->post('captions');

			foreach ($images as $key => $image) {

				$crop_width  = $this->input->post('crop_width');
				$crop_height = $this->input->post('crop_height');
				$x_axis = $this->input->post('crop_x');
				$y_axis = $this->input->post('crop_y');

				if (isset($crop_width[$key]) && isset($crop_height[$key])) {
					// Crop image to user defined properties.
					$dimensions = array(
						'width' => $crop_width[$key],
						'height' => $crop_height[$key],
						'x_axis' => $x_axis[$key],
						'y_axis' => $y_axis[$key],
					);
					$this->image->crop($dimensions);
				}

				$insert['company_id'] = $company_id;
				$insert['url']  = $image['file_name'];

				if (isset($captions[$key])) {
					$insert['caption'] = $captions[$key];
				}

				// Insert hospital images.
				$this->db->insert('companies_files', $insert);
			}
		}

		return $this->db->affected_rows();
	}

	public function update_hospital_image($company_id, $id)
	{
		$this->load->library('image');

		if ($this->input->post('crop_width_'.$id) && $this->input->post('crop_height_'.$id)) {

			// Get image details
			$image = $this->db->select('url')->get_where('companies_files', ['id'=>$id])->result();

			// Crop image to user defined properties.
			$crop = $this->image->crop([
				'filepath' => $image[0]->url,
				'width' =>  $this->input->post('crop_width_'.$id),
				'height' => $this->input->post('crop_height_'.$id),
				'x_axis' => $this->input->post('crop_x_'.$id),
				'y_axis' => $this->input->post('crop_y_'.$id),
			]);
		}
		
		$this->db->where('id', $id);
		$this->db->where('company_id', $company_id);
		$this->db->set('caption', $this->input->post('caption_'.$id));
		$this->db->update('companies_files');
			
		return isset($crop) ? $crop : $this->db->affected_rows();
	}

	public function update_facilities($company_id, $ids)
	{
		$is_updated = false;
		
		foreach ($ids as $type_id) {
			$data = [
				'company_id' => $company_id,
				'company_facility_id' => $type_id
			];
			// Get old facilities.
			$existing = $this->db->where($data)->count_all_results('companies_facilities');
			
			if ($existing == 0) {
				// Add facilities if it does not exit.
				$this->db->insert('companies_facilities', $data);
				$is_updated = $this->db->affected_rows();
			}
		}

		// Remove other types that are not in data
		$this->db->where_in('company_id', $company_id);
		$this->db->where_not_in('company_facility_id', $ids);
		$this->db->delete('companies_facilities');
		($is_updated) ? null : $is_updated = $this->db->affected_rows();

		return $is_updated;
	}

	public function delete_hospital($id)
	{
		// Delete images.
		$this->delete_hospital_images($id);

		$this->db->where('id', $id);
		$this->db->delete('companies');

		return $this->db->affected_rows();
	}

	public function get_doctor_hospital($id)
	{
		$this->db->select('companies.id');
		$this->db->select('companies.name');
		$this->db->select('companies.slug');
		$this->db->from('companies_users');
		$this->db->where('companies_users.user_id', $id);
		$this->db->join('companies', 'companies.id = companies_users.company_id');
		
		return $this->db->get()->result_array();
	}

	public function belongs_to_hospital($id, $user_id)
	{
		$this->db->select('companies.id');
		$this->db->select('companies.name');
		$this->db->select('companies.slug');
		$this->db->from('companies_users');
		$this->db->where('companies.id', $id);
		$this->db->where('companies_users.user_id', $user_id);
		$this->db->join('companies', 'companies.id = companies_users.company_id');
		
		return ($this->db->count_all_results() > 0) ? true : false;
	}

	public function assign_user($id, $user_id)
	{
		$this->db->insert('companies_users', array(
			'company_id'=> $id,
			'user_id' => $user_id,
		));

		return $this->db->affected_rows();
	}

	public function assign_doctors($id, $doctor_ids)
	{
		// Add unique fields to be inserted.
		$insert['company_id'] = $id;
		
		foreach ($doctor_ids as $key => $doctor_id) {
			$insert['user_id'] = $doctor_id;
			// Check if doctors is already there.
			$this->db->limit(1)->where($insert);
			$similar = $this->db->count_all_results('companies_users');

			if ($similar == 0) $this->db->insert('companies_users', $insert);
		}

		return $this->db->affected_rows();
	}

	public function remove_doctors($id, $doctor_ids)
	{
		$target['company_id'] = $id;
		// Number before we remove.
		$before_count = $this->db->count_all('companies_users');
		
		foreach ($doctor_ids as $key => $doctor_id)
		{
			$target['user_id'] = $doctor_id;
			$this->db->delete('companies_users', $target);
		}
		// Number after we remove.
		$after_count = $this->db->count_all('companies_users');

		if ($after_count < $before_count) {
			return true;
		} else {
			$this->set_error_message('Doctor(s) could not be removed.');
			return false;
		}
	}

	public function add_doctor_hospital()
	{
		// Number before we add.
		$before_count = $this->db->count_all('companies_users');

		// Add unique fields to be inserted.
		$insert['doctor_id'] = $id;

		//Delete former record.
		$this->db->delete('companies_users', $insert);

		foreach ($this->input->post('selected') as $key => $id)
		{
			$insert['company_id'] = $id;
			$this->db->insert('companies_users', $insert);
		}

		// Number after we add.
		$after_count = $this->db->count_all('companies_users');

		if ($after_count > $before_count)
		{
			return array(
				'alert' => array(
					'type' 	  => 'success',
					'message' => 'Doctor(s) have been removed.'
				)
			);
		}
		else
		{
			return array(
				'alert' => array(
					'type' 	  => 'danger',
					'message' => 'Doctor(s) could not be removed.'
				)
			);
		}
	}

	public function delete_hospital_image($id)
	{
		$this->load->library('image');
		
		// Number before we add.
		$this->db->where('id', $id);
		$images = $this->db->get('companies_files')->result();

		foreach ($images as $key => $file) {
			
			$this->image->delete($file->url);
			$this->db->where('id', $id);
			$this->db->delete('companies_files');
		}

		return $this->db->affected_rows();
	}

	public function delete_hospital_images($hospital_id)
	{
		$this->load->library('image');

		$this->db->where('company_id', $hospital_id);
		$images = $this->db->get('companies_files')->result();

		foreach ($images as $key => $file) {

			if ($this->image->delete($file->url)) {
				$this->db->where('id', $id);
				$this->db->delete('companies_files');
				return $this->db->affected_rows();
			}  else {
				return false;
			}
		}
	}

	public function get_hospital_facilities($company_id)
	{
		$this->db->select('company_facility_id AS facility_id');
		$this->db->where('company_id', $company_id);
		return $this->db->get('company_facility')->result();
	}

	public function get_hospital_specialities($company_id)
	{
		$this->db->select('doctor_specialities.name, doctor_specialities.code, doctor_specialities.description');
		$this->db->from('companies_users');
		$this->db->where('company_id', $company_id);
		$this->db->group_by('doctors_profiles.speciality_id');
		// Get and Join the specialities
		$this->db->join('doctors_profiles', 'doctors_profiles.user_id = companies_users.user_id');
		$this->db->join('doctor_specialities', 'doctor_specialities.id = doctors_profiles.speciality_id');
		
		return $this->db->get()->result_array();
	}

	public function get_hospital_doctors($company_id, $limit = 0)
	{
		$this->db->limit($limit);

		$this->db->select('doctor_details.reg_no');
		$this->db->select('doctor_specialities.name AS speciality');
		$this->db->select('users.id');
		$this->db->select('users.avatar');
		$this->db->select('users.first_name');
		$this->db->select('users.last_name');
		$this->db->from('companies_users');
		$this->db->where('company_id', $company_id);
		$this->db->group_by('companies_users.doctor_id');

		$this->db->join('doctor_details', 'doctor_details.doctor_id = companies_users.doctor_id');
		$this->db->join('users', 'users.id = companies_users.doctor_id');
		$this->db->join('doctor_specialities', 'doctor_specialities.id = doctor_details.speciality');
		
		return $this->db->get()->result_array();
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
		// Load Library porterstemmmer search algorithm
		$this->load->library('search/porterStemmer');

		// Remove some characters and words.($rmWords and $rmSymbols)
		$rmWords 	= array("the", "and", "a", "to", "of", "in", "i", "is",
		"that", "it", "on", "you", "this", "for", "but",
		"with", "are", "have", "be", "at", "or", "as",
		"was", "so", "if", "out", "not");
		$rmSymbols 	= array('\'s', '.', ',', '\'', '!', '?', '"');

		$searchTerms 	= explode(" ", str_replace($rmSymbols, "", $q));
		$stemmerTerms 	= array();
		foreach ($searchTerms as $searchTerm) {
			$stem = PorterStemmer::Stem($searchTerm);
			if (!in_array($stem, $rmWords)) {
				$stemmerTerms[] = $stem;
			}
		}

		// Cache query
		if (isset($options['cache'])) $this->db->cache_on();

		// Set default options
		if (!isset($options['start'])) $options['start'] = 0;
		
		// We cache because we need to remember our filter/where clauses.
		// This allows us to get both the row count and the query objects in one call
		// otherwise the CI query builder would reset after getting the row count.
		$this->db->start_cache();
		
		$this->db->from('companies company');
		
		$this->db->where('company.active', 1);
		
		$this->db->select('company.id');
		$this->db->select('company.name');
		$this->db->select('company.slug');
		$this->db->select('company.logo');
		$this->db->select('company.preview');
		$this->db->select('company.email');
		$this->db->select('company.phone');
		// Get and Join the doctors count
		$this->db->select('IFNULL(inner_1.doctors, 0) doctors');
		$this->db->join(
			'(
			SELECT company_id, COUNT(*) doctors  
			FROM companies_users docs 
			GROUP BY company_id
			) inner_1',
			'inner_1.company_id = company.id', 'left'
		);
		// Get and Join the facilities count
		$this->db->select('IFNULL(facs.facilities, 0) facilities');
		$this->db->join(
			'(
				SELECT company_id, COUNT(*) facilities
				FROM companies_facilities	
				GROUP BY company_id
			) facs',
			'facs.company_id = company.id', 'left'
		);
		// Get and Join the location
		$this->db->select('locations.id AS location_id');
		$this->db->select('locations.name AS address');
		// Create a string in mysql result for the search engine to match and rate against.
		$searchColumn = 'LOWER(CONCAT(
			company.name, " ",
			company.description, " ",
			company.email, " ",
			company.address, " ",
			locations.name
			))';
		$this->db->select($searchColumn.' AS searchtext');
		
		foreach ($stemmerTerms as $i => $term) {
			if ($i == 0) {
				$this->db->like($searchColumn, $term);
			} else {
				$this->db->or_like($searchColumn, $term);
			}
		}

		//  Joins
		$this->db->join('locations', 'locations.id = company.location_id', 'left');
		
		// Count the items before applying pagination.
		$this->count = $this->db->count_all_results();
		
		// Limit number of objects in the results.
		// This is for pagination purposes.
		if ($options['start'] > 0) $options['start'] = $options['start'] - 1;
		if (isset($options['limit'])) $this->db->limit($options['limit'], $options['start']);
		
		$result = $this->db->get()->result_array();
		
		// Don't forget to stop and clear the cache.
		$this->db->stop_cache();
		$this->db->flush_cache();

		foreach ($result as $key => $value) {
			$result[$key]["match_count"] = 0; // match count
			$result[$key]["score"] = 0; // Accurracy rating

	    	// Remove symbols 
			$words 		= str_replace($rmSymbols, " ", $value['searchtext']);
			$words 		= explode(" ", $words);
			$stem_words = array();
			
			foreach($words as $word) {
				$stem = strtolower(PorterStemmer::Stem($word));

				if(!in_array($stem, $rmWords)) {
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