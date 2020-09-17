<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapa_mex extends CI_Controller {
	public function index() {
		$this->load->view('mapa_mex/index');
	}
}