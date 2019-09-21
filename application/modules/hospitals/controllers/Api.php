<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* 
* TODO: Only Admin and One Manager User should perform C.R(everyone).U.D
* Currently, any manager can delete any hospitals data
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
        $this->load->model(['hospitals_model', 'types_model', 'specialities_model']);
        
		$this->load->library('users/ion_auth');
    }

    /**
	 * Return all hospitals.
	 * Filtering options are set by GET parameters.
     * 
     * @return JSON
	 */
    public function index() {
        $this->load->helper('form');

        $columns = ['id', 'logo', 'name', 'email', 'physicians'];

        if ($order = $this->input->get('order')) {
            $options['order'] = [
                'column' => $columns[$order[0]['column']],
                'dir' => $order[0]['dir']
            ];
        }
        
        if ($search = $this->input->get('search')) $options['search'] = $search['value'];

        $options['start'] = $this->input->get('start') ? $this->input->get('start') : 0;
        $options['limit'] = $this->input->get('length');
        $options['ignore_status'] = true;
        
        $hospitals = $this->hospitals_model->get_hospitals($options);

        foreach ($hospitals as $key => $hospital) {
            $link = site_url('admin/hospitals/edit/'.$hospital['id']);
            $html = '<div class="btn-group">';
            $html .= "<a href=\"$link\" class=\"btn btn-sm btn-primary\">".lang('btn_edit').'</a> ';
            $html .='<button type="button" class="btn btn-sm btn-danger delete-row">'.lang('btn_delete').'</button>';
            $html .='</div>';
            
            $hospitals[$key]['logo'] = base_url('image/'.$hospital["logo"]);
            $hospitals[$key]['action'] = $html;
        }
        
        echo $this->json->response('success', [
            'draw' => $this->input->get('draw') ? $this->input->get('order') : 1,
            "recordsTotal" => $this->db->count_all_results('companies'),
            "recordsFiltered" => $this->hospitals_model->count,
            'data' => $hospitals
        ]);
    }

    /**
	 * Return all hospital types.
	 * Filtering options are set by GET parameters.
     * 
     * @return JSON
	 */
    public function types($list = null) {
        $this->load->helper('form');

        $columns = ['id', 'parent_id', 'name', 'description'];

        if ($order = $this->input->get('order')) {
            $options['order'] = [
                'column' => $columns[$order[0]['column']],
                'dir' => $order[0]['dir']
            ];
        }
        
        if ($search = $this->input->get('search')) $options['search'] = $search['value'];

        $options['start'] = $this->input->get('start') ? $this->input->get('start') : 0;
        $options['limit'] = $this->input->get('length');
        
        $types = $this->types_model->get_types($options);

        if($list == null) {
            $drop_opts = [null => ''];
            foreach ($types as $value) $drop_opts[$value['id']] = $value['name'];
            
            foreach ($types as $key => $type) {
                $types[$key]['name'] = $this->load->view('form_fields', [
                    'fields' => [
                        "update[".$type['id']."][name]" => ['value' => $type['name']]
                    ]
                ], true);
                $types[$key]['code'] = $this->load->view('form_fields', [
                    'fields' => [
                        "update[".$type['id']."][code]" => [
                            'value' => $type['code'],
                            'attr' => ['style' => 'width:100px']
                        ]
                    ]
                ], true);
                $types[$key]['parent'] = $this->load->view('form_fields', [
                    'fields' => [
                        "update[".$type['id']."][parent_id]" => [
                            'type' => 'select',
                            'options' => $drop_opts,
                            'selected' => $type['parent_id'],
                        ]
                    ]
                ], true);
                $types[$key]['description'] = $this->load->view('form_fields', [
                    'fields' => [
                        "update[".$type['id']."][description]" => ['type' => 'textarea', 'value' => $type['description']]
                    ]
                ], true);
            }
            
            echo $this->json->response('success', [
                'draw' => $this->input->get('draw') ? $this->input->get('order') : 1,
                "recordsTotal" => $this->db->count_all_results('company_types'),
                "recordsFiltered" => $this->types_model->count,
                'data' => $types
            ]);
        } else {
            echo $this->json->response('success', $types);
        }
    }

    /**
	 * Return all hospital types.
	 * Filtering options are set by GET parameters.
     * 
     * @return JSON
	 */
    public function facilities($list = null) {
        $this->load->helper('form');
        $columns = ['id', 'code', 'name', 'description'];

        if ($order = $this->input->get('order')) {
            $options['order'] = [
                'column' => $columns[$order[0]['column']],
                'dir' => $order[0]['dir']
            ];
        }
        
        if ($search = $this->input->get('search')) $options['search'] = $search['value'];

        $options['start'] = $this->input->get('start') ? $this->input->get('start') : 0;
        $options['limit'] = $this->input->get('length');
        
        $options['inherit'] = true;
        $types = $this->types_model->facilities($options);

        if($list == null) {
            $drop_opts = [null => ''];
            foreach ($types as $value) $drop_opts[$value['id']] = $value['name'];
            
            foreach ($types as $key => $type) {
                $link = site_url('admin/hospitals/facilities/'.$type['id']);

                $types[$key]['name'] = $this->load->view('form_fields', [
                    'fields' => [
                        "update[".$type['id']."][name]" => ['value' => $type['name']]
                    ]
                ], true);

                $types[$key]['code'] = $this->load->view('form_fields', [
                    'fields' => [
                        "update[".$type['id']."][code]" => [
                            'value' => $type['code'],
                            'attr' => ['style' => 'width:100px']
                        ]
                    ]
                ], true);
                
                $types[$key]['description'] = $this->load->view('form_fields', [
                    'fields' => [
                        "update[".$type['id']."][description]" => ['type' => 'textarea', 'value' => $type['description']]
                    ]
                ], true);
            }
            
            echo $this->json->response('success', [
                'draw' => $this->input->get('draw') ? $this->input->get('order') : 1,
                "recordsTotal" => $this->db->count_all_results('company_types'),
                "recordsFiltered" => $this->types_model->count,
                'data' => $types
            ]);
        } else {
            echo $this->json->response('success', $types);
        }
    }

    /**
	 * Return all hospital types.
	 * Filtering options are set by GET parameters.
     * 
     * @return JSON
	 */
    public function specialties($list = null) {
        $this->load->helper('form');

        $columns = ['id', 'name', 'description'];

        if ($order = $this->input->get('order')) {
            $options['order'] = [
                'column' => $columns[$order[0]['column']],
                'dir' => $order[0]['dir']
            ];
        }
        
        if ($search = $this->input->get('search')) $options['search'] = $search['value'];

        $options['start'] = $this->input->get('start') ? $this->input->get('start') : 0;
        $options['limit'] = $this->input->get('length');
        
        $options['inherit'] = true;
        $types = $this->specialities_model->get_specialists($options);

        if($list == null) {
            $drop_opts = [null => ''];
            foreach ($types as $value) $drop_opts[$value['id']] = $value['name'];
            
            foreach ($types as $key => $type) {
                $types[$key]['name'] = $this->load->view('form_fields', [
                    'fields' => [
                        "update[".$type['id']."][name]" => ['value' => $type['name']]
                    ]
                ], true);
                
                $types[$key]['description'] = $this->load->view('form_fields', [
                    'fields' => [
                        "update[".$type['id']."][description]" => ['type' => 'textarea', 'value' => $type['description']]
                    ]
                ], true);
            }
            
            echo $this->json->response('success', [
                'draw' => $this->input->get('draw') ? $this->input->get('order') : 1,
                "recordsTotal" => $this->db->count_all('doctor_specialities'),
                "recordsFiltered" => $this->specialities_model->count,
                'data' => $types
            ]);
        } else {
            echo $this->json->response('success', $types);
        }
    }

    /**
	 * Delete a Facility(s).
	 *
	 * @param  int id of facility to be deleted
     * 
	 * @return JSON
	 */
    public function deleteFacilities($id = null) {
        if(! $this->ion_auth->in_group('admin') && ! $this->ion_auth->in_group('manager')) {
            // Non admin or manager is not authorized
            $this->json->response('unauthorized');
        }

        if ($id && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
            // Request to delete a single location tier.
            if($this->types_model->deleteFacilities([$id])) {
                $response['error'] = false;
				$response['message'] = lang('alert_success_general');
				$this->json->response('deleted');
			} else {
				$response['message'] = lang('alert_fail_general');
				$this->json->response('fail');
			}
        }
        elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Request to batch delete location tiers.
            if($this->types_model->deleteFacilities($this->input->post('ids'))) {
                $response['error'] = false;
				$response['message'] = lang('alert_success_general');
				$this->json->response('deleted');
			} else {
				$response['message'] = lang('alert_fail_general');
				$this->json->response('fail');
			}
        }
        exit();
    }

    /**
	 * Delete a hospital(s).
	 *
	 * @param  int id of hospital to be deleted
     * 
	 * @return JSON
	 */
    public function delete($id = null) {
		$this->load->library('users/ion_auth');

        if( ! $this->ion_auth->in_group('admin')) {
            // Non admin is not authorized
            $this->json->response('unauthorized');
        }

        if ($id && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
            // Request to delete a single location tier.
            if($this->hospitals_model->delete_hospital($id)) {
                echo 'yessssssss';
                $response['error'] = false;
				$response['message'] = lang('alert_success_general');
				$this->json->response('deleted');
			} else {
                echo 'noooooooooo';
				$response['message'] = lang('alert_fail_general');
				$this->json->response('fail');
			}
        }
        elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Request to batch delete location tiers.
            $deleted = false;
            foreach ($this->input->post('ids') as $key => $id) {
                $r = $this->hospitals_model->delete_hospital($id);
                $deleted = $deleted ? $deleted : $r;
            }
            if($deleted) {
                $response['error'] = false;
				$response['message'] = lang('alert_success_general');
				$this->json->response('deleted');
			} else {
				$response['message'] = lang('alert_fail_general');
				$this->json->response('fail');
			}
        }
        exit();
    }

    /**
	 * Delete a Type(s).
	 *
	 * @param  int id of type to be deleted
     * 
	 * @return JSON
	 */
    public function deleteTypes($id = null) {
        if(! $this->ion_auth->in_group('admin') && ! $this->ion_auth->in_group('manager')) {
            // Non admin or manager is not authorized
            $this->json->response('unauthorized');
        }

        if ($id && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
            // Request to delete a single location tier.
            if($this->types_model->delete_types([$id])) {
                $response['error'] = false;
				$response['message'] = lang('alert_success_general');
				$this->json->response('deleted');
			} else {
				$response['message'] = lang('alert_fail_general');
				$this->json->response('fail');
			}
        }
        elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Request to batch delete location tiers.
            if($this->types_model->delete_types($this->input->post('ids'))) {
                $response['error'] = false;
				$response['message'] = lang('alert_success_general');
				$this->json->response('deleted');
			} else {
				$response['message'] = lang('alert_fail_general');
				$this->json->response('fail');
			}
        }
        exit();
    }

    /**
	 * Delete a Specialty(s).
	 *
	 * @param  int id of specialty to be deleted
     * 
	 * @return JSON
	 */
    public function deleteSpecialty($id = null) {
        if(! $this->ion_auth->in_group('admin') && ! $this->ion_auth->in_group('manager')) {
            // Non admin or manager is not authorized
            $this->json->response('unauthorized');
        }

        if ($id && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
            // Request to delete a single location tier.
            if($this->specialities_model->delete_specialities([$id])) {
                $response['error'] = false;
				$response['message'] = lang('alert_success_general');
				$this->json->response('deleted');
			} else {
				$response['message'] = lang('alert_fail_general');
				$this->json->response('fail');
			}
        }
        elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Request to batch delete location tiers.
            if($this->specialities_model->delete_specialities($this->input->post('ids'))) {
                $response['error'] = false;
				$response['message'] = lang('alert_success_general');
				$this->json->response('deleted');
			} else {
				$response['message'] = lang('alert_fail_general');
				$this->json->response('fail');
			}
        }
        exit();
    }

    /**
	 * Delete image(s).
	 *
	 * @param  int id of image to be deleted
     * 
	 * @return JSON
	 */
    public function deleteImage($id = null) {
        if(! $this->ion_auth->in_group('admin') && ! $this->ion_auth->in_group('manager')) {
            // Non admin or manager is not authorized
            $this->json->response('unauthorized');
        }

        if ($id && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
            // Request to delete a single image.
            if($this->hospitals_model->delete_hospital_image($id)) {
                $response['error'] = false;
				$response['message'] = lang('alert_success_general');
				$this->json->response('deleted');
			} else {
				$response['message'] = lang('alert_fail_general');
				$this->json->response('fail');
			}
        }
        elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Request to batch delete images.
            $deleted = false;
            foreach ($this->input->post('ids') as $id) {
                $deleted = $this->hospitals_model->delete_hospital_image($id);
            }

            if($deleted) {
                $response['error'] = false;
				$response['message'] = lang('alert_success_general');
				$this->json->response('deleted');
			} else {
				$response['message'] = lang('alert_fail_general');
				$this->json->response('fail');
			}
        }
        exit();
    }

    /**
	 * Return all users of a hospital.
	 * Filtering options are set by GET parameters.
     * 
     * @return JSON
	 */
    public function users($hospitalId, $options = []) {
        $this->load->model('physicians_model');
        $columns = [
            'id',
            'thumbnail',
            'username',
            'email',
            'status'
        ];
        $options['ignore_status'] = true;
        
        if (isset($options['out_hospital'])) {
            $options['out_hospital'] = $hospitalId;
        } else {
            $options['in_hospital'] = $hospitalId;
        }
        
        if ($order = $this->input->get('order')) {
            $options['order'] = [
                'column' => $columns[$order[0]['column']],
                'dir' => $order[0]['dir']
            ];
        }
        
        if ($search = $this->input->get('search')) $options['search'] = $search['value'];

        $options['start'] = $this->input->get('start') ? $this->input->get('start') : 0;
        $options['limit'] = $this->input->get('length');
        
        $users = $this->physicians_model->getAll($options);

        foreach ($users as $key => $user) {
            $html = '<div class="btn-group">';
            $html .= '<a href="'.site_url('admin/users/edit/'.$user['id']).'" class="btn btn-sm btn-primary">'.lang('btn_edit').'</a> ';
            $html .='<button type="button" class="btn btn-sm btn-danger delete-row">'.lang('btn_delete').'</button>';
            $html .='</div>';
            $users[$key]['thumbnail'] = base_url('image/'.$user["thumbnail"]);
            $users[$key]['action'] = $html;
        }
        $options['count'] = true;
        
        echo $this->json->response('success', [
            'draw' => $this->input->get('draw') ? $this->input->get('order') : 1,
            "recordsFiltered" => $this->physicians_model->count,
            "recordsTotal" => $this->physicians_model->getAll($options),
            'data' => $users
        ]);
    }

    /**
	 * Return all users not in a hospital.
	 * Filtering options are set by GET parameters.
     * 
     * @return JSON
	 */
    public function nonUsers($hospitalId, $options = []) {
        $this->users($hospitalId, ['out_hospital' => $hospitalId]);
    }

    /**
	 * Remove a hospital user.
     * 
     * @return JSON
	 */
    public function remove_user($hospitalId, $user_id) {
        // Non admin or manager is not authorized
        if(! $this->_canEdit($hospitalId)) $this->json->response('unauthorized');

        if($this->hospitals_model->remove_doctors($hospitalId, [$user_id])) {
            $response['error'] = false;
            $response['message'] = lang('alert_success_general');
        } else {
            $response['error'] = true;
            $response['message'] = lang('alert_fail_general');
        }
        $this->json->response('success', $response);
    }

    /**
	 * Remove multiple hospital users.
     * 
     * @return JSON
	 */
    public function remove_assigned($hospitalId) {
        if(! $this->ion_auth->in_group('admin') && ! $this->ion_auth->in_group('manager')) {
            // Non admin or manager is not authorized
            $this->json->response('unauthorized');
        }
        if($this->hospitals_model->remove_doctors($hospitalId, $this->input->post('ids'))) {
            $response['error'] = false;
            $response['message'] = lang('alert_success_general');
            $this->json->response('deleted', $response);
        } else {
            $response['message'] = lang('alert_fail_general');
            $this->json->response('fail', $response);
        }
    }

    /**
	 * Remove hospital users.
     * 
     * @return JSON
	 */
    public function assign($hospitalId) {
        if(! $this->ion_auth->in_group('admin') && ! $this->ion_auth->in_group('manager')) {
            // Non admin or manager is not authorized
            $this->json->response('unauthorized');
        }
        if($this->hospitals_model->assign_doctors($hospitalId, $this->input->post('ids'))) {
            $response['error'] = false;
            $response['message'] = lang('alert_success_general');
            $this->json->response('deleted');
        } else {
            $response['message'] = lang('alert_fail_general');
            $this->json->response('fail');
        }
    }

    /**
	 * Is the user logged in and the admin or manager of hospital.
     * 
     * @return mixed Boolean or JSON
	 */
    private function _canEdit($hospitalId)
    {
        // Non admin or manager is not authorized
        $manager = (
            $this->ion_auth->in_group('manager') &&
            $this->hospitals_model->belongs_to_hospital($hospitalId, $this->app->user('id')));

        if(! $this->ion_auth->in_group('admin') && ! $manager) {
            $this->json->response('unauthorized');
            return false;
        }

        return true;
    }
}

/* End of file Api.php */
/* Location: ./application/modules/hospitals/controllers/Api.php */