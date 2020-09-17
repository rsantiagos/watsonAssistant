<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatCoordenada extends MY_Model {

	protected $_table_name = 'cat_coordenada';
	protected $_primary_key = 'coo_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'coo_id';
	public $_rules = array(
		'est_id' => array(
			'field' => 'est_id',
			'label' => 'estado',
			'rules' => 'trim|required'
			),
		'coo_coordenadas' => array(
			'field' => 'coo_coordenadas',
			'label' => 'coordenadas',
			'rules' => 'trim|required'
			)
		);

	public function get_new(){
		$obj = new stdClass();
		$obj->est_id = '';
		$obj->coo_coordenadas = '';
		return $obj;
	}

}

/* End of file CatCoordenada.php */
/* Location: ./application/models/CatCoordenada.php */