<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Illness_m extends MY_Model {

	protected $_table_name = 'illnesses';
	protected $_order_by = 'latin_name';
	protected $_primary_key = 'illnesses_id';
	protected $_rules = array();
	protected $_timestamps = FALSE;

	public $rules = array(
			'title' => array(
				'field' => 'title',
				'label' => 'Navn',
				'rules' => 'trim|required|max_length[30]|xss_clean'
			),
			'latin_name' => array(
				'field' => 'latin_name',
				'label' => 'Det Latinske navn',
				'rules' => 'trim|max_length[30]|xss_clean'
			),
			'description' => array(
				'field' => 'description',
				'label' => 'Beskrivelse',
				'rules' => 'trim|required|max_length[255]|xss_clean'
			)
		);

	public function __construct() {
		parent::__construct();
	}

	public function get($id = NULL, $single = FALSE) {
		$r = parent::get($id, $single);

		if ($id || $single) {
			$r->symptom_types = $this->symptom_m->get_by_type_for('illness', $r->illnesses_id);
		}
		return $r;
	}

	public function get_illness_symptoms($id) {
		$sympts = $this->db
				->select('symptom')
				->where('illness', $id)
				->get('illness_symptoms')
				->result();
		$symptoms = array();
		foreach ($sympts as $symptom) {
			$symptoms[] = $symptom->symptom;
		}
		return $symptoms;
	}

	public function get_top($limit) {
		$this->db
			->select('COUNT(illness_visits_id) visits, illnesses.*')
			->join('illness_visits', 'illness = illnesses_id', 'left')
			->group_by('illnesses_id')
			->order_by('visits DESC, title ASC')
			->limit($limit);
		return $this->get();
	}

	public function get_user_illness($user) {
		$this->db
			->join('user_illness', 'illness = illnesses_id')
			->where('user', $user);
		return $this->get();
	}

	public function addView($id) {
		$this->db->set('illness', $id)->insert('illness_visits');
	}

	public function addToUser($illness, $user) {
		$r = $this->db
			->where('user', $user)
			->where('illness', $illness)
			->get('user_illness')
			->result();
		if (count($r)) return FALSE;
		$this->db
			->set('illness', $illness)
			->set('user', $user)
			->insert('user_illness');
		return TRUE;
	}

	public function removeFromUser($illness, $user) {
		$this->db
			->where('user', $user)
			->where('illness', $illness)
			->delete('user_illness');
	}

	public function is_users_illness($illness, $user) {
		$r = $this->db
			->where('user', $user)
			->where('illness', $illness)
			->get('user_illness')
			->result();
		return count($r);
	}

	public function save($data, $id = NULL) {
		// Remove symptoms list from array
		$symptoms = $data['symptoms'];
		unset($data['symptoms']);

		// Save illness
		$id = parent::save($data, $id);

		// Clear illness' symptoms
		$this->db->where('illness', $id)->delete('illness_symptoms');

		if (empty($symptoms)) return;

		// Save illness' symptoms
		$sympts = array();
		foreach ($symptoms as $symptom) {
			$sympts[] = array('illness' => $id, 'symptom' => $symptom);
		}
		$this->db->insert_batch('illness_symptoms', $sympts);
	}
	
	public function get_new() {
		$symptom = new stdClass();
		$symptom->title = '';
		$symptom->latin_name = '';
		$symptom->description = '';
		$symptom->symptoms = array();
		return $symptom;
	}
	
}