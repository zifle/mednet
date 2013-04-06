<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Medicine extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('medicine_m');
	}

	public function index() {
		// Fetch all medicines
		$this->data['medicines'] = $this->medicine_m->get();

		// Load view
		$this->data['subview'] = 'admin/medicine/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function edit($id = NULL) {
		// Fetch a medicine or set a new one
		if ($id) {
			$this->data['medicine'] = $this->medicine_m->get($id);
			count($this->data['medicine']) || $this->data['errors'][] = 'medicine could not be found';
		}
		else {
			$this->data['medicine'] = $this->medicine_m->get_new();
		}
		
		// Set up the form
		$rules = $this->medicine_m->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) {
			$data = $this->medicine_m->array_from_post(array('title', 'slug', 'body', 'pubdate'));
			$this->medicine_m->save($data, $id);
			redirect('admin/medicine');
		}

		// Load the view
		$this->data['subview'] = 'admin/medicine/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function delete($id) {
		$this->medicine_m->delete($id);
		redirect('admin/medicine');
	}
}