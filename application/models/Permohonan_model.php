<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan_model extends CI_Model {

    public function get_all()
    {
        $this->db->select('p.*, g.nama_guru, s.nama_siswa');
        $this->db->from('permohonan p');
        $this->db->join('guru g','g.id_guru=p.id_guru','left');
        $this->db->join('siswa s','s.id_siswa=p.id_siswa','left');
        return $this->db->order_by('p.id_permohonan','DESC')->get()->result();
    }

    public function get_detail($id)
    {
        $this->db->select('d.*, b.nama_barang, b.merk, b.satuan');
        $this->db->from('permohonan_detail d');
        $this->db->join('barang b','b.id_barang=d.id_barang');
        $this->db->where('d.id_permohonan',$id);
        return $this->db->get()->result();
    }

    public function insert($header, $detail)
    {
        $this->db->trans_start();

        $this->db->insert('permohonan', $header);
        $id_permohonan = $this->db->insert_id();

        foreach($detail as $d){
            $d['id_permohonan'] = $id_permohonan;
            $this->db->insert('permohonan_detail', $d);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function update_status($id,$status)
    {
        return $this->db->where('id_permohonan',$id)
                        ->update('permohonan',['status'=>$status]);
    }

    public function get_barang()
{
    $this->db->select('
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
    ');
    $this->db->from('barang b');
    $this->db->join('barang_masuk bm','bm.id_barang = b.id_barang','left');
    $this->db->group_by('b.id_barang, b.nama_barang, b.merk, b.satuan');
    $this->db->order_by('b.nama_barang','ASC');

    return $this->db->get()->result();
}

    public function get_guru()
    {
        return $this->db->get('guru')->result();
    }

    public function get_siswa()
    {
        return $this->db->get('siswa')->result();
    }
    public function delete($id_permohonan)
{
    return $this->db->where('id_permohonan',$id_permohonan)
                    ->delete('permohonan');
}

}
