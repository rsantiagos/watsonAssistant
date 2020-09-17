<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatLocalidad extends MY_Model {

	protected $_table_name = 'cat_localidad';
	protected $_primary_key = 'loc_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'loc_id';
	public $_rules = array(
		'loc_nombre' => array(
			'field' => 'loc_nombre',
			'label' => 'nombre',
			'rules' => 'trim|required'
			),
		'loc_tipo' => array(
			'field' => 'loc_tipo',
			'label' => 'tipo',
			'rules' => 'trim|required'
			),
		'loc_cp' => array(
			'field' => 'loc_cp',
			'label' => 'codigo postal',
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
		$obj->loc_nombre = '';
		$obj->loc_tipo = '';
		$obj->loc_cp = '';
		$obj->mun_id = '';
		$obj->est_id = '';
		return $obj;
	}
}

/* End of file CatLocalidad.php */
/* Location: ./application/models/CatLocalidad.php */