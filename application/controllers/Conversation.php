<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conversation extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library("Assistant");
		$this->load->library("Credentials");
		$this->load->library('session');
	}

	public function conversation() {

		if (!isset($_SESSION['id'])) {
			$this->output->set_header('Content-Type: application/json; charset=utf-8');
			$this->output->set_output(json_encode(array('not_logged_in' => true)));
		} else {
	    $query = $this->input->post('query');
	    $credenciales = new Credentials();
			$watson = new Assistant();
			$watson->set_credentials( $credenciales->get_Assistant_Credentials_User(),
	                              $credenciales->get_Assistant_Credentials_Password());
			$wid = $credenciales->get_Assistant_Id();

			$data_array = $watson->send_watson_conv_request($query,$wid);
			if(!empty($data_array['intents'])){
				$confidence = $data_array['intents'][0]['confidence'];
				if ($confidence <= 0.37){
					if(isset($data_array['context']['intentos'])){
						$intentos = $data_array['context']['intentos'];
						$data_array['context']['intentos'] = $intentos+1;
					}else{
						$data_array['context']['intentos'] = 1;
					}
				}
			}

			if(isset($this->session->userdata['per_nombre'])){
				$data_array['context']['usuario'] = $this->session->userdata('per_nombre');
			}else{
				$data_array['context']['usuario'] = NULL;
			}

			if(isset($data_array['output']['datos'])){
				if(isset($data_array['output']['datos']['pintaDate'])){
					if($data_array['output']['datos']['pintaDate'] == 'inicial'){
						$data_array['chat_ui']['datepicker'] = 'inicial';
						$data_array['context']["f_inicial"] = '2018-01-01' ;
					}elseif ($data_array['output']['datos']['pintaDate'] == 'final'){
						$data_array['chat_ui']['datepicker'] = 'final';
						$data_array['context']["f_final"] = '2018-01-15' ;
					}
				}

				if(isset($data_array['output']['datos']['button'])){
					$data_array['chat_ui']['button'] = true;
				}

				if(isset($data_array['output']['datos']['pregunta'])){
					$datos = (object) ['pregunta' => $data_array['output']['datos']['pregunta']];
					//creamos un objeto con las variables
					foreach ( $data_array['output']['datos'] as $key => $valor ) {
						if(!empty($valor)){
							$datos->$key = $valor;
						}
					}
					//hacemos la consulta dependiendo la pregunta
					$respuesta = $this->consulta($datos);
					//print_r($respuesta);
					if(count($data_array['output']['text'])>1){
						for($i=0; $i <= count($data_array['output']['text']); $i++) {
							if($i == 0 ){
								$salida[] = $data_array['output']['text'][$i];
							}else if($i == 1){
								$salida[$i] = $respuesta['text'];
							}else{
								$salida[$i] = $data_array['output']['text'][$i-1];
							}
						}
						$data_array['output']['text']=$salida;
					}else{
						$data_array['output']['text'][]=$respuesta['text'];
					}
					if(isset($respuesta['datos'])){
						$data_array['chat_ui']['datos'] = $respuesta['datos'];
					}else{
						$data_array['chat_ui']['datos'] = 'Error';
					}

				}
			}

			$this->session->set_userdata('context', json_encode($data_array['context']));
			$watson->set_context($this->session->userdata('context'));
			$this->output->set_header('Content-Type: application/json; charset=utf-8');
			$this->output->set_output(json_encode($data_array));
		}
  }

	private function consulta($datos){
		$datos->region = isset($datos->region)?$datos->region : '';
		$datos->estados =isset($datos->estados)?$datos->estados : '';
		$datos->mes = isset($datos->mes)?$datos->mes:12;
		$datos->top = isset($datos->top)?$datos->top:50;
		$datos->anio = isset($datos->anio)?$datos->anio:2017;
		switch ($datos->pregunta) {
			case 1://Top 5 de fuerza de venta
				$num_mes=$this->numMes($datos->mes);
				$top = $this->numTop($datos->top);

				if($datos->region!=''){
					//$respuesta["text"] = "Aqui va el valor que retorna la consulta 1 por region->".$datos->region;
					$respuesta["text"] = "";
				}else{
					if($datos->estados!=''){
						//$respuesta["text"] = "Aqui va el valor que retorna la consulta 1 por estado->".$datos->estados;
						$respuesta["text"] = "";
					}else{
						$sql = "
							SELECT tfv_id, fve_nombre, ven_fecha, ven_monto, pln_nombre
							FROM cat_venta
								INNER JOIN cat_FuerzaVenta USING (fve_id)
								INNER JOIN cat_TipoFuerzaVenta USING (tfv_id)
								INNER JOIN cat_cuenta USING (cta_id)
								INNER JOIN cat_numero USING (num_id)
								INNER JOIN cat_plan USING (pln_id)
							WHERE MONTH(ven_fecha) = $num_mes AND YEAR(ven_fecha) = $datos->anio
								AND pln_nombre = 'TELCEL PREPAGO'
							ORDER BY ven_monto DESC
							LIMIT $top;
						";
						$query=$this->db->query($sql);
						//$respuesta["text"]= "El top $top de fueza de venta en ".$datos->mes." de ".$datos->anio." se muestra en la gráfica";
						$respuesta["text"] = "";
					}
					$datos->top = $top;
					$datos->mes = $num_mes;
					$respuesta['datos'] = $datos;
					$respuesta['datos'] = $query->result_array();
				}
				break;
			case 2:
				$num_mes=$this->numMes($datos->mes);
				$f_inicial = $datos->fechas['f_inicial'];
				$f_final = $datos->fechas['f_final'];
				$sql = "
					SELECT reg_id, reg_nombre, count(num_id) totalLineas, fac_fecha,
						vin_observacion Movimiento, vin_fecha fechaMovimiento
					FROM cat_venta
						INNER JOIN cat_cuenta USING(cta_id)
						INNER JOIN cat_plan USING(pln_id)
						INNER JOIN vin_movimientoCuenta USING(cta_id)
						INNER JOIN cat_movimiento USING(mov_id)
						INNER JOIN cat_factura USING(ven_id)
						INNER JOIN cat_estado USING(est_id)
						INNER JOIN cat_region USING(reg_id)
						INNER JOIN cat_coordenada USING(est_id)
					WHERE MONTH(fac_fecha) = $num_mes AND YEAR(fac_fecha) = $datos->anio
						AND vin_fecha BETWEEN '$f_inicial' AND '$f_final'
						AND pln_id=3 # telcel pregado
						AND mov_id=1 AND vin_observacion='PRIMERA RECARGA'
					GROUP BY reg_id ORDER BY reg_id;
				";
				$query=$this->db->query($sql);
				//$respuesta["text"]= "El total de lineas por region se muestra en la gráfica";
				$respuesta["text"] = "";
				$datos->mes = $num_mes;
				$respuesta['datos'] = $datos;
				$respuesta['datos'] = $query->result_array();
				break;
			case 3:
				$num_mes=$this->numMes($datos->mes);
				$sql = "
					SELECT reg_id, reg_nombre, count(num_id) totalLineas#, fac_fecha
					FROM cat_venta
						INNER JOIN cat_cuenta USING(cta_id)
						INNER JOIN cat_plan USING(pln_id) # plan prepago
						INNER JOIN cat_factura USING(ven_id)
						INNER JOIN cat_estado USING(est_id)
						INNER JOIN cat_region USING(reg_id)
						INNER JOIN cat_coordenada USING(est_id)
						INNER JOIN cat_empleado USING(emp_id)
					WHERE MONTH(fac_fecha) = $num_mes AND YEAR(fac_fecha) = $datos->anio
						AND pln_id=3 # telcel pregado
						AND rol_id = (
							SELECT rol_id FROM telcel.cat_rol where rol_nombre = '$datos->rol'
                        ) # rol empleado LIDER
					GROUP BY reg_id ORDER BY count(num_id) ASC ;
				";
				$query=$this->db->query($sql);
				//$respuesta["text"]= "El total de lineas por region con rol $datos->rol se muestra en la gráfica";
				$respuesta["text"] = "";
				$datos->mes = $num_mes;
				$respuesta['datos'] = $datos;
				$respuesta['datos'] = $query->result_array();
				break;
			case 4:
				$num_mes = $this->numMes($datos->mes);
				$operador = $this->operadorCondicional($datos->condicional);
				$sql = "
					SELECT num_numero, reg_nombre, num_fechaActivacion, pln_nombre, v.fve_id venta, va.fve_id activacion
					FROM cat_factura
						INNER JOIN cat_venta v USING (ven_id)
						INNER JOIN cat_localidad USING (loc_id, mun_id,est_id)
						INNER JOIN cat_estado USING (est_id)
						INNER JOIN cat_region USING (reg_id)
						INNER JOIN cat_cuenta USING (cta_id)
						INNER JOIN cat_numero USING (num_id)
						INNER JOIN cat_plan USING (pln_id)
						INNER JOIN cat_FuerzaVenta USING (fve_id)
						INNER JOIN cat_activacionVenta va USING (cta_id)
					WHERE MONTH(ven_fecha) = $num_mes AND YEAR(ven_fecha) = $datos->anio
						AND reg_nombre = '$datos->region' AND pln_nombre='TELCEL PREPAGO'
						AND v.fve_id $operador va.fve_id
						ORDER BY num_fechaActivacion;
				";
				$query=$this->db->query($sql);
				//$respuesta["text"]= "Las lineas que se portaron en $datos->mes de $datos->anio y de la $datos->region se muestran en la tabla";
				$respuesta["text"] = "";
				$datos->mes = $num_mes;
				$datos->condicional = $operador;
				$respuesta['datos'] = $datos;
				$respuesta['datos'] = $query->result_array();
				break;
			case 5:
				//print_r('got in');
				$num_mes=$this->numMes($datos->mes);
				$sql = "
					SELECT " . ($datos->estados ? 'CONCAT(reg_id,"-",est_id), est_nombre AS nombre' : 'reg_id, reg_nombre AS nombre') . ", SUM(vin_duracion)TotalMG
					FROM cat_venta
						INNER JOIN cat_cuenta USING(cta_id)
						INNER JOIN cat_plan USING(pln_id) # plan prepago
						INNER JOIN cat_factura USING(ven_id)
						INNER JOIN cat_estado USING(est_id)
						INNER JOIN cat_region USING(reg_id)
						INNER JOIN vin_movimientoCuenta USING(cta_id)
					WHERE MONTH(vin_fecha) = $num_mes AND YEAR(vin_fecha) = $datos->anio
						AND pln_id=3 # telcel pregado
						AND mov_id = 6 # navegacion internet
						" . ($datos->estados ? 'AND est_nombre like "%' . $datos->estados . '%"' : '') . "
					group by " . ($datos->estados ? 'est_id,reg_id' : 'reg_id') . "
					order by SUM(vin_duracion) DESC
					LIMIT 1;";
				//print_r($sql);
				$query=$this->db->query($sql);
				//$respuesta["text"]= "La region $result->reg_id es la que descargo mas megabytes con la cantidad de $result->TotalMG megabytes";
				$respuesta["text"] = "";
				$datos->mes = $num_mes;
				$respuesta['datos'] = $query->result_array();
				break;
			default:
				//$respuesta["text"] = "No hay respuesta para la pregunta".$datos->pregunta;
				$respuesta["text"] = "";
				break;
		}
		return $respuesta;
	}

	private function numMes($mes){
		switch ($mes) {
			case 'enero':
				$num = 1;
				break;
			case 'febrero':
				$num = 2;
				break;
			case 'marzo':
				$num = 3;
				break;
			case 'abril':
				$num = 4;
				break;
			case 'mayo':
				$num = 5;
				break;
			case 'junio':
				$num = 6;
				break;
			case 'julio':
				$num = 7;
				break;
			case 'agosto':
				$num = 8;
				break;
			case 'septiembre':
				$num = 9;
				break;
			case 'octubre':
				$num = 10;
				break;
			case 'noviembre':
				$num = 11;
				break;
			case 'diciembre':
				$num = 12;
				break;
			default:
				$num = 1;
		}
		return $num;
	}

	private function numTop($top){
		switch ($top) {
			case 'limit5':
				$num = 5;
				break;
			case 'limit10':
				$num = 10;
				break;
			default:
				$num = 5;
				break;
		}
		return $num;
	}

	private function operadorCondicional($condicional){
		switch ($condicional) {
			case 'diferente':
				$operador = '<>';
				break;
			case 'igual':
				$operador = '=';
				break;
			default:
				$operador = '<>';
				break;

		}
		return $operador;
	}

}
