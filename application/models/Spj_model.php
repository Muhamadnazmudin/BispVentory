<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spj_model extends CI_Model
{
    private $table  = 'spj_kebutuhan';
    private $detail = 'spj_kebutuhan_detail';


    /* =========================================================
       KATEGORI
    ========================================================= */

    public function get_kategori()
    {
        return $this->db
            ->select('id_kategori, kodering, nama_kategori')
            ->from('kategori_barang')
            ->order_by('kodering', 'ASC')
            ->get()
            ->result();
    }


    public function get_kategori_by_id($id)
    {
        return $this->db
            ->select('id_kategori, kodering, nama_kategori')
            ->from('kategori_barang')
            ->where('id_kategori', (int) $id)
            ->get()
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
            ->order_by('spj_kebutuhan.id_kebutuhan', 'DESC')
            ->get()
            ->result();
    }


    /* =========================================================
       GET HEADER
    ========================================================= */

    public function get_kebutuhan($id)
    {
        return $this->db
            ->where('id_kebutuhan', (int) $id)
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
                (int) $id
            )
            ->order_by(
                'spj_kebutuhan_detail.id_detail',
                'ASC'
            )
            ->get()
            ->result();
    }


    /* =========================================================
       INSERT KEBUTUHAN
    ========================================================= */

    public function insert_kebutuhan($header, $details)
    {
        $this->db->trans_begin();


        /*
         * HEADER
         *
         * $header sekarang dapat berisi:
         * - nomor_surat
         * - nomor_invoice
         * - nomor_pesanan
         * - nama_penyedia
         * - perihal
         * - kegiatan
         * - tanggal
         * - keterangan
         * - created_by
         */

        $this->db->insert(
            $this->table,
            $header
        );

        $id_kebutuhan = $this->db->insert_id();


        /*
         * DETAIL
         */

        foreach ($details as $row) {

            $row['id_kebutuhan'] = $id_kebutuhan;

            $this->db->insert(
                $this->detail,
                $row
            );
        }


        /*
         * CEK TRANSAKSI
         */

        if ($this->db->trans_status() === false) {

            $this->db->trans_rollback();

            return false;
        }


        $this->db->trans_commit();

        return $id_kebutuhan;
    }


    /* =========================================================
       UPDATE KEBUTUHAN
    ========================================================= */

    public function update_kebutuhan($id, $header, $details)
    {
        $this->db->trans_begin();


        /*
         * UPDATE HEADER
         */

        $this->db
            ->where(
                'id_kebutuhan',
                (int) $id
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
                (int) $id
            )
            ->delete(
                $this->detail
            );


        /*
         * INSERT DETAIL BARU
         */

        foreach ($details as $row) {

            $row['id_kebutuhan'] = (int) $id;

            $this->db->insert(
                $this->detail,
                $row
            );
        }


        /*
         * CEK TRANSAKSI
         */

        if ($this->db->trans_status() === false) {

            $this->db->trans_rollback();

            return false;
        }


        $this->db->trans_commit();

        return true;
    }


    /* =========================================================
       DELETE KEBUTUHAN
    ========================================================= */

    public function delete_kebutuhan($id)
    {
        return $this->db
            ->where(
                'id_kebutuhan',
                (int) $id
            )
            ->delete($this->table);
    }


    /* =========================================================
       UPDATE BAST INTERNAL
    ========================================================= */

    public function update_bast_internal($id, $data)
    {
        return $this->db
            ->where(
                'id_kebutuhan',
                (int) $id
            )
            ->update(
                $this->table,
                $data
            );
    }

    /* =========================================================
   GET BAST INTERNAL
========================================================= */

