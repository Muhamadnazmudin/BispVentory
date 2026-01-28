<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_masuk_model extends CI_Model {

    // =========================
    // LIST DATA
    // =========================
    public function get_all()
    {
        $this->db->select('
            bm.id_masuk,
            bm.tanggal,
            bm.no_faktur,
            bm.no_kwitansi,
            bm.no_bast,
            bm.jumlah,
            bm.satuan,
            bm.perolehan,
            bm.toko,
            bm.keterangan,
            b.nama_barang,
            b.merk,
            b.harga
        ');
        $this->db->from('barang_masuk bm');
        $this->db->join('barang b','b.id_barang = bm.id_barang');
        return $this->db->order_by('bm.id_masuk','ASC')
                        ->get()
                        ->result();
    }

    // =========================
    // DATA BARANG (DROPDOWN)
    // =========================
    public function get_barang()
    {
        return $this->db
            ->select('b.*, k.nama_kategori')
            ->from('barang b')
            ->join('kategori_barang k','k.id_kategori = b.id_kategori')
            ->get()
            ->result();
    }

    // =========================
    // INSERT (MANUAL + IMPORT)
    // =========================
    public function insert($data)
    {
        $this->db->trans_start();

        // insert barang masuk
        $this->db->insert('barang_masuk', $data);

        // update stok barang
        $this->db->set('stok', 'stok + '.$data['jumlah'], false)
                 ->where('id_barang', $data['id_barang'])
                 ->update('barang');

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    // =========================
    // GET BY ID (EDIT)
    // =========================
    public function get_by_id($id_masuk)
    {
        return $this->db->get_where(
            'barang_masuk',
            ['id_masuk' => $id_masuk]
        )->row();
    }

    // =========================
    // UPDATE (ROLLBACK STOK)
    // =========================
    public function update($id_masuk)
    {
        $lama = $this->get_by_id($id_masuk);
        if (!$lama) return false;

        $baru = [
            'tanggal'     => $this->input->post('tanggal'),
            'no_faktur'   => $this->input->post('no_faktur'),
            'no_kwitansi' => $this->input->post('no_kwitansi'),
            'no_bast'     => $this->input->post('no_bast'),
            'id_barang'   => $this->input->post('id_barang'),
            'jumlah'      => $this->input->post('jumlah'),
            'satuan'      => $this->input->post('satuan'),
            'toko'        => $this->input->post('toko'),
            'perolehan'   => $this->input->post('perolehan'),
            'keterangan'  => $this->input->post('keterangan')
        ];

        $this->db->trans_start();

        // rollback stok lama
        $this->db->set('stok', 'stok - '.$lama->jumlah, false)
                 ->where('id_barang', $lama->id_barang)
                 ->update('barang');

        // update barang masuk
        $this->db->where('id_masuk', $id_masuk)
                 ->update('barang_masuk', $baru);

        // tambah stok baru
        $this->db->set('stok', 'stok + '.$baru['jumlah'], false)
                 ->where('id_barang', $baru['id_barang'])
                 ->update('barang');

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    // =========================
    // DELETE (ROLLBACK STOK)
    // =========================
    public function delete($id_masuk)
    {
        $row = $this->get_by_id($id_masuk);
        if (!$row) return false;

        $this->db->trans_start();

        // rollback stok
        $this->db->set('stok', 'stok - '.$row->jumlah, false)
                 ->where('id_barang', $row->id_barang)
                 ->update('barang');

        // hapus data
        $this->db->where('id_masuk', $id_masuk)
                 ->delete('barang_masuk');

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}
