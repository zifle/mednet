<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('menu_m');
	}

	public function index() {
		// Fetch all menus
		$this->data['menus'] = $this->menu_m->get();

		// Load view
		$this->data['subview'] = 'admin/menu/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function edit($id = NULL) {
		// Fetch a menu or set a new one
		if ($id) {
			$this->data['menu'] = $this->menu_m->get($id);
			count($this->data['menu']) || $this->data['errors'][] = 'menu could not be found';
		}
		else {
			$this->data['menu'] = $this->menu_m->get_new();
		}
		
		// Set up the form
		$rules = $this->menu_m->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) {
			$data = $this->menu_m->array_from_post(array('title', 'slug', 'body', 'pubdate'));
			$this->menu_m->save($data, $id);
			redirect('admin/menu');
		}

		// Load the view
		$this->data['subview'] = 'admin/menu/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function delete($id) {
		$this->menu_m->delete($id);
		redirect('admin/menu');
	}
}