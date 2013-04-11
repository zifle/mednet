<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Side extends Frontend_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->data['meta_title'] = '%Dynamic%';
	}

	public function index($id = NULL) {
		if (!$id) redirect('/');
		$this->data['page'] = $this->page_m->get($id);

		if (!$this->data['page']) redirect('/');

		if (
			!$this->data['page']->template ||
			!file_exists('./application/views/'.$this->data['page']->template.'.php')
			) $this->data['page']->template = 'pages/default';

		$this->data['meta_title'] = $this->data['page']->title;
		// Load view
		$this->data['subview'] = 'pages/load';
		$this->load->view('admin/_layout_main', $this->data);
	}

}