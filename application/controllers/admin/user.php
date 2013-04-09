<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		// Fetch all users
		$this->data['users'] = $this->admin_user_m->get();

		// Load view
		$this->data['subview'] = 'admin/user/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function edit($id = NULL) {
		// Fetch a user or set a new one
		if ($id) {
			$this->data['user'] = $this->admin_user_m->get($id);
			count($this->data['user']) || $this->data['errors'][] = 'User could not be found';
		}
		else {
			$this->data['user'] = $this->admin_user_m->get_new();
		}
		
		// Set up the form
		$rules = $this->admin_user_m->rules_admin;
		$id || $rules['password']['rules'] .= '|required';
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) {
			$data = $this->admin_user_m->array_from_post(array('name', 'email', 'password'));
			$data['password'] = $this->admin_user_m->hash($data['password']);
			$this->admin_user_m->save($data, $id);
			redirect('admin/user');
		}

		// Load the view
		$this->data['subview'] = 'admin/user/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function delete($id) {
		$this->admin_user_m->delete($id);
		redirect('admin/user');
	}

	public function login() {
		// Redirect a user if he's already logged in
		$dashboard = 'admin/dashboard';
		$this->admin_user_m->loggedin() == FALSE || redirect($dashboard);

		// Set form
		$rules = $this->admin_user_m->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) {
			// We can login and redirect
			if ($this->admin_user_m->login() == TRUE) {
				$this->statuses->save();
				redirect($dashboard);
			}
			else {
				$this->statuses->save();
				redirect('admin/user/login', 'refresh');
			}
		}
		
		// Load the view
		$this->data['subview'] = 'admin/user/login';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function logout() {
		$this->admin_user_m->logout();
		redirect('admin/user/login');
	}

	public function _unique_email($str) {
		// Do NOT validate if email already exists
		// UNLEDD it's the email of the current user
		
		$id = $this->uri->segment(4);
		$this->db->where('email', $this->input->post('email'));
		!$id || $this->db->where('id !=', $id);
		$user = $this->admin_user_m->get();

		if (count($user)) {
			$this->form_validation->set_message('_unique_email', '%s should be unique');
			return FALSE;
		}

		return TRUE;
	}
}