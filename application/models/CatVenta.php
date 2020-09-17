<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatVenta extends MY_Model {

	protected $_table_name = 'cat_venta';
	protected $_primary_key = 'ven_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'ven_id';
	public $_rules = array(
		'ven_monto' => array(
			'field' => 'ven_monto',
			'label' => 'monto',
			'rules' => 'trim|required'
			),
		'ven_fecha' => array(
			'field' => 'ven_fecha',
			'label' => 'fecha',
			'rules' => 'trim|required'
			),
		'cta_id' => array(
			'field' => 'cta_id',
			'label' => 'cuenta',
			'rules' => 'trim|required'
			),
		'fve_id' => array(
			'field' => 'fve_id',
			'label' => 'fuerza venta',
			'rules' => 'trim|required'
			)
		);

	public function get_new(){
		$obj = new stdClass();
		$obj->ven_monto = '';
		$obj->ven_fecha = '';
		$obj->cta_id = '';
		$obj->fve_id = '';
		return $obj;
	}

	public function getPregunta1($cond){

		$this->db->select('fve_nombre, tfv_nombre, pln_nombre, COUNT(ven_id) AS portaciones');

		$this->db->join('cat_FuerzaVenta', 'cat_FuerzaVenta.fve_id = cat_venta.fve_id');
		$this->db->join('cat_TipoFuerzaVenta', 'cat_TipoFuerzaVenta.tfv_id = cat_FuerzaVenta.tfv_id');
		$this->db->join('cat_cuenta', 'cat_cuenta.cta_id = cat_venta.cta_id');
		$this->db->join('cat_plan', 'cat_plan.pln_id = cat_cuenta.pln_id');

		$this->db->group_by('cat_FuerzaVenta.fve_id');
		$this->_order_by = 'portaciones DESC';

		$where = 'cat_plan.pln_id = 3';

		if (isset($cond->fInicial) && !empty($cond->fInicial)) {
			$where .= ' AND cat_venta.ven_fecha >= "' . $cond->fInicial . '"';
		}

		if (isset($cond->fFinal) && !empty($cond->fFinal)) {
			$where .= ' AND cat_venta.ven_fecha <= "' . $cond->fFinal . '"';
		}

		return $this->get_by($where);
	}

	public function getPregunta2($cond){
		$this->db->select('reg_id, reg_nombre, count(num_id) totalLineas, vin_observacion AS movimiento');

		$this->db->join('cat_cuenta', 'cat_cuenta.cta_id = cat_venta.cta_id');
		$this->db->join('cat_plan', 'cat_plan.pln_id = cat_cuenta.pln_id');
		$this->db->join('vin_movimientoCuenta', 'vin_movimientoCuenta.cta_id = cat_cuenta.cta_id');
		$this->db->join('cat_movimiento', 'cat_movimiento.mov_id = vin_movimientoCuenta.mov_id');
		$this->db->join('cat_factura', 'cat_factura.ven_id = cat_venta.ven_id');
		$this->db->join('cat_estado', 'cat_estado.est_id = cat_factura.est_id');
		$this->db->join('cat_region', 'cat_region.reg_id = cat_estado.reg_id');
		$this->db->join('cat_coordenada', 'cat_coordenada.est_id = cat_estado.est_id');

		$this->db->group_by('cat_region.reg_id');
		$this->_order_by = 'cat_region.reg_id';

		$where = 'cat_plan.pln_id = 3';
		if (isset($cond->mes) && !empty($cond->mes)) {
			$where .= ' AND MONTH(fac_fecha) = ' . $mes;
		}

		if (isset($cond->anio) && !empty($cond->anio)) {
			$where .= ' AND YEAR(fac_fecha) = ' . $anio;
		}

		if (isset($cond->fInicial) && !empty($cond->fInicial)) {
			$where .= ' AND vin_movimientoCuenta.vin_fecha >= "' . $cond->fInicial . '"';
		}

		if (isset($cond->fFinal) && !empty($cond->fFinal)) {
			$where .= ' AND vin_movimientoCuenta.vin_fecha <= "' . $cond->fFinal . '"';
		}

		return $this->get_by($where);
	}
}

/* End of file CatVenta.php */
/* Location: ./application/models/CatVenta.php */