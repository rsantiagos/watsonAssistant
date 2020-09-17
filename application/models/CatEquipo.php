<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatEquipo extends MY_Model {

	protected $_table_name = 'cat_equipo';
	protected $_primary_key = 'equ_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'equ_id';
	public $_rules = array(
		'equ_imei' => array(
			'field' => 'equ_imei',
			'label' => 'imei',
			'rules' => 'trim|required'
			),
		'equ_tac' => array(
			'field' => 'equ_tac',
			'label' => 'tac',
			'rules' => 'trim|required'
			),
		'equ_sistemaOperativo' => array(
			'field' => 'equ_sistemaOperativo',
			'label' => 'sistema operativo',
			'rules' => 'trim|required'
			),
		'equ_modelo' => array(
			'field' => 'equ_modelo',
			'label' => 'modelo',
			'rules' => 'trim|required'
			),
		'equ_marca' => array(
			'field' => 'equ_marca',
			'label' => 'marca',
			'rules' => 'trim|required'
			)
		);

	public function get_new(){
		$obj = new stdClass();
		$obj->equ_imei = '';
		$obj->equ_tac = '';
		$obj->equ_sistemaOperativo = '';
		$obj->equ_modelo = '';
		$obj->equ_marca = '';
		return $obj;
	}
}

/* End of file CatEquipo.php */
/* Location: ./application/models/CatEquipo.php */