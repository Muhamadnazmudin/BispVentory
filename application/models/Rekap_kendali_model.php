<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_kendali_model extends CI_Model {

    public function get_rekap($tahun)
    {
        // ambil kategori + kodering
        $kategori = $this->db
            ->select('id_kategori, kodering, nama_kategori')
            ->order_by('kodering','ASC')
            ->get('kategori_barang')
            ->result();

        $data = [];

        foreach ($kategori as $k) {

            // saldo awal = sebelum tahun berjalan
            $saldo_awal = $this->saldo_awal($k->id_kategori, $tahun);

            $row = [
                'kode'       => $k->kodering,
                'uraian'     => $k->nama_kategori,
                'saldo_awal' => $saldo_awal,
                'bulan'      => []
            ];

            $saldo = $saldo_awal;

            // JANUARI - DESEMBER
            for ($bulan = 1; $bulan <= 12; $bulan++) {

                $masuk  = $this->mutasi_masuk($k->id_kategori, $tahun, $bulan);
                $keluar = $this->mutasi_keluar($k->id_kategori, $tahun, $bulan);

                $saldo = $saldo + $masuk - $keluar;

                $row['bulan'][$bulan] = [
                    'masuk'  => $masuk,
                    'keluar' => $keluar,
                    'saldo'  => $saldo
                ];
            }

            $data[] = $row;
        }

        return $data;
    }

    // ===============================
    // SALDO AWAL (SEBELUM TAHUN)
    // ===============================
    private function saldo_awal($id_kategori, $tahun)
    {
        $sql = "
            SELECT
                IFNULL(SUM(bm.jumlah * b.harga),0)
                -
                IFNULL((
                    SELECT SUM(bk.jumlah * b.harga)
                    FROM barang_keluar bk
                    JOIN barang b ON b.id_barang = bk.id_barang
                    WHERE b.id_kategori = ?
                    AND YEAR(bk.tanggal) < ?
                ),0) AS saldo
            FROM barang_masuk bm
            JOIN barang b ON b.id_barang = bm.id_barang
            WHERE b.id_kategori = ?
            AND YEAR(bm.tanggal) < ?
        ";

        return (int) $this->db->query(
            $sql,
            [$id_kategori, $tahun, $id_kategori, $tahun]
        )->row()->saldo;
    }

    // ===============================
    // MUTASI MASUK PER BULAN
    // ===============================
    private function mutasi_masuk($id_kategori, $tahun, $bulan)
    {
        $sql = "
            SELECT IFNULL(SUM(bm.jumlah * b.harga),0) AS total
            FROM barang_masuk bm
            JOIN barang b ON b.id_barang = bm.id_barang
            WHERE b.id_kategori = ?
            AND YEAR(bm.tanggal) = ?
            AND MONTH(bm.tanggal) = ?
        ";

        return (int) $this->db->query(
            $sql,
            [$id_kategori, $tahun, $bulan]
        )->row()->total;
    }

    // ===============================
    // MUTASI KELUAR PER BULAN
    // ===============================
    private function mutasi_keluar($id_kategori, $tahun, $bulan)
    {
        $sql = "
            SELECT IFNULL(SUM(bk.jumlah * b.harga),0) AS total
            FROM barang_keluar bk
            JOIN barang b ON b.id_barang = bk.id_barang
            WHERE b.id_kategori = ?
            AND YEAR(bk.tanggal) = ?
            AND MONTH(bk.tanggal) = ?
        ";

        return (int) $this->db->query(
            $sql,
            [$id_kategori, $tahun, $bulan]
        )->row()->total;
    }
}
