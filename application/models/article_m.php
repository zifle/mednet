<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article_m extends MY_Model {

	protected $_table_name = 'articles';
	protected $_order_by = 'publish desc, modified desc, created desc, articles_id desc';
	protected $_primary_key = 'articles_id';
	protected $_rules = array();
	protected $_timestamps = TRUE;

	public $rules = array(
			'publish' => array(
				'field' => 'publish',
				'label' => 'Udgivelses dato',
				'rules' => 'trim|required|exact_length[10]|xss_clean'
			),
			'title' => array(
				'field' => 'title',  
				'label' => 'Titel',
				'rules' => 'trim|required|max_length[100]|xss_clean'
			),
			'content' => array(
				'field' => 'content',
				'label' => 'Indhold',
				'rules' => 'trim|required'
			),
			'teaser' => array(
				'field' => 'teaser',
				'label' => 'Teaser',
				'rules' => 'trim|max_length[100]|xss_clean'
			),
			'symptom' => array(
				'field' => 'symptom',
				'label' => 'Symptomer',
				'rules' => 'trim'
			),
			'pharmacy' => array(
				'field' => 'pharmacy',
				'label' => 'Apoteker',
				'rules' => 'trim'
			),
			'medicine' => array(
				'field' => 'medicine',
				'label' => 'Medicin',
				'rules' => 'trim'
			),
			'illness' => array(
				'field' => 'illness',
				'label' => 'Sygdomme',
				'rules' => 'trim'
			),
		);

	public function __construct() {
		parent::__construct();
	}

	public function save($data, $id = NULL) {
		if (empty($data['symptom'])) $data['symptom'] = NULL;
		if (empty($data['medicine'])) $data['medicine'] = NULL;
		if (empty($data['pharmacy'])) $data['pharmacy'] = NULL;
		if (empty($data['illness'])) $data['illness'] = NULL;

		return parent::save($data, $id);
	}

	public function get_after($offset, $limit) {
		$this->db->offset($offset);
		$this->db->limit($limit);
		return $this->get();
	}

	public function get($id = NULL, $single = FALSE) {
		// Only get published news, if on the frontend!
		if (!$this->data['is_admin'])
			$this->db->where('publish <', 'NOW()', FALSE);
		return parent::get($id, $single);
	}
	
	public function get_new() {
		$article = new stdClass();
		$article->title = '';
		$article->content = '';
		$article->teaser = '';
		$article->symptom = NULL;
		$article->pharmacy = NULL;
		$article->medicine = NULL;
		$article->illness = NULL;
		$article->publish = date('Y-m-d');
		$article->image = '';
		return $article;
	}
}