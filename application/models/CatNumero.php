<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatNumero extends MY_Model {

	protected $_table_name = 'cat_numero';
	protected $_primary_key = 'num_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'num_id';
	public $_rules = array(
		'sim_id' => array(
			'field' => 'sim_id',
			'label' => 'sim',
			'rules' => 'trim|required'
			),
		'equ_id' => array(
			'field' => 'equ_id',
			'label' => 'equipo',
			'rules' => 'trim|required'
			),
		'num_numero' => array(
			'field' => 'num_numero',
			'label' => 'numero',
			'rules' => 'trim|required'
			),
		'num_fechaActivacion' => array(
			'field' => 'num_fechaActivacion',
			'label' => 'fecha activacion',
			'rules' => 'trim|required'
			)
		);

	public function get_new(){
		$obj = new stdClass();
		$obj->sim_id = '';
		$obj->equ_id = '';
		$obj->num_numero = '';
		$obj->num_fechaActivacion = '';
		return $obj;
	}
}

/* End of file CatNumero.php */
/* Location: ./application/models/CatNumero.php */