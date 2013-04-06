<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article_m extends MY_Model {

	protected $_table_name = 'articles';
	protected $_order_by = 'pubdate desc, id desc';
	protected $_rules = array();
	protected $_timestamps = TRUE;

	public $rules = array(
			'pubdate' => array(
				'field' => 'pubdate',
				'label' => 'Publication date',
				'rules' => 'trim|required|exact_length[10]|css_clean'
			),
			'title' => array(
				'field' => 'title',  
				'label' => 'Title',
				'rules' => 'trim|required|max_length[100]|xss_clean'
			),
			'slug' => array(
				'field' => 'slug',
				'label' => 'Slug',
				'rules' => 'trim|required|max_length[100]|url_title|xss_clean'
			),
			'body' => array(
				'field' => 'body',
				'label' => 'Body',
				'rules' => 'trim|required'
			)
		);

	public function __construct() {
		parent::__construct();
	}
	
	public function get_new() {
		$article = new stdClass();
		$article->title = '';
		$article->slug = '';
		$article->body = '';
		$article->pubdate = 0;
		return $article;
	}
	
}