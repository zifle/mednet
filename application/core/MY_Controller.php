<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	
	public $data = array();

	protected $menu = array('slug' => 'Set menus');

	public function __construct($menu = NULL) {
		parent::__construct();
		if ($menu !== NULL) $this->menu = $menu;

		if (isset($_POST['search_query'])) redirect($this->uri->uri_string().'/'.$_POST['search_query']);

		$this->data['errors'] = array();
		$this->data['site_name'] = config_item('site_name');
		$this->data['is_admin'] = FALSE;
		$this->data['menu'] = $this->menu;
		$this->data['sidebar'] = array();
		$this->data['sidebar_side'] = 'right';
		$this->data['draw_sidebar'] = TRUE;
		$this->data['search_query'] = FALSE;
		$this->load->library('statuses');
	}
	
}