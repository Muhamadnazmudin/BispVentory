<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_model extends CI_Model {

    public function get_all()
    {
        return $this->db->order_by('nama_siswa','ASC')
                        ->get('siswa')
                        ->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where(
            'siswa',
            ['id_siswa' => $id]
        )->row();
    }

    public function insert($data)
    {
        return $this->db->insert('siswa', $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id_siswa', $id)
                        ->update('siswa', $data);
    }

    public function delete($id)
    {
        return $this->db->delete(
            'siswa',
            ['id_siswa' => $id]
        );
    }
    public function cek_nisn($nisn)
{
    return $this->db->get_where(
        'siswa',
        ['nisn' => $nisn]
    )->row();
}
}
