<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_model extends CI_Model {

    public function get_all()
    {
        return $this->db->order_by('id_kategori','DESC')
                        ->get('kategori_barang')
                        ->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where(
            'kategori_barang',
            ['id_kategori' => $id]
        )->row();
    }

    public function insert($data)
    {
        return $this->db->insert('kategori_barang', $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id_kategori', $id)
                        ->update('kategori_barang', $data);
    }

    public function delete($id)
    {
        return $this->db->delete(
            'kategori_barang',
            ['id_kategori' => $id]
        );
    }
    public function insert_batch($data)
{
    return $this->db->insert_batch('kategori', $data);
}

}
