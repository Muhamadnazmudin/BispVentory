<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_model extends CI_Model {

    public function get_all()
    {
        $this->db->select('barang.*, kategori_barang.nama_kategori');
        $this->db->from('barang');
        $this->db->join(
            'kategori_barang',
            'kategori_barang.id_kategori = barang.id_kategori'
        );
        $this->db->order_by('barang.id_barang','DESC');
        return $this->db->get()->result();
    }

    public function get_kategori()
    {
        return $this->db->get('kategori_barang')->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where(
            'barang',
            ['id_barang' => $id]
        )->row();
    }

    public function insert($data)
    {
        // $data boleh berisi: nama_barang, merk, satuan, id_kategori, keterangan
        return $this->db->insert('barang', $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id_barang', $id)
                        ->update('barang', $data);
    }

    public function delete($id)
    {
        return $this->db->delete(
            'barang',
            ['id_barang' => $id]
        );
    }
}
