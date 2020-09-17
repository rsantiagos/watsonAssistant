<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatEstado extends MY_Model {

	protected $_table_name = 'cat_estado';
	protected $_primary_key = 'est_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'est_nombre';
	public $_rules = array(
		'est_nombre' => array(
			'field' => 'est_nombre',
			'label' => 'nombre',
			'rules' => 'trim|required'
			),
		'est_lada' => array(
			'field' => 'est_lada',
			'label' => 'lada',
			'rules' => 'trim|required'
			),
		'reg_id' => array(
			'field' => 'reg_id',
			'label' => 'region',
			'rules' => 'trim|required'
			)
		);

	public function get_new(){
		$obj = new stdClass();
		$obj->est_nombre = '';
		$obj->est_lada = '';
		$obj->reg_id = '';
		return $obj;
	}

	public function getByRegion($nombreRegion){
		$this->db->join('cat_region', 'cat_region.reg_id = cat_estado.reg_id');
		return $this->get_by('cat_region.reg_nombre LIKE "%' . $nombreRegion . '%"');
	}

	public function getByNombre($nombreEstado){
		$this->db->join('cat_region', 'cat_region.reg_id = cat_estado.reg_id');
		return $this->get_by('cat_estado.est_nombre LIKE "%' . $nombreEstado . '%"');
	}
}

/* End of file CatEstado.php */
/* Location: ./application/models/CatEstado.php */