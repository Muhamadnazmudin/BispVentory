<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';

        /* =========================
           CARD STATISTIK
        ========================== */
        $data['kategori'] = $this->Dashboard_model->count('kategori_barang');
        $data['barang']   = $this->Dashboard_model->count('barang');
        $data['ruangan']  = $this->Dashboard_model->count('ruangan');
        $data['guru']     = $this->Dashboard_model->count('guru');
        $data['siswa']    = $this->Dashboard_model->count('siswa');

        $data['permohonan_total']   = $this->Dashboard_model->permohonan_total();
        $data['permohonan_setujui'] = $this->Dashboard_model->permohonan_status('disetujui');
        $data['permohonan_tolak']   = $this->Dashboard_model->permohonan_status('ditolak');
        $data['permohonan_pending'] = $this->Dashboard_model->permohonan_status('pending');

        /* =========================
           GRAFIK (PAKAI TANGGAL)
        ========================== */
        $tahun_list = $this->Dashboard_model->tahun_pengeluaran();
        $data['tahun_list'] = $tahun_list;

        // tahun aktif
        $tahun = $this->input->get('tahun')
            ?? (!empty($tahun_list) ? $tahun_list[0]->tahun : date('Y'));

        $data['tahun'] = $tahun;

        $data['grafik_pengeluaran'] =
            $this->Dashboard_model->pengeluaran_per_bulan($tahun);

            /* =========================
   ALERT STOK MENIPIS
========================== */
$batas_stok = 10; // bisa diubah
$data['batas_stok'] = $batas_stok;

$data['stok_menipis'] =
    $this->Dashboard_model->stok_menipis($batas_stok);

$data['jumlah_stok_menipis'] =
    count($data['stok_menipis']);


        /* ========================= */
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('dashboard', $data);
        $this->load->view('layouts/footer');
    }
}
