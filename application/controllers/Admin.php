<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index()
    {
        $data['title'] = 'Data Admin';
        $data['admin'] = $this->User_model->get_admin();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('admin/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambah()
    {
        if ($this->input->post()) {

            if ($this->User_model->cek_username(
                $this->input->post('username')
            )) {
                $this->session->set_flashdata(
                    'error','Username sudah digunakan'
                );
                redirect('admin/tambah');
            }

            $this->User_model->insert([
                'username' => $this->input->post('username'),
                'password' => password_hash(
                    $this->input->post('password'),
                    PASSWORD_DEFAULT
                ),
                'nama'     => $this->input->post('nama'),
                'role'     => 'admin'
            ]);

            $this->session->set_flashdata(
                'success','Admin berhasil ditambahkan'
            );
            redirect('admin');
        }

        $data['title'] = 'Tambah Admin';
        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('admin/form', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        if ($this->input->post()) {

            $data = [
                'nama'     => $this->input->post('nama'),
                'username' => $this->input->post('username')
            ];

            if ($this->input->post('password')) {
                $data['password'] = password_hash(
                    $this->input->post('password'),
                    PASSWORD_DEFAULT
                );
            }

            $this->User_model->update($id, $data);
            $this->session->set_flashdata(
                'success','Admin berhasil diupdate'
            );
            redirect('admin');
        }

        $data['title'] = 'Edit Admin';
        $data['row']   = $this->User_model->get_by_id($id);

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('admin/form', $data);
        $this->load->view('layouts/footer');
    }

    public function hapus($id)
    {
        $this->User_model->delete($id);
        $this->session->set_flashdata(
            'success','Admin berhasil dihapus'
        );
        redirect('admin');
    }
}
