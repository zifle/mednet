<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Symptom extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('symptom_m');
	}

	public function index() {
		// Fetch all symptoms
		$this->data['symptoms'] = $this->symptom_m->get();

		// Load view
		$this->data['subview'] = 'admin/symptom/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function edit($id = NULL) {
		// Fetch a symptom or set a new one
		if ($id) {
			$this->data['symptom'] = $this->symptom_m->get($id);
			count($this->data['symptom']) || $this->data['errors'][] = 'symptom could not be found';
		}
		else {
			$this->data['symptom'] = $this->symptom_m->get_new();
		}
		
		// Set up the form
		$rules = $this->symptom_m->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) {
			$data = $this->symptom_m->array_from_post(array('title', 'slug', 'body', 'pubdate'));
			$this->symptom_m->save($data, $id);
			redirect('admin/symptom');
		}

		// Load the view
		$this->data['subview'] = 'admin/symptom/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function delete($id) {
		$this->symptom_m->delete($id);
		redirect('admin/symptom');
	}
}