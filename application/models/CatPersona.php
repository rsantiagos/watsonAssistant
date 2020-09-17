<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatPersona extends MY_Model {

	protected $_table_name = 'cat_persona';
	protected $_primary_key = 'per_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'per_id';
	public $_rules = array(
		'per_nombre' => array(
			'field' => 'per_nombre',
			'label' => 'nombre',
			'rules' => 'trim|required'
			),
		'per_apellidoPaterno' => array(
			'field' => 'per_apellidoPaterno',
			'label' => 'apellido paterno',
			'rules' => 'trim|required'
			),
		'per_apellidoMaterno' => array(
			'field' => 'per_apellidoMaterno',
			'label' => 'apellido materno',
			'rules' => 'trim|required'
			),
		'per_fechaNacimiento' => array(
			'field' => 'per_fechaNacimiento',
			'label' => 'fecha nacimiento',
			'rules' => 'trim|required'
			),
		'per_sexo' => array(
			'field' => 'per_sexo',
			'label' => 'sexo',
			'rules' => 'trim|required'
			),
		'per_curp' => array(
			'field' => 'per_curp',
			'label' => 'curp',
			'rules' => 'trim|required'
			),
		'per_rfc' => array(
			'field' => 'per_rfc',
			'label' => 'rfc',
			'rules' => 'trim|required'
			),
		'per_tipo' => array(
			'field' => 'per_tipo',
			'label' => 'tipo',
			'rules' => 'trim|required'
			),
		'per_numeroTelefono' => array(
			'field' => 'per_numeroTelefono',
			'label' => 'numero telefono',
			'rules' => 'trim|required'
			)
		);

	public function get_new(){
		$obj = new stdClass();
		$obj->per_nombre = '';
		$obj->per_apellidoPaterno = '';
		$obj->per_apellidoMaterno = '';
		$obj->per_fechaNacimiento = '';
		$obj->per_sexo = '';
		$obj->per_curp = '';
		$obj->per_rfc = '';
		$obj->per_tipo = '';
		$obj->per_numeroTelefono = '';
		return $obj;
	}
}

/* End of file CatPersona.php */
/* Location: ./application/models/CatPersona.php */