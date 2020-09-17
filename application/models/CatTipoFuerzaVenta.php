<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatTipoFuerzaVenta extends MY_Model {

	protected $_table_name = 'cat_TipoFuerzaVenta';
	protected $_primary_key = 'tfv_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'tfv_id';
	public $_rules = array(
		'tfv_nombre' => array(
			'field' => 'tfv_nombre',
			'label' => 'nombre',
			'rules' => 'trim|required'
			),
		'tfv_observacion' => array(
			'field' => 'tfv_observacion',
			'label' => 'observacion',
			'rules' => 'trim|required'
			)
		);

	public function get_new(){
		$obj = new stdClass();
		$obj->tfv_nombre = '';
		$obj->tfv_observacion = '';
		return $obj;
	}
}

/* End of file CatTipoFuerzaVenta.php */
/* Location: ./application/models/CatTipoFuerzaVenta.php */