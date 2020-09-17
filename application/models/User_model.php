<?php
class User_model extends CI_Model
{

    public $id;
    public $email;
    public $persona_id;
    public $emp_nombre;
    public $emp_apellidoPaterno;
    public $emp_apellidoMaterno;

    public function login_user()
    {   
        $this->db->select('u.id, u.email, emp_nombre, emp_apellidoPaterno', 'emp_apellidoMaterno');
        $this->db->from('users u');
        $this->db->join('cat_empleado', 'on empleado_id = emp_id', 'inner');
        $this->db->where(array('email' => $_POST['email'], 'password' => md5($_POST['password'])));
        $query = $this->db->get();
        $user = $query->row();
        return isset($user) ? $user : false;
    }

    /*public function insert_user()
    {
        $this->email   = $_POST['email']; // please read the below note
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->insert('users', $this);
    }

    public function update_user()
    {
        $this->title   = $_POST['title'];
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->update('users', $this, array('id' => $_POST['id']));
    }*/

}
