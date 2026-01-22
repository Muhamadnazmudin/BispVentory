<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_ruangan_model extends CI_Model {

    public function get_all()
    {
        $this->db->select('barang_ruangan.*, barang.nama_barang, ruangan.nama_ruangan');
        $this->db->join('barang','barang.id_barang = barang_ruangan.id_barang');
        $this->db->join('ruangan','ruangan.id_ruangan = barang_ruangan.id_ruangan');
        return $this->db->order_by('id_barang_ruangan','DESC')
                        ->get('barang_ruangan')
                        ->result();
    }

    public function get_barang()
    {
        return $this->db->get('barang')->result();
    }

    public function get_ruangan()
    {
        return $this->db->get('ruangan')->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where(
            'barang_ruangan',
            ['id_barang_ruangan'=>$id]
        )->row();
    }

    public function insert($data)
    {
        return $this->db->insert('barang_ruangan',$data);
    }

    public function update($id,$data)
    {
        return $this->db->where('id_barang_ruangan',$id)
                        ->update('barang_ruangan',$data);
    }

    public function delete($id)
    {
        return $this->db->delete(
            'barang_ruangan',
            ['id_barang_ruangan'=>$id]
        );
    }
}
