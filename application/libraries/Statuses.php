<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**************************************\
 * Statuses library
 * Author: Niels Pedersen
 *
 * Handles messages to the user.
\**************************************/
session_start();
class Statuses {
	
	// Method to use for printing.
	// Per default, two options exist:
	// - 'default'		- Default markup
	// - 'bootstrap'	- Bootstrap markup
	protected $print_method = 'bootstrap';

	// The types available for different status types.
	protected $types = array(
							'messages' => array(
								'bootstrap_class' => 'info',
								'name' => 'message'
							),
							'errors' => array(
								'bootstrap_class' => 'error',
								'name' => 'error'
							),
							'successes' => array(
								'bootstrap_class' => 'success',
								'name' => 'success'
							)
						);

	function __construct($types = NULL, $print_method = NULL) {
		// Create type variables
		if ($types !== NULL) $this->types = $types;
		foreach ($this->types as $type => $data)
			$this->$type = array();

		// Load print method
		if ($print_method !== NULL) $this->print_method = $print_method;

		// Load saved messages
		if (isset($_SESSION['statuses'])) {
			foreach ($_SESSION['statuses'] as $type => $statuses) {
				$this->$type = $statuses;
			}
			unset($_SESSION['statuses']);
		}
	}

	// Magic method to catch undefined methods.
	// Will, to some extend, parse the called method, and act appropriately
	public function __call($method, $arguments) {
		if (stripos($method, 'add') === 0) {
			$type = substr($method, 3);
			if (strpos($type, '_') === 0) $type = substr($type, 1);
			$this->add($type, $arguments);
		}
		else
			log_message('error', 'Status library encountered error: Requested method did not exist (Method: '.$method.')');
	}

	// Dynamically add status(es) to appropriate type.
	public function add($type, $data) {
		// Make sure the type already exists, if not, try adding an 's', or 'es', to the end.
		$type = strtolower($type);
		if (!array_key_exists($type, $this->types)) {
			$t_o = $type;
			$type .= 's';
			if (!array_key_exists($type, $this->types)) {
				$type = $t_o .'es';
				if (!array_key_exists($type, $this->types)) return FALSE;
			}
		}
		// If data is array, recurse through function
		if (is_array($data)) {
			foreach ($data as $input) {
				$this->add($type, $input);
			}
		}
		else {
			// Add data to the array
			$this->{$type}[] = $data;
			return TRUE;
		}
		return FALSE;
	}

	// Alias method
	public function save() {
		$this->saveStatuses();
	}

	// Save statuses in session, for use next page load.
	public function saveStatuses() {
		foreach ($this->types as $type => $data) {
			$_SESSION['statuses'][$type] = $this->$type;
		}
		return true;
	}

	// Print statuses, use first argument TRUE, if string should be returned.
	public function show_statuses($method = NULL, $close_button = TRUE, $silent = TRUE) {
		if ($method === NULL) $method = $this->print_method();
		$str = $this->{'_print_'.$method}($close_button);
		if ($silent) return $str;
		echo $str;
	}

	private function _print_bootstrap($close_button) {
		$str = '';
		$content = FALSE;
		foreach($this->types as $type => $data) {
			foreach ($this->$type as $message) {
				$str .= '<div class="alert alert-'.$data['bootstrap_class'].'">';
				!$close_button || $str .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
				$str .= $message;
				$str .= '</div>'.PHP_EOL;
				$content = TRUE;
			}
		}
		if (!$content) return '';
		return $str;
	}

	private function _print_default($close_button) {
		$str = '<div class="statuses">'.PHP_EOL;
		$content = FALSE;
		foreach($this->types as $type => $data) {
			foreach ($this->$type as $message) {
				$str .= '<p class="status '.$type.'">'.$message.'</p>'.PHP_EOL;
				$content = TRUE;
			}
		}
		$str .= '</div>'.PHP_EOL;
		if (!$content) return '';
		return $str;
	}
	
	// Clear statuses
	public function clear() {
		foreach ($this->types as $type => $data) {
			$this->$type = array();
		}
		return true;
	}
}
?>
