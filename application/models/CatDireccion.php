<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatDireccion extends MY_Model {

	protected $_table_name = 'cat_direccionPersona';
	protected $_primary_key = 'dir_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'dir_id';
	public $_rules = array(
		'dir_calle' => array(
			'field' => 'dir_calle',
			'label' => 'calle',
			'rules' => 'trim|required'
			),
		'dir_num' => array(
			'field' => 'dir_num',
			'label' => 'numero',
			'rules' => 'trim|required'
			),
		'dir_tipo' => array(
			'field' => 'dir_tipo',
			'label' => 'tipo',
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
			),
		'per_id' => array(
			'field' => 'cli_id',
			'label' => 'cliente',
			'rules' => 'trim|required'
			)
		);

	public function get_new(){
		$obj = new stdClass();
		$obj->dir_calle = '';
		$obj->dir_num = '';
		$obj->dir_tipo = '';
		$obj->loc_id = '';
		$obj->mun_id = '';
		$obj->est_id = '';
		$obj->per_id = '';
		return $obj;
	}
}

/* End of file CatDireccion.php */
/* Location: ./application/models/CatDireccion.php */