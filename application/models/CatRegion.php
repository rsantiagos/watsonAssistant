<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatRegion extends MY_Model {

	protected $_table_name = 'cat_region';
	protected $_primary_key = 'reg_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'reg_nombre';
	public $_rules = array(
		'reg_nombre' => array(
			'field' => 'reg_nombre',
			'label' => 'nombre',
			'rules' => 'trim|required'
			),
		'reg_descripcion' => array(
			'field' => 'reg_descripcion',
			'label' => 'descripcion',
			'rules' => 'trim|required'
			)
		);

	public function get_new(){
		$obj = new stdClass();
		$obj->reg_nombre = '';
		$obj->reg_descripcion = '';
		return $obj;
	}

	public function getListaRegiones(){

		$consultaReg = $this->db->query('
			SELECT r.reg_id, r.reg_nombre, r.reg_color, 
				CONCAT(r.reg_nombre," - ", GROUP_CONCAT(e.est_abreviatura SEPARATOR ", ")) AS est
			FROM telcel.cat_region AS r
			INNER JOIN telcel.cat_estado AS e USING (reg_id)
			GROUP BY reg_id;
		');

		return $consultaReg->result();
	}
}

/* End of file CatRegion.php */
/* Location: ./application/models/CatRegion.php */