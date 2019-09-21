<?php
class Banners_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		$this->load->config('app');
		$this->app = $this->config->item('app');
	}

	public function insert_banner()
	{
		// Path that the logo image will be uploaded to
		$uploadPath = $this->app['file_path'];

		$this->db->set('title', $this->input->post('title'));

		if ($this->input->post('html_text'))
		{
			$this->db->set('html', $this->input->post('html_text'));
		}
		else
		{
			if ($_FILES['userfile']['size'] > 0)
			{
				// Load the CI upload library
				$config['upload_path'] 		= $uploadPath;
		        $config['allowed_types']	= "gif|jpg|png|jpeg|JPEG|PNG";
		        $config['encrypt_name'] 	= TRUE;
		        $this->load->library('upload', $config);

				if ( ! $this->upload->do_upload())
				{
					// Return an error if it should occur
					$this->flexi_cart_admin->set_error_message($this->upload->display_errors(' ', ' '), 'admin', TRUE);
					$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
					return FALSE;
				}
				else
				{
					// Get file properties data.
					$imageData = $this->upload->data();
					$this->db->set('image', $uploadPath.$imageData['file_name']);
					$this->db->set('caption', $this->input->post('caption'));
				}
			}
		}

		$this->db->set('url', $this->input->post('url'));
		$this->db->set('start_date', $this->input->post('start_date'));
		$this->db->set('end_date', $this->input->post('end_date'));

		$this->db->insert('banners');

		if ($this->db->affected_rows())
		{
			$this->flexi_cart_admin->set_status_message('Banner was added successfully.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}
		else
		{
			// Remove the uploaded image.
			if (isset($imageData)) unlink($uploadPath.$insert['image']);

			$this->flexi_cart_admin->set_error_message('Banner could not be added.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return FALSE;
		}
	}

	public function update_banner()
	{
		// Path that the logo image will be uploaded to
		$uploadPath = $this->app['file_path'];

		$this->db->set('title', $this->input->post('title'));

		if ($this->input->post('html_text'))
		{
			$this->db->set('html', $this->input->post('html_text'));
		}
		else
		{
			if ($_FILES['userfile']['size'] > 0)
			{
				// Load the CI upload library
				$config['upload_path'] 		= $uploadPath;
		        $config['allowed_types']	= "gif|jpg|png|jpeg|JPEG|PNG";
		        $config['encrypt_name'] 	= TRUE;
		        $this->load->library('upload', $config);

				if ( ! $this->upload->do_upload())
				{
					// Return an error if it should occur
					$this->flexi_cart_admin->set_error_message($this->upload->display_errors(' ', ' '), 'admin', TRUE);
					$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
					return FALSE;
				}
				else
				{
					// Get file properties data.
					$imageData = $this->upload->data();
					$this->db->set('image', $uploadPath.$imageData['file_name']);
					$this->db->set('caption', $this->input->post('caption'));
				}
			}
		}

		$this->db->set('url', $this->input->post('url'));
		$this->db->set('start_date', $this->input->post('start_date'));
		$this->db->set('end_date', $this->input->post('end_date'));

		$this->db->update('banners');

		if ($this->db->affected_rows())
		{
			$this->flexi_cart_admin->set_status_message('Banner was updated successfully.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}
		else
		{
			// Remove the uploaded image.
			if (isset($imageData)) unlink($uploadPath.$insert['image']);

			$this->flexi_cart_admin->set_error_message('Banner could not be updated.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return FALSE;
		}
	}

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
			$banner->days_left = count(date_range(date('Y-m-d'), $banner->end_date))-1;
		}
		return $banners;
	}

	public function get_banner_details($id)
	{
		$this->db->where('id', $id);
		$banners = $this->db->get('banners')->result();

		if ( ! empty($banners)) $banners = $banners[0];

		return $banners;
	}

	public function delete_multiple($ids = array())
	{
		// Query banners to be deleted.
		$this->db->where_in('id', $ids);
		$banners_to_delete = $this->db->get('banners')->result();

		foreach ($banners_to_delete as $key => $banner)
		{
			// Remove banner image if it exists on disk.
			if (is_file($banner->image)) unlink($banner->image);
		}

		// Delete database records.
		$this->db->where_in('id', $ids)->delete('banners');

		if ($this->db->affected_rows())
		{
			$this->flexi_cart_admin->set_status_message('Banner(s) were deleted.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}
		$this->flexi_cart_admin->set_status_message('Banner(s) could not be deleted.', 'admin', TRUE);
		$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
		return FALSE;
	}
}
