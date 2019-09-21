<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Store
*
* Author: Ignatius Yesigye
*		  ignatiusyesigye@gmail.com
*/

class Store
{
	/**
	 * __construct
	 */
	public function __construct()
	{
		$this->load->database();

		$this->data = array();
		$this->load->config('app');
		$this->data['app'] = $this->config->item('app');
	}

	/**
	 * __get
	 *
	 * Enables the use of CI super-global without having to define an extra variable.
	 *
	 * I can't remember where I first saw this, so thank you if you are the original author. -Militis
	 *
	 * @access	public
	 * @param	$var
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
	}

	/**
	 * owner
	 *
	 * @access	public
	 * @return object
	 **/
	public function owner()
	{
		$this->load->model('users_model');
		return $this->users_model->admin();
	}

	/**
	 * menu
	 *
	 * @access	public
	 * @return object
	 **/
	public function menu($limit = NULL, $random = FALSE)
	{
		if ($limit) $this->db->limit($limit);
		
		if ($random) $this->db->order_by('id', 'RANDOM');

		$this->db->select('id, name, slug');
		$this->db->where('parent_id', NULL);
		return $this->db->get('product_categories')->result();
	}

	/**
	 * pages
	 *
	 * @access	public
	 * @return object
	 **/
	public function pages()
	{
		$this->db->select('id, name, slug');
		return $this->db->get('pages')->result();
	}

	/**
	 * app
	 *
	 * @access	public
	 * @return Array
	 **/
	public function app($index = NULL)
	{
		$this->load->config('app');
		$app_config = $this->config->item('app');

		if ($index)
		{
			if (isset($app_config[$index]))
				return $app_config[$index];
		}
		return $app_config;
	}

