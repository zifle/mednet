<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_m extends MY_Model {

	protected $_table_name = 'pages';
	protected $_primary_key = 'pages_id';
	protected $_order_by = 'pages_id';
	protected $_rules = array();

	public $rules = array(
			'template' => array(
				'field' => 'template',
				'label' => 'Template',
				'rules' => 'trim|require|max_length[20]|xss_clean'
			),
			'title' => array(
				'field' => 'title',
				'label' => 'Titel',
				'rules' => 'trim|required|max_length[50]|xss_clean'
			),
			'footer' => array(
				'field' => 'footer',
				'label' => 'Footer',
				'rules' => 'trim|required|exact_length[1]|is_natural'
			),
			'content' => array(
				'field' => 'content',
				'label' => 'Indhold',
				'rules' => 'trim|required'
			)
		);

	public function __construct() {
		parent::__construct();
	}
	
	public function get_new() {
		$page = new stdClass();
		$page->title = '';
		$page->template = '';
		$page->content = '';
		$page->footer = '0';
		return $page;
	}

}