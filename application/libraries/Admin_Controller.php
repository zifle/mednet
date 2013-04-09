<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends MY_Controller {
	
	protected $menu = array(
					'Medicin' => 'admin/medicine',
					'Sygdom' => 'admin/illness',
					'Apoteker' => 'admin/pharmacy',
					'Symptomer' => array('Symptomer' => 'admin/symptom', 'Symptom typer' => 'admin/symptom_type'),
					'Nyheder' => 'admin/article',
					'Sider' => 'admin/page'
					// 'Menu' => 'admin/menu',
					// 'Brugere' => 'admin/user'
				);

	public function __construct($menu = NULL) {
		parent::__construct($menu);

		$this->data['meta_title'] = 'Content Management System';
		$this->data['is_admin'] = TRUE;
		$this->data['draw_sidebar'] = FALSE;

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model("admin_user_m");

		// Login check
		$exception_uris = array(
				'admin/user/login',
				'admin/user/logout'
			);
		if (in_array(uri_string(), $exception_uris) == FALSE) {
			if ($this->admin_user_m->loggedin() == FALSE) {
				redirect('admin/user/login');
			}
		}
		else {
			$this->data['menu'] = array('Log ind' => 'admin/user/login');
		}

		// Set form validation messages
		$this->form_validation->set_message('required', 'Du skal udfylde %s');
		$this->form_validation->set_message('max_length', '%s må ikke være på mere end %d tegn.');
		$this->form_validation->set_message('exact_length', '%s skal være på %d tegn.');
		$this->form_validation->set_message('is_natural', '%s må kun være et tal.');
		$this->form_validation->set_message('numeric', '%s må kun være et tal.');

		log_message('debug', 'Admin_Controller loaded');
	}
	
}