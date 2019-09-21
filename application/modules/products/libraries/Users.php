<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users
{

	/**
	 * __get
	 *
	 * Enables the use of CI super-global without having to define an extra variable.
	 *
	 * I can't remember where I first saw this, so thank you if you are the original author. -Militis
	 *
	 * @param	$var
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
	}

	/**
	 * all
	 *
	 * @param Array $options filters for querying users
	 * @return Array
	 **/
	public function all($options = array())
	{
		$this->load->model('users/user');

		$page_limit = $this->app->pageLimit;

		if (!isset($options['limit'])) $options['limit'] = $page_limit;

		if ($this->input->get('group')) $options['group'] = $this->input->get('group');

		if ($this->input->get('u_not_group')) $options['exclude_group'] = $this->input->get('u_not_group');

		if (!isset($options['limit'])) $options['limit'] = $page_limit;

		if ($this->input->get('u_addr')) $options['address_id'] = $this->input->get('u_addr');

		if ($this->input->get('u_spec')) $options['speciality'] = $this->input->get('u_spec');

		if ($this->input->get('az')) $options['order'] = $this->input->get('az');

		if ($this->input->get('u_fac')) $options['fac'] = $this->input->get('u_fac');

		if ($this->input->get('u_mobile')) $options['mobile'] = $this->input->get('u_mobile');

		if ($this->input->get('status')) $options['status'] = $this->input->get('status');

		if (!isset($options['search'])) {

			if ($this->input->post('search'))
			{
				redirect(current_url().($_SERVER['QUERY_STRING'].($_SERVER['QUERY_STRING'] ? '&u_query=' : '?u_query=').$this->input->post('q')));
			}
			
			if ($this->input->get('u_query')) $options['search'] = $this->input->get('u_query');
		}

		if ($page_num = $this->input->get('per_page')) {
			$options['start'] = ( ($page_num*$options['limit'])-$options['limit'] ) + 1;
		} else {
			$options['start'] = 0;
		}

		$users = $this->user->all($options);
		$result_total = $this->user->count;

		// Add some pagination to this page.
		$this->load->library('pagination');

		// Construct Url
		$page_url = $this->input->get('per_page') ? preg_replace('/(^|&)per_page=[^&]*/', '', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'];

		$config['base_url'] = current_url().'?'.$page_url;
		$config['page_query_string'] = TRUE;
		$config['per_page'] = $page_limit;
		$config['total_rows'] = $result_total;
		if (isset($options['uri_segment'])) {
			$config['query_string_segment'] = $options['uri_segment'];
		}
		// $config['num_links']  = round($config['total_rows'] / $config['per_page']);
		$this->pagination->initialize($config);

		return array(
			'rows' => $users,
			'total' => $result_total,
			'pagination' => $this->pagination->create_links(),
		);
	}
}