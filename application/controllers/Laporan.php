<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_model');
    }

    public function masuk()
    {
        $data['title'] = 'Laporan Barang Masuk';
        $data['list']  = $this->Laporan_model->barang_masuk();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('laporan/barang_masuk',$data);
        $this->load->view('layouts/footer');
    }

    public function keluar()
    {
        $data['title'] = 'Laporan Barang Keluar';
        $data['list']  = $this->Laporan_model->barang_keluar();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('laporan/barang_keluar',$data);
        $this->load->view('layouts/footer');
    }

    public function stok()
    {
        $data['title'] = 'Laporan Sisa Stok';
        $data['list']  = $this->Laporan_model->stok();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('laporan/stok',$data);
        $this->load->view('layouts/footer');
    }

    public function buku_besar()
{
    $data['title'] = 'Kartu Persediaan Barang';

    $data['barang'] = $this->Laporan_model->get_barang();

    $id_barang = $this->input->get('id_barang');
    $awal      = $this->input->get('awal');
    $akhir     = $this->input->get('akhir');

    $data['id_barang'] = $id_barang;
    $data['awal']      = $awal;
    $data['akhir']     = $akhir;

    if ($id_barang && $awal && $akhir) {
        $data['saldo_awal'] = $this->Laporan_model
            ->saldo_awal($id_barang, $awal);

        $data['list'] = $this->Laporan_model
            ->kartu_persediaan($id_barang, $awal, $akhir);
    } else {
        $data['saldo_awal'] = null;
        $data['list']       = [];
    }

    $this->load->view('layouts/header');
    $this->load->view('layouts/sidebar');
    $this->load->view('layouts/topbar');
    $this->load->view('laporan/kartu_persediaan',$data);
    $this->load->view('layouts/footer');
}

}
