<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sygdom extends Frontend_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->load->model('illness_m');

		// Load sidebar
		$this->db->limit(6);
		$oldnews = $this->article_m->get_by(array('illness !=' => 'NULL'));
		$oldnews_parsed = array();
		foreach ($oldnews as $article) {
			$oldnews_parsed['nyhed/'.$article->articles_id] = $article->title;
		}
		$this->data['sidebar']['news'] = array(
				'type' => 'links',
				'title' => 'Nyheder',
				'data' => $oldnews_parsed
			);

		$this->data['sidebar_side'] = 'left';
		$this->data['meta_title'] = 'Sygdomme';
	}

	public function index() {
		$this->data['most_visited'] = $this->illness_m->get_top(9);

		$this->data['prim_key'] = 'illnesses_id';
		// Load view
		$this->data['subview'] = 'illness/overview';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function vis($id = NULL) {
		// Return if id not set
		if (!$id) redirect('sygdom');

		$this->load->model('symptom_m');
		$this->load->model('symptom_types_m');

		$this->data['illness'] = $this->illness_m->get($id);
		// Return if id not found (article might not be published)
		if (!$this->data['illness']) {
			$this->statuses->addMessage('Kunne ikke finde sygdom');
			$this->statuses->save();
			redirect('illness');
		}

		$this->illness_m->addView($id);

		// Load view
		$this->data['subview'] = 'illness/show';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function add($id = NULL) {
		if (!$id || !$this->user_m->loggedin()) redirect('sygdom');

		$this->load->model('symptom_m');
		$this->load->model('symptom_types_m');

		$this->data['illness'] = $this->illness_m->get($id);
		if (!$this->data['illness']) {
			$this->statuses->addError('Kunne ikke tilføje sygdom');
			$this->statuses->save();
			redirect('sygdom');
		}

		$this->illness_m->addToUser($id, $this->user_m->user->users_id);
		$this->statuses->addSuccess('Sygdom tilføjet til \'mine sygdomme\'');
		$this->statuses->save();
		redirect('sygdom/vis/'.$id);
	}

	public function remove($id = NULL) {
		if (!$id || !$this->user_m->loggedin()) redirect('sygdom');

		$this->illness_m->removeFromUser($id, $this->user_m->user->users_id);
		$this->statuses->addSuccess('Sygdom fjernet fra \'mine sygdomme\'');
		$this->statuses->save();
		redirect('sygdom/vis/'.$id);
	}
}