<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatCuenta extends MY_Model {

	protected $_table_name = 'cat_cuenta';
	protected $_primary_key = 'cta_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'cta_id';
	public $_rules = array(
		'num_id' => array(
			'field' => 'num_id',
			'label' => 'numero',
			'rules' => 'trim|required'
			),
		'per_id' => array(
			'field' => 'per_id',
			'label' => 'persona',
			'rules' => 'trim|required'
			),
		'pln_id' => array(
			'field' => 'pln_id',
			'label' => 'plan',
			'rules' => 'trim|required'
			)
		);

	public function get_new(){
		$obj = new stdClass();
		$obj->num_id = '';
		$obj->per_id = '';
		$obj->pln_id = '';
		return $obj;
	}
}

/* End of file CatCuenta.php */
/* Location: ./application/models/CatCuenta.php */