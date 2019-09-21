    <?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MX_Controller {

	function __construct() 
    {
        parent::__construct();

        $this->load->library('json');

        if ( ! $this->input->is_ajax_request()) {
            // Dont allow non ajax requests
            $this->json->response('unauthorized');
        }
        
        $this->load->helper(['form', 'language']);
        $this->load->library('app');
		$this->load->model('appointments_model');
    }

    /**
	 * Return all appointments.
	 * Filtering options are set by GET parameters.
     * 
     * @return JSON
	 */
    public function index() {
        $this->load->helper('form');

        $columns = ['id', 'title', 'user', 'doctor', 'start_date'];

        if ($order = $this->input->get('order')) {
            $options['order'] = [
                'column' => $columns[$order[0]['column']],
                'dir' => $order[0]['dir']
            ];
        }
        
        if ($search = $this->input->get('search')) $options['search'] = $search['value'];

        $options['start'] = $this->input->get('start') ? $this->input->get('start') : 0;
        $options['limit'] = $this->input->get('length');
        
        $appointments = $this->appointments_model->all($options);
        
        foreach ($appointments as $key => $appointment) {
            $html = '<div class="btn-group">';
            $html .= '<a href="'.site_url('admin/appointments/edit/'.$appointment['id']).'" class="btn btn-sm btn-primary">'.lang('btn_view').'</a> ';
            $html .='</div>';
            $appointments[$key]['date'] = $appointment['start_date'];
            $appointments[$key]['action'] = $html;
        }

        echo $this->json->response('success', [
            'draw' => $this->input->get('draw') ? $this->input->get('order') : 1,
            "recordsTotal" => $this->db->count_all_results('appointments'),
            "recordsFiltered" => $this->appointments_model->count,
            'data' => $appointments
        ]);
    }

    /**
	 * Return calendar events.
	 * Filtering options are set by GET parameters.
     * 
     * @return JSON
	 */
	public function events($userId)
	{
		$events = $this->appointments_model->all([
            'user' => $userId,
			'start' => $this->input->get('start'),
			'end' => $this->input->get('end'),
        ]);

		$data_events = [];
		foreach ($events as $key => $row) {
			$data_events[] = [
                "id" => $row['id'],
                "title" => $row['title'],
                "message" => $row['message'],
				"userId" => $row['user_id'],
				"start" => $row['start_date'],
				"end" => $row['end_date'],
				"approved" => ($row['approved'] == 1) ? true : false,
				// indicate as editable if appointments are for logged in doctor.
                "editable" => ($userId === $row['doctor_id']) ? true : false
            ];
		}
		
		echo $this->json->response('success', ["events" => $data_events]);
	}
}