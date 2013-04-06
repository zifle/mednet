<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pharmacy extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('pharmacy_m');
	}

	public function index() {
		// Fetch all pharmacies
		$this->data['pharmacys'] = $this->pharmacy_m->get();

		// Load view
		$this->data['subview'] = 'admin/pharmacy/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function edit($id = NULL) {
		// Fetch a pharmacy or set a new one
		if ($id) {
			$this->data['pharmacy'] = $this->pharmacy_m->get($id);
			count($this->data['pharmacy']) || $this->data['errors'][] = 'pharmacy could not be found';
		}
		else {
			$this->data['pharmacy'] = $this->pharmacy_m->get_new();
		}
		
		// Set up the form
		$rules = $this->pharmacy_m->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) {
			$data = $this->pharmacy_m->array_from_post(array('title', 'slug', 'body', 'pubdate'));
			$this->pharmacy_m->save($data, $id);
			redirect('admin/pharmacy');
		}

		// Load the view
		$this->data['subview'] = 'admin/pharmacy/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function delete($id) {
		$this->pharmacy_m->delete($id);
		redirect('admin/pharmacy');
	}
}