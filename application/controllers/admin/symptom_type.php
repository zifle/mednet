<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Symptom_type extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('symptom_types_m');
	}

	public function index() {
		// Fetch all symptoms
		$this->data['symptom_types'] = $this->symptom_types_m->get();

		$this->data['sidebar'][] = array(
										'type' => 'button',
										'slug' => 'admin/symptom_type/edit',
										'label' => 'Opret ny'
									);

		// Load view
		$this->data['subview'] = 'admin/symptom_types/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function search($query) {
		// if query is not set, redirect to index
		if (!$query) redirect('admin/symptom_type');

		$query = urldecode($query);

		// Load results
		$this->data['symptom_types'] = $this->symptom_types_m->search($query, array(
															'title' => 'after'
														));

		$this->data['search_query'] = $query;
		$this->data['sidebar'][] = array('type' => 'button', 'label' => 'Tilbage til oversigt', 'slug' => 'admin/symptom_type');

		$this->data['subview'] = 'admin/symptom_types/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function edit($id = NULL) {
		// Fetch a symptom or set a new one
		if ($id) {
			$this->data['symptom_type'] = $this->symptom_types_m->get($id);
			if (!count($this->data['symptom_type'])) {
				$this->statuses->addErrors('Kunne ikke finde symptom');
				$this->statuses->save();
				redirect('admin/symptom_type/edit');
			}
		}
		else {
			$this->data['symptom_type'] = $this->symptom_types_m->get_new();
		}
		
		// Set up the form
		$rules = $this->symptom_types_m->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) {
			$data = $this->symptom_types_m->array_from_post(array('title'));
			$this->symptom_types_m->save($data, $id);
			$this->statuses->addSuccess('Symptom type gemt');
			$this->statuses->save();
			redirect('admin/symptom_type');
		}

		// Add back button to sidebar
		$this->data['sidebar'][] = array(
										'type' => 'button',
										'slug' => 'admin/symptom_type',
										'label' => 'Tilbage'
									);

		// Load the view
		$this->data['subview'] = 'admin/symptom_types/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function delete($id) {
		$this->symptom_types_m->delete($id);
		$this->statuses->addSuccess('Symptom type slettet');
		$this->statuses->save();
		redirect('admin/symptom_type');
	}
}