<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
		$this->load->model('locations_model', 'locale');
    }

    /**
	 * Return all users objects.
	 * Filtering options are set by GET parameters.
     * 
     * @return JSON
	 */
    public function index($options = []) {
        $this->load->helper('form');

        $columns = ['id', 'name', 'parent_id', 'code'];

        if ($order = $this->input->get('order')) {
            $options['order'] = [
                'column' => $columns[$order[0]['column']],
                'dir' => $order[0]['dir']
            ];
        }
        
        if ($search = $this->input->get('search')) $options['search'] = $search['value'];

        $options['start'] = $this->input->get('start') ? $this->input->get('start') : 0;
        $options['limit'] = $this->input->get('length');
        
        $tiers = $this->locale->tiers($options);

        $drop_opts = [null => ''];
        foreach ($tiers as $value) $drop_opts[$value['id']] = $value['name'];
        
        foreach ($tiers as $key => $tier) {
            $html = '<div class="btn-group">';
            $html .= '<a href="'.site_url('admin/locations/areas/'.$tier['id']).'" class="btn btn-sm btn-primary">'.lang('btn_edit').'</a> ';
            $html .='<button type="button" class="btn btn-sm btn-danger delete-row">'.lang('btn_delete').'</button>';
            $html .='</div>';
            $tiers[$key]['action'] = $html;

            $tiers[$key]['name'] = $this->load->view('form_fields', [
				'fields' => [
					"update[".$tier['id']."][name]" => ['value' => $tier['name']]
				]
			], true);
            $tiers[$key]['parent'] = $this->load->view('form_fields', [
				'fields' => [
					"update[".$tier['id']."][parent_id]" => [
						'type' => 'select',
						'options' => $drop_opts,
						'selected' => $tier['parent_id'],
					]
				]
			], true);
            $tiers[$key]['code'] = $this->load->view('form_fields', [
				'fields' => [
					"update[".$tier['id']."][code]" => ['value' => $tier['code']]
				]
			], true);
        }
        
        echo $this->json->response('success', [
            'draw' => $this->input->get('draw') ? $this->input->get('order') : 1,
            "recordsTotal" => $this->locale->get_total(),
            "recordsFiltered" => $this->locale->count,
            'data' => $tiers
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
		$this->load->library('users/ion_auth');

        if( ! $this->ion_auth->in_group('admin')) {
            // Non admin is not authorized
            $this->json->response('unauthorized');
        }

        if ($id && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
            // Request to delete a single location tier.
            if($this->locale->delete_tiers([$id])) {
                $response['error'] = false;
				$response['message'] = lang('feedback_delete_successful');
				$this->json->response('deleted');
			} else {
				$response['message'] = lang('feedback_delete_failed');
				$this->json->response('fail');
			}
        }
        elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Request to batch delete location tiers.
            if($this->locale->delete_tiers($this->input->post('ids'))) {
                $response['error'] = false;
				$response['message'] = lang('feedback_delete_successful');
				$this->json->response('deleted');
			} else {
				$response['message'] = lang('feedback_delete_failed');
				$this->json->response('fail');
			}
        }
        exit();
    }

    /**
	 * Return all places in a location.
	 * Filtering options are set by GET parameters.
     * 
     * @return JSON
	 */
    public function places($tierId, $parentId = null) {
		$this->load->helper('form');

        $columns = ['id', 'name', 'parent_id', 'code'];

        if ($order = $this->input->get('order')) {
            $options['order'] = [
                'column' => $columns[$order[0]['column']],
                'dir' => $order[0]['dir']
            ];
        }
        
        if ($search = $this->input->get('search')) $options['search'] = $search['value'];

        $options['start']  = $this->input->get('start') ? $this->input->get('start') : 0;
        $options['limit']  = $this->input->get('length');
        $options['level']  = $tierId;
        $options['parent']  = $parentId;
        
        $this->load->model('locations_model', 'locale');
		$tiers = $this->locale->tiers($options, 'locations');
        

		$lineage = $this->app->lineage('location_types', $tierId, array('id', 'name'));
        $levels = $this->locale->locations($lineage[count($lineage)-1]['parent_id']);
		$drop_opts = [null => ''];
		foreach ($levels as $value) $drop_opts[$value['id']] = $value['name'];
		
        foreach ($tiers as $key => $tier) {
            $html = '<button type="button" class="btn btn-sm btn-danger delete-row">'.lang('btn_delete').'</button>';
			$tiers[$key]['action'] = $html;
			
            $tiers[$key]['name'] = $this->load->view('form_fields', [
				'fields' => [
					"update[".$tier['id']."][name]" => ['value' => $tier['name']]
				]
			], true);
            $tiers[$key]['parent'] = $this->load->view('form_fields', [
				'fields' => [
					"update[".$tier['id']."][parent_id]" => [
						'type' => 'select',
						'options' => $drop_opts,
						'selected' => $tier['parent_id'],
					]
				]
			], true);
            $tiers[$key]['code'] = $this->load->view('form_fields', [
				'fields' => [
					"update[".$tier['id']."][code]" => ['value' => $tier['code']]
				]
			], true);
        }
        
        echo $this->json->response('success', [
            'draw' => $this->input->get('draw') ? $this->input->get('order') : 1,
            "recordsTotal" => $this->locale->get_total(),
            "recordsFiltered" => $this->locale->count,
            'data' => $tiers
        ]);
    }

    /**
	 * Delete place(s).
	 *
	 * @param  int id of place to be deleted
     * 
	 * @return JSON
	 */
    public function deletePlace($id = null) {
		$this->load->library('users/ion_auth');

        if( ! $this->ion_auth->in_group('admin')) {
            // Non admin is not authorized
            $this->json->response('unauthorized');
        }

		
		// Request to delete a single group.
        if ($id && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
			if($this->locale->delete_locations([$id])) {
				$response['error'] = false;
				$response['message'] = lang('feedback_delete_successful');
				$this->json->response('deleted');
			} else {
				$response['message'] = lang('feedback_delete_failed');
				$this->json->response('fail');
			}
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if($this->locale->delete_locations($this->input->post('ids'))) {
				$response['error'] = false;
				$response['message'] = lang('feedback_delete_successful');
				$this->json->response('deleted');
			} else {
				$response['message'] = lang('feedback_delete_failed');
				$this->json->response('fail');
			}
		}
		
        exit();
    }

    /**
	 * Return all places in a location.
	 * Filtering options are set by GET parameters.
     * 
     * @return JSON
	 */
    public function nodes()
    {
        $inputs = $this->input->get();
		
		if (empty($inputs)) $this->json->response('unauthorized');
		
		foreach ($inputs as $key => $value) $code = $value;

		$reordered = [];
		foreach ($this->locale->getChildren($code) as $key => $type) {
            
            foreach ($type as $rows) $reordered[$rows['code']] = $rows['name'];
        }
        
		echo $this->json->response('success', $reordered);
    }

    /**
	 * Return all users objects.
	 * Filtering options are set by GET parameters.
     * 
     * @return JSON
	 */
    public function zones($options = []) {
        $this->load->helper('form');

        $columns = ['id', 'name', 'parent_id', 'code'];

        if ($order = $this->input->get('order')) {
            $options['order'] = [
                'column' => $columns[$order[0]['column']],
                'dir' => $order[0]['dir']
            ];
        }
        
        if ($search = $this->input->get('search')) $options['search'] = $search['value'];

        $options['start'] = $this->input->get('start') ? $this->input->get('start') : 0;
        $options['limit'] = $this->input->get('length');
        
        $tiers = $this->locale->zones($options);

        $drop_opts = [null => ''];
        foreach ($tiers as $value) $drop_opts[$value['id']] = $value['name'];
        
        foreach ($tiers as $key => $tier) {
            $html = '<div class="btn-group">';
            $html .= '<a href="'.site_url('admin/locations/areas/'.$tier['id']).'" class="btn btn-sm btn-primary">'.lang('btn_edit').'</a> ';
            $html .='<button type="button" class="btn btn-sm btn-danger delete-row">'.lang('btn_delete').'</button>';
            $html .='</div>';
            $tiers[$key]['action'] = $html;

            $tiers[$key]['name'] = $this->load->view('form_fields', [
				'fields' => [
					"update[".$tier['id']."][name]" => ['value' => $tier['name']]
				]
			], true);
            $tiers[$key]['description'] = $this->load->view('form_fields', [
				'fields' => [
					"update[".$tier['id']."][description]" => ['value' => $tier['description']]
				]
			], true);
            $tiers[$key]['status'] = $this->load->view('form_fields', [
				'fields' => [
					"update[".$tier['id']."][status]" => [
                        'value' => 'active',
                        'type' => 'checkbox',
                        'checked' => $tier['status'] ? true : false
                    ]
				]
			], true);
        }
        
        echo $this->json->response('success', [
            'draw' => $this->input->get('draw') ? $this->input->get('order') : 1,
            "recordsTotal" => $this->locale->get_Zones_total(),
            "recordsFiltered" => $this->locale->count,
            'data' => $tiers
        ]);
    }
}

/* End of file Api.php */
/* Location: ./application/modules/locations/controllers/Api.php */