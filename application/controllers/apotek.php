<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apotek extends Frontend_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->load->model('pharmacy_m');

		// Load sidebar
		$s_index = array(
						(object) array('letter' => '0000-0999'),
						(object) array('letter' => '1000-2999'),
						(object) array('letter' => '3000-3699'),
						(object) array('letter' => '3700-3999'),
						(object) array('letter' => '4000-4999'),
						(object) array('letter' => '5000-5999'),
						(object) array('letter' => '6000-6999'),
						(object) array('letter' => '7000-7999'),
						(object) array('letter' => '8000-8999'),
						(object) array('letter' => '9000-9999')
					);
		$this->data['sidebar']['zipcodes'] = array(
				'type' => 'index',
				'title' => 'Find apoteker nær dig',
				'base' => 'search/apotek/',
				'data' => $s_index
			);
		unset($this->data['sidebar']['medicine']);

		$this->db->limit(6);
		$oldnews = $this->article_m->get_by(array('pharmacy !=' => 'NULL'));
		$oldnews_parsed = array();
		foreach ($oldnews as $article) {
			$oldnews_parsed['nyhed/'.$article->articles_id] = $article->title;
		}
		$this->data['sidebar']['news'] = array(
				'type' => 'links',
				'title' => 'Nyheder',
				'data' => $oldnews_parsed
			);

		krsort($this->data['sidebar']);

		$this->data['sidebar_side'] = 'left';
		$this->data['meta_title'] = 'Apoteker';
	}

	public function index() {
		$this->data['most_visited'] = $this->pharmacy_m->get_top(9);

		$this->data['prim_key'] = 'pharmacies_id';
		// Load view
		$this->data['subview'] = 'pharmacy/overview';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function vis($id = NULL) {
		// Return if id not set
		if (!$id) redirect('apotek');

		$this->data['pharmacy'] = $this->pharmacy_m->get($id);
		// Return if id not found (article might not be published)
		if (!$this->data['pharmacy']) {
			$this->statuses->addMessage('Kunne ikke finde apotek');
			$this->statuses->save();
			redirect('pharmacy');
		}

		$this->pharmacy_m->addView($id);

		// Load view
		$this->data['subview'] = 'pharmacy/show';
		$this->load->view('admin/_layout_main', $this->data);
	}
}