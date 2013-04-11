<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Symptom_m extends MY_Model {

	protected $_table_name = 'symptoms';
	protected $_order_by = 'symptoms_id';
	protected $_primary_key = 'symptoms_id';
	protected $_rules = array();
	protected $_timestamps = FALSE;

	public $rules = array(
			'type' => array(
				'field' => 'type',
				'label' => 'Type',
				'rules' => 'trim|required'
			),
			'title' => array(
				'field' => 'title',  
				'label' => 'Titel',
				'rules' => 'trim|required|max_length[30]|xss_clean'
			),
			'description' => array(
				'field' => 'description',
				'label' => 'Beskrivelse',
				'rules' => 'trim|required|max_length[255]|xss_clean'
			)
		);

	public function __construct() {
		parent::__construct();
	}

	public function get($id = NULL, $single = FALSE) {
		$symptoms = parent::get($id);
		if (!count($symptoms)) return $symptoms;

		// Add proper title to symptoms
		if ($id === NULL && !$single) {
			foreach ($symptoms as &$symptom) {
				$symptom->type_id = $symptom->type;
				$symptom->type = $this->symptom_types_m->get($symptom->type)->title;
			}
		}
		else {
			$symptoms->type_id = $symptoms->type;
			$symptoms->type = $this->symptom_types_m->get($symptoms->type)->title;
		}

		return $symptoms;
	}

	public function get_by_type_for($for, $id) {
		$types = $this->symptom_types_m->get();
		$symptoms = array();
		foreach ($types as $type) {
			$this->db->join($for.'_symptoms', 'symptom = symptoms_id')->where($for, $id);
			$symptoms[$type->title] = $this->get_by(array('type' => $type->symptom_types_id));
		}
		return $symptoms;
	}

	public function search($like, $and = FALSE) {
		$this->db->select('symptoms_id, type as type_id, symptom_types.title as type, symptoms.title as title, description');
		$this->db->join('symptom_types', 'type = symptom_types_id');
		return parent::search($like, $and);
	}
	
	public function get_new() {
		$symptom = new stdClass();
		$symptom->title = '';
		$symptom->type = '';
		$symptom->description = '';
		return $symptom;
	}
	
}