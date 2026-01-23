<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

    /* ===============================
       BARANG MASUK (FILTER BULAN & TAHUN)
    =============================== */
    public function barang_masuk($bulan = null, $tahun = null)
    {
        $this->db
            ->select('bm.tanggal, b.nama_barang, b.merk, bm.jumlah, bm.satuan, bm.perolehan, bm.toko')
            ->from('barang_masuk bm')
            ->join('barang b','b.id_barang=bm.id_barang');

        if (!empty($bulan)) {
            $this->db->where('MONTH(bm.tanggal)', $bulan);
        }

        if (!empty($tahun)) {
            $this->db->where('YEAR(bm.tanggal)', $tahun);
        }

        return $this->db
            ->order_by('bm.tanggal','DESC')
            ->get()
            ->result();
    }

    /* ===============================
       BARANG KELUAR
    =============================== */
    public function barang_keluar($bulan = null, $tahun = null)
{
    $this->db
        ->select('bk.tanggal, b.nama_barang, b.merk, bk.jumlah, bk.pemohon, bk.keterangan')
        ->from('barang_keluar bk')
        ->join('barang b', 'b.id_barang = bk.id_barang');

    if (!empty($bulan)) {
        $this->db->where('MONTH(bk.tanggal)', $bulan);
    }

    if (!empty($tahun)) {
        $this->db->where('YEAR(bk.tanggal)', $tahun);
    }

    return $this->db
        ->order_by('bk.tanggal', 'DESC')
        ->get()
        ->result();
}

    /* ===============================
       LAPORAN STOK
    =============================== */
    public function stok($bulan = null, $tahun = null)
{
    // default: sampai hari ini
    $batasTanggal = date('Y-m-d');

    if (!empty($bulan) && !empty($tahun)) {
        // ambil tanggal terakhir di bulan tsb
        $batasTanggal = date('Y-m-t', strtotime($tahun.'-'.$bulan.'-01'));
    } elseif (!empty($tahun)) {
        // kalau hanya tahun → sampai akhir tahun
        $batasTanggal = $tahun.'-12-31';
    }

    return $this->db->query("
        SELECT 
            b.nama_barang,
            b.merk,
            b.satuan,

            (
                SELECT IFNULL(SUM(jumlah),0)
                FROM barang_masuk
                WHERE id_barang = b.id_barang
                  AND tanggal <= ?
            )
            -
            (
                SELECT IFNULL(SUM(jumlah),0)
                FROM barang_keluar
                WHERE id_barang = b.id_barang
                  AND tanggal <= ?
            )
            AS stok

        FROM barang b
        ORDER BY b.nama_barang ASC
    ", [$batasTanggal, $batasTanggal])->result();
}


    /* ===============================
       MASTER BARANG
    =============================== */
    public function get_barang()
    {
        return $this->db
            ->select('id_barang, nama_barang, merk, satuan')
            ->from('barang')
            ->order_by('nama_barang','ASC')
            ->get()
            ->result();
    }

    /* ===============================
       SALDO AWAL KARTU PERSEDIAAN
    =============================== */
    public function saldo_awal($id_barang, $awal)
    {
        $masuk = $this->db
            ->select('IFNULL(SUM(jumlah),0) AS total')
            ->from('barang_masuk')
            ->where('id_barang',$id_barang)
            ->where('tanggal <',$awal)
            ->get()
            ->row()
            ->total;

        $keluar = $this->db
            ->select('IFNULL(SUM(jumlah),0) AS total')
            ->from('barang_keluar')
            ->where('id_barang',$id_barang)
            ->where('tanggal <',$awal)
            ->get()
            ->row()
            ->total;

        return $masuk - $keluar;
    }

    /* ===============================
       KARTU PERSEDIAAN
    =============================== */
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
                WHERE bm.id_barang = ?
                  AND bm.tanggal BETWEEN ? AND ?

                UNION ALL

                SELECT 
                    bk.tanggal,
                    CONCAT('Barang Keluar - ', bk.pemohon) AS uraian,
                    0 AS masuk,
                    bk.jumlah AS keluar
                FROM barang_keluar bk
                WHERE bk.id_barang = ?
                  AND bk.tanggal BETWEEN ? AND ?
            ) t
            ORDER BY tanggal ASC
        ", [
            $id_barang, $awal, $akhir,
            $id_barang, $awal, $akhir
        ])->result();
    }

}
