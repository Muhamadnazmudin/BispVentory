<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends MY_Controller {

    public function index()
    {
        $data['title'] = 'Backup & Restore Database';

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('backup/index', $data);
        $this->load->view('layouts/footer');
    }

    // ================= BACKUP =================
    public function backup_db()
    {
        $this->load->dbutil();

        $prefs = [
            'format'   => 'txt',
            'filename' => 'backup_database.sql'
        ];

        $backup = $this->dbutil->backup($prefs);

        $this->load->helper('download');

        $filename = 'backup_bispventory_' . date('Ymd_His') . '.sql';
        force_download($filename, $backup);
    }

    // ================= RESTORE =================
    public function restore_db()
    {
        if (!isset($_FILES['file_sql']['name'])) {
            redirect('backup');
        }

        $sql = file_get_contents($_FILES['file_sql']['tmp_name']);

        $queries = explode(";\n", $sql);

        foreach ($queries as $query) {
            if (trim($query) != '') {
                $this->db->query($query);
            }
        }

        $this->session->set_flashdata(
            'success',
            'Database berhasil direstore'
        );
        redirect('backup');
    }
}
