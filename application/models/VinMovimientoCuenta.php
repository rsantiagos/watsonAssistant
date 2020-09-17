<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VinMovimientoCuenta extends MY_Model {

	protected $_table_name = 'vin_movimientoCuenta';
	protected $_primary_key = 'vin_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'vin_id';
	public $_rules = array(
		'vin_fecha' => array(
			'field' => 'vin_fecha',
			'label' => 'fecha',
			'rules' => 'trim|required'
			),
		'vin_duracion' => array(
			'field' => 'vin_duracion',
			'label' => 'duracion',
			'rules' => 'trim|required'
			),
		'vin_observacion' => array(
			'field' => 'vin_observacion',
			'label' => 'observacion',
			'rules' => 'trim|required'
			),
		'mov_id' => array(
			'field' => 'mov_id',
			'label' => 'movimiento',
			'rules' => 'trim|required'
			),
		'cta_id' => array(
			'field' => 'cta_id',
			'label' => 'cuenta',
			'rules' => 'trim|required'
			)
		);

	public function get_new(){
		$obj = new stdClass();
		$obj->vin_fecha = '';
		$obj->vin_duracion = '';
		$obj->vin_observacion = '';
		$obj->mov_id = '';
		$obj->cta_id = '';
		return $obj;
	}
}

/* End of file VinMovimientoCuenta.php */
/* Location: ./application/models/VinMovimientoCuenta.php */