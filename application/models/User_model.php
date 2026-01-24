<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function get_admin()
    {
        return $this->db->where('role','admin')
                        ->order_by('nama','ASC')
                        ->get('users')
                        ->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where(
            'users',
            ['id_user' => $id]
        )->row();
    }

    public function cek_username($username)
    {
        return $this->db->get_where(
            'users',
            ['username' => $username]
        )->row();
    }

    public function insert($data)
    {
        return $this->db->insert('users', $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id_user', $id)
                        ->update('users', $data);
    }

    public function delete($id)
    {
        return $this->db->delete(
            'users',
            ['id_user' => $id]
        );
    }
}
