<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Guru_model');
    }

    public function index()
    {
        $data['title'] = 'Data Guru';
        $data['guru']  = $this->Guru_model->get_all();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('guru/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambah()
    {
        if ($this->input->post()) {
            $this->Guru_model->insert([
                'nama_guru' => $this->input->post('nama_guru'),
                'nip'       => $this->input->post('nip'),
                'jabatan'   => $this->input->post('jabatan')
            ]);
            $this->session->set_flashdata('success','Data guru berhasil ditambahkan');
            redirect('guru');
        }

        $data['title'] = 'Tambah Guru';
        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('guru/form', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        if ($this->input->post()) {
            $this->Guru_model->update($id, [
                'nama_guru' => $this->input->post('nama_guru'),
                'nip'       => $this->input->post('nip'),
                'jabatan'   => $this->input->post('jabatan')
            ]);
            $this->session->set_flashdata('success','Data guru berhasil diupdate');
            redirect('guru');
        }

        $data['title'] = 'Edit Guru';
        $data['row']   = $this->Guru_model->get_by_id($id);

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('guru/form', $data);
        $this->load->view('layouts/footer');
    }

    public function hapus($id)
    {
        $this->Guru_model->delete($id);
        $this->session->set_flashdata('success','Data guru berhasil dihapus');
        redirect('guru');
    }
}
