<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Illness extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('illness_m');
		$this->load->model('symptom_m');
		$this->load->model('symptom_types_m');
	}

	public function index() {
		// Fetch all illnesses
		$this->data['illnesses'] = $this->illness_m->get();

		$this->data['sidebar'][] = array('type' => 'button', 'label' => 'Opret ny', 'slug' => 'admin/illness/edit');

		// Load view
		$this->data['subview'] = 'admin/illness/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function search($query) {
		// if query is not set, redirect to index
		if (!$query) redirect('admin/illness');

		$query = urldecode($query);

		// Load results
		$this->data['illnesses'] = $this->illness_m->search($query, array(
															'latin_name' => 'after',
															'title' => 'after',
															'description' => 'both'
														));

		$this->data['search_query'] = $query;
		$this->data['sidebar'][] = array('type' => 'button', 'label' => 'Tilbage til oversigt', 'slug' => 'admin/illness');

		$this->data['subview'] = 'admin/illness/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function edit($id = NULL) {
		// Fetch a illness or set a new one
		if ($id) {
			$this->data['illness'] = $this->illness_m->get($id);
			if (!count($this->data['illness'])) {
				$this->statuses->addError('Kunne ikke finde sygdom');
				$this->statuses->save();
				redirect('admin/illness/edit');
			}
			$this->data['illness']->symptoms = $this->illness_m->get_illness_symptoms($id);
		}
		else {
			$this->data['illness'] = $this->illness_m->get_new();
		}

		// Set up the form
		$rules = $this->illness_m->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) {
			$data = $this->illness_m->array_from_post(array('title', 'latin_name', 'description', 'symptoms'));
			$this->illness_m->save($data, $id);
			$this->statuses->addSuccess('Sygdom gemt');
			$this->statuses->save();
			redirect('admin/illness');
		}

		$symptoms = $this->symptom_m->get();
		$a = array();
		foreach ($symptoms as $symptom) {
			$a[$symptom->symptoms_id] = $symptom->title;
		}
		$this->data['symptoms'] = $a;

		$this->data['sidebar'][] = array('type' => 'button', 'label' => 'Tilbage', 'slug' => 'admin/illness');

		// Load the view
		$this->data['subview'] = 'admin/illness/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function delete($id) {
		$this->illness_m->delete($id);
		$this->statuses->addSuccess('Sygdom slettet');
		$this->statuses->save();
		redirect('admin/illness');
	}
}