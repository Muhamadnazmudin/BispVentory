<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kategori_model');
    }

    public function index()
    {
        $data['title'] = 'Kategori Barang';
        $data['kategori'] = $this->Kategori_model->get_all();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('kategori/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambah()
    {
        if ($this->input->post()) {
            $this->Kategori_model->insert([
                'nama_kategori' => $this->input->post('nama_kategori'),
                'keterangan'    => $this->input->post('keterangan')
            ]);
            $this->session->set_flashdata('success','Data berhasil disimpan');
            redirect('kategori');
        }

        $data['title'] = 'Tambah Kategori';
        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('kategori/form', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        if ($this->input->post()) {
            $this->Kategori_model->update($id, [
                'nama_kategori' => $this->input->post('nama_kategori'),
                'keterangan'    => $this->input->post('keterangan')
            ]);
            $this->session->set_flashdata('success','Data berhasil diupdate');
            redirect('kategori');
        }

        $data['title'] = 'Edit Kategori';
        $data['row']   = $this->Kategori_model->get_by_id($id);

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('kategori/form', $data);
        $this->load->view('layouts/footer');
    }

    public function hapus($id)
    {
        $this->Kategori_model->delete($id);
        $this->session->set_flashdata('success','Data berhasil dihapus');
        redirect('kategori');
    }
}
