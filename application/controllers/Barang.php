<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_model');
    }

    public function index()
    {
        $data['title']  = 'Data Barang';
        $data['barang'] = $this->Barang_model->get_all();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('barang/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambah()
    {
        if ($this->input->post()) {
            $this->Barang_model->insert([
                'kode_barang' => $this->input->post('kode_barang'),
                'nama_barang' => $this->input->post('nama_barang'),
                'merk'        => $this->input->post('merk'),
                'id_kategori' => $this->input->post('id_kategori'),
                'satuan'      => $this->input->post('satuan'),
                'keterangan'  => $this->input->post('keterangan')
            ]);
            $this->session->set_flashdata('success','Data barang berhasil disimpan');
            redirect('barang');
        }

        $data['title']    = 'Tambah Barang';
        $data['kategori'] = $this->Barang_model->get_kategori();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('barang/form', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        if ($this->input->post()) {
            $this->Barang_model->update($id, [
                'kode_barang' => $this->input->post('kode_barang'),
                'nama_barang' => $this->input->post('nama_barang'),
                'id_kategori' => $this->input->post('id_kategori'),
                'satuan'      => $this->input->post('satuan'),
                'keterangan'  => $this->input->post('keterangan')
            ]);
            $this->session->set_flashdata('success','Data barang berhasil diupdate');
            redirect('barang');
        }

        $data['title']    = 'Edit Barang';
        $data['row']      = $this->Barang_model->get_by_id($id);
        $data['kategori'] = $this->Barang_model->get_kategori();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('barang/form', $data);
        $this->load->view('layouts/footer');
    }

    public function hapus($id)
    {
        $this->Barang_model->delete($id);
        $this->session->set_flashdata('success','Data barang berhasil dihapus');
        redirect('barang');
    }
}
