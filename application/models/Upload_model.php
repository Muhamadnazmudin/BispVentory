<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_model extends CI_Model
{
    protected $table_point = 'upload_point';
    protected $table_file  = 'upload_berkas';


    /* =========================================================
       POINT
    ========================================================= */

    public function get_points($keyword = null)
    {
        $this->db
            ->select('p.*')
            ->from($this->table_point . ' p')
            ->where('p.aktif', 1)
            ->order_by('p.nomor', 'ASC');

        if ($keyword !== null && $keyword !== '') {

            $this->db->group_start();

            $this->db->like(
                'p.nama_point',
                $keyword
            );

            $this->db->or_like(
                'p.nomor',
                $keyword
            );

            $this->db->group_end();
        }

        return $this->db
            ->get()
            ->result();
    }


    public function get_point($id)
    {
        return $this->db
            ->where('id', (int) $id)
            ->get($this->table_point)
            ->row();
    }


    /* =========================================================
       FILE BERDASARKAN POINT
    ========================================================= */

    public function get_files_by_point(
        $point_id,
        $tahun = null
    )
    {
        $this->db
            ->where(
                'point_id',
                (int) $point_id
            );

        if ($tahun !== null) {

            $this->db->where(
                'tahun',
                (int) $tahun
            );
        }

        return $this->db
            ->order_by(
                'uploaded_at',
                'DESC'
            )
            ->get($this->table_file)
            ->result();
    }


    /* =========================================================
       FILE BERDASARKAN:
       POINT + TAHUN + SUMBER DANA
       
       BOSP / BOPD
    ========================================================= */

    public function get_files_by_point_dana(
        $point_id,
        $tahun,
        $sumber_dana
    )
    {
        return $this->db
            ->where(
                'point_id',
                (int) $point_id
            )
            ->where(
                'tahun',
                (int) $tahun
            )
            ->where(
                'sumber_dana',
                strtoupper(
                    trim($sumber_dana)
                )
            )
            ->order_by(
                'uploaded_at',
                'DESC'
            )
            ->get(
                $this->table_file
            )
            ->result();
    }


    /* =========================================================
       SATU FILE
    ========================================================= */

    public function get_file($id)
    {
        return $this->db
            ->select(
                'f.*, p.nomor, p.nama_point'
            )
            ->from(
                $this->table_file . ' f'
            )
            ->join(
                $this->table_point . ' p',
                'p.id = f.point_id',
                'left'
            )
            ->where(
                'f.id',
                (int) $id
            )
            ->get()
            ->row();
    }


    /* =========================================================
       INSERT POINT
    ========================================================= */

    public function insert_point($data)
    {
        return $this->db->insert(
            $this->table_point,
            $data
        );
    }


    /* =========================================================
       UPDATE POINT
    ========================================================= */

    public function update_point(
        $id,
        $data
    )
    {
        return $this->db
            ->where(
                'id',
                (int) $id
            )
            ->update(
                $this->table_point,
                $data
            );
    }


    /* =========================================================
       DELETE POINT
    ========================================================= */

    public function delete_point($id)
    {
        return $this->db
            ->where(
                'id',
                (int) $id
            )
            ->delete(
                $this->table_point
            );
    }


    /* =========================================================
       INSERT FILE
    ========================================================= */

    public function insert_file($data)
    {
        return $this->db->insert(
            $this->table_file,
            $data
        );
    }


    /* =========================================================
       DELETE FILE
    ========================================================= */

    public function delete_file($id)
    {
        return $this->db
            ->where(
                'id',
                (int) $id
            )
            ->delete(
                $this->table_file
            );
    }


    /* =========================================================
       STATISTIK
    ========================================================= */

    public function get_stats()
    {
        $stats = array();


        foreach (
            array(2025, 2026)
            as $tahun
        ) {

            $total_point =
                $this->db
                    ->where(
                        'aktif',
                        1
                    )
                    ->count_all_results(
                        $this->table_point
                    );


            $point_terisi =
                $this->db
                    ->select(
                        'COUNT(DISTINCT point_id) AS total',
                        false
                    )
                    ->where(
                        'tahun',
                        $tahun
                    )
                    ->get(
                        $this->table_file
                    )
                    ->row();


            $total_file =
                $this->db
                    ->where(
                        'tahun',
                        $tahun
                    )
                    ->count_all_results(
                        $this->table_file
                    );


            $stats[$tahun] = array(

                'total_point' =>
                    $total_point,

                'point_terisi' =>
                    $point_terisi
                        ? (int) $point_terisi->total
                        : 0,

                'total_file' =>
                    $total_file
            );
        }


        return $stats;
    }


    /* =========================================================
       JUMLAH FILE POINT + TAHUN
    ========================================================= */

    public function count_files(
        $point_id,
        $tahun
    )
    {
        return $this->db
            ->where(
                'point_id',
                (int) $point_id
            )
            ->where(
                'tahun',
                (int) $tahun
            )
            ->count_all_results(
                $this->table_file
            );
    }


    /* =========================================================
       JUMLAH FILE POINT + TAHUN + SUMBER DANA
    ========================================================= */

    public function count_files_dana(
        $point_id,
        $tahun,
        $sumber_dana
    )
    {
        return $this->db
            ->where(
                'point_id',
                (int) $point_id
            )
            ->where(
                'tahun',
                (int) $tahun
            )
            ->where(
                'sumber_dana',
                strtoupper(
                    trim($sumber_dana)
                )
            )
            ->count_all_results(
                $this->table_file
            );
    }

    public function get_all_files_for_zip()
{
    return $this->db
        ->select('
            f.*,
            p.nomor,
            p.nama_point
        ')
        ->from($this->table_file . ' f')
        ->join(
            $this->table_point . ' p',
            'p.id = f.point_id',
            'inner'
        )
        ->where('p.aktif', 1)
        ->order_by('p.nomor', 'ASC')
        ->order_by('f.tahun', 'ASC')
        ->order_by('f.sumber_dana', 'ASC')
        ->order_by('f.uploaded_at', 'ASC')
        ->get()
        ->result();
}
}