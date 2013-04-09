<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('page_m');
	}

	public function index() {
		// Fetch all pages
		$this->data['pages'] = $this->page_m->get();

		// Add create new button to sidebar
		$this->data['sidebar'][] = array(
										'type' => 'button',
										'slug' => 'admin/page/edit',
										'label' => 'Opret ny side'
									);

		// Load view
		$this->data['subview'] = 'admin/page/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function search($query) {
		// if query is not set, redirect to index
		if (!$query) redirect('admin/page');

		$query = urldecode($query);

		// Load results
		$this->data['pages'] = $this->page_m->search($query, array(
															'title' => 'after',
															'content' => 'both',
															'template' => 'after'
														));

		$this->data['search_query'] = $query;
		$this->data['sidebar'][] = array('type' => 'button', 'label' => 'Tilbage til oversigt', 'slug' => 'admin/page');

		$this->data['subview'] = 'admin/page/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function edit($id = NULL) {
		// Fetch a page or set a new one
		if ($id) {
			$this->data['page'] = $this->page_m->get($id);
			if (!count($this->data['page'])) {
				$this->statuses->addError('Kunne ikke finde side');
				$this->statuses->save();
				redirect('admin/page/edit');
			}
		}
		else {
			$this->data['page'] = $this->page_m->get_new();
		}

		// Set up the form
		$rules = $this->page_m->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) {
			$data = $this->page_m->array_from_post(array('title', 'template', 'content', 'footer'));
			$this->page_m->save($data, $id);
			$this->statuses->addSuccess('Side gemt');
			$this->statuses->save();
			redirect('admin/page');
		}

		$this->data['sidebar'][] = array('type' => 'button', 'label' => 'Tilbage', 'slug' => 'admin/page');

		// Load the view
		$this->data['subview'] = 'admin/page/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function delete($id) {
		$this->page_m->delete($id);
		$this->statuses->addSuccess('Side slettet');
		$this->statuses->save();
		redirect('admin/page');
	}

}