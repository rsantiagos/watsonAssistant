<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_controller extends CI_Controller {
	public function index() {
		$this->load->view('layout/header');
		$this->load->view('chat/index');
		$this->load->view('layout/footer');
	}
}