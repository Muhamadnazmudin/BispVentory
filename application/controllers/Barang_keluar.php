<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_keluar extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_keluar_model');
    }

    public function index()
{
    $data['title'] = 'Barang Keluar';
    $data['list']  = $this->Barang_keluar_model->get_all();

    $this->load->view('layouts/header');
    $this->load->view('layouts/sidebar');
    $this->load->view('layouts/topbar');
    $this->load->view('barang_keluar/index',$data);
    $this->load->view('layouts/footer');
}


    public function tambah()
    {
        if ($this->input->post()) {

            $id_barang = $this->input->post('id_barang');
            $jumlah    = (int)$this->input->post('jumlah');

            $stok = $this->Barang_keluar_model->get_stok($id_barang);

            if ($jumlah > $stok) {
                $this->session->set_flashdata(
                    'error',
                    'Stok tidak mencukupi. Sisa stok: '.$stok
                );
                redirect('barang_keluar/tambah');
            }

            $pemohon = $this->input->post('pemohon');

            $this->Barang_keluar_model->insert([
                'tanggal'   => $this->input->post('tanggal'),
                'id_barang' => $id_barang,
                'jumlah'    => $jumlah,
                'pemohon'   => $pemohon,
                'id_guru'   => $pemohon == 'guru' ? $this->input->post('id_guru') : NULL,
                'id_siswa'  => $pemohon == 'siswa' ? $this->input->post('id_siswa') : NULL,
                'keterangan'=> $this->input->post('keterangan')
            ]);

            $this->session->set_flashdata('success','Barang keluar berhasil disimpan');
            redirect('barang_keluar');
        }

        $data['title']  = 'Tambah Barang Keluar';
        $data['barang'] = $this->Barang_keluar_model->get_barang();
        $data['guru']   = $this->Barang_keluar_model->get_guru();
        $data['siswa']  = $this->Barang_keluar_model->get_siswa();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('barang_keluar/form',$data);
        $this->load->view('layouts/footer');
    }
    public function hapus($id)
{
    $row = $this->db
        ->get_where('barang_keluar',['id_keluar'=>$id])
        ->row();

    if(!$row){
        $this->session->set_flashdata('error','Data tidak ditemukan');
        redirect('barang_keluar');
    }

    // HAPUS DATA BARANG KELUAR
    $this->db->delete('barang_keluar',['id_keluar'=>$id]);

    // ⚠️ TIDAK PERLU UPDATE STOK
    // karena stok dihitung dari:
    // barang_masuk - barang_keluar

    $this->session->set_flashdata(
        'success',
        'Pengeluaran barang dibatalkan. Stok otomatis dikembalikan.'
    );
    redirect('barang_keluar');
}

}