	/**
	 * settings
	 *
	 * @access	public
	 * @return Array
	 **/
	public function settings($value = '')
	{
		$this->load->database();
		$result = $this->db->get('cart_config')->result();
		if ($result)
		{
			switch ($value) {
				case 'upload_limit':
					return $result[0]->config_user_files_limit;
					break;
				case 'pagination_limit':
					return $result[0]->config_pagination_limit;
					break;
				default:
					return $result[0]->config_user_files_limit;
					break;
			}
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * products
	 *
	 * @access	public
	 * @return Array
	 **/
	public function products($product_options = array())
	{
		$this->load->model(array('product_model', 'category_model'));
		
		$page_limit = (isset($product_options['limit'])) ? $product_options['limit'] : $this->settings('pagination_limit');

		// Define options to query products.
		$product_options['limit'] = $page_limit;

		if ($this->input->get('order')) $product_options['order'] = $this->input->get('order');

		if ($this->input->get('cate')) $product_options['category_id'] = $this->input->get('cate');

		if ($this->input->get('price')) $product_options['price_range'] = $this->input->get('price');

		if ($this->input->get('seller')) $product_options['seller'] = $this->input->get('seller');

		if ($this->input->post('price_range'))
		{
			// Update query URI string and redirect to back here.

			// Remove lowest price or highest price options from the url.
			//  They conflict with price range.
			if ($this->input->get('order') !== 'lowpx')
			{
				$query_uri = current_url().'?'.preg_replace('/(^|&)order=[^&]*/', '', $_SERVER['QUERY_STRING']);
			}
			elseif ($this->input->get('order') !== 'hghpx')
			{
				$query_uri = current_url().'?'.preg_replace('/(^|&)order=[^&]*/', '', $_SERVER['QUERY_STRING']);
			}

			redirect($query_uri.'&price='.$this->input->post('price'), 'refresh');
		}

		if ($this->input->post('p_search'))
		{
			redirect(current_url().($_SERVER['QUERY_STRING'].($_SERVER['QUERY_STRING'] ? '&p_query=' : '?p_query=').$this->input->post('p_query')));
		}
		
		if ($this->input->get('p_query')) $product_options['search'] = $this->input->get('p_query');

		if ($page_num = $this->input->get('per_page'))
		{
			$product_options['start'] = ( ($page_num*$product_options['limit'])-$product_options['limit'] ) + 1;
		}
		else
		{
			$product_options['start'] = 0;
		}

		$products_meta = $this->product_model->get_products($product_options);
		$products = $products_meta->products;
		$result_total = $products_meta->count;

		// Add some pagination to this page.
		$this->load->library('pagination');

		// Construct Url
		$page_url = $this->input->get('per_page') ? preg_replace('/(^|&)per_page=[^&]*/', '', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'];

		$config['base_url'] = current_url().'?'.$page_url;
		$config['page_query_string'] = TRUE;
		$config['per_page'] = $page_limit;
		$config['total_rows'] = $result_total;
		$config['num_links']  = 4;
		$config['use_page_numbers']  = TRUE;
		$config['full_tag_open']  = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open']   = '<li>';
		$config['num_tag_close']  = '</li>';
		$config['cur_tag_open']   = '<li class="active"><a>';
		$config['cur_tag_close']  = '</a></li>';
		$config['prev_tag_open']  = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['prev_link'] 	  = 'prev';
		$config['next_link'] 	  = 'next';
		$config['next_tag_open']  = '<li class="next">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open']  = '<li class="last">';
		$config['last_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		return array(
			'rows' => $products,
			'total' => $result_total,
			'pagination' => $this->pagination->create_links(),
		);
	}

	/**
	 * settings
	 *
	 * @access	public
	 * @return Array
	 **/
	public function users($options = array())
	{
		$this->load->model('users_model');

		$page_limit = $this->settings('pagination_limit');

		// Define options to query doctors.

		if (!isset($options['limit'])) $options['limit'] = $page_limit;

		if ($this->input->get('u_addr')) $options['address_id'] = $this->input->get('u_addr');

		if ($this->input->get('u_spec')) $options['speciality'] = $this->input->get('u_spec');

		if ($this->input->get('u_order')) $options['order'] = $this->input->get('u_order');

		if ($this->input->get('u_fac')) $options['fac'] = $this->input->get('u_fac');

		if ($this->input->get('u_mobile')) $options['mobile'] = $this->input->get('u_mobile');

		if ($this->input->get('u_status')) $options['status'] = $this->input->get('u_status');

		if (!isset($options['search']))
		{
			if ($this->input->post('search'))
			{
				redirect(current_url().($_SERVER['QUERY_STRING'].($_SERVER['QUERY_STRING'] ? '&u_query=' : '?u_query=').$this->input->post('q')));
			}
			
			if ($this->input->get('u_query')) $options['search'] = $this->input->get('u_query');
		}

		if ($page_num = $this->input->get('per_page'))
		{
			$options['start'] = ( ($page_num*$options['limit'])-$options['limit'] ) + 1;
		}
		else
		{
			$options['start'] = 0;
		}

		$users_meta = $this->users_model->users($options);
		$users = $users_meta->users;
		$result_total = $users_meta->count;

		// Add some pagination to this page.
		$this->load->library('pagination');

		// Construct Url
		$page_url = $this->input->get('per_page') ? preg_replace('/(^|&)per_page=[^&]*/', '', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'];

		$config['base_url'] = current_url().'?'.$page_url;
		$config['page_query_string'] = TRUE;
		$config['per_page'] = $page_limit;
		$config['total_rows'] = $result_total;
		// $config['num_links']  = round($config['total_rows'] / $config['per_page']);
		$config['num_links']  = 4;
		$config['use_page_numbers']  = TRUE;
		$config['full_tag_open']  = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open']   = '<li>';
		$config['num_tag_close']  = '</li>';
		$config['cur_tag_open']   = '<li class="active"><a>';
		$config['cur_tag_close']  = '</a></li>';
		$config['prev_tag_open']  = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['prev_link'] 	  = 'prev';
		$config['next_link'] 	  = 'next';
		$config['next_tag_open']  = '<li class="next">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open']  = '<li class="last">';
		$config['last_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		return array(
			'rows' => $users,
			'total' => $result_total,
			'pagination' => $this->pagination->create_links(),
		);
	}
}
