<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Frontend_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->load->library('form_validation');
		// Set form validation messages
		$this->form_validation->set_message('required', 'Du skal udfylde %s');
		$this->form_validation->set_message('max_length', '%s må ikke være på mere end %d tegn.');
		$this->form_validation->set_message('valid_email', '%s skal være en email.');
		$this->form_validation->set_message('_unique_email', '%s allerede i brug.');
		$this->form_validation->set_message('matches', '%s og %s skal være identiske');
	}

	public function index() {
		// Fetch all users
		$this->data['users'] = $this->user_m->get();

		// Load view
		$this->data['subview'] = 'user/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function register() {
		$this->data['user'] = $this->user_m->get_new();

		// Set up form
		$rules = $this->user_m->register_rules;
		$this->form_validation->set_rules($rules);

		// Process form
		if ($this->form_validation->run() == TRUE) {
			$data = $this->user_m->array_from_post(array('name', 'email', 'password'));
			$data['passhash'] = $this->user_m->hash($data['password']);
			unset($data['password']);
			$this->user_m->save($data);
			$this->statuses->addSuccess('Registrering fuldført. Du kan nu logge ind.');
			$this->statuses->save();
			redirect('user/login');
		}

		// Load view
		$this->data['subview'] = 'user/register';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function login() {
		// Redirect a user if he's already logged in
		$dashboard = 'user';
		$this->user_m->loggedin() == FALSE || redirect($dashboard);

		// Set form
		$rules = $this->user_m->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) {
			// We can login and redirect
			if ($this->user_m->login() == TRUE) {
				$this->statuses->save();
				redirect($dashboard);
			}
			else {
				$this->statuses->save();
				redirect('user/login', 'refresh');
			}
		}
		
		// Load the view
		$this->data['subview'] = 'user/login';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function logout() {
		$this->user_m->logout();
		redirect('user/login');
	}

	public function _unique_email($str) {
		// Do NOT validate if email already exists

		$this->db->where('email', $this->input->post('email'));
		$user = $this->user_m->get();

		if (count($user)) {
			$this->form_validation->set_message('_unique_email', '%s allerede i brug');
			return FALSE;
		}

		return TRUE;
	}
}