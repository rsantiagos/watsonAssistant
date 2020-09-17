<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("User_model");
    }

    public function login()
    {
        if ($user = $this->User_model->login_user()) {
            $this->session->set_userdata(get_object_vars($user));
            $this->session->set_flashdata('notify', array('status' => 1, 'message' => '¡Bienvenido ' . $user->emp_nombre . ' ' . $user->emp_apellidoPaterno . '!'));
            redirect(base_url());
        } else {
    		$this->session->set_flashdata('notify', array('status' => 0, 'message' => 'Usuario no encontrado. Intenta con otro email y/o contraseña.'));
            $this->session->set_flashdata('data', $_POST);
            redirect(base_url());
        }
    }

    public function logout()
    {
        $emp_nombre = $_SESSION['emp_nombre'];
        $emp_apellidoPaterno = $_SESSION['emp_apellidoPaterno'];
        $this->session->sess_destroy();
        $this->session->set_userdata(array('nothing' => 1));
        $this->session->set_flashdata('notify', array('status' => 2, 'message' => '¡Hasta luego ' . $emp_nombre . ' ' . $emp_apellidoPaterno . '!'));
        redirect(base_url());
    }

}
