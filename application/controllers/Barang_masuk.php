<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_masuk extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_masuk_model');
    }

    public function index()
    {
        $data['title'] = 'Barang Masuk';
        $data['list']  = $this->Barang_masuk_model->get_all();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('barang_masuk/index',$data);
        $this->load->view('layouts/footer');
    }

    public function tambah()
    {
        if ($this->input->post()) {

            $simpan = $this->Barang_masuk_model->insert([
                'tanggal'    => $this->input->post('tanggal'),
                'id_barang'  => $this->input->post('id_barang'),
                'jumlah'     => $this->input->post('jumlah'),
                'satuan'     => $this->input->post('satuan'),
                'toko'       => $this->input->post('toko'),
                'perolehan'  => $this->input->post('perolehan'),
                'keterangan' => $this->input->post('keterangan')
            ]);

            if ($simpan) {
                $this->session->set_flashdata('success','Barang masuk berhasil disimpan');
            } else {
                $this->session->set_flashdata('error','Gagal menyimpan data');
            }

            redirect('barang_masuk');
        }

        $data['title']  = 'Tambah Barang Masuk';
        $data['barang'] = $this->Barang_masuk_model->get_barang();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('barang_masuk/form',$data);
        $this->load->view('layouts/footer');
    }

    // ===============================
    // EDIT
    // ===============================
    public function edit($id_masuk)
    {
        $data['title']  = 'Edit Barang Masuk';
        $data['row']    = $this->Barang_masuk_model->get_by_id($id_masuk);
        $data['barang'] = $this->Barang_masuk_model->get_barang();

        if (!$data['row']) {
            show_404();
        }

        if ($this->input->post()) {
            $this->Barang_masuk_model->update($id_masuk);
            $this->session->set_flashdata('success','Data berhasil diupdate');
            redirect('barang_masuk');
        }

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('barang_masuk/form',$data);
        $this->load->view('layouts/footer');
    }

    // ===============================
    // DELETE
    // ===============================
    public function delete($id_masuk)
    {
        $hapus = $this->Barang_masuk_model->delete($id_masuk);

        if ($hapus) {
            $this->session->set_flashdata('success','Data berhasil dihapus');
        } else {
            $this->session->set_flashdata('error','Gagal menghapus data');
        }

        redirect('barang_masuk');
    }
}
