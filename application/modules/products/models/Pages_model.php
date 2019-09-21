<?php
class Pages_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		$this->load->config('app');
		$this->app = $this->config->item('app');
	}

	public function get_pages($id = NULL)
	{
		$this->db->select('id, slug, name');

		if ($id)
		{
			$this->db->select('body');

			(ctype_digit($id)) ? $this->db->where('pages.id', $id) : $this->db->where('pages.slug', $id);
		}
		
		$pages = $this->db->get('pages')->result();
		
		if ($id)
		{
			if ( ! empty($pages))
			{
				$pages = $pages[0];
			}
		}
		return $pages;
	}

	public function add_page()
	{
		$this->db->set('name', $this->input->post('name'));
		$this->db->set('slug', url_title($this->input->post('name')));
		$this->db->set('body', $this->input->post('body'));
		$this->db->insert('pages', $insert);

		if ($this->db->affected_rows())
		{
			$this->flexi_cart_admin->set_status_message('Page has been added.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}
		else
		{
			$this->flexi_cart_admin->set_error_message('Page could not be added.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return FALSE;
		}
	}

	public function update_page($id)
	{
		$this->db->where('id', $id);
		$this->db->set('name', $this->input->post('name'));
		$this->db->set('slug', url_title($this->input->post('name')));
		$this->db->set('body', $this->input->post('body'));
		$this->db->update('pages', $insert);

		if ($this->db->affected_rows())
		{
			$this->flexi_cart_admin->set_status_message('Page has been updated.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}
		else
		{
			$this->flexi_cart_admin->set_error_message('Page could not be update.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return FALSE;
		}
	}

	public function delete_multiple($ids = array())
	{
		$this->db->where_in('id', $ids)->delete('pages');

		if ($this->db->affected_rows())
		{
			$this->flexi_cart_admin->set_status_message('Page(s) have been deleted.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}
		$this->flexi_cart_admin->set_status_message('Page(s) could not be deleted.', 'admin', TRUE);
		$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
		return FALSE;
	}
}
