<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    // hitung isi tabel
    public function count($table)
    {
        return $this->db->count_all($table);
    }

    // total permohonan
    public function permohonan_total()
    {
        return $this->db->count_all('permohonan');
    }

    // permohonan per status
    public function permohonan_status($status)
    {
        return $this->db
            ->where('status',$status)
            ->from('permohonan')
            ->count_all_results();
    }
    public function pengeluaran_per_bulan($tahun)
{
    $result = $this->db->query("
        SELECT 
            MONTH(tanggal) AS bulan,
            SUM(jumlah) AS total
        FROM barang_keluar
        WHERE YEAR(tanggal) = ?
        GROUP BY MONTH(tanggal)
        ORDER BY MONTH(tanggal)
    ", [$tahun])->result();

    // default 12 bulan = 0
    $data = array_fill(1, 12, 0);

    foreach ($result as $r) {
        $data[(int)$r->bulan] = (int)$r->total;
    }

    return array_values($data); // index 0–11
}

public function tahun_pengeluaran()
{
    return $this->db->query("
        SELECT DISTINCT YEAR(tanggal) AS tahun
        FROM barang_keluar
        ORDER BY tahun DESC
    ")->result();
}
public function stok_menipis($batas = 5)
{
    return $this->db->query("
        SELECT 
            b.id_barang,
            b.nama_barang,
            b.merk,
            b.satuan,
            (
                IFNULL(SUM(bm.jumlah),0)
                -
                IFNULL((
                    SELECT SUM(bk.jumlah)
                    FROM barang_keluar bk
                    WHERE bk.id_barang = b.id_barang
                ),0)
            ) AS stok
        FROM barang b
        LEFT JOIN barang_masuk bm ON bm.id_barang = b.id_barang
        GROUP BY b.id_barang, b.nama_barang, b.merk, b.satuan
        HAVING stok <= ?
        ORDER BY stok ASC
    ", [$batas])->result();
}


}
