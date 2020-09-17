<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatFactura extends MY_Model {

	protected $_table_name = 'cat_factura';
	protected $_primary_key = 'fac_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'fac_id';
	public $_rules = array(
		'fac_fecha' => array(
			'field' => 'fac_fecha',
			'label' => 'fecha',
			'rules' => 'trim|required'
			),
		'fac_domicilio' => array(
			'field' => 'fac_domicilio',
			'label' => 'domicilio',
			'rules' => 'trim|required'
			),
		'ven_id' => array(
			'field' => 'ven_id',
			'label' => 'venta',
			'rules' => 'trim|required'
			),
		'loc_id' => array(
			'field' => 'loc_id',
			'label' => 'localidad',
			'rules' => 'trim|required'
			),
		'mun_id' => array(
			'field' => 'mun_id',
			'label' => 'municipio',
			'rules' => 'trim|required'
			),
		'est_id' => array(
			'field' => 'est_id',
			'label' => 'estado',
			'rules' => 'trim|required'
			)
		);

	public function get_new(){
		$obj = new stdClass();
		$obj->fac_fecha = '';
		$obj->fac_domicilio = '';
		$obj->ven_id = '';
		$obj->loc_id = '';
		$obj->mun_id = '';
		$obj->est_id = '';
		return $obj;
	}
}

/* End of file CatFactura.php */
/* Location: ./application/models/CatFactura.php */