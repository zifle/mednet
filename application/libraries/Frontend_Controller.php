<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frontend_Controller extends MY_Controller {
	
	protected $menu = array(
			'Nyheder' => 'nyhed',
			'Medicin' => 'medicin',
			'Sygdom' => 'sygdom',
			'Apoteker' => 'apotek'
		);

	public function __construct() {
		parent::__construct();

		// Load stuff

		$this->load->helper('form');
		$this->load->library('session');
		$this->load->model('user_m');
		$this->load->model('page_m');
		$this->load->model('article_m');
		$this->load->model('medicine_m');

		$this->data['meta_title'] = '';

		// Add menu if user is logged in
		if ($this->user_m->loggedin()) {
			$this->data['menu']['divider'] = '';
			$this->data['menu']['Min side'] = 'user';
		}

		$this->data['pages'] = $this->page_m->get_by(array('footer' => 1));
		$this->db->limit(5);
		$this->data['footer_articles'][] = (object) array('title' => 'Medicin', 'data' => $this->article_m->get_by(array('medicine !=' => 'NULL')));
		$this->db->limit(5);
		$this->data['footer_articles'][] = (object) array('title' => 'Sygdom', 'data' => $this->article_m->get_by(array('illness !=' => 'NULL')));
		$this->db->limit(5);
		$this->data['footer_articles'][] = (object) array('title' => 'Apoteker', 'data' => $this->article_m->get_by(array('pharmacy !=' => 'NULL')));

		// Load sidebar
		$this->data['sidebar']['medicine'] = array(
				'type' => 'index',
				'title' => 'Find medicin',
				'base' => 'search/medicin/',
				'data' => $this->medicine_m->get_index()
			);
		$oldnews = $this->article_m->get_after(0, 6);
		foreach ($oldnews as $article) {
			$oldnews_parsed['nyhed/'.$article->articles_id] = $article->title;
		}
		$this->data['sidebar']['news'] = array(
				'type' => 'links',
				'title' => 'Nyheder',
				'data' => $oldnews_parsed
			);
	}
	
}