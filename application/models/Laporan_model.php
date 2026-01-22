<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

    public function barang_masuk()
    {
        return $this->db
            ->select('bm.tanggal, b.nama_barang, b.merk, bm.jumlah, bm.satuan, bm.perolehan, bm.toko')
            ->from('barang_masuk bm')
            ->join('barang b','b.id_barang=bm.id_barang')
            ->order_by('bm.tanggal','DESC')
            ->get()->result();
    }

    public function barang_keluar()
    {
        return $this->db
            ->select('bk.tanggal, b.nama_barang, b.merk, bk.jumlah, bk.pemohon, bk.keterangan')
            ->from('barang_keluar bk')
            ->join('barang b','b.id_barang=bk.id_barang')
            ->order_by('bk.tanggal','DESC')
            ->get()->result();
    }

    public function stok()
    {
        return $this->db->query("
            SELECT 
                b.nama_barang,
                b.merk,
                b.satuan,
                IFNULL(SUM(bm.jumlah),0)
                -
                IFNULL((
                    SELECT SUM(bk.jumlah)
                    FROM barang_keluar bk
                    WHERE bk.id_barang = b.id_barang
                ),0) AS stok
            FROM barang b
            LEFT JOIN barang_masuk bm ON bm.id_barang = b.id_barang
            GROUP BY b.id_barang, b.nama_barang, b.merk, b.satuan
            ORDER BY b.nama_barang
        ")->result();
    }

    public function get_barang()
{
    return $this->db
        ->select('id_barang, nama_barang, merk, satuan')
        ->from('barang')
        ->order_by('nama_barang','ASC')
        ->get()->result();
}
public function saldo_awal($id_barang, $awal)
{
    $masuk = $this->db
        ->select('IFNULL(SUM(jumlah),0) AS total')
        ->from('barang_masuk')
        ->where('id_barang',$id_barang)
        ->where('tanggal <',$awal)
        ->get()->row()->total;

    $keluar = $this->db
        ->select('IFNULL(SUM(jumlah),0) AS total')
        ->from('barang_keluar')
        ->where('id_barang',$id_barang)
        ->where('tanggal <',$awal)
        ->get()->row()->total;

    return $masuk - $keluar;
}
public function kartu_persediaan($id_barang, $awal, $akhir)
{
    return $this->db->query("
        SELECT tanggal, uraian, masuk, keluar
        FROM (
            SELECT 
                bm.tanggal,
                CONCAT('Barang Masuk (', bm.perolehan, ')') AS uraian,
                bm.jumlah AS masuk,
                0 AS keluar
            FROM barang_masuk bm
            WHERE bm.id_barang = '$id_barang'
              AND bm.tanggal BETWEEN '$awal' AND '$akhir'

            UNION ALL

            SELECT 
                bk.tanggal,
                CONCAT('Barang Keluar - ', bk.pemohon) AS uraian,
                0 AS masuk,
                bk.jumlah AS keluar
            FROM barang_keluar bk
            WHERE bk.id_barang = '$id_barang'
              AND bk.tanggal BETWEEN '$awal' AND '$akhir'
        ) t
        ORDER BY tanggal ASC
    ")->result();
}


}
