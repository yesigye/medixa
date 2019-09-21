<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MX_Controller {

    function __construct() 
    {
        parent::__construct();

        modules::run('users/authenticate/admin');

		$this->load->library('app');
		$this->load->model('languages');
		$this->load->helper(['form', 'language']);
		$this->data = array();
	}

	public function edit($language)
	{
		
		if ($this->input->post('insert')) {
			//validate form input
			$this->load->library('form_validation');
			$this->form_validation->set_rules('language', lang('menu_languages'), 'required|is_unique[languages.language]');

			if ($this->form_validation->run() == true) {
			
				if ($this->languages->save($this->input->post('language'))) {
					$this->app->setAlert(lang('alert_success_general'));
					redirect('admin/languages/edit/'.$this->input->post('language'));
				} else {
					$this->app->setAlert(lang('alert_fail_general'), 'error');
					redirect(current_url());
				}
			}
		}
		
		if ($this->input->post('edit_name')) {
			//validate form input
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', lang('menu_languages'), 'required|is_unique[languages.language]');

			if ($this->form_validation->run() == true) {
			
				if ($this->languages->save($this->input->post('name'), $language)) {
					$this->app->setAlert(lang('alert_success_general'));
					redirect('admin/languages/edit/'.$this->input->post('name'));
				} else {
					$this->app->setAlert(lang('alert_fail_general'), 'error');
					redirect(current_url());
				}
			}
		}

		if ($name = $this->input->post('delete')) {
			
			if ($this->languages->delete($name)) {
				$this->app->setAlert(lang('alert_success_general'));
			} else {
				$this->app->setAlert(
					$this->languages->error_message ? $this->languages->error_message : lang('alert_fail_general'),
					'error');
			}
			redirect('admin/languages');
		}

		if ($this->input->post('update')) {
			if ($this->languages->save_translations($language, $this->input->post('rows'))) {
				$this->app->setAlert($delCount.' Locations were updated');
				redirect(current_url());
			} else {
				if(validation_errors() == '') {
					$this->app->setAlert('Locations could not be updated', 'error');
					redirect(current_url());
				}
			}
		}

		$this->data['link'] = 'languages';
		$this->data['language'] = $language;
		$this->data['languages'] = $this->languages->get_languages();
		$this->data['translations'] = $this->languages->get_translations($language);
		$this->load->view('admin/language_edit_view', $this->data);
	}
}