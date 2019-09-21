<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MX_Controller {

    function __construct() 
    {
        parent::__construct();

        modules::run('users/authenticate/admin');

		$this->load->model('locations_model', 'locations');
		$this->load->library('app');
		$this->load->helper(['form', 'language']);
		$this->data = array();
	}

	public function locations($address=NULL)
	{
		$this->data['insertRows'] = 1;
		if ($this->input->post('add_tiers')) {
			$this->data['insertRows'] = count($this->input->post('insert'));
			if ($this->locations->add_tiers()) {
				$this->app->setAlert($delCount.' Location tiers were added');
				redirect(current_url());
			} else {
				if(validation_errors() == '') {
					$this->app->setAlert('Location tiers could not be added', 'error');
					redirect(current_url());
				}
			}
		}

		if ($this->input->post('update_tiers')) {
			if ($this->locations->update_tiers()) {
				$this->app->setAlert($delCount.' Location tiers were updated');
				redirect(current_url());
			} else {
				if(validation_errors() == '') {
					$this->app->setAlert('Location tiers could not be updated', 'error');
					redirect(current_url());
				}
			}
		}

		if ($this->input->post('delete_tiers')) {
			if ($this->locations->delete_tiers()) {
				$this->app->setAlert($delCount.' Location tiers were deleted');
				redirect(current_url());
			} else {
				if(validation_errors() == '') {
					$this->app->setAlert('Location tiers could not be deleted', 'error');
					redirect(current_url());
				}
			}
		}

		$this->data['tiers'] = $this->locations->tiers();
		$this->load->view('admin/levels_view', $this->data);
	}

	public function areas($tier_id)
	{
		
		$this->data['insertRows'] = 1;
		if ($this->input->post('add_places')) {
			$this->data['insertRows'] = count($this->input->post('insert'));
			
			if ($this->locations->add_locations($tier_id)) {
				$this->app->setAlert($delCount.' Locations were added');
				redirect(current_url());
			} else {
				if(validation_errors() == '') {
					$this->app->setAlert('Locations could not be added', 'error');
					redirect(current_url());
				}
			}
		}
		
		if ($this->input->post('update_locations')) {
			if ($this->locations->update_locations()) {
				$this->app->setAlert($delCount.' Locations were updated');
				redirect(current_url());
			} else {
				if(validation_errors() == '') {
					$this->app->setAlert('Locations could not be updated', 'error');
					redirect(current_url());
				}
			}
		}
		
		if ($this->input->post('delete_locations')) {
			if ($this->locations->delete_locations()) {
				$this->app->setAlert($delCount.' Locations were deleted');
				redirect(current_url());
			} else {
				if(validation_errors() == '') {
					$this->app->setAlert('Locations could not be deleted', 'error');
					redirect(current_url());
				}
			}
		}
		
		$tier = $this->locations->tier($tier_id);
		$tiers = $this->locations->tiers();
		$lineage = $this->app->lineage('location_types', $tier_id, array('id', 'name'));
		$tierOpts[null] = '';
		foreach ($tiers as $key => $value) $tierOpts[$value['id']] = $value['name'];

		// Define form structure to edit the location tier.
		$this->data['form_fields'] = [
			'name' => [
				'label' => lang('form_location_level'),
				'value' => $tier['name'],
			],
			'parent' => [
				'type'  => 'select',
				'label' => lang('form_location_parent'),
				'options' => $tierOpts,
				'selected' => $tier['parent_id'],
			],
			'code' => [
				'label' => lang('form_location_code'),
				'value' => $tier['code'],
			],
		];

		$this->data['tierId'] = $tier_id;
		$this->data['lineage'] = $lineage;
		$this->data['parent'] = isset($lineage[count($lineage)-2]) ? $lineage[count($lineage)-2] : [];
		$this->data['tiers'] = $this->locations->locations($lineage[count($lineage)-1]['parent_id']);
		$this->data['locations'] = $this->locations->locations($tier_id);
		$this->load->view('admin/areas_view', $this->data);
	}

	public function zones()
	{
		$this->data['insertRows'] = 1;
		
		if ($this->input->post('add_zones')) {
			$this->data['insertRows'] = count($this->input->post('insert'));
			$this->_feedback($this->locations->add_zones());
		}

		if ($this->input->post('update_zones')) {
			$this->_feedback($this->locations->update_zones());
		}

		$this->load->view('admin/zones_view', $this->data);
	}

	private function _feedback($result)
	{
		if ($result) {
			// Form operation was successful
			$this->app->setAlert(lang('alert_success_general'));
			redirect(current_url());
		} else {
			// The was a problem after form submission
			if(validation_errors() == '') {
				$this->app->setAlert(lang('alert_fail_general'), 'error');
				redirect(current_url());
			}

			return null;
		}
	}
}