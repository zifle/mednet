<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Medicin extends Frontend_Controller {
	
	public function __construct() {
		parent::__construct();

		// Load sidebar
		$this->db->limit(6);
		$oldnews = $this->article_m->get_by(array('medicine !=' => 'NULL'));
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
		if (!$id) redirect('medicin');

		$this->load->model('symptom_m');
		$this->load->model('symptom_types_m');

		$this->data['medicine'] = $this->medicine_m->get($id);
		// Return if id not found (article might not be published)
		if (!$this->data['medicine']) {
			$this->statuses->addMessage('Kunne ikke finde medicin');
			$this->statuses->save();
			redirect('medicin');
		}

		$this->medicine_m->addView($id);

		// Load view
		$this->data['subview'] = 'medicine/show';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function add($id = NULL) {
		if (!$id || !$this->user_m->loggedin()) redirect('medicin');

		$this->load->model('symptom_m');
		$this->load->model('symptom_types_m');

		$this->data['medicine'] = $this->medicine_m->get($id);
		if (!$this->data['medicine']) {
			$this->statuses->addError('Kunne ikke tilføje medicin');
			$this->statuses->save();
			redirect('medicin');
		}

		$this->medicine_m->addToUser($id, $this->user_m->user->users_id);
		$this->statuses->addSuccess('Medicin tilføjet til \'mit medicin\'');
		$this->statuses->save();
		redirect('medicin/vis/'.$id);
	}

	public function remove($id = NULL) {
		if (!$id || !$this->user_m->loggedin()) redirect('medicin');

		$this->medicine_m->removeFromUser($id, $this->user_m->user->users_id);
		$this->statuses->addSuccess('Medicin fjernet fra \'mit medicin\'');
		$this->statuses->save();
		redirect('medicin/vis/'.$id);
	}
}