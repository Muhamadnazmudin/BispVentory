<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    /*
    |--------------------------------------------------------------------------
    | TOTAL SPJ KEBUTUHAN
    |--------------------------------------------------------------------------
    */

    public function total_spj_kebutuhan()
    {
        return (int) $this->db
            ->count_all('spj_kebutuhan');
    }


    /*
    |--------------------------------------------------------------------------
    | TOTAL DETAIL BARANG
    |--------------------------------------------------------------------------
    |
    | Data barang pada sistem sekarang berasal dari:
    | spj_kebutuhan_detail
    |
    */

    public function total_detail_barang()
    {
        return (int) $this->db
            ->count_all('spj_kebutuhan_detail');
    }


    /*
    |--------------------------------------------------------------------------
    | TOTAL BAST PEMERIKSAAN
    |--------------------------------------------------------------------------
    */

    public function total_spj_pemeriksaan()
    {
        return (int) $this->db
            ->count_all('spj_bast_pemeriksaan');
    }


    /*
    |--------------------------------------------------------------------------
    | TOTAL BAST INTERNAL
    |--------------------------------------------------------------------------
    |
    | BAST Internal disimpan pada tabel:
    | spj_kebutuhan
    |
    | Sebuah kebutuhan dianggap sudah memiliki BAST Internal
    | apabila:
    |
    | - nomor_bast_internal terisi
    | - tanggal_bast_internal terisi
    |
    | Logika ini dibuat sama persis dengan halaman:
    | spj/bast_internal/index.php
    |
    */

    public function total_spj_internal()
    {
        return (int) $this->db
            ->where('nomor_bast_internal IS NOT NULL', null, false)
            ->where('nomor_bast_internal !=', '')
            ->where('tanggal_bast_internal IS NOT NULL', null, false)
            ->where('tanggal_bast_internal !=', '')
            ->from('spj_kebutuhan')
            ->count_all_results();
    }
}