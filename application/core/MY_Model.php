<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {
	
	public $rules = array();

	protected $_table_name = '';
	protected $_primary_key = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by = '';
	protected $_timestamps = FALSE;

	public function __construct() {
		parent::__construct();
	}

	public function get($id = NULL, $single = FALSE) {
		if ($id !== NULL) {
			$filter = $this->_primary_filter;
			$id = $filter($id);
			$this->db->where($this->_primary_key, $id);
			$method = 'row';
		}
		elseif ($single == TRUE) {
			$method = 'row';
		}
		else {
			$method = 'result';
		}

		if (!count($this->db->ar_orderby)) {
			$this->db->order_by($this->_order_by);
		}
		return $this->db->get($this->_table_name)->$method();

	}

	public function get_by($where, $single = FALSE) {
		$this->db->where($where);
		return $this->get(NULL, $single);
	}
	
	public function save($data, $id = NULL) {
		
		// Set timestamps
		if ($this->_timestamps == TRUE) {
			$now = date('Y-m-d H:i:s');
			$id || $data['created'] = $now;
			$data['modified'] = $now;
		}

		// Insert
		if ($id === NULL) {
			!isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
			$this->db->set($data);
			$this->db->insert($this->_table_name);
			$id = $this->db->insert_id();
		}
		// Update
		else {
			$filter = $this->_primary_filter;
			$id = $filter($id);
			$this->db->set($data);
			$this->db->where($this->_primary_key, $id);
			$this->db->update($this->_table_name);
		}

		return $id;
	}
	
	public function delete($id) {
		$filter = $this->_primary_filter;
		$id = $filter($id);

		if (!$id) {
			return FALSE;
		}
		$this->db->where($this->_primary_key, $id);
		$this->db->limit(1);
		$this->db->delete($this->_table_name);
	}

	public function array_from_post($fields) {
		$data = array();
		foreach ($fields as $field) {
			$data[$field] = $this->input->post($field);
		}
		return $data;
	}

	public function search($query, $like, $and = FALSE) {
		if ($and) $method = 'like';
		else $method = 'or_like';
		
		if (is_array($query)) {
			foreach ($query as $search) {
				if (empty($search)) continue;
				foreach ($like as $col => $side) {
					$this->db->$method($col, $search, $side);
				}
			}
		}
		else {
			foreach ($like as $col => $side) {
				$this->db->$method($col, $query, $side);
			}
		}

		if (!count($this->db->ar_orderby)) {
			$this->db->order_by($this->_order_by);
		}
		return
			$this->db
			->group_by($this->_primary_key)
			->get($this->_table_name)
			->result();
	}
	
}