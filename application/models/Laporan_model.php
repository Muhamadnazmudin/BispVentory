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
public function laporan_mutasi_tahunan($tahun)
{
    $barang = $this->db->get('barang')->result();

    $hasil = [];

    foreach ($barang as $b) {

        $saldo = 0; // saldo awal januari

        for ($bulan = 1; $bulan <= 12; $bulan++) {

            // ===============================
            // BARANG MASUK
            // ===============================
            $masuk = $this->db->query("
                SELECT SUM(jumlah) AS total
                FROM barang_masuk
                WHERE id_barang = ?
                AND MONTH(tanggal) = ?
                AND YEAR(tanggal) = ?
            ", [$b->id_barang, $bulan, $tahun])->row()->total ?? 0;

            // ===============================
            // BARANG KELUAR
            // ===============================
            $keluar = $this->db->query("
                SELECT SUM(jumlah) AS total
                FROM barang_keluar
                WHERE id_barang = ?
                AND MONTH(tanggal) = ?
                AND YEAR(tanggal) = ?
            ", [$b->id_barang, $bulan, $tahun])->row()->total ?? 0;

            $saldo_akhir = $saldo + $masuk - $keluar;

            $data_bulan[$bulan] = [
                'saldo_awal'  => (int)$saldo,
                'masuk'       => (int)$masuk,
                'keluar'      => (int)$keluar,
                'saldo_akhir' => (int)$saldo_akhir
            ];

            $saldo = $saldo_akhir; // lanjut bulan berikutnya
        }

        $hasil[] = [
            'id_barang'   => $b->id_barang,
            'nama_barang' => $b->nama_barang,
            'bulan'       => $data_bulan
        ];
    }

    return $hasil;
}
public function mutasi_bulanan($bulan, $tahun)
{
    return $this->db->query("
        SELECT 
            b.id_barang,
            b.nama_barang,
            b.merk,
            b.satuan,
            kb.kodering,
            b.harga,

            -- dokumen (ambil salah satu, cukup untuk laporan)
            MAX(bm.no_faktur)   AS no_faktur,
            MAX(bm.no_kwitansi) AS no_kwitansi,
            MAX(bm.no_bast)     AS no_bast,

            -- TOTAL MASUK BULAN INI
            IFNULL(SUM(bm.jumlah),0) AS masuk_vol,
            IFNULL(SUM(bm.jumlah * b.harga),0) AS masuk_total,

            -- TOTAL KELUAR BULAN INI
            IFNULL(SUM(bk.jumlah),0) AS keluar_vol,
            IFNULL(SUM(bk.jumlah * b.harga),0) AS keluar_total

        FROM barang b
        JOIN kategori_barang kb 
            ON kb.id_kategori = b.id_kategori

        LEFT JOIN barang_masuk bm 
            ON bm.id_barang = b.id_barang
            AND MONTH(bm.tanggal) = ?
            AND YEAR(bm.tanggal) = ?

        LEFT JOIN barang_keluar bk
            ON bk.id_barang = b.id_barang
            AND MONTH(bk.tanggal) = ?
            AND YEAR(bk.tanggal) = ?

        GROUP BY b.id_barang
        ORDER BY kb.kodering, b.nama_barang
    ", [$bulan, $tahun, $bulan, $tahun])->result();
}

public function mutasi_range_bulan($bulan_awal, $bulan_akhir, $tahun)
{
    return $this->db->query("
        SELECT 
            b.nama_barang,
            b.merk,
            b.satuan,
            kb.kodering,
            b.harga,

            bm.no_faktur,
            bm.no_kwitansi,
            bm.no_bast,
            bm.tanggal,

            -- TOTAL MASUK (RANGE BULAN)
            IFNULL((
                SELECT SUM(jumlah)
                FROM barang_masuk
                WHERE id_barang = b.id_barang
                  AND YEAR(tanggal) = ?
                  AND MONTH(tanggal) BETWEEN ? AND ?
            ),0) AS masuk_vol,

            IFNULL((
                SELECT SUM(jumlah * b.harga)
                FROM barang_masuk
                WHERE id_barang = b.id_barang
                  AND YEAR(tanggal) = ?
                  AND MONTH(tanggal) BETWEEN ? AND ?
            ),0) AS masuk_total,

            -- TOTAL KELUAR (RANGE BULAN)
            IFNULL((
                SELECT SUM(jumlah)
                FROM barang_keluar
                WHERE id_barang = b.id_barang
                  AND YEAR(tanggal) = ?
                  AND MONTH(tanggal) BETWEEN ? AND ?
            ),0) AS keluar_vol,

            IFNULL((
                SELECT SUM(jumlah * b.harga)
                FROM barang_keluar
                WHERE id_barang = b.id_barang
                  AND YEAR(tanggal) = ?
                  AND MONTH(tanggal) BETWEEN ? AND ?
            ),0) AS keluar_total

        FROM barang b
        JOIN kategori_barang kb 
            ON kb.id_kategori = b.id_kategori

        LEFT JOIN barang_masuk bm 
            ON bm.id_barang = b.id_barang
            AND YEAR(bm.tanggal) = ?
            AND MONTH(bm.tanggal) BETWEEN ? AND ?

        ORDER BY kb.kodering, b.nama_barang
    ", [
        $tahun, $bulan_awal, $bulan_akhir,
        $tahun, $bulan_awal, $bulan_akhir,
        $tahun, $bulan_awal, $bulan_akhir,
        $tahun, $bulan_awal, $bulan_akhir,
        $tahun, $bulan_awal, $bulan_akhir
    ])->result();
}


}