public function get_bast_internal($id)
{
    $id = (int) $id;

    if ($id <= 0) {
        return null;
    }

    return $this->db
        ->select('
            spj_bast_internal.*,

            spj_kebutuhan.nomor_surat,
            spj_kebutuhan.nomor_invoice,
            spj_kebutuhan.nomor_pesanan,
            spj_kebutuhan.nama_penyedia,
            spj_kebutuhan.perihal,
            spj_kebutuhan.kegiatan,
            spj_kebutuhan.tanggal AS tanggal_kebutuhan,
            spj_kebutuhan.keterangan,

            spj_bast_pemeriksaan.nomor_bast
                AS nomor_bast_pemeriksaan,

            spj_bast_pemeriksaan.tanggal_pemeriksaan
                AS tanggal_bast_pemeriksaan
        ')
        ->from('spj_bast_internal')
        ->join(
            'spj_kebutuhan',
            'spj_kebutuhan.id_kebutuhan =
             spj_bast_internal.id_kebutuhan',
            'left'
        )
        ->join(
            'spj_bast_pemeriksaan',
            'spj_bast_pemeriksaan.id_kebutuhan =
             spj_bast_internal.id_kebutuhan',
            'left'
        )
        ->where(
            'spj_bast_internal.id_bast_internal',
            $id
        )
        ->limit(1)
        ->get()
        ->row();
}

    /* =========================================================
   BAST PEMERIKSAAN
========================================================= */

public function get_all_bast_pemeriksaan()
{
    return $this->db
        ->select('
            spj_bast_pemeriksaan.*,

            spj_kebutuhan.nomor_surat,
            spj_kebutuhan.nomor_invoice,
            spj_kebutuhan.nomor_pesanan,
            spj_kebutuhan.nama_penyedia,
            spj_kebutuhan.perihal,
            spj_kebutuhan.tanggal AS tanggal_kebutuhan
        ')
        ->from('spj_bast_pemeriksaan')
        ->join(
            'spj_kebutuhan',
            'spj_kebutuhan.id_kebutuhan =
             spj_bast_pemeriksaan.id_kebutuhan',
            'left'
        )
        ->order_by(
            'spj_bast_pemeriksaan.id_bast_pemeriksaan',
            'DESC'
        )
        ->get()
        ->result();
}


public function get_bast_pemeriksaan_by_kebutuhan($id_kebutuhan)
{
    return $this->db
        ->where(
            'id_kebutuhan',
            (int) $id_kebutuhan
        )
        ->get(
            'spj_bast_pemeriksaan'
        )
        ->row();
}


public function get_bast_pemeriksaan($id)
{
    return $this->db
        ->select('
            spj_bast_pemeriksaan.*,

            spj_kebutuhan.nomor_surat,
            spj_kebutuhan.nomor_invoice,
            spj_kebutuhan.nomor_pesanan,
            spj_kebutuhan.nama_penyedia,
            spj_kebutuhan.perihal,
            spj_kebutuhan.kegiatan,
            spj_kebutuhan.tanggal AS tanggal_kebutuhan
        ')
        ->from('spj_bast_pemeriksaan')
        ->join(
            'spj_kebutuhan',
            'spj_kebutuhan.id_kebutuhan =
             spj_bast_pemeriksaan.id_kebutuhan',
            'left'
        )
        ->where(
            'spj_bast_pemeriksaan.id_bast_pemeriksaan',
            (int) $id
        )
        ->get()
        ->row();
}


public function get_bast_pemeriksaan_detail($id)
{
    return $this->db
        ->select('
            spj_bast_pemeriksaan_detail.*,
            kategori_barang.nama_kategori
        ')
        ->from(
            'spj_bast_pemeriksaan_detail'
        )
        ->join(
            'kategori_barang',
            'kategori_barang.id_kategori =
             spj_bast_pemeriksaan_detail.id_kategori',
            'left'
        )
        ->where(
            'id_bast_pemeriksaan',
            (int) $id
        )
        ->order_by(
            'id_detail',
            'ASC'
        )
        ->get()
        ->result();
}


public function insert_bast_pemeriksaan(
    $header,
    $details
) {
    $this->db->trans_begin();

    $this->db->insert(
        'spj_bast_pemeriksaan',
        $header
    );

    $id =
        $this->db->insert_id();

    foreach ($details as $detail) {

        $detail['id_bast_pemeriksaan'] =
            $id;

        $this->db->insert(
            'spj_bast_pemeriksaan_detail',
            $detail
        );
    }


    if (
        $this->db->trans_status() === false
    ) {

        $this->db->trans_rollback();

        return false;
    }


    $this->db->trans_commit();

    return $id;
}


public function update_bast_pemeriksaan(
    $id,
    $header,
    $details
) {
    $this->db->trans_begin();


    $this->db
        ->where(
            'id_bast_pemeriksaan',
            (int) $id
        )
        ->update(
            'spj_bast_pemeriksaan',
            $header
        );


    $this->db
        ->where(
            'id_bast_pemeriksaan',
            (int) $id
        )
        ->delete(
            'spj_bast_pemeriksaan_detail'
        );


    foreach ($details as $detail) {

        $detail['id_bast_pemeriksaan'] =
            $id;

        $this->db->insert(
            'spj_bast_pemeriksaan_detail',
            $detail
        );
    }


    if (
        $this->db->trans_status() === false
    ) {

        $this->db->trans_rollback();

        return false;
    }


    $this->db->trans_commit();

    return true;
}


public function delete_bast_pemeriksaan($id)
{
    return $this->db
        ->where(
            'id_bast_pemeriksaan',
            (int) $id
        )
        ->delete(
            'spj_bast_pemeriksaan'
        );
}
}