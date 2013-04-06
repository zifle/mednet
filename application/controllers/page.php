<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends Frontend_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('page_m');
	}

	public function index() {
		// Fetch the page data
		$this->data['page'] = $this->page_m->get_by(array('slug' => (string) $this->uri->segment(1)), TRUE);
		count($this->data['page']) || show_404(current_url());

		// Fetch the page data
		$method = '_' . $this->data['page']->template;
		if (method_exists($this, $method)) {
			$this->$method();
		}
		else {
			log_message('error', 'Cound not load template ' . $method . ' in file '. __FILE__ .' at line ' . __LINE__);
			show_error('Cound not load template ' . $method);
		}

		// Load the view
		$this->data['subview'] = $this->data['page']->template;
		$this->load->view('_main_layout', $this->data);
	}

	private function _page() {
		dump('Welcome from PAGE');
	}
	
	private function _homepage() {
		$this->load->model('article_m');
		$this->db->limit(6);
		$this->data['articles'] = $this->article_m->get();
	}

	private function _news_archive() {
		dump('Welcome from NEWS'); 
	}
}