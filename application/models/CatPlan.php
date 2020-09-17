<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatPlan extends MY_Model {

	protected $_table_name = 'cat_plan';
	protected $_primary_key = 'pln_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'pln_id';
	public $_rules = array(
		'pln_clave' => array(
			'field' => 'pln_clave',
			'label' => 'clave',
			'rules' => 'trim|required'
			),
		'pln_nombre' => array(
			'field' => 'pln_nombre',
			'label' => 'nombre',
			'rules' => 'trim|required'
			),
		'pln_descripcion' => array(
			'field' => 'pln_descripcion',
			'label' => 'descripcion',
			'rules' => 'trim|required'
			)
		);

	public function get_new(){
		$obj = new stdClass();
		$obj->pln_clave = '';
		$obj->pln_nombre = '';
		$obj->pln_descripcion = '';
		return $obj;
	}
}

/* End of file CatPlan.php */
/* Location: ./application/models/CatPlan.php */