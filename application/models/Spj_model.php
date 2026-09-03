<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spj_model extends CI_Model
{
    private $table = 'spj_kebutuhan';
    private $detail = 'spj_kebutuhan_detail';


    /* =========================================================
       KATEGORI
    ========================================================= */

    public function get_kategori()
    {
        return $this->db
            ->select('id_kategori, kodering, nama_kategori')
            ->order_by('kodering', 'ASC')
            ->get('kategori_barang')
            ->result();
    }

public function get_kategori_by_id($id)
{
    return $this->db
        ->select('id_kategori, kodering, nama_kategori')
        ->where('id_kategori', (int) $id)
        ->get('kategori_barang')
        ->row();
}
    /* =========================================================
       GET ALL KEBUTUHAN
    ========================================================= */

    public function get_all_kebutuhan()
    {
        return $this->db
            ->select('
                spj_kebutuhan.*,
                COUNT(spj_kebutuhan_detail.id_detail) AS jumlah_item
            ')
            ->from($this->table)
            ->join(
                $this->detail,
                'spj_kebutuhan_detail.id_kebutuhan = spj_kebutuhan.id_kebutuhan',
                'left'
            )
            ->group_by('spj_kebutuhan.id_kebutuhan')
            ->order_by(
                'spj_kebutuhan.id_kebutuhan',
                'DESC'
            )
            ->get()
            ->result();
    }


    /* =========================================================
       GET HEADER
    ========================================================= */

    public function get_kebutuhan($id)
    {
        return $this->db
            ->where('id_kebutuhan', $id)
            ->get($this->table)
            ->row();
    }


    /* =========================================================
       GET DETAIL
    ========================================================= */

    public function get_detail($id)
{
    return $this->db
        ->select('
            spj_kebutuhan_detail.*,
            kategori_barang.nama_kategori,
            kategori_barang.nama_kodering
        ')
        ->from($this->detail)
        ->join(
            'kategori_barang',
            'kategori_barang.id_kategori = spj_kebutuhan_detail.id_kategori',
            'left'
        )
        ->where(
            'spj_kebutuhan_detail.id_kebutuhan',
            $id
        )
        ->order_by(
            'spj_kebutuhan_detail.id_detail',
            'ASC'
        )
        ->get()
        ->result();
}


    /* =========================================================
       INSERT
    ========================================================= */

    public function insert_kebutuhan($header, $details)
    {
        $this->db->trans_begin();


        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        */

        $this->db->insert(
            $this->table,
            $header
        );


        $id_kebutuhan =
            $this->db->insert_id();


        /*
        |--------------------------------------------------------------------------
        | DETAIL
        |--------------------------------------------------------------------------
        */

        foreach ($details as $detail) {

            $detail['id_kebutuhan'] =
                $id_kebutuhan;

            $this->db->insert(
                $this->detail,
                $detail
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        */

        if (
            $this->db->trans_status() === false
        ) {

            $this->db->trans_rollback();

            return false;
        }


        $this->db->trans_commit();

        return $id_kebutuhan;
    }


    /* =========================================================
       DELETE
    ========================================================= */

    public function delete_kebutuhan($id)
    {
        return $this->db
            ->where('id_kebutuhan', $id)
            ->delete($this->table);
    }

    public function update_kebutuhan(
    $id,
    $header,
    $details
) {
    $this->db->trans_begin();


    /*
     * UPDATE HEADER
     */
    $this->db
        ->where(
            'id_kebutuhan',
            $id
        )
        ->update(
            $this->table,
            $header
        );


    /*
     * HAPUS DETAIL LAMA
     */
    $this->db
        ->where(
            'id_kebutuhan',
            $id
        )
        ->delete(
            $this->detail
        );


    /*
     * INSERT DETAIL BARU
     */
    foreach ($details as $row) {

        $row['id_kebutuhan'] = $id;

        $this->db->insert(
            $this->detail,
            $row
        );
    }


    /*
     * CEK TRANSAKSI
     */
    if (
        $this->db->trans_status() === false
    ) {

        $this->db->trans_rollback();

        return false;
    }


    $this->db->trans_commit();

    return true;
}

public function update_bast_internal($id, $data)
{
    return $this->db
        ->where('id_kebutuhan', $id)
        ->update($this->table, $data);
}
}