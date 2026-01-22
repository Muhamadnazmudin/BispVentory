<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_ruangan extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_ruangan_model');
    }

    public function index()
    {
        $data['title'] = 'Barang Ruangan';
        $data['list']  = $this->Barang_ruangan_model->get_all();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('barang_ruangan/index',$data);
        $this->load->view('layouts/footer');
    }

    public function tambah()
    {
        if ($this->input->post()) {
            $this->Barang_ruangan_model->insert([
                'id_barang'  => $this->input->post('id_barang'),
                'id_ruangan' => $this->input->post('id_ruangan'),
                'jumlah'     => $this->input->post('jumlah'),
                'keterangan' => $this->input->post('keterangan')
            ]);
            $this->session->set_flashdata('success','Data berhasil disimpan');
            redirect('barang_ruangan');
        }

        $data['title']   = 'Tambah Barang Ruangan';
        $data['barang']  = $this->Barang_ruangan_model->get_barang();
        $data['ruangan'] = $this->Barang_ruangan_model->get_ruangan();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('barang_ruangan/form',$data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        if ($this->input->post()) {
            $this->Barang_ruangan_model->update($id,[
                'id_barang'  => $this->input->post('id_barang'),
                'id_ruangan' => $this->input->post('id_ruangan'),
                'jumlah'     => $this->input->post('jumlah'),
                'keterangan' => $this->input->post('keterangan')
            ]);
            $this->session->set_flashdata('success','Data berhasil diupdate');
            redirect('barang_ruangan');
        }

        $data['title']   = 'Edit Barang Ruangan';
        $data['row']     = $this->Barang_ruangan_model->get_by_id($id);
        $data['barang']  = $this->Barang_ruangan_model->get_barang();
        $data['ruangan'] = $this->Barang_ruangan_model->get_ruangan();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('barang_ruangan/form',$data);
        $this->load->view('layouts/footer');
    }

    public function hapus($id)
    {
        $this->Barang_ruangan_model->delete($id);
        $this->session->set_flashdata('success','Data berhasil dihapus');
        redirect('barang_ruangan');
    }
}
