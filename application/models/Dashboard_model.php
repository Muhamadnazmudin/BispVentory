<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    /*
    |--------------------------------------------------------------------------
    | HITUNG DATA TABEL
    |--------------------------------------------------------------------------
    */

    public function count($table)
    {
        return (int) $this->db->count_all($table);
    }


    /*
    |--------------------------------------------------------------------------
    | STATISTIK SPJ
    |--------------------------------------------------------------------------
    */

    public function total_spj_kebutuhan()
    {
        return (int) $this->db
            ->count_all('spj_kebutuhan');
    }


    public function total_spj_pemeriksaan()
    {
        return (int) $this->db
            ->count_all('spj_bast_pemeriksaan');
    }


    /*
    |--------------------------------------------------------------------------
    | PERMOHONAN
    |--------------------------------------------------------------------------
    */

    public function permohonan_total()
    {
        return (int) $this->db
            ->count_all('permohonan');
    }


    public function permohonan_status($status)
    {
        return (int) $this->db
            ->where('status', $status)
            ->from('permohonan')
            ->count_all_results();
    }


    /*
    |--------------------------------------------------------------------------
    | PENGELUARAN PER BULAN
    |--------------------------------------------------------------------------
    */

    public function pengeluaran_per_bulan($tahun)
    {
        $tahun = (int) $tahun;

        $result = $this->db
            ->select('
                MONTH(tanggal) AS bulan,
                SUM(jumlah) AS total
            ')
            ->from('barang_keluar')
            ->where('YEAR(tanggal) =', $tahun)
            ->group_by('MONTH(tanggal)')
            ->order_by('MONTH(tanggal)', 'ASC')
            ->get()
            ->result();


        /*
        | Default 12 bulan
        */

        $data = array_fill(1, 12, 0);


        foreach ($result as $row) {

            $bulan = (int) $row->bulan;

            if ($bulan >= 1 && $bulan <= 12) {

                $data[$bulan] =
                    (int) $row->total;
            }
        }


        return array_values($data);
    }


    /*
    |--------------------------------------------------------------------------
    | DAFTAR TAHUN PENGELUARAN
    |--------------------------------------------------------------------------
    */

    public function tahun_pengeluaran()
    {
        return $this->db
            ->select('YEAR(tanggal) AS tahun')
            ->from('barang_keluar')
            ->where('tanggal IS NOT NULL')
            ->group_by('YEAR(tanggal)')
            ->order_by('tahun', 'DESC')
            ->get()
            ->result();
    }


    /*
    |--------------------------------------------------------------------------
    | STOK MENIPIS
    |--------------------------------------------------------------------------
    */

    public function stok_menipis($batas = 5)
    {
        $batas = (int) $batas;


        return $this->db->query("
            SELECT
                b.id_barang,
                b.nama_barang,
                b.merk,
                b.satuan,

                (
                    IFNULL(SUM(bm.jumlah), 0)
                    -
                    IFNULL(
                        (
                            SELECT SUM(bk.jumlah)
                            FROM barang_keluar bk
                            WHERE bk.id_barang = b.id_barang
                        ),
                        0
                    )
                ) AS stok

            FROM barang b

            LEFT JOIN barang_masuk bm
                ON bm.id_barang = b.id_barang

            GROUP BY
                b.id_barang,
                b.nama_barang,
                b.merk,
                b.satuan

            HAVING stok <= ?

            ORDER BY stok ASC
        ", array($batas))->result();
    }
}