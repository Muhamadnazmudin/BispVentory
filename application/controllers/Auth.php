<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Auth_model');
    }

    public function login(){
        if($this->session->userdata('login') == TRUE){
            redirect('dashboard');
        }

        if($_POST){
            $user = $this->Auth_model->cek_login(
                $this->input->post('username')
            );

            if($user && password_verify(
                $this->input->post('password'),
                $user->password
            )){
                $this->session->set_userdata([
                    'login' => TRUE,
                    'id_user' => $user->id_user,
                    'nama' => $user->nama,
                    'role' => $user->role
                ]);
                redirect('dashboard');
            }else{
                $this->session->set_flashdata('error','Username atau password salah');
            }
        }

        $this->load->view('auth/login');
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
