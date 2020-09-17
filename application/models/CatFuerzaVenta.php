<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatFuerzaVenta extends MY_Model {

	protected $_table_name = 'cat_FuerzaVenta';
	protected $_primary_key = 'fve_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'fve_id';
	public $_rules = array(
		'fve_nombre' => array(
			'field' => 'fve_nombre',
			'label' => 'nombre',
			'rules' => 'trim|required'
			),
		'fve_descripcion' => array(
			'field' => 'fve_descripcion',
			'label' => 'descripcion',
			'rules' => 'trim|required'
			),
		'tfv_id' => array(
			'field' => 'tfv_id',
			'label' => 'tipo fuerza venta',
			'rules' => 'trim|required'
			)
		);

	public function get_new(){
		$obj = new stdClass();
		$obj->fve_nombre = '';
		$obj->fve_descripcion = '';
		$obj->tfv_id = '';
		return $obj;
	}
}

/* End of file CatFuerzaVenta.php */
/* Location: ./application/models/CatFuerzaVenta.php */