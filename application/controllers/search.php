<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends Frontend_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->data['sidebar_side'] = 'left';
		$this->data['meta_title'] = 'Søgeresultater';
	}

	public function index($search = NULL) {
		$this->soeg($search);
	}

	public function soeg($search = NULL) {
		if ($search) {
			$search = rawurldecode($search);
			$this->_medicine($search);
			$this->_illness($search);
			$this->_pharmacy($search);
		}
		else {
			if ($q = $this->input->post('query')) {
				redirect('search/soeg/'.rawurlencode($q));
			}
			$this->data['search_results']['medicine'] = array();
			$this->data['search_results']['illness'] = array();
			$this->data['search_results']['pharmacy'] = array();
		}

		$this->data['search_query'] = $search;

		// Load view
		$this->data['subview'] = 'search/view';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function medicin($search = NULL) {
		if ($search) {
			$search = rawurldecode($search);
			$this->_medicine($search);
		}
		else {
			if ($q = $this->input->post('query')) {
				redirect('search/medicin/'.$q);
			}
			$this->data['search_results']['medicine'] = array();
		}		

		$this->data['search_query'] = $search;

		$this->data['subview'] = 'search/view';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function sygdom($search = NULL) {
		if ($search) {
			$search = rawurldecode($search);
			$this->_illness($search);
		}
		else {
			if ($q = $this->input->post('query')) {
				redirect('search/sygdom/'.$q);
			}
			$this->data['search_results']['illness'] = array();
		}

		$this->data['search_query'] = $search;

		$this->data['subview'] = 'search/view';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function apotek($search = NULL) {
		if ($search) {
			$search = rawurldecode($search);
			$this->_pharmacy($search);
		}
		else {
			if ($q = $this->input->post('query')) {
				redirect('search/apotek/'.$q);
			}
			$this->data['search_results']['pharmacy'] = array();
		}

		$this->data['search_query'] = $search;

		// Load sidebar
		$s_index = array(
						(object) array('letter' => '0000-0999'),
						(object) array('letter' => '1000-2999'),
						(object) array('letter' => '3000-3699'),
						(object) array('letter' => '3700-3999'),
						(object) array('letter' => '4000-4999'),
						(object) array('letter' => '5000-5999'),
						(object) array('letter' => '6000-6999'),
						(object) array('letter' => '7000-7999'),
						(object) array('letter' => '8000-8999'),
						(object) array('letter' => '9000-9999')
					);
		$this->data['sidebar']['zipcodes'] = array(
				'type' => 'index',
				'title' => 'Find apoteker nær dig',
				'base' => 'search/apotek/',
				'data' => $s_index
			);
		unset($this->data['sidebar']['medicine']);
		krsort($this->data['sidebar']);

		$this->data['subview'] = 'search/view';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function _medicine($search) {
		if (strlen($search) == 1) {
			$this->db->where('LEFT(`%PRE%medicine`.`title`, 1) =', $search, TRUE);
			$this->data['search_results']['medicine'] = $this->medicine_m->search('', array());
			return;
		}

		// Create an array, split by comma, so that we can get more search results
		$search = explode(',', $search);

		$this->db
			->select('medicine.*')
			->join('medicine_symptoms', 'medicine_id = medicine', 'left')
			->join('symptoms', 'symptom = symptoms_id', 'left');
		$this->data['search_results']['medicine'] = $this->medicine_m->search($search, array(
													'medicine.title' => 'both',
													'usage' => 'both',
													'symptoms.title' => 'both',
													'description' => 'both'
												));
	}

	public function _illness($search) {
		$this->load->model('illness_m');

		$search = explode(',', $search);

		$this->db
			->select('illnesses.*')
			->join('illness_symptoms', 'illnesses_id = illness', 'left')
			->join('symptoms', 'symptom = symptoms_id', 'left');
		$this->data['search_results']['illness'] = $this->illness_m->search($search, array(
																'illnesses.title' => 'both',
																'latin_name' => 'after',
																'illnesses.description' => 'both',
																'symptoms.title' => 'both',
																'symptoms.description' => 'both'
															));
	}

	public function _pharmacy($search) {
		$this->load->model('pharmacy_m');
		if (strlen($search) == 9) {
			$s = explode('-', $search);
			if (count($s) == 2) {
				$this->db
					->where('zipcode >', $s[0])
					->where('zipcode <', $s[1]);
				$this->data['search_results']['pharmacy'] = $this->pharmacy_m->get();
				return;
			}
		}
		$search = explode(',', $search);
		$this->data['search_results']['pharmacy'] = $this->pharmacy_m->search($search, array(
																'title' => 'both',
																'zipcode' => 'after'
															));
	}
}