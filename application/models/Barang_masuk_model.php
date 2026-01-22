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
            bm.jumlah,
            bm.satuan,
            bm.perolehan,
            bm.toko,
            bm.keterangan,
            b.nama_barang,
            b.merk
        ');
        $this->db->from('barang_masuk bm');
        $this->db->join('barang b','b.id_barang = bm.id_barang');
        return $this->db->order_by('bm.id_masuk','DESC')
                        ->get()
                        ->result();
    }

    // =========================
    // DATA BARANG (DROPDOWN)
    // =========================
    public function get_barang()
    {
        $this->db->select('b.*, k.nama_kategori');
        $this->db->from('barang b');
        $this->db->join('kategori_barang k','k.id_kategori = b.id_kategori');
        return $this->db->get()->result();
    }

    // =========================
    // INSERT
    // =========================
    public function insert($data)
    {
        return $this->db->insert('barang_masuk',$data);
    }

    // =========================
    // GET BY ID (EDIT)
    // =========================
    public function get_by_id($id_masuk)
    {
        return $this->db->get_where(
            'barang_masuk',
            ['id_masuk'=>$id_masuk]
        )->row();
    }

    // =========================
    // UPDATE
    // =========================
    public function update($id_masuk)
    {
        $data = [
            'tanggal'    => $this->input->post('tanggal'),
            'id_barang'  => $this->input->post('id_barang'),
            'jumlah'     => $this->input->post('jumlah'),
            'satuan'     => $this->input->post('satuan'),
            'toko'       => $this->input->post('toko'),
            'perolehan'  => $this->input->post('perolehan'),
            'keterangan' => $this->input->post('keterangan')
        ];

        return $this->db->where('id_masuk',$id_masuk)
                        ->update('barang_masuk',$data);
    }

    // =========================
    // DELETE
    // =========================
    public function delete($id_masuk)
    {
        return $this->db->where('id_masuk',$id_masuk)
                        ->delete('barang_masuk');
    }
}
