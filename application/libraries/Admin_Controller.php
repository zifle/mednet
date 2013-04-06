<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->data['meta_title'] = 'Mednet Content Management System';
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model("admin_user_m");

		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');

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
		log_message('debug', 'Admin_Controller loaded');
	}
	
}