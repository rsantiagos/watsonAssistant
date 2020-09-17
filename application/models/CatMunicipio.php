<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatMunicipio extends MY_Model {

	protected $_table_name = 'cat_municipio';
	protected $_primary_key = 'mun_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'mun_id';
	public $_rules = array(
		'mun_nombre' => array(
			'field' => 'mun_nombre',
			'label' => 'nombre',
			'rules' => 'trim|required'
			),
		'est_id' => array(
			'field' => 'estado_id',
			'label' => 'estado',
			'rules' => 'trim|required'
			)
		);

	public function get_new(){
		$obj = new stdClass();
		$obj->mun_nombre = '';
		$obj->est_id = '';
		return $obj;
	}
}

/* End of file CatMunicipio.php */
/* Location: ./application/models/CatMunicipio.php */