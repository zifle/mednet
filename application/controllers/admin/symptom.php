<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Symptom extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('symptom_m');
		$this->load->model('symptom_types_m');
	}

	public function index() {
		// Fetch all symptoms
		$this->data['symptoms'] = $this->symptom_m->get();

		// Add create new button to sidebar
		$this->data['sidebar'][] = array(
										'type' => 'button',
										'slug' => 'admin/symptom/edit',
										'label' => 'Opret nyt symptom'
									);

		// Load view
		$this->data['subview'] = 'admin/symptom/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function search($query) {
		// if query is not set, redirect to index
		if (!$query) redirect('admin/symptom');

		$query = urldecode($query);

		// Load results
		$this->data['symptoms'] = $this->symptom_m->search($query, array(
															'symptom_types.title' => 'after',
															'description' => 'both',
															'type' => 'after'
														));

		$this->data['search_query'] = $query;
		$this->data['sidebar'][] = array('type' => 'button', 'label' => 'Tilbage til oversigt', 'slug' => 'admin/symptom');

		$this->data['subview'] = 'admin/symptom/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function edit($id = NULL) {
		// Fetch a symptom or set a new one
		if ($id) {
			$this->data['symptom'] = $this->symptom_m->get($id);
			if (!count($this->data['symptom'])) {
				$this->statuses->addError('Kunne ikke finde symptom');
				$this->statuses->save();
				redirect('admin/symptom/edit');
			}
		}
		else {
			$this->data['symptom'] = $this->symptom_m->get_new();
		}
		
		// Set up the form
		$rules = $this->symptom_m->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) {
			$data = $this->symptom_m->array_from_post(array('title', 'type', 'description'));
			$this->symptom_m->save($data, $id);
			$this->statuses->addSuccess('Symptom gemt');
			$this->statuses->save();
			redirect('admin/symptom');
		}

		// Load symptom types
		$symptom_types = $this->symptom_types_m->get();
		$a = array();
		foreach ($symptom_types as $st) {
			$a[$st->symptom_types_id] = $st->title;
		}
		$this->data['symptom_types'] = $a;

		// Add back button to sidebar
		$this->data['sidebar'][] = array(
										'type' => 'button',
										'slug' => 'admin/symptom',
										'label' => 'Tilbage'
									);

		// Load the view
		$this->data['subview'] = 'admin/symptom/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function delete($id) {
		$this->symptom_m->delete($id);
		$this->statuses->addSuccess('Symptom slettet');
		$this->statuses->save();
		redirect('admin/symptom');
	}
}