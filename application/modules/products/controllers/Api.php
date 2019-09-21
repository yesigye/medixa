<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Form validation rules are set in the file:
 * './application/modules/users/config/form_validate.php'
*/
class Api extends MX_Controller {

    function __construct() 
    {
        parent::__construct();

        $this->load->library('json');

        if ( ! $this->input->is_ajax_request()) {
            // Dont allow non ajax requests
            // $this->json->response('unauthorized');
        }
        
        $this->load->helper(['form', 'language']);
        $this->load->library('app');
    }

    /**
	 * Return all users objects.
	 * Filtering options are set by GET parameters.
     * 
     * @return JSON
	 */
    public function index($options = []) {
        $columns = [
            'id',
            'thumbnail',
            'username',
            'email',
            'group',
            'status'
        ];

        if ($order = $this->input->get('order')) {
            $options['order'] = [
                'column' => $columns[$order[0]['column']],
                'dir' => $order[0]['dir']
            ];
        }
        
        if ($search = $this->input->get('search')) $options['search'] = $search['value'];

        $options['start'] = $this->input->get('start') ? $this->input->get('start') : 0;
        $options['limit'] = $this->input->get('length');
        
        $this->load->model('user');
        $users = $this->user->all($options);

        foreach ($users as $key => $user) {
            $html = '<div class="btn-group">';
            $html .= '<a href="'.site_url('admin/users/edit/'.$user['id']).'" class="btn btn-sm btn-primary">'.lang('btn_edit').'</a> ';
            $html .='<button type="button" class="btn btn-sm btn-danger delete-row">'.lang('btn_delete').'</button>';
            $html .='</div>';
            $users[$key]['thumbnail'] = base_url('image/'.$user["thumbnail"]);
            $users[$key]['action'] = $html;
            $users[$key]['group'] = $user['group_name'];
        }
        
        echo $this->json->response('success', [
            'draw' => $this->input->get('draw') ? $this->input->get('order') : 1,
            "recordsTotal" => $this->user->get_users_total(),
            "recordsFiltered" => $this->user->count,
            'data' => $users
        ]);
    }

