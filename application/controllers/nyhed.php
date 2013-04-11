<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nyhed extends Frontend_Controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['articles'] = $this->article_m->get_after(0, 6);

		// Load sidebar
		$oldnews = $this->article_m->get_after(6, 5);
		$oldnews_parsed = array();
		foreach ($oldnews as $article) {
			$oldnews_parsed['nyhed/'.$article->articles_id] = $article->title;
		}
		$this->data['sidebar']['news'] = array(
				'type' => 'links',
				'title' => 'Ældre nyheder',
				'data' => $oldnews_parsed
			);

		$this->data['meta_title'] = 'Nyheder';
		// Load view
		$this->data['subview'] = 'article/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function vis($id = NULL) {
		// Return if id not set
		if (!$id) redirect('nyhed');

		$this->data['article'] = $this->article_m->get($id);
		// Return if id not found (article might not be published)
		if (!$this->data['article']) {
			$this->statuses->addMessage('Kunne ikke finde nyhed');
			$this->statuses->save();
			redirect('nyhed');
		}

		$this->data['meta_title'] = $this->data['article']->title;
		// Load view
		$this->data['subview'] = 'article/show';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function image($id=NULL, $w=940, $h=500) {
		if (intval($w) <= 0) $w = 940;
		if (intval($h) <= 0) $h = 500;

		if ($id) {
			$i_path = './img/articles/';
			$a = $this->article_m->get($id);
			
			if ($a != FALSE) {
				$i_name = $a->image;
				$i_full = $i_path.$i_name;
			}
			else {
				$i_name = '404.png';
				$i_full = './img/404.png';
			}
		}
		else {
			$i_name = '404.png';
			$i_full = './img/404.png';
		}
		
		if (!file_exists($i_full)) {
			$i_name = '404.png';
			$i_full = './img/404.png';
		}

		$img = NULL;
		$ext = strtolower(end(explode('.', $i_name)));

		// Get image resource
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
				$img = @imagecreatefrompng('./img/404.png');
				exit;
		}

		// Get image dimensions
		$o_width = imagesx($img);
		$o_height = imagesy($img);

		// Get scale ratio
		$scale = max($w/$o_width, $h/$o_height);
		log_message('debug', 'Scale ratio of image: max('. $w/$o_width .', '. $h/$o_height .') = '.$scale);

		if ($scale < 1) {
			$do_scale = TRUE;
			
			$n_width = floor($scale*$o_width);
			$n_height = floor($scale*$o_height);
		}
		else if(($scale = min($w/$o_width, $h/$o_height) < 1)) {
			$do_scale = TRUE;

			if ($w/$o_width < $h/$o_height) {
				$n_width = floor($scale*$o_width);
				$n_height = floor($scale*$o_height);
			}
			else {
				$n_width = floor($scale*$o_width);
				$n_height = floor($scale*$o_height);
			}
		}
		else $do_scale = FALSE;

		if ($do_scale) {
			log_message('debug', 'New dimensions: '.$n_width.'x'.$n_height);

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
	}
}