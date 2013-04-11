<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('article_m');

		$this->load->model('symptom_m');
		$this->load->model('symptom_types_m');
		$this->load->model('medicine_m');
		$this->load->model('illness_m');
		$this->load->model('pharmacy_m');
	}

	public function index() {
		// Fetch all articles
		$this->data['articles'] = $this->article_m->get();

		$this->data['sidebar'][] = array('type' => 'button', 'label' => 'Opret ny', 'slug' => 'admin/article/edit');

		// Load view
		$this->data['subview'] = 'admin/article/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function search($query) {
		// if query is not set, redirect to index
		if (!$query) redirect('admin/article');

		$query = urldecode($query);

		// Load results
		$this->data['articles'] = $this->article_m->search($query, array(
															'title' => 'after',
															'content' => 'both',
															'teaser' => 'after',
															'publish' => 'both'
														));

		$this->data['search_query'] = $query;
		$this->data['sidebar'][] = array('type' => 'button', 'label' => 'Tilbage til oversigt', 'slug' => 'admin/article');

		$this->data['subview'] = 'admin/article/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function edit($id = NULL) {
		// Fetch a article or set a new one
		if ($id) {
			$this->data['article'] = $this->article_m->get($id);
			if (!count($this->data['article'])) {
				$this->statuses->addError('Kunne ikke finde den ønskede nyhed');
				$this->statuses->save();
				redirect('admin/article/edit');
			}
		}
		else {
			$this->data['article'] = $this->article_m->get_new();
		}
		
		// Set up the form
		$rules = $this->article_m->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) {
			$data = $this->article_m->array_from_post(array('title', 'content', 'teaser', 'symptom', 'medicine', 'pharmacy', 'illness', 'publish'));
			$id = $this->article_m->save($data, $id);

			if (!empty($_FILES['image']['tmp_name'])) {
				// Save image
				$config['upload_path'] = './img/articles/';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['max_size'] = '2048'; // kB
				$config['overwrite'] = TRUE;
				$config['file_name'] = $id.'_article';
	
				$this->load->library('upload', $config);
				if (FALSE !== $this->upload->do_upload('image')) {
					$upload = $this->upload->data();
					$this->article_m->save(array('image' => $upload['file_name']), $id);
				}
				else {
					$this->statuses->addError('Billede kunne ikke gemmes');
				}
			}

			$this->statuses->addSuccess('Nyhed gemt');
			$this->statuses->save();
			redirect('admin/article');
		}

		$pharmacies = $this->pharmacy_m->get();
		$symptoms = $this->symptom_m->get();
		$medicines = $this->medicine_m->get();
		$illnesses = $this->illness_m->get();
		
		$this->data['pharmacies'] = array('' => 'Ingen');
		$this->data['symptoms'] = array('' => 'Ingen');
		$this->data['medicines'] = array('' => 'Ingen');
		$this->data['illnesses'] = array('' => 'Ingen');

		foreach ($pharmacies as $pharmacy)
			$this->data['pharmacies'][$pharmacy->pharmacies_id] = $pharmacy->title;
		foreach ($symptoms as $symptom)
			$this->data['symptoms'][$symptom->symptoms_id] = $symptom->title;
		foreach ($medicines as $medicine)
			$this->data['medicines'][$medicine->medicine_id] = $medicine->title;
		foreach ($illnesses as $illness)
			$this->data['illnesses'][$illness->illnesses_id] = $illness->title;

		$this->data['sidebar'][] = array('type' => 'button', 'label' => 'Tilbage', 'slug' => 'admin/article');

		// Load the view
		$this->data['subview'] = 'admin/article/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function delete($id) {
		$this->article_m->delete($id);
		$this->statuses->addSuccess('Nyhed slettet');
		$this->statuses->save();
		redirect('admin/article');
	}

	public function image($id=NULL, $w=0, $h=0) {
		if (!$id) exit;
		$i_path = './img/articles/';
		$a = $this->article_m->get($id, TRUE);
		if ($a === FALSE) exit;
		$i_name = $a->image;
		$i_full = $i_path.$i_name;
		if (file_exists($i_full)) {
			$img = NULL;
			$ext = strtolower(end(explode('.', $i_name)));

			switch ($ext) {
				case 'jpg':
					$img = @imagecreatefromjpeg($i_full);
					break;
				case 'jpeg':
					$img = @imagecreatefromjpeg($i_full);
					break;
				case 'png':
					$img = @imagecreatefrompng($i_full);
					break;
				default:
					echo "Not an image";
					exit;
			}

			$o_width = imagesx($img);
			$o_height = imagesy($img);

			// Get scale ratio
			$scale = max($w/$o_width, $h/$o_height);

			if ($scale < 1) {
				$n_width = floor($scale*$o_width);
				$n_height = floor($scale*$o_height);

				$tmp_img = imagecreatetruecolor($n_width, $n_height);
				$tmp_img2 = imagecreatetruecolor($w, $h);

				imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $n_width, $n_height, $o_width, $o_height);

				if ($n_width == $w) {
					$x = 0;
					$y = ($n_height / 2) - ($h / 2);
				}
				else if ($n_height == $h) {
					$x = ($n_width / 2) - ($w / 2);
					$y = 0;
				}

				imagecopyresampled($tmp_img2, $tmp_img, 0, 0, $x, $y, $w, $h, $w, $h);

				imagedestroy($img);
				imagedestroy($tmp_img);
				$img = $tmp_img2;
			}

			header('Content-Type: image/jpeg');
			imagejpeg($img, NULL, 90);
		} else exit;
	}
}