<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatSim extends MY_Model {

	protected $_table_name = 'cat_sim';
	protected $_primary_key = 'sim_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'sim_id';
	public $_rules = array(
		'sim_version' => array(
			'field' => 'sim_version',
			'label' => 'version',
			'rules' => 'trim|required'
			),
		'sim_descripcion' => array(
			'field' => 'sim_descripcion',
			'label' => 'descripcion',
			'rules' => 'trim|required'
			)
		);

	public function get_new(){
		$obj = new stdClass();
		$obj->sim_version = '';
		$obj->sim_descripcion = '';
		return $obj;
	}
}

/* End of file CatSim.php */
/* Location: ./application/models/CatSim.php */