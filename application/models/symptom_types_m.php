<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Symptom_types_m extends MY_Model {

	protected $_table_name = 'symptom_types';
	protected $_order_by = 'symptom_types_id';
	protected $_primary_key = 'symptom_types_id';
	protected $_rules = array();
	protected $_timestamps = FALSE;

	public $rules = array(
			'title' => array(
				'field' => 'title',
				'label' => 'Type',
				'rules' => 'trim|required|max_length[45]|xss_clean'
			)
		);

	public function __construct() {
		parent::__construct();
	}
	
	public function get_new() {
		$symptom = new stdClass();
		$symptom->title = '';
		return $symptom;
	}
	
}