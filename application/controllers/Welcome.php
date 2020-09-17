<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Discovery");
        $this->load->library("Credentials");
        $this->load->library('session');
    }

    public function index()
    {
        // $param=$this->load->view('welcome_message');
        //$vista = $this->load->view('welcome_message', array(), true);
        //$this->output->set_output($vista);
    }

    public function mostrarDiscovery()
    {
        $query['query']=$this->input->post('query');
        $vista = $this->load->view('Discovery', $query, true);
        $this->output->set_output($vista);
    }

    public function discovery()
    {
        $query=$this->input->post('consulta');
        $discovery = new Discovery();
        $resultado = $discovery->queryDiscovery($query);
        //$res=json_encode($resultado['results'][0]['enriched_text'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $res=json_encode($resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $datos = $this->jsonVis($res);
        echo $datos;
    }

    public function jsonVis($discoveryResult)
    {
        $obj = json_decode($discoveryResult);
        $nodesGen = array();
        $edgesGen = array();
        $group = '';
        $color = '';
        $jsonConstruct = '';
        for ($i = 0; $i < count($obj->results); $i++) {
            switch ($obj->results[$i]->enriched_text->sentiment->document->label) {
                case "neutral":
                    $color = "#FFB61E";
                    break;
                case "positive":
                    $color = "#37a000";
                    break;
                case "negative":
                    $color = "#E5343D";
                    break;
                default:
                    $color = "#5b69bc";
            }
            // if (!empty($obj->results[$i]->fecha)) {
            // 		$fecha = $obj->results[$i]->fecha;
            // 	}
            // 	else {
            // 		$fecha = $obj->results[$i]->published;
            // 	}
            array_push(
                $nodesGen,
                    array(
                        'id' => $obj->results[$i]->id,
                        'label' => "sin titulo",//$obj->results[$i]->title,
                        'shape' => 'icon',
                        'group' => 'noticia',
                        'medio' => "sin url",//parse_url($obj->results[$i]->url)["host"],
                        'icon' => array('color' => $color),
                        'text' => $obj->results[$i]->text,
                        'title' => "sin titulo",//$obj->results[$i]->title,
                        'published' => "",//$fecha,
                        'fuente' => "sin url",//parse_url($obj->results[$i]->url)["host"],
                        'sent' => $obj->results[$i]->enriched_text->sentiment->document->label,
                        'entities' => $this->removeDuplicates("text", $obj->results[$i]->enriched_text->entities),
                    )
            );
            $leo = array();
            for ($j=0; $j < count($obj->results[$i]->enriched_text->entities); $j++) {
                array_push(
                    $leo,
                    array(
                                    'text'=> $obj->results[$i]->enriched_text->entities[$j]->text,
                                    'type'=> $obj->results[$i]->enriched_text->entities[$j]->type
                                )
                );
            }
            $unique = $this->removeDuplicates("text", $leo);
            for ($l = 0; $l < count($unique); $l++) {
                switch ($unique[$l]['text']) {
                    case 'Axtel':
                        $shapeType = 'image';
                    break;
                    default:
                        $shapeType = 'icon';
                    break;
                }
                switch ($unique[$l]['type']) {
                    case 'DIRECTIVOS_TELMEX':
                        $group = 'persona';
                        $color = '#2493FE';
                    break;
                    case 'DIRECTIVOS_IZZI':
                        $group = 'persona';
                        $color = '#FF9800';
                    break;
                    case 'DIRECTIVOS_AXTEL':
                        $group = 'persona';
                        $color = '#007EC0';
                    break;
                    case 'DIRECTIVOS_TOTALPLAY':
                        $group = 'persona';
                        $color = '#007EC2';
                    break;
                    case 'COMISIONADOS_IFT':
                        $group = 'persona';
                        $color = '#007EC2';
                    break;
                    case 'EMPRESAS_TV':
                        $group = 'empresa';
                        $color = '#919191';
                    break;
                    case 'EMPRESAS_TELECOMUNICACIONES':
                        $group = 'empresa';
                        $color = '#919191';
                    break;
                    case 'EMPRESAS_INTERNET':
                        $group = 'empresa';
                        $color = '#919191';
                    break;
                    case 'FABRICANTES':
                        $group = 'fabrica';
                        $color = '#919191';
                    break;
                    case 'TEMA_RIESGO':
                        $group = 'riesgo';
                        $color = '#ff0000';
                    break;
                    case 'TEMAS_RIESGO':
                        $group = 'riesgo';
                        $color = '#ff0000';
                    break;
                    case 'MALA_PERCEPCION':
                        $group = 'fallas';
                        $color = '#ff0000';
                    break;
                    case 'INTERNET_FALLAS':
                        $group = 'fallas';
                        $color = '#ff0000';
                    break;
                    case 'IFT':
                        $group = 'riesgo';
                        $color = '#9f3014';
                    break;
                    case 'REGULADORES':
                        $group = 'riesgo';
                        $color = '#9f3014';
                    break;
                    case 'INTERNET':
                        $group = 'telecomunicacion';
                        $color = '#b0de09';
                    break;
                    case 'COLUMNISTAS':
                        $group = 'persona';
                        $color = '#007EC2';
                    break;
                    case 'TELECOMUNICACIONES':
                        $group = 'telecomunicacion';
                        $color = '#b0de09';
                    break;
                    case 'MEDIOS_AAA':
                        $group = 'medios';
                        $color = '#5780ae';
                    break;
                    default:
                        $group = 'empty';
                        $color = '#fff';
                    break;
                }
                $newId = $this->encrypt($unique[$l]['text']);
                array_push($nodesGen, array(
                    'id'=> $newId,
                    'leonardo' => $obj->results[$i]->text,
                    'label' => $unique[$l]['text'],
                    'shape' => $shapeType,
                    'image' => 'assets/dist/img/mini-logo.png',
                    'icon' => array('color' => $color),
                    'group' => $group
                ));
                array_push($edgesGen, array(
                    'from' => $obj->results[$i]->id, 'to' => $newId
                ));
            }
        }

        $nodesGen = $this->removeDuplicates("id", $nodesGen);
        $discoveryNews = array('nodesGen' => $nodesGen, 'edgesGen' => $edgesGen);
        $discoveryNews = json_encode($discoveryNews);
        return $discoveryNews;
    }

    public function removeDuplicates($key, $data)
    {
        $_data = array();
        $array = json_decode(json_encode($data), true);
        foreach ($array as $v) {
            $leo = $v[$key];

            if (isset($_data[$leo])) {
                continue;
            }
            // remember unique item
            $_data[$leo] = $v;
        }
        // if you need a zero-based array, otheriwse work with $_data
        $array = array_values($_data);
        return $array;
    }

    public function encrypt($text)
    {
        $crypted = crypt($text, 'st');
        return $crypted;
    }
}
