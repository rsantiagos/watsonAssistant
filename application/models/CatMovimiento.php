<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatMovimiento extends MY_Model {

	protected $_table_name = 'cat_movimiento';
	protected $_primary_key = 'mov_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'mov_id';
	public $_rules = array(
		'mov_nombre' => array(
			'field' => 'mov_nombre',
			'label' => 'nombre',
			'rules' => 'trim|required'
			),
		'mov_unidadMedicion' => array(
			'field' => 'mov_unidadMedicion',
			'label' => 'unidad medicion',
			'rules' => 'trim|required'
			),
		'mov_descripcion' => array(
			'field' => 'mov_descripcion',
			'label' => 'descripcion',
			'rules' => 'trim|required'
			)
		);

	public function get_new(){
		$obj = new stdClass();
		$obj->mov_nombre = '';
		$obj->mov_unidadMedicion = '';
		$obj->mov_descripcion = '';
		return $obj;
	}
}

/* End of file CatMovimiento.php */
/* Location: ./application/models/CatMovimiento.php */