    /**
	 * Delete a user(s).
	 *
	 * @param  int id of user to be deleted
     * 
	 * @return JSON
	 */
    public function delete($id = null) {
        $this->load->library('ion_auth');
        $this->load->model('user');

        if( ! $this->ion_auth->in_group('admin')) {
            // Non admin is not authorized
            $this->json->response('unauthorized');
        }

        if ($id && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
            // Request to delete a single user.
            if($this->user->delete_user($id)) {
                $this->json->response('deleted');
            }
        }
        elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Request to batch delete users.
            if($this->user->delete_multiple($this->input->post('ids'))) {
                $this->json->response('deleted');
            }
        }
        exit();
    }

    /**
	 * Create a new user.
	 *
	 * @return JSON
	 */
    public function create() {
		$this->load->library(['ion_auth', 'form_validation']);
		// Set validation rules for registering user
		$this->config->load('form_validate');
		$validation_rules = $this->config->item('signup');
        $this->form_validation->set_rules($validation_rules);
        
        $response = [ 'error' => true ];

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
                $response['error'] = false;
                $response['message'] = lang('alert_account_created');
			} else {
                $response['message'] = $this->ion_auth->errors();
            }
		} else {
            $response['message'] = validation_errors();
        }
        
        echo $this->json->response('success', $response);
    }

    /**
	 * Route API requests to users groups.
     * 
     * @return JSON
	 */
    public function categories($method = '', $id = null) {
        
        $this->load->model('category_model');
        
        switch ($method) {
            case 'create':
                $this->_addCategory();
                break;
            case 'assign':
                $this->_assign_group_users($id);
                break;
            case 'remove_assigned':
                $this->_remove_assigned_group_users($id);
                break;
            case 'delete':
                $this->_delete_group($id);
                break;
            case 'users':
                $this->index(['in_group' => $id]);
                break;
            case 'non_users':
                $this->index(['out_group' => $id]);
                break;
            default:
                $this->_getCategories();
                break;
        }
    }

    /**
	 * Return all groups objects.
	 * Filtering options are set by GET parameters.
     * 
     * @return JSON
	 */
    private function _getCategories() {
        $columns = [
          'id', 'name', 'description', 'users_count'
        ];
        
        if ($order = $this->input->get('order')) {
            $options['order'] = [
                'column' => $columns[$order[0]['column']],
                'dir' => $order[0]['dir']
            ];
        }
        
        if ($search = $this->input->get('search')) $options['search'] = $search['value'];

        $options['start'] = $this->input->get('start') ? $this->input->get('start') : 0;
        $options['limit'] = $this->input->get('length');

        $groups = $this->category_model->get_categories_list();

        foreach ($groups as $key => $group) {
            $html = '<div class="btn-group">';
            $html .= '<a href="'.site_url('admin/users/edit_group/'.$group['id']).'" class="btn btn-sm btn-primary">'.lang('btn_edit').'</a> ';
            $html .='<button type="button" class="btn btn-sm btn-danger delete-row">'.lang('btn_delete').'</button>';
            $html .='</div>';
            $groups[$key]['action'] = $html;
        }
        
        echo $this->json->response('success', [
            'draw' => $this->input->get('draw') ? $this->input->get('order') : 1,
            "recordsTotal" => $this->db->count_all('groups'),
            "recordsFiltered" => $this->category_model->total(),
            'data' => $groups
        ]);
    }

    /**
	 * Create a new group.
	 *
	 * @return JSON
	 */
    private function _addCategory() {
		$this->load->library('form_validation');
		// Set validation rules for registering user
		$this->config->load('form_validate');
		$validation_rules = $this->config->item('category_insert');
        $this->form_validation->set_rules($validation_rules);
        
        $response = [ 'error' => true ];

		if ($this->form_validation->run('user_group') == true) {
				
			if($this->category_model->add_category()) {
                $response['error'] = false;
                $response['message'] = lang('alert_success_general');
			} else {
                $response['message'] = lang('alert_sfail_general');
			}
		} else {
            $response['message'] = validation_errors();
        }
        
        echo $this->json->response('success', $response);
    }

    /**
	 * Delete group(s).
	 *
	 * @param  int id of group to be deleted
     * 
	 * @return JSON
	 */
    private function _delete_group($id = null) {
        $this->load->library('ion_auth');

        if( ! $this->ion_auth->in_group('admin')) {
            // Non admin is not authorized
            $this->json->response('unauthorized');
        }

        if ($id && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
            // Request to delete a single group.
            if($this->ion_auth->delete_group($id)) {
                $response['error'] = false;
                $response['message'] = lang('group_delete_successful');
                $this->json->response('deleted');
			} else {
                $response['message'] = $this->ion_auth->errors();
                $this->json->response('fail');
			}
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Request to batch delete groups.
            $deleted = false;

            foreach($this->input->post('ids') as $id) {
                $bool = $this->ion_auth->delete_group($id);
                // Only acknowledge when an item is deleted
                if($bool === true) $deleted = $bool;
            }

            if($deleted) {
                $response['error'] = false;
                $response['message'] = lang('group_delete_successful');
                $this->json->response('deleted');
            } else {
                $response['message'] = $this->ion_auth->errors();
                $this->json->response('fail');
            }
        }
        exit();
    }

    /**
	 * Assign users to group.
	 *
	 * @param  int id of group
     * 
	 * @return JSON
	 */
    private function _assign_group_users($id) {
        $this->load->library('ion_auth');
        $this->load->model('user');

        if( ! $this->ion_auth->in_group('admin')) {
            // Non admin is not authorized
            $this->json->response('unauthorized');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Request to batch delete users.
            foreach($this->input->post('ids') as $userId) {
                $this->ion_auth->add_to_group($id, $userId);
            }
            $this->json->response('deleted');
        }
        exit();
    }

    /**
	 * Assign users to group.
	 *
	 * @param  int id of group
     * 
	 * @return JSON
	 */
    private function _remove_assigned_group_users($id) {
        $this->load->library('ion_auth');
        $this->load->model('user');

        if( ! $this->ion_auth->in_group('admin')) {
            // Non admin is not authorized
            $this->json->response('unauthorized');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Request to batch delete users.
            foreach($this->input->post('ids') as $userId) {
                $this->ion_auth->remove_from_group($id, $userId);
            }
            
            $this->json->response('deleted');
        }
        exit();
    }
}

/* End of file Api.php */
/* Location: ./application/modules/users/controllers/Api.php */