<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_keluar_model extends CI_Model {

    public function get_stok($id_barang)
    {
        $masuk = $this->db->select_sum('jumlah')
                          ->get_where('barang_masuk', ['id_barang'=>$id_barang])
                          ->row()->jumlah ?? 0;

        $keluar = $this->db->select_sum('jumlah')
                           ->get_where('barang_keluar', ['id_barang'=>$id_barang])
                           ->row()->jumlah ?? 0;

        return $masuk - $keluar;
    }

   public function get_all()
{
    $this->db->select('
        bk.id_keluar,
        bk.tanggal,
        bk.jumlah,
        bk.pemohon,
        bk.keterangan,
        b.nama_barang,
        b.merk,
        g.nama_guru,
        s.nama_siswa
    ');
    $this->db->from('barang_keluar bk');
    $this->db->join('barang b','b.id_barang = bk.id_barang');
    $this->db->join('guru g','g.id_guru = bk.id_guru','left');
    $this->db->join('siswa s','s.id_siswa = bk.id_siswa','left');
    $this->db->order_by('bk.id_keluar','DESC');

    return $this->db->get()->result();
}


    public function get_barang()
    {
        return $this->db
            ->select('id_barang, nama_barang, merk, satuan')
            ->get('barang')
            ->result();
    }

    public function get_guru()
    {
        return $this->db->get('guru')->result();
    }

    public function get_siswa()
    {
        return $this->db->get('siswa')->result();
    }

    public function insert($data)
    {
        return $this->db->insert('barang_keluar', $data);
    }
}
