<?php
class Banners_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	/**
	 * Insert a banner object.
	 *
	 * @return boolean
	 **/
	public function insert_banner()
	{
		$this->db->set('title', $this->input->post('title'));

		if ($this->input->post('html_text'))
		{
			$this->db->set('html', $this->input->post('html_text'));
		}
		else
		{
			// Upload the user image if it was posted.
			if ($_FILES['userfile']['size'] > 0)
			{
				$this->load->library('image');

				if ($this->image->upload(array('field' => 'userfile')))
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
					}

					// Update the user profile with avatar.
					$this->db->set('image', $this->image->filename);
					$this->db->set('caption', $this->input->post('caption'));
				}
				else
				{
					// Set an error if it should occur
					modules::run('notify/alerts/set_message', $this->image->error_message, 'admin', 'error');

					return false;
				}
			}
		}

		$this->db->set('url', $this->input->post('url'));
		$this->db->set('start_date', $this->input->post('start_date'));
		$this->db->set('end_date', $this->input->post('end_date'));

		$this->db->insert('banners');

		if ($this->db->affected_rows())
		{
			// Set a success message.
			$message = 'Banner was added successfully.';
			modules::run('notify/alerts/set_message', $message, 'admin', 'status');

			return true;
		}
		else
		{
			// Remove the uploaded image.
			if (isset($imageData)) unlink($uploadPath.$insert['image']);

			$banner = $this->get_banner_details($this->db->insert_id());

			$message = 'Banner '.anchor('admin/banners/'.$banner->id, $banner->title).' could not be added.';
			modules::run('notify/alerts/set_message', $message, 'admin', 'status');
			
			return false;
		}
	}

	/**
	 * Update a banner object.
	 *
	 * @return boolean
	 **/
	public function update_banner($id)
	{
		// Get the current banner, we shall need this data later.
		$banner = $this->get_banner_details($id);

		$update['title'] = $this->input->post('title');

		if ($this->input->post('html_text'))
		{
			$update['html'] = $this->input->post('html_text');
		}
		else
		{
			// Upload the user image if it was posted.
			if ($_FILES['userfile']['size'] > 0)
			{
				$this->load->library('image');

				if ($this->image->upload(array('field' => 'userfile')))
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
					}
					// Update the user profile with avatar.
					$update['image'] = $this->image->filename;
				}
				else
				{
					// Set an error if it should occur
					modules::run('notify/alerts/set_message', $this->image->error_message, 'admin', 'error');

					return false;
				}
			}
		}

		if ($this->input->post('caption')) $update['caption'] = $this->input->post('caption');
		$update['url'] = $this->input->post('url');
		$update['start_date'] = $this->input->post('start_date');
		$update['end_date'] = $this->input->post('end_date');
		
		$this->db->where('id', $id);
		$this->db->update('banners', $update);

		if ($this->db->affected_rows())
		{
			// Remove old banner image if it exists on disk.
			$this->load->library('image');
			$this->image->delete($banner->image);
			
			$message = 'Banner has been updated.';
			modules::run('notify/alerts/set_message', $message, 'admin', 'status');
			return true;
		}
		else
		{
			// Remove the uploaded image.
			$this->load->library('image');
			
			if ($file = $this->image->filename)
			{
				$this->image->delete($file);
			}

			$message = 'Banner could not be updated.';
			modules::run('notify/alerts/set_message', $message, 'admin', 'error');
			return false;
		}
	}

	/**
	 * Return banner objects.
	 *
	 * @return object
	 **/
	public function get_banners($options = array())
	{
		$this->load->helper('date');
		$this->db->order_by('id', 'DESC');

		if (isset($options['limit'])) $this->db->limit($options['limit']);

		if (isset($options['running'])) $this->db->where('banners.end_date >=', date('Y-m-d'));

		$banners = $this->db->get('banners')->result();

		foreach ($banners as $key => $banner)
		{
			// Subtract this very day.
			$banner->days_left  = time_elapsed($banner->end_date);
			$banner->is_expired = is_expired($banner->end_date);
		}
		return $banners;
	}

	/**
	 * Return a banner object.
	 *
	 * @return object
	 **/
	public function get_banner_details($id)
	{
		$this->db->where('id', $id);
		$banners = $this->db->get('banners')->result();

		if ( ! empty($banners)) $banners = $banners[0];

		return $banners;
	}

	/**
	 * Delete multiple banner objects.
	 *
	 * @return boolean
	 **/
	public function delete_multiple($ids = array())
	{
		// Query banners to be deleted.
		$this->db->where_in('id', $ids);
		$banners_to_delete = $this->db->get('banners')->result();

		$count = 0;
		foreach ($banners_to_delete as $key => $banner)
		{
			$count++;
			// Remove banner image if it exists on disk.
			$this->load->library('image');
			$this->image->delete($banner->image);
		}

		// Delete database records.
		$this->db->where_in('id', $ids)->delete('banners');

		if ($this->db->affected_rows())
		{
			$message = $count.' banner'.(($count > 1) ? 's were' : 'was').' deleted.';
			modules::run('notify/alerts/set_message', $message, 'admin', 'status');
			return TRUE;
		}

		$message = 'Banner(s) could not be deleted.';
		modules::run('notify/alerts/set_message', $message, 'admin', 'error');
		return FALSE;
	}
}
