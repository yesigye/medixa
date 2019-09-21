<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends MX_Controller
{
	function __construct() 
	{
		parent::__construct();

		$this->load->database();
		$this->load->library(['app', 'users/ion_auth']);

		// Check if admin user is logged in.
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$this->load->model('settings_model', 'settings');
			$this->load->model('languages');
			$this->load->helper('form');
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

	public function index()
	{
		$settings = $this->settings->values();
		// Attempt to update settings
		if ($this->input->post('update')) {
			if ($this->settings->update([
				'site_name'         => $this->input->post('name'),
				'site_description'  => $this->input->post('description'),
				'site_language'     => $this->input->post('language'),
				'no_reply'          => $this->input->post('no_reply'),
				'pagination_limit'  => $this->input->post('pagination'),
				'upload_limit'      => $this->input->post('upload_limit'),
			])) {
				$this->app->setAlert(lang('alert_success_general'));
			} else {
				$this->app->setAlert(lang('alert_fail_general'), 'error');
			}
			redirect(current_url());
		}
		$languages = $this->languages->get_languages();
		$lang_list = [];

		foreach ($languages as $row) $lang_list[$row['language']] = $row['language'];
		
		$this->data['form_fields']  = array(
			'name' => array(
				'label' => lang('form_settings_sitename'),
				'help-text' => lang('form_settings_sitename_txt'),
				'value' => $settings['site_name'],
			),
			'description' => array(
				'label' => lang('form_settings_description'),
				'help-text' => lang('form_settings_description_txt'),
				'value' => $settings['site_description'],
			),
			'language' => array(
				'label' => lang('form_settings_language'),
				'help-text' => lang('form_settings_language_txt'),
				'type' => 'select',
				'options' => $lang_list,
				'selected' => [$settings['site_language']],
			),
			'no_reply' => array(
				'label' => lang('form_settings_noreply'),
				'help-text' => lang('form_settings_noreply_txt'),
				'value' => $settings['no_reply'],
			),
			'pagination' => array(
				'label' => lang('form_settings_paginate'),
				'help-text' => lang('form_settings_paginate_txt'),
				'value' => $settings['pagination_limit'],
			),
			'upload_limit' => array(
				'label' => lang('form_settings_uploads'),
				'help-text' => lang('form_settings_uploads_txt'),
				'value' => $settings['upload_limit'],
			)
		);
		$this->data['settings'] = $settings;
		$this->load->view('settings_view', $this->data);
	}

	public function languages($language = null)
	{
		if(! $language) $language = $this->languages->default_language;

		if ($this->input->post('insert')) {
			//validate form input
			$this->load->library('form_validation');
			$this->form_validation->set_rules('language', lang('menu_languages'), 'required|is_unique[languages.language]');

			if ($this->form_validation->run() == true) {
			
				if ($this->languages->save($this->input->post('language'))) {
					$this->app->setAlert(lang('alert_success_general'));
					redirect('admin/settings/languages/'.$this->input->post('language'));
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
					redirect('admin/settings/languages/'.$this->input->post('name'));
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
			redirect('admin/settings/languages');
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
		$this->data['default_language'] = $this->languages->default_language;
		$this->data['translations'] = $this->languages->get_translations($language);
		$this->load->view('admin/language_edit_view', $this->data);
	}

	public function privacy_policy()
	{
		if ($this->input->post('update')) {
			if ($this->settings->update([
				'privacy_policy' => $this->input->post('privacy'),
			])) {
				$this->app->setAlert(lang('alert_success_general'));
			} else {
				$this->app->setAlert(lang('alert_fail_general'), 'error');
			}
			redirect(current_url());
		}

		$this->data['settings'] = $this->settings->values();
		$this->load->view('privacy_edit_view', $this->data);
	}

	public function terms()
	{
		if ($this->input->post('update')) {
			if ($this->settings->update([
				'terms_of_service' => $this->input->post('terms'),
			])) {
				$this->app->setAlert(lang('alert_success_general'));
			} else {
				$this->app->setAlert(lang('alert_fail_general'), 'error');
			}
			redirect(current_url());
		}

		$this->data['settings'] = $this->settings->values();
		$this->load->view('terms_edit_view', $this->data);
	}
}

/* End of file Settings.php */
/* Location: ./application/modules/admin/controllers/Settings.php */