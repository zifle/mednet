<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Illness_m extends MY_Model {

	protected $_table_name = 'illnesses';
	protected $_order_by = 'latin_name';
	protected $_primary_key = 'illnesses_id';
	protected $_rules = array();
	protected $_timestamps = FALSE;

	public $rules = array(
			'title' => array(
				'field' => 'title',
				'label' => 'Navn',
				'rules' => 'trim|required|max_length[30]|xss_clean'
			),
			'latin_name' => array(
				'field' => 'latin_name',
				'label' => 'Det Latinske navn',
				'rules' => 'trim|max_length[30]|xss_clean'
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

	public function get_illness_symptoms($id) {
		$sympts = $this->db
				->select('symptom')
				->where('illness', $id)
				->get('illness_symptoms')
				->result();
		$symptoms = array();
		foreach ($sympts as $symptom) {
			$symptoms[] = $symptom->symptom;
		}
		return $symptoms;
	}

	public function save($data, $id = NULL) {
		// Remove symptoms list from array
		$symptoms = $data['symptoms'];
		unset($data['symptoms']);

		// Save illness
		$id = parent::save($data, $id);

		// Clear illness' symptoms
		$this->db->where('illness', $id)->delete('illness_symptoms');

		// Save illness' symptoms
		$sympts = array();
		foreach ($symptoms as $symptom) {
			$sympts[] = array('illness' => $id, 'symptom' => $symptom);
		}
		$this->db->insert_batch('illness_symptoms', $sympts);
	}
	
	public function get_new() {
		$symptom = new stdClass();
		$symptom->title = '';
		$symptom->latin_name = '';
		$symptom->description = '';
		$symptom->symptoms = array();
		return $symptom;
	}
	
}