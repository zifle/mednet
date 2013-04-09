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
				'rules' => 'trim|required|max_length[20]|xss_clean'
			),
			'zipcode' => array(
				'field' => 'zipcode',
				'label' => 'Postnr.',
				'rules' => 'trim|required|exact_length[4]|is_natural|xss_clean'
			),
			'longitude' => array(
				'field' => 'longitude',
				'label' => 'Længdegrad',
				'rules' => 'trim|max_length[15]|numeric|xss_clean'
			),
			'latitude' => array(
				'field' => 'latitude',
				'label' => 'Breddegrad',
				'rules' => 'trim|max_length[15]|numeric|xss_clean'
			),

		);

	public function __construct() {
		parent::__construct();
	}
	
	public function get_new() {
		$symptom = new stdClass();
		$symptom->title = '';
		$symptom->zipcode = '';
		$symptom->longitude = '';
		$symptom->latitude = '';
		return $symptom;
	}
	
}