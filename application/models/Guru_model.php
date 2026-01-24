<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_model extends CI_Model {

    public function get_all()
    {
        return $this->db->order_by('nama_guru','ASC')
                        ->get('guru')
                        ->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where(
            'guru',
            ['id_guru' => $id]
        )->row();
    }

    public function insert($data)
    {
        return $this->db->insert('guru', $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id_guru', $id)
                        ->update('guru', $data);
    }

    public function delete($id)
    {
        return $this->db->delete(
            'guru',
            ['id_guru' => $id]
        );
    }
    public function cek_nip($nip)
{
    return $this->db->get_where('guru', ['nip' => $nip])->row();
}

}
