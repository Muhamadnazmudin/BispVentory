<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends MY_Controller {

    public function index()
    {
        $this->db->select('
    b.id_barang,
    b.nama_barang,
    b.merk,
    b.satuan,
    k.nama_kategori,
    (
        IFNULL(SUM(bm.jumlah),0)
        -
        IFNULL((
            SELECT SUM(bk.jumlah)
            FROM barang_keluar bk
            WHERE bk.id_barang = b.id_barang
        ),0)
    ) AS total_stok
');

$this->db->from('barang b');
$this->db->join('kategori_barang k','k.id_kategori = b.id_kategori','left');
$this->db->join('barang_masuk bm','bm.id_barang = b.id_barang','left');
$this->db->group_by('b.id_barang, b.nama_barang, b.merk, b.satuan, k.nama_kategori');

$data['stock'] = $this->db->get()->result();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('stock/index',$data);
        $this->load->view('layouts/footer');
    }
}
