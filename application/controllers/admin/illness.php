<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Illness extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('illness_m');
	}

	public function index() {
		// Fetch all illnesses
		$this->data['illnesses'] = $this->illness_m->get();

		// Load view
		$this->data['subview'] = 'admin/illness/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function edit($id = NULL) {
		// Fetch a illness or set a new one
		if ($id) {
			$this->data['illness'] = $this->illness_m->get($id);
			count($this->data['illness']) || $this->data['errors'][] = 'illness could not be found';
		}
		else {
			$this->data['illness'] = $this->illness_m->get_new();
		}
		
		// Set up the form
		$rules = $this->illness_m->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) {
			$data = $this->illness_m->array_from_post(array('title', 'slug', 'body', 'pubdate'));
			$this->illness_m->save($data, $id);
			redirect('admin/illness');
		}

		// Load the view
		$this->data['subview'] = 'admin/illness/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function delete($id) {
		$this->illness_m->delete($id);
		redirect('admin/illness');
	}
}