<?php
class Auth_model extends CI_Model {

    public function cek_login($username){
        return $this->db->get_where('users',['username'=>$username])->row();
    }
}
