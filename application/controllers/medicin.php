<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Medicin extends Frontend_Controller {
	
	public function __construct() {
		parent::__construct();

		// Load sidebar
		$this->db->limit(5);
		$oldnews = $this->article_m->get_by(array('medicine !=' => 'NULL'));
		$oldnews_parsed = array();
		foreach ($oldnews as $article) {
			$oldnews_parsed['nyhed/'.$article->articles_id] = $article->title;
		}
		$this->data['sidebar']['news'] = array(
				'type' => 'links',
				'title' => 'Ældre nyheder',
				'data' => $oldnews_parsed
			);

		$this->data['sidebar_side'] = 'left';
		$this->data['meta_title'] = 'Medicin';
	}

	public function index() {
		$this->data['most_visited'] = $this->medicine_m->get_top(9);

		$this->data['prim_key'] = 'medicine_id';
		// Load view
		$this->data['subview'] = 'medicine/overview';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function vis($id = NULL) {
		// Return if id not set
		if (!$id) redirect('nyhed');

		$this->data['article'] = $this->article_m->get($id);
		// Return if id not found (article might not be published)
		if (!$this->data['article']) {
			$this->statuses->addMessage('Kunne ikke finde nyhed');
			$this->statuses->save();
			redirect('nyhed');
		}

		// Load view
		$this->data['subview'] = 'article/show';
		$this->load->view('admin/_layout_main', $this->data);
	}
}