<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Medicine_m extends MY_Model {

	protected $_table_name = 'medicine';
	protected $_order_by = 'title';
	protected $_primary_key = 'medicine_id';
	protected $_rules = array();
	protected $_timestamps = FALSE;

	public $rules = array(
			'title' => array(
				'field' => 'title',
				'label' => 'Navn',
				'rules' => 'trim|required|max_length[30]|xss_clean'
			),
			'usage' => array(
				'field' => 'usage',
				'label' => 'Anvendelse',
				'rules' => 'trim|required|max_length[255]|xss_clean'
			),
			'doses' => array(
				'field' => 'doses[]',
				'label' => 'Dosering',
				'rules' => 'required|max_length[150]'
			),
			'symptoms' => array(
				'field' => 'symptoms[]',
				'label' => 'Symptomer',
				'rules' => ''
			),
			'price_doses' => array(
				'field' => 'price_doses[]',
				'label' => 'Pris disponeringsform',
				'rules' => 'trim|required|xss_clean'
			),
			'price_price' => array(
				'field' => 'price_price[]',
				'label' => 'Pris',
				'rules' => 'trim|required|numeric'
			),
			'price_quantity' => array(
				'field' => 'price_quantity[]',
				'label' => 'Antal',
				'rules' => 'trim|required'
			),
			'price_quantity_type' => array(
				'field' => 'price_quantity_type[]',
				'label' => 'Antal type',
				'rules' => 'trim|required'
			),
			'price_receipt_required' => array(
				'field' => 'price_receipt_required[]',
				'label' => 'Pris recept',
				'rules' => 'natural'
			)
		);

	public function __construct() {
		parent::__construct();
	}

	public function get($id = NULL, $single = FALSE) {
		$r = parent::get($id, $single);

		if ($id || $single) {
			// Get doses
			$r->doses = $this->db
				->where('medicine', $id ? $id : $r->$_primary_key)
				->get('doses')
				->result();

			// Get prices
			$r->prices = $this->db
				->where('medicine', $id ? $id : $r->$_primary_key)
				->get('medicine_prices')
				->result();

			// Get symptoms
			$r->symptom_types = $this->symptom_m->get_by_type_for('medicine', $r->medicine_id);
		}
		return $r;
	}

	public function get_medicine_symptoms($id) {
		$sympts = $this->db
				->select('symptom')
				->where('medicine', $id)
				->get('medicine_symptoms')
				->result();
		$symptoms = array();
		foreach ($sympts as $symptom) {
			$symptoms[] = $symptom->symptom;
		}
		return $symptoms;
	}

	public function get_index() {
		$this->db
			->select('DISTINCT LEFT(title, 1) letter', FALSE)
			->order_by('letter ASC');
		return $this->get();
	}

	public function get_top($limit) {
		$this->db
			->select('COUNT(medicine_visits_id) visits, medicine.*')
			->join('medicine_visits', 'medicine = medicine_id', 'left')
			->group_by('medicine_id')
			->order_by('visits DESC, title ASC')
			->limit($limit);
		return $this->get();
	}

	public function get_user_medicine($user) {
		$this->db
			->join('user_medicine', 'medicine = medicine_id')
			->where('user', $user);
		return $this->get();
	}

	public function addView($id) {
		$this->db->set('medicine', $id)->insert('medicine_visits');
	}

	public function save($data, $id = NULL) {
		// Remove symptoms list from array
		$symptoms = $data['symptoms'];
		unset($data['symptoms']);

		// Remove doses list from array
		$doses = $data['doses'];
		unset($data['doses']);

		// Remove prices list from array
		$prices = $data['prices'];
		unset($data['prices']);

		// Save medicine
		$id = parent::save($data, $id);

		
		// Clear medicines symptoms
		$this->db->where('medicine', $id)->delete('medicine_symptoms');
		// Prepare medicines symptoms
		if ($symptoms) {
			$sympts = array();
			foreach ($symptoms as $symptom) {
				$sympts[] = array('medicine' => $id, 'symptom' => $symptom);
			}
			// Save medicine
			$this->db->insert_batch('medicine_symptoms', $sympts);
		}

		
		// Clear medicines prices
		$this->db->where('medicine', $id)->delete('medicine_prices');
		// Prepare medicines prices
		$prics = array();
		foreach ($prices as $price) {
			$prics[] = array(
					'medicine'			=> $id,
					'price'				=> $price['price'],
					'receipt_required'	=> $price['receipt_required'],
					'quantity'			=> $price['quantity'],
					'quantity_type'		=> $price['quantity_type'],
					'doses'				=> $price['doses']
				);
		}
		// Save prices
		$this->db->insert_batch('medicine_prices', $prics);


		// Clear medicines doses
		$this->db->where('medicine', $id)->delete('doses');
		// Prepare medicines doses
		$doss = array();
		foreach ($doses as $dose) {
			$doss[] = array('medicine' => $id, 'text' => $dose);
		}
		// Save doses
		$this->db->insert_batch('doses', $doss);
	}

	public function addToUser($medicine, $user) {
		$r = $this->db
			->where('user', $user)
			->where('medicine', $medicine)
			->get('user_medicine')
			->result();
		if (count($r)) return FALSE;
		$this->db
			->set('medicine', $medicine)
			->set('user', $user)
			->insert('user_medicine');
		return TRUE;
	}

	public function removeFromUser($medicine, $user) {
		$this->db
			->where('user', $user)
			->where('medicine', $medicine)
			->delete('user_medicine');
	}

	public function is_users_medicine($medicine, $user) {
		$r = $this->db
			->where('user', $user)
			->where('medicine', $medicine)
			->get('user_medicine')
			->result();
		return count($r);
	}
	
	public function get_new() {
		$medicine = new stdClass();
		$medicine->title = '';
		$medicine->usage = '';
		$medicine->symptoms = array();
		$medicine->prices = array();
		$medicine->doses = array();
		return $medicine;
	}
	
}