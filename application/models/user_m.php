<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_M extends MY_Model {
	
	public $rules = array(
			'email' => array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'trim|required|valid_email|xss_clean'
			),
			'password' => array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'trim|required'
			)
		);

	public $register_rules = array(
			'name' => array(
				'field' => 'name',
				'label' => 'Navn',
				'rules' => 'trim|max_length[70]|xss_clean'
			),
			'email' => array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'trim|required|valid_email|max_length[255]|callback__unique_email|xss_clean'
			),
			'email2' => array(
				'field' => 'email2',
				'label' => 'Gentag email',
				'rules' => 'trim|required|matches[email]|xss_clean'
			),
			'password' => array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'trim|required'
			),
			'password2' => array(
				'field' => 'password2',
				'label' => 'Gentag Password',
				'rules' => 'trim|required|matches[password]'
			)
		);

	public $user = NULL;

	protected $_table_name = 'users';
	protected $_primary_key = 'users_id';
	protected $_order_by = 'name';
	protected $_timestamps = FALSE;

	public function __construct() {
		parent::__construct();
		$this->load->library('PBKDF2', 'pbkdf2');

		if ($this->loggedin()) {
			$this->user = $this->get_by(array('email' => $this->session->userdata['email']), TRUE);
		}
	}

	public function login() {
		$user = $this->get_by(array(
			'email' => $this->input->post('email')
		), TRUE);

		if (count($user)) {
			// Check password
			if ($this->confirm_hash($this->input->post('password'), $user->passhash)) {
				$this->user = $user;
				// Log in user
				$data = array(
					'name' => $user->name,
					'email' => $user->email,
					'loggedin' => TRUE
				);
				$this->session->set_userdata($data);
				$this->statuses->addSuccess('Du blev logget ind');
				return TRUE;
			}
			else {
				$this->statuses->addError('Login oplysninger ikke korrekte');
				return FALSE;
			}
		}
		else {
			$this->statuses->addError('Login oplysning ikke korrekte');
			return FALSE;
		}
	}
	
	public function logout() {
		$this->session->unset_userdata(array('loggedin' => '', 'name' => '', 'email' => ''));
	}
	
	public function loggedin() {
		return (bool) $this->session->userdata('loggedin');
	}

	public function get_new() {
		$user = new stdClass();
		$user->name = '';
		$user->email = '';
		$user->password = '';
		return $user;
	}

	public function hash($string) {
		return $this->pbkdf2->create_hash($string);
	}

	public function confirm_hash($provided, $true) {
		return $this->pbkdf2->validate_password($provided, $true);
	}
	
}