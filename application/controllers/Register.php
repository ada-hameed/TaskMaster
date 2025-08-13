<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property User_model $User_model
 */
class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
        $this->load->view('register');
    }

    public function store() {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $mobile = $this->input->post('mobile'); 
        $password = $this->input->post('password');

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'name' => $name,
            'email' => $email,
            'contact_number' => $mobile,
            'password' => $hashed_password
        ];

        $this->User_model->insert_user($data);
        $this->session->set_flashdata('toastr_success', 'Registration successful. You can now login.');
        redirect('login');
    }
}
