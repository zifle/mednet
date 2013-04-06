<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_user_M extends MY_Model {
	
	public $rules = array(
			'username' => array(
				'field' => 'username',
				'label' => 'brugernavn',
				'rules' => 'trim|required|xss_clean'
			),
			'password' => array(
				'field' => 'password',
				'label' => 'password',
				'rules' => 'trim|required'
			)
		);

	public $rules_admin = array(
			'username' => array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'trim|required|xss_clean'
			),
			'password' => array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'trim|matches[password_confirm]'
			),
			'password_confirm' => array(
				'field' => 'password_confirm',
				'label' => 'Confirm password',
				'rules' => 'trim|matches[password]'
			)
		);

	protected $_table_name = 'admin_users';
	protected $_primary_key = 'admin_users_id';
	protected $_order_by = 'admin_users_id';
	protected $_timestamps = FALSE;

	public function __construct() {
		parent::__construct();
		$this->load->library('PBKDF2', 'pbkdf2');
	}

	public function login() {
		$user = $this->get_by(array(
			'login' => $this->input->post('username')
		), TRUE);

		if (count($user)) {
			// Check password
			if ($this->confirm_hash($this->input->post('password'), $user->passhash)) {
				// Log in user
				$data = array(
					'admin_id' => $user->admin_users_id,
					'login' => $user->login,
					'admin_loggedin' => TRUE
				);
				$this->session->set_userdata($data);
				$this->statuses->addSuccess('Du blev logget ind');
			}
			else {
				$this->statuses->addError('Login oplysninger ikke korrekte');
			}
		}
		else {
			$this->statuses->addError('Login oplysninger ikke korrekte');
		}
	}
	
	public function logout() {
		$this->session->unset_userdata(array('admin_id' => '', 'admin_loggedin' => ''));
	}
	
	public function loggedin() {
		return (bool) $this->session->userdata('admin_loggedin');
	}

	public function get_new() {
		$user = new stdClass();
		$user->login = '';
		$user->passhash = '';
		return $user;
	}

	public function hash($string) {
		return $this->pbkdf2->create_hash($string);
	}

	public function confirm_hash($provided, $true) {
		return $this->pbkdf2->validate_password($provided, $true);
	}
	
}