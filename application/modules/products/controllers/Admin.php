<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller for Users module
 * AJAX Requests are redirected to controller at './application/modules/users/controllers/Api.php'
 *
 * @category User
 * @package  Controllers
 * @author   Ignatius Yesigye <ignatiusyesigye@gmail.com>
 * @license  MIT <http://opensource.org/licenses/MIT>
 * @link     null
 */
class Admin extends MX_Controller
{
	
	function __construct() 
	{
		parent::__construct();

		$this->load->database();
		$this->load->library(['app', 'ion_auth']);

		// Check if admin user is logged in.
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$this->load->model('product_model', 'product');
			$this->load->model('category_model', 'category');
			$this->load->helper(['form', 'language']);
			$this->data = [];
		} else {
			// redirect if user is not requesting login page.
			if ($this->uri->segment(2) !== 'login') {
				// Set the url to redirect to after login.
				$this->session->set_userdata('login_redirect', current_url());
				redirect('admin/login');
			}
		}
	}
	
	/**
	 * View a list of products and perform some CRUD functions through AJAX
	 *
	 * @return response
	 **/
	public function products()
	{
		// Figure out the default user group id
		$this->config->load('users/ion_auth');
		$default_group_id = null;

		// Initialize groups form options
		$group_options = [];
		$groups = $this->ion_auth->groups()->result();
		
		foreach ($groups as $key => $group) {
			$group_options[$group->id] = $group->name;

			if ($group->name == $this->config->item('default_group')) $default_group_id = $group->id;
		}

		// Define form structure to register a user
		$this->data['form_fields'] = [
			'group_id' => [
				'attr' => ['class' => 'form-control form-control-sm'],
				'label' => lang('form_group_name'),
				'type' => 'select',
				'options' => $group_options,
				'selected' => [$default_group_id],
				'required' => true,
			],
			'first_name' => [
				'attr' => ['class' => 'form-control form-control-sm'],
				'label' => lang('form_users_fname'),
				'required' => true,
				'col' => 'col-6'
			],
			'last_name' => [
				'attr' => ['class' => 'form-control form-control-sm'],
				'label' => lang('form_users_lname'),
				'col' => 'col-6'
			],
			'password' => [
				'attr' => ['class' => 'form-control form-control-sm'],
				'label' => lang('form_users_password'),
				'type' => 'password',
				'required' => true,
			],
			'email' => [
				'attr' => ['class' => 'form-control form-control-sm'],
				'label' => lang('form_users_email'),
				'type' => 'text',
				'required' => true,
			],
			'phone' => [
				'attr' => ['class' => 'form-control form-control-sm'],
				'label' => lang('form_users_phone'),
				'type' => 'phone',
			],
			'address' => [
				'attr' => ['class' => 'form-control form-control-sm'],
				'label' => lang('form_users_address'),
			],
		];

		$this->load->view('admin/products_view', $this->data);
	}
	
	/**
	 * Update user details
	 *
	 * @return response
	 **/
	public function edit($user_id)
	{
		// $physicians = modules::load('healthcare/physicians');
		
		$this->load->helper('form');

		$details = $this->user->details($user_id);
		
		$groups = $this->ion_auth->groups()->result();
		$groupSelect = array();
		$groupSelect[''] = '';
		foreach ($groups as $group) {
			$groupSelect[$group->id] = $group->name;
		}
		$userGroups = $this->ion_auth->get_users_groups($user_id)->result();
		$user_groups = array();
		foreach ($userGroups as $group) array_push($user_groups, $group->id);

		if ($this->input->post('sendMessage')) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('message', 'Message', 'required');

			if ($this->form_validation->run()) {
				$this->load->library('email');

				$this->email->from($this->app->no_reply);
				$this->email->to($details['email']);
				$this->email->subject($this->input->post('title'));
				$this->email->message($this->load->view(
					'emails/generic',
					array('message' => $this->input->post('title')
				), true));

				if ($this->email->send()) {
					$this->app->setAlert('An email was sent to the User');
				} else {
					$this->app->setAlert('Email could not be sent', 'error');
				}
				redirect(current_url(), 'redirect');
			} else {
				echo validation_errors();
			}
		}

		if ($this->input->post('updateStatus')) {
			$statusUpdate = $this->ion_auth->update($user_id, array('active' => $this->input->post('status')));
			if ($statusUpdate) {
				$this->app->setAlert('User status has been updated');
			} else {
				$this->app->setAlert('User status could not be changed', 'error');
			}
			redirect(current_url(), 'redirect');
		}

		if ($this->input->post('update')) {
			// Attempt to update user details
			if($this->user->update($user_id)) {
				$this->app->setAlert('User profile has been updated');
				redirect(current_url());
			} else {
				$message = $this->user->error_message ? $this->user->error_message : 'Profile could not be updated';
				$this->app->setAlert($message, 'error');
			}
		}

		// Form fields for user editing
		$this->data['form_fields'] = [
			'avatar' =>	[
				'type'  => 'image',
				'label' => lang('form_users_avatar'),
				'value' => (isset($details['avatar'])) ? $details['avatar'] : null
			],
			'group' =>	[
				'label'    => lang('form_group_name'),
				'type'     => 'select',
				'options'   => $groupSelect,
				'selected' => $user_groups,
				'col' => 'col-md-6'
			],
			'email' => [
				'type'  => 'email',
				'label' => lang('form_users_email'),
				'value' => $details['email'],
				'col' => 'col-md-6'
			],
			'first_name' => [
				'label' => lang('form_users_fname'),
				'value' => $details['first_name'],
				'col' => 'col-md-6'
			],
			'last_name' => [
				'label' => lang('form_users_lname'),
				'value' => $details['last_name'],
				'col' => 'col-md-6'
			],
			'address' => [
				'label' => lang('form_users_address'),
				'value' => $details['address'],
				'col' => 'col-md-6'
			],
			'phone' => [
				'type' => 'phone',
				'label' => lang('form_users_phone'),
				'value' => $details['phone'],
				'col' => 'col-md-6'
			],
			'status' => [
				'label' => lang('form_users_active'),
				'type' => 'checkbox',
				'value' => '1',
				'checked' => set_checkbox('status', '1') ? true : (bool) $details['active']
			],
		];

		// We use the variable "person" because
		// the global "user" is already being used for currently signed in user.
		$this->data['person'] = $details;

		$this->data['user_id'] = $user_id;

		// $this->data['profile'] = $physicians->details($user_id);
		// $this->data['specialities'] = $physicians->specialities();
		$this->load->view('admin/user_update_view', $this->data);
	}

	public function user_profession($user_id)
	{
		$this->load->model('locations/locations_model');
		$this->load->model('hospitals/physicians_model');
		
		$this->load->library('hospitals/doctors');
		
		if ($this->input->post('save')) {
			
			$this->load->library('form_validation');
			// Validation rules are in config file at
			// ./application/modules/hospitals/config/Form_validate.php
			$this->config->load('hospitals/form_validate');
			$validation_rules = $this->config->item('doctor_update');
			$this->form_validation->set_rules($validation_rules);

			if ($this->form_validation->run() == true) {
				
				foreach ($this->input->post() as $key => $value) {
					if (substr($key, 0, 8) == 'locType_') {
						$location_code = $this->input->post($key);
					}
				}
				if (isset($location_code)) {
					// Set location ID
					$_POST['location_id'] = $this->locations_model->get_location_id($location_code);
				}
	
				if ($this->physicians_model->save($user_id)) {
					$this->app->setAlert('Profile has been updated');
				} else {
					$this->app->setAlert('Profile could not be updated', 'error');
				}
				redirect(current_url());
			}
		}

        $this->data['user_id']       = $user_id;
		$this->data['username']      = $this->user->row($user_id, 'username');
		$this->data['locationTypes'] = $this->locations_model->tiers();
		$this->load->view('admin/user_profession_view', $this->data);
	}

	public function user_permissions($user_id)
    {
		$this->load->library('ion_auth_acl');

        if( $this->input->post() && $this->input->post('save')) {
			$hasUpdated = false;
            foreach($this->input->post() as $k => $v) {
                if( substr($k, 0, 5) == 'perm_' ) {
					$permission_id  = str_replace("perm_","",$k);
					
                    if( $v == "X" ) {
						$hasUpdated = $this->ion_auth_acl->remove_permission_from_user($user_id, $permission_id);
					} else {
						$hasUpdated = $this->ion_auth_acl->add_permission_to_user($user_id, $permission_id, $v);
					}
                }
			}
			if ($hasUpdated) {
				$this->app->setAlert('User permissions have been updated');
			} else {
				$this->app->setAlert('User permissions could not be updated');
			}
            redirect(current_url(), 'redirect');
        }

        $user_groups = $this->ion_auth_acl->get_user_groups($user_id);

        $this->data['user_id']            = $user_id;
		$this->data['username']           = $this->user->row($user_id, 'username');
        $this->data['permissions']        = $this->ion_auth_acl->permissions('full', 'perm_key');
        $this->data['group_permissions']  = $this->ion_auth_acl->get_group_permissions($user_groups);
        $this->data['users_permissions']  = $this->ion_auth_acl->build_acl($user_id);

        $this->load->view('users/admin/user_permissions', $this->data);
    }

	/**
	 * Register a new user
	 * Validation rules are set in a config file at ./application/modules/users/config/Form_validation.php
	 *
	 * @return null
	 **/
	private function _addUser()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		// Set validation rules
		$this->config->load('form_validate');
		$validation_rules = $this->config->item('signup');
		$this->form_validation->set_rules($validation_rules);

		if ($this->form_validation->run('signup') == true) {
			$email = strtolower($this->input->post('email'));
			$password = $this->input->post('password');
			$group = [(int)$this->input->post('group_id')];
			$details = [
				'username' => $this->input->post('username') ? $this->input->post('username') : $this->input->post('email'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'address' 	=> $this->input->post('address'),
				'phone' 	=> $this->input->post('phone'),
			];
			$register = $this->ion_auth->register($email, $password, $email, $details, $group);

			if($register) {
				// As the admin, activate user automatically
				$this->ion_auth->activate($register['id']);
				$this->app->setAlert('User was added successfully');
			} else {
				$this->app->setAlert($this->ion_auth->errors(), 'error');
			}
			
			redirect('admin/users');
		}
	}
	
	/**
	 * View a list of user categories
	 *
	 * @return response
	 **/
	public function categories()
	{
		$this->load->helper('form');

		// Initialize categories form options
		$form_options = ['' => lang('form_category_no_parent')];
		$categories = $this->category->get_categories_list();
		
		foreach ($categories as $key => $c) $form_options[$c['id']] = $c['name'];

		$this->data['form_fields'] = array(
			'name' => array(
				'label' => lang('form_category_name'),
			),
			'parent' => array(
				'label' => lang('form_category_parent'),
				'help-text' => lang('form_category_parent_txt'),
				'type' => 'select',
				'options' => $form_options,
				'selected' => [],
			),
		);
		
		$this->load->view('products/admin/categories/categories_list', $this->data);
	}
	
	/**
	 * Edit a user group
	 *
	 * @return response
	 **/
	public function edit_group($group_id = null)
	{
		if($group_id === null) show_404();

		$this->load->library('ion_auth_acl');
		
		$group = $this->ion_auth->group($group_id)->result_array();

		if ($this->input->post('update_group')) {
			$this->load->library('form_validation');
			
			// Set validation rules
			// Validation rules are set by config file at
			// ./application/modules/users/config/Form_validation.php
			$this->config->load('form_validate');
			$validation_rules = $this->config->item('user_group_edit');
			$this->form_validation->set_rules($validation_rules);

			if ($this->form_validation->run('user_group_edit') == true) {
				$group_name = $this->input->post('name');
				$group_description = $this->input->post('description');
				$update = $this->ion_auth->update_group($group_id, $group_name, $group_description);

				if( ! $update) {
					$this->app->setAlert('Group could not be update', 'error');
				} else {
					$this->app->setAlert('Group has been update');
				}
				redirect(current_url(), 'redirect');
			}
		}

		if (!empty($group)) {
			$this->data['form_fields'] = array(
				'name' => array(
					'label' => lang('form_group_name'),
					'value' => $group[0]['name']
				),
				'description' => array(
					'label' => lang('form_group_description'),
					'type' => 'textarea',
					'attr' => ['rows'=>3],
					'value' => $group[0]['description']
				),
			);
		}

		// Groups data.
		$this->data['group_id'] = $group_id;
		$this->data['group'] = (!empty($group)) ? $group[0] : $group;
		
		// display the users groups
		$this->load->view('users/admin/groups/group_edit', $this->data);
	}

	public function group_permissions($group_id = null)
	{
		if($group_id === null) show_404();

		$this->load->library('ion_auth_acl');
		$group = $this->ion_auth->group($group_id)->result_array();
		$groupPerms = $this->ion_auth_acl->get_group_permissions($group_id);
		
		if ($this->input->post('updatePerms')) {
			
			foreach($this->input->post() as $k => $v) {
				
				if( substr($k, 0, 5) == 'perm_' ) {
					$permission_id  =   str_replace("perm_","",$k);
					
                    if( $v == "X" )
					$this->ion_auth_acl->remove_permission_from_group($group_id, $permission_id);
                    else
					$this->ion_auth_acl->add_permission_to_group($group_id, $permission_id, $v);
				}
				$this->app->setAlert('Permission have been updated');
            }
			redirect(current_url(), 'redirect');
		}

		$this->data['group_id'] = $group_id;
		$this->data['group_name'] = !empty($group) ? $group[0]['name'] : '';
		$this->data['groupPermissions'] = $groupPerms;
		$this->data['permissions'] = $this->ion_auth_acl->permissions('full');
		// display the users groups
		$this->load->view('users/admin/groups/group_permissions', $this->data);
	}

	public function group_users($group_id = null)
	{
		if($group_id === null) show_404();

		// Remove exisiting user from group
		if ($this->input->post('removeUsers')) {
			$userIds = $this->input->post('users');
			$removal = false;
			
			foreach ($userIds as $user_id) {
				$removal = $this->ion_auth->remove_from_group($group_id, $user_id);
			}

			if ($removal) {
				$this->app->setAlert('User(s) have been removed');
			} else {
				$this->app->setAlert('User(s) could not be removed', 'error');
			}
			redirect(current_url(), 'redirect');
		}

		$group = $this->ion_auth->group($group_id)->result_array();
		$this->data['group_id'] = $group_id;
		$this->data['group_name'] = !empty($group) ? $group[0]['name'] : '';
		// display the users groups
		$this->load->view('users/admin/groups/group_users', $this->data);
	}
	
	public function permissions()
	{
		$this->load->library(['form_validation', 'ion_auth_acl']);
		
		$this->data['insertRows']  = 1;
		
		// Attempt to add permissions
		if ($this->input->post('addPerm')) {
			$insertData = $this->input->post('insert');
			$this->data['insertRows'] = count($insertData);
			// Set validation rules.
			$i = 1; // Identify rows using standard counting from 1 rather than 0.
			foreach($insertData as $id => $row) {
				$this->form_validation->set_rules('insert['.$id.'][permKey]', 'Key', 'required|is_unique[permissions.perm_key]');
				$this->form_validation->set_rules('insert['.$id.'][permName]', 'Name', 'required');
				$i++;
			}
			// Attempt to validate fields.
			if ($this->form_validation->run()) {
				$addCount = 0;
				foreach ($insertData as $key => $row) {
					if ($this->ion_auth_acl->create_permission($row['permKey'], $row['permName'])) {
						$addCount++;
					}
				}
				if ($addCount > 0) {
					$this->app->setAlert($addCount.' permissions were created');
				} else {
					$this->app->setAlert('Permsissions could not be created', 'error');
				}
				redirect(current_url(), 'redirect');
			}
		}

		// Attempt to delete permissions
		if($this->input->post('delete_selected')) {
			$permIds = $this->input->post('selected');
			$delCount = 0;
			foreach ($permIds as $permId) {
				if( $this->ion_auth_acl->remove_permission($permId)) {
					$delCount++;
				}
			}
			if ($delCount > 0) {
				$this->app->setAlert($delCount.' permissions were deleted');
			} else {
				$this->app->setAlert('Permsissions could not be deleted', 'error');
			}
			redirect(current_url(), 'redirect');
		}

		$this->data['permissions'] = $this->ion_auth_acl->permissions('full');
		$this->data['add_fields']  = $this->load->view('form_fields', array(
			'form_fields' => array(
				array(
					'field' => 'perm_key',
					'label' => 'Key',
				),
				array(
					'field' => 'perm_name',
					'label' => 'Name',
				),
			),
			'cols' => 'col-sm-12'
		), true);
		$this->load->view('users/admin/permissions', $this->data);
	}

	public function deletePerm($perm_id)
	{
		$this->load->library(['ion_auth_acl']);
		
		if( $this->ion_auth_acl->remove_permission($perm_id)) {
			$this->app->setAlert('Permission has been deleted');
			redirect("admin/users/permissions", 'refresh');
		} else {
			$this->app->setAlert($this->ion_auth_acl->messages(), 'error');
		}
	}
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */