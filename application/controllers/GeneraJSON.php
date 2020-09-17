<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GeneraJSON extends CI_Controller {

	public function index(){

		//$this->load->view('mapa_mex/index');
		//$this->data['mapaRegion'] = $this->mapa(1);//Pinta la region
		//this->data['mapaEstado'] = $this->mapa(1, true);//Pinta el estado
		$this->data['grafica'] = $this->charts(3);//Pinta la grafica
		$this->load->view('welcome_message', $this->data);
		//$this->load->view('amchart/index', $this->data, false);
		
	}
	
	public function mapa(){

		$this->load->model('CatRegion');
		$this->load->model('CatEstado');

		$entrada = $this->input->post('entrada');
		$estado = $this->input->post('estado');

		$map = new stdClass();
		$map->name = 'mexico';
		$map->zoom = new stdClass();
		$map->zoom->enabled = 'true';
		$map->zoom->maxLevel = 10;

		$legend = new stdClass();
		$legend->area = new stdClass();
		$legend->area->display = true;
		$legend->area->title = 'REGIONES DE VENTA TELCEL';
		$legend->area->mode = 'vertical';
		$legend->area->slices = array();

		//CONSULTA DE LAS REGIONES
		foreach ($this->CatRegion->getListaRegiones() as $region) {
			$slices = new stdClass();
			$slices->max = $region->reg_id;
			$slices->min = $region->reg_id;
			$slices->attrs = new stdClass();
			$slices->attrs->fill = '#' . $region->reg_color;
			$slices->label = $region->est;
			array_push($legend->area->slices, $slices);
		}

		//CONSULTA DE LOS ESTADOS
		if (!empty($entrada) && $estado) {
			$consultaEst = $this->CatEstado->getByNombre($entrada);
		} elseif ( !empty($entrada) && !$estado) {
			$consultaEst = $this->CatEstado->getByRegion($entrada);
		}

		$areas = new stdClass();
		foreach ($consultaEst as $fila){
			$areas->{$fila->est_nombre} = new stdClass();
			$areas->{$fila->est_nombre}->value = $fila->reg_id;
			$areas->{$fila->est_nombre}->href = '#';
			$areas->{$fila->est_nombre}->tooltip = new stdClass();
			$areas->{$fila->est_nombre}->tooltip->content = '<span style="font-weight:bold;">' . $fila->reg_nombre . '</span> - ' . $fila->est_nombre;
		}

		$mapa = new stdClass();
		$mapa->map = $map;
		$mapa->legend = $legend;
		$mapa->areas = $areas;

		$this->data['script'] = '$(".mapcontainer").mapael(' . json_encode($mapa, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . ');';
		$vista = $this->load->view('mapa_mex/index', $this->data, TRUE);
		$this->output->set_output($vista);
		//$this->output->set_output($sqlMapa);
	}

	public function charts(){

		$obj = new stdClass();
		$obj->region = $this->input->post('region');
		$obj->estado = $this->input->post('estado');
		$obj->mes = $this->input->post('mes');
		$obj->anio = $this->input->post('anio');
		$obj->top = $this->input->post('top');
		$obj->fInicial = $this->input->post('fInicial');
		$obj->fFinal = $this->input->post('fFinal');
		$obj->rol = $this->input->post('rol');
		$obj->condicional = $this->input->post('condicional');
		$obj->pregunta = $this->input->post('pregunta');

		$amcharts = new stdClass();

		switch ($obj->pregunta) {
			case 1:
				$this->load->model('CatVenta');
				$resultado = $this->CatVenta->getPregunta1($obj);

				$amcharts->type = 'serial';
				$amcharts->dataProvider = array();
				foreach ($resultado as $fila){
					$valores = new stdClass();
					$valores->fve_nombre = $fila->fve_nombre;
					$valores->portaciones = $fila->portaciones;
					array_push($amcharts->dataProvider, $valores);
				}
				$amcharts->categoryField = 'fve_nombre';
				$amcharts->rotate = true;
				
				$amcharts->categoryAxis = new stdClass();
				$amcharts->categoryAxis->gridPosition = 'start';
				$amcharts->categoryAxis->axisColor = '#DADADA';

				$amcharts->valueAxes = array();
				$valAx = new stdClass();
				$valAx->axisAlpha = 0.2;
				array_push($amcharts->valueAxes, $valAx);

				$amcharts->graphs = array();
				$gra = new stdClass();
				$gra->type = 'column';
				$gra->title = 'PORTACIONES';
				$gra->valueField = 'portaciones';
				$gra->lineAlpha = 0;
				$gra->fillColors = '#ADD981';
				$gra->fillAlphas = 0.8;
				$gra->balloonText = '[[title]] EN [[category]]:<b>[[value]]</b>';
				array_push($amcharts->graphs, $gra);

				break;

			case 2:
				$sql = '
					SELECT reg_id, reg_nombre, count(num_id) totalLineas, #fac_fecha,
						vin_observacion Movimiento#, vin_fecha fechaMovimiento
					FROM cat_venta
						INNER JOIN cat_cuenta USING(cta_id)
						INNER JOIN cat_plan USING(pln_id)
						INNER JOIN vin_movimientoCuenta USING(cta_id)
						INNER JOIN cat_movimiento USING(mov_id)
						INNER JOIN cat_factura USING(ven_id)
						INNER JOIN cat_estado USING(est_id)
						INNER JOIN cat_region USING(reg_id)
						INNER JOIN cat_coordenada USING(est_id)
					WHERE pln_id=3 #PREPAGO
						AND mov_id=1
						AND vin_observacion="PRIMERA RECARGA"';

				if (!empty($mes)) {
					$sql .= '
						AND MONTH(fac_fecha) = ' . $mes;
				}

				if (!empty($anio)) {
					$sql .= '
						AND YEAR(fac_fecha) = ' . $anio;
				}

				if (!empty($f_inicial) && !empty($f_final)) {
					$sql .= '
						AND vin_fecha BETWEEN "' . $f_inicial . '" AND "' . $f_final . '"';
				}

				$sql .= '
					GROUP BY reg_id ORDER BY reg_id;';
		
				$resultado = $this->db->query($sql)->result();

				$amcharts->type = 'serial';
				$amcharts->dataProvider = array();
				foreach ($resultado as $fila){
					$valores = new stdClass();
					$valores->reg_nombre = $fila->reg_nombre;
					$valores->totalLineas = $fila->totalLineas;
					array_push($amcharts->dataProvider, $valores);
				}
				$amcharts->categoryField = 'reg_nombre';
				$amcharts->rotate = true;
				
				$amcharts->categoryAxis = new stdClass();
				$amcharts->categoryAxis->gridPosition = 'start';
				$amcharts->categoryAxis->axisColor = '#DADADA';

				$amcharts->valueAxes = array();
				$valAx = new stdClass();
				$valAx->axisAlpha = 0.2;
				array_push($amcharts->valueAxes, $valAx);

				$amcharts->graphs = array();
				$gra = new stdClass();
				$gra->type = 'column';
				$gra->title = 'TOTAL DE LÍNEAS';
				$gra->valueField = 'totalLineas';
				$gra->lineAlpha = 0;
				$gra->fillColors = '#ADD981';
				$gra->fillAlphas = 0.8;
				$gra->balloonText = '[[title]] EN [[category]]:<b>[[value]]</b>';
				array_push($amcharts->graphs, $gra);

				break;

			case 3:
				$sql = '
					SELECT reg_id, reg_nombre, count(num_id) totalLineas#, fac_fecha
					FROM cat_venta
						INNER JOIN cat_cuenta USING(cta_id)
						INNER JOIN cat_plan USING(pln_id) # plan prepago
						INNER JOIN cat_factura USING(ven_id)
						INNER JOIN cat_estado USING(est_id)
						INNER JOIN cat_region USING(reg_id)
						INNER JOIN cat_coordenada USING(est_id)
						INNER JOIN cat_empleado USING(emp_id)
					WHERE pln_id=3 # telcel pregado
						AND rol_id = 3 # rol empleado LIDER
			      ';

				if (!empty($mes)) {
					$sql .= '
						AND MONTH(fac_fecha) = ' . $mes;
				}

				if (!empty($anio)) {
					$sql .= '
						AND YEAR(fac_fecha) = ' . $anio;
				}

				$sql .= '
					GROUP BY reg_id ORDER BY count(num_id) ASC;';
		
				$resultado = $this->db->query($sql)->result();

				$amcharts->type = 'serial';
				$amcharts->dataProvider = array();
				foreach ($resultado as $fila){
					$valores = new stdClass();
					$valores->reg_nombre = $fila->reg_nombre;
					$valores->totalLineas = $fila->totalLineas;
					array_push($amcharts->dataProvider, $valores);
				}
				$amcharts->categoryField = 'reg_nombre';
				$amcharts->rotate = true;
				
				$amcharts->categoryAxis = new stdClass();
				$amcharts->categoryAxis->gridPosition = 'start';
				$amcharts->categoryAxis->axisColor = '#DADADA';

				$amcharts->valueAxes = array();
				$valAx = new stdClass();
				$valAx->axisAlpha = 0.2;
				array_push($amcharts->valueAxes, $valAx);

				$amcharts->graphs = array();
				$gra = new stdClass();
				$gra->type = 'column';
				$gra->title = 'TOTAL DE LÍNEAS';
				$gra->valueField = 'totalLineas';
				$gra->lineAlpha = 0;
				$gra->fillColors = '#ADD981';
				$gra->fillAlphas = 0.8;
				$gra->balloonText = '[[title]] EN [[category]]:<b>[[value]]</b>';
				array_push($amcharts->graphs, $gra);

				/*foreach ($resultado->result() as $fila){
					$props = new stdClass();
					$props->category = $fila->reg_nombre;
					$props->value1 = $fila->totalLineas;
					array_push($amcharts, $props);
				}*/
				break;

		}

		$this->data['grafica'] = 'AmCharts.makeChart( "chartdivd", ' . json_encode($amcharts, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . ');';
		$vista = $this->load->view('amchart/index', $this->data, TRUE);
		$this->output->set_output($vista);
		//return $this->data['grafica'];
	}

}

/* End of file GeneraJSON.php */
/* Location: ./application/controllers/GeneraJSON.php */