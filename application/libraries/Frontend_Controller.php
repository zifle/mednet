<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frontend_Controller extends MY_Controller {
	
	public function __construct() {
		parent::__construct();

		// Load stuff
		$this->load->model('page_m');

		// Fetch navigation
		$this->data['menu'] = $this->page_m->get_nested();
	}
	
}