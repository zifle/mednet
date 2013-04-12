<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pharmacy_m extends MY_Model {

	protected $_table_name = 'pharmacies';
	protected $_order_by = 'zipcode';
	protected $_primary_key = 'pharmacies_id';
	protected $_rules = array();
	protected $_timestamps = FALSE;

	public $rules = array(
			'title' => array(
				'field' => 'title',
				'label' => 'Navn',
				'rules' => 'trim|required|max_length[40]|xss_clean'
			),
			'zipcode' => array(
				'field' => 'zipcode',
				'label' => 'Postnr.',
				'rules' => 'trim|required|exact_length[4]|is_natural|xss_clean'
			),
			'address' => array(
				'field' => 'address',
				'label' => 'Adresse',
				'rules' => 'trim|max_length[255]|xss_clean'
			)
		);

	public function __construct() {
		parent::__construct();
	}

	public function get_top($limit) {
		$this->db
			->select('COUNT(pharmacy_visits_id) visits, pharmacies.*')
			->join('pharmacy_visits', 'pharmacy = pharmacies_id', 'left')
			->group_by('pharmacies_id')
			->order_by('visits DESC, title ASC')
			->limit($limit);
		return $this->get();
	}

	public function addView($id) {
		$this->db->set('pharmacy', $id)->insert('pharmacy_visits');
	}
	
	public function get_new() {
		$symptom = new stdClass();
		$symptom->title = '';
		$symptom->zipcode = '';
		$symptom->address = '';
		return $symptom;
	}
	
}