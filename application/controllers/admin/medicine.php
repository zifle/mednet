<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Medicine extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('medicine_m');
		$this->load->model('symptom_m');
		$this->load->model('symptom_types_m');
	}

	public function index() {
		// Fetch all medicines
		$this->data['medicines'] = $this->medicine_m->get();

		$this->data['sidebar'][] = array('type' => 'button', 'label' => 'Opret ny', 'slug' => 'admin/medicine/edit');

		// Load view
		$this->data['subview'] = 'admin/medicine/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function search($query) {
		// if query is not set, redirect to index
		if (!$query) redirect('admin/medicine');

		$query = urldecode($query);

		// Load results
		$this->data['medicines'] = $this->medicine_m->search($query, array(
															'title' => 'after',
															'usage' => 'both'
														));

		$this->data['search_query'] = $query;
		$this->data['sidebar'][] = array('type' => 'button', 'label' => 'Tilbage til oversigt', 'slug' => 'admin/medicine');

		$this->data['subview'] = 'admin/medicine/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function edit($id = NULL) {
		// Fetch a medicine or set a new one
		if ($id) {
			$this->data['medicine'] = $this->medicine_m->get($id);
			if (!count($this->data['medicine'])) {
				$this->statuses->addError('Kunne ikke finde den ønskede medicin');
				$this->statuses->save();
				redirect('admin/medicine/edit');
			}
			$this->data['medicine']->symptoms = $this->medicine_m->get_medicine_symptoms($id);
		}
		else {
			$this->data['medicine'] = $this->medicine_m->get_new();
		}

		// Set up the form
		$rules = $this->medicine_m->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) {
			$data = $this->medicine_m->array_from_post(array(
						'title',
						'usage',
						'price_price',
						'price_doses',
						'price_quantity',
						'price_quantity_type',
						'price_receipt_required',
						'doses',
						'symptoms'
					));

			// Need to do some extra with the price list
			$data['prices'] = array();
			foreach ($data['price_doses'] as $k => $dose) {
				$price = array();
				$price['doses'] = $dose;
				$price['price'] = $data['price_price'][$k];
				$price['quantity'] = $data['price_quantity'][$k];
				$price['quantity_type'] = $data['price_quantity_type'][$k];
				$price['receipt_required'] = $_POST['price_receipt_required'][$k];
				$data['prices'][] = $price;
			}
			// Unset old arrays, they would just screw everything up...
			unset($data['price_price']);
			unset($data['price_doses']);
			unset($data['price_quantity']);
			unset($data['price_quantity_type']);
			unset($data['price_receipt_required']);

			$this->medicine_m->save($data, $id);
			$this->statuses->addSuccess('Medicin gemt');
			$this->statuses->save();
			redirect('admin/medicine');
		}

		$this->data['symptom_types'] = $this->symptom_types_m->get();

		// Get list of symptoms, by type
		$symptoms = $this->symptom_m->get();
		$a = array();
		foreach ($symptoms as $symptom) {
			$a[$symptom->type_id][$symptom->symptoms_id] = $symptom->title;
		}
		$this->data['symptoms'] = $a;

		$this->data['sidebar'][] = array('type' => 'button', 'label' => 'Tilbage', 'slug' => 'admin/medicine');

		// Load the view
		$this->data['subview'] = 'admin/medicine/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function delete($id) {
		$this->medicine_m->delete($id);
		$this->statuses->addSuccess('Medicin slettet');
		$this->statuses->save();
		redirect('admin/medicine');
	}
}