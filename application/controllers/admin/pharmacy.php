<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pharmacy extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('pharmacy_m');
	}

	public function index() {
		// Fetch all pharmacies
		$this->data['pharmacies'] = $this->pharmacy_m->get();
		
		$this->data['sidebar'][] = array('type' => 'button', 'label' => 'Opret ny', 'slug' => 'admin/pharmacy/edit');

		// Load view
		$this->data['subview'] = 'admin/pharmacy/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function search($query) {
		// if query is not set, redirect to index
		if (!$query) redirect('admin/pharmacy');

		$query = urldecode($query);

		// Load results
		$this->data['pharmacies'] = $this->pharmacy_m->search($query, array(
															'title' => 'after',
															'zipcode' => 'after'
														));

		$this->data['search_query'] = $query;
		$this->data['sidebar'][] = array('type' => 'button', 'label' => 'Tilbage til oversigt', 'slug' => 'admin/pharmacy');

		$this->data['subview'] = 'admin/pharmacy/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function edit($id = NULL) {
		// Fetch a pharmacy or set a new one
		if ($id) {
			$this->data['pharmacy'] = $this->pharmacy_m->get($id);
			if (!count($this->data['pharmacy'])) {
				$this->statuses->addError('Kunne ikke finde apotek');
				$this->statuses->save();
				redirect('admin/pharmacy/edit');
			}
		}
		else {
			$this->data['pharmacy'] = $this->pharmacy_m->get_new();
		}
		
		// Set up the form
		$rules = $this->pharmacy_m->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) {
			$data = $this->pharmacy_m->array_from_post(array('title', 'zipcode', 'longitude', 'latitude'));
			$this->pharmacy_m->save($data, $id);
			$this->statuses->addSuccess('Apotek gemt');
			$this->statuses->save();
			redirect('admin/pharmacy');
		}

		$this->data['sidebar'][] = array('type' => 'button', 'label' => 'Tilbage', 'slug' => 'admin/pharmacy');

		// Load the view
		$this->data['subview'] = 'admin/pharmacy/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function delete($id) {
		$this->pharmacy_m->delete($id);
		$this->statuses->addSuccess('Apotek slettet');
		$this->statuses->save();
		redirect('admin/pharmacy');
	}
}