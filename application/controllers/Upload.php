<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends MY_Controller
{
    protected $allowed_roles = array(1, 2);
    protected $allowed_years = array(2025, 2026);
    protected $allowed_funds = array('BOSP', 'BOPD');

    public function __construct()
{
    parent::__construct();

    $this->load->model('Upload_model');

    $this->load->helper(array(
        'url',
        'file',
        'download'
    ));

    $this->load->library('session');


    /* =====================================================
       CEK LOGIN
       Sudah ditangani MY_Controller
    ===================================================== */


    /* =====================================================
       CEK ROLE
       
       Mendukung beberapa kemungkinan session:
       - role_id = 1
       - role = admin
       - role_name = admin
       - role_id = 2
       - role = operator
       - role_name = operator
    ===================================================== */

    $role_id = (int) $this->session->userdata('role_id');

    $role = strtolower(
        trim(
            (string) $this->session->userdata('role')
        )
    );

    $role_name = strtolower(
        trim(
            (string) $this->session->userdata('role_name')
        )
    );


    $is_admin =
        ($role_id === 1) ||
        ($role === 'admin') ||
        ($role_name === 'admin');


    $is_operator =
        ($role_id === 2) ||
        ($role === 'operator') ||
        ($role_name === 'operator');


    if (!$is_admin && !$is_operator) {

        log_message(
            'error',
            'UPLOAD ACCESS DENIED | ' .
            'role_id=' . $role_id .
            ' | role=' . $role .
            ' | role_name=' . $role_name
        );

        show_error(
            'Anda tidak memiliki akses ke halaman Upload.',
            403,
            'Akses Ditolak'
        );
    }
}


    /* =========================================================
       INDEX
    ========================================================= */

    public function index()
    {
        $keyword = trim(
            $this->input->get('q', true)
        );

        $tahun = (int) $this->input->get('tahun');

        if (!in_array($tahun, $this->allowed_years, true)) {
            $tahun = 2025;
        }


        $points =
            $this->Upload_model->get_points($keyword);


        foreach ($points as &$point) {

            /* =========================
               2025 BOSP
            ========================= */

            $point->files_2025_bosp =
                $this->Upload_model
                    ->get_files_by_point_dana(
                        $point->id,
                        2025,
                        'BOSP'
                    );


            /* =========================
               2025 BOPD
            ========================= */

            $point->files_2025_bopd =
                $this->Upload_model
                    ->get_files_by_point_dana(
                        $point->id,
                        2025,
                        'BOPD'
                    );


            /* =========================
               2026 BOSP
            ========================= */

            $point->files_2026_bosp =
                $this->Upload_model
                    ->get_files_by_point_dana(
                        $point->id,
                        2026,
                        'BOSP'
                    );


            /* =========================
               2026 BOPD
            ========================= */

            $point->files_2026_bopd =
                $this->Upload_model
                    ->get_files_by_point_dana(
                        $point->id,
                        2026,
                        'BOPD'
                    );
        }

        unset($point);


        $data = array(
            'title'   => 'Upload Berkas Inspektorat',
            'points'  => $points,
            'keyword' => $keyword,
            'tahun'   => $tahun,
            'stats'   => $this->Upload_model->get_stats()
        );


        $this->load->view(
            'layouts/header',
            $data
        );

        $this->load->view(
            'layouts/sidebar'
        );

        $this->load->view(
            'layouts/topbar'
        );

        $this->load->view(
            'upload/index',
            $data
        );

        $this->load->view(
            'layouts/footer'
        );
    }


    /* =========================================================
       UPLOAD FILE
    ========================================================= */

    public function upload_file($point_id)
    {
        $point_id = (int) $point_id;


        /* =====================================================
           CEK POINT
        ===================================================== */

        $point =
            $this->Upload_model->get_point(
                $point_id
            );

        if (!$point) {

            $this->_error(
                'Point dokumen tidak ditemukan.'
            );
        }


        /* =====================================================
           AMBIL TAHUN
        ===================================================== */

        $tahun = (int) $this->input->post(
            'tahun'
        );


        if (
            !in_array(
                $tahun,
                $this->allowed_years,
                true
            )
        ) {

            $this->_error(
                'Tahun dokumen tidak valid.'
            );
        }


        /* =====================================================
           AMBIL SUMBER DANA
           
           PENTING:
           Tidak menggunakan DEFAULT BOSP.
           Kalau kosong -> ERROR.
        ===================================================== */

        $sumber_dana = strtoupper(
            trim(
                (string) $this->input->post(
                    'sumber_dana',
                    true
                )
            )
        );


        if ($sumber_dana === '') {

            log_message(
                'error',
                'UPLOAD: sumber_dana kosong. ' .
                'point=' . $point_id .
                ' tahun=' . $tahun
            );

            $this->_error(
                'Sumber dana belum dipilih. ' .
                'Pastikan upload melalui tombol BOSP atau BOPD.'
            );
        }


        if (
            !in_array(
                $sumber_dana,
                $this->allowed_funds,
                true
            )
        ) {

            log_message(
                'error',
                'UPLOAD: sumber_dana tidak valid: ' .
                $sumber_dana
            );

            $this->_error(
                'Sumber dana tidak valid.'
            );
        }


        /* =====================================================
           DEBUG LOG
        ===================================================== */

        log_message(
            'debug',
            'UPLOAD INSPEKTORAT | ' .
            'point=' . $point_id .
            ' | tahun=' . $tahun .
            ' | sumber_dana=' . $sumber_dana
        );


        /* =====================================================
           CEK FILE
        ===================================================== */

        if (
            !isset($_FILES['berkas'])
        ) {

            $this->_error(
                'Tidak ada file yang diterima server.'
            );
        }


        $file_error =
            (int) $_FILES['berkas']['error'];


        if (
            $file_error !== UPLOAD_ERR_OK
        ) {

            $messages = array(

                UPLOAD_ERR_INI_SIZE =>
                    'Ukuran file melebihi batas upload server.',

                UPLOAD_ERR_FORM_SIZE =>
                    'Ukuran file melebihi batas form.',

                UPLOAD_ERR_PARTIAL =>
                    'File hanya terupload sebagian.',

                UPLOAD_ERR_NO_FILE =>
                    'Tidak ada file yang dipilih.',

                UPLOAD_ERR_NO_TMP_DIR =>
                    'Folder temporary server tidak tersedia.',

                UPLOAD_ERR_CANT_WRITE =>
                    'Server tidak dapat menulis file.',

                UPLOAD_ERR_EXTENSION =>
                    'Upload dihentikan oleh ekstensi PHP.'
            );


            $message =
                isset($messages[$file_error])
                    ? $messages[$file_error]
                    : 'Terjadi kesalahan saat upload file.';


            $this->_error(
                $message
            );
        }


        /* =====================================================
           FOLDER UPLOAD
        ===================================================== */

        $upload_path =
            FCPATH .
            'uploads/inspektorat/' .
            $tahun .
            '/';


        if (!is_dir($upload_path)) {

            if (
                !mkdir(
                    $upload_path,
                    0755,
                    true
                )
            ) {

                $this->_error(
                    'Folder upload tidak dapat dibuat.'
                );
            }
        }


        /* =====================================================
           CONFIG UPLOAD
        ===================================================== */

        $config = array(

            'upload_path' =>
                $upload_path,

            'allowed_types' =>
                'pdf|doc|docx|xls|xlsx|ppt|pptx|' .
                'jpg|jpeg|png|gif|webp|zip|rar',

            'max_size' =>
                204800,

            'encrypt_name' =>
                true,

            'remove_spaces' =>
                true,

            'detect_mime' =>
                true,

            'mod_mime_fix' =>
                true
        );


        $this->load->library(
            'upload'
        );

        $this->upload->initialize(
            $config
        );


        /* =====================================================
           PROSES UPLOAD
        ===================================================== */

        if (
            !$this->upload->do_upload(
                'berkas'
            )
        ) {

            $error =
                strip_tags(
                    $this->upload->display_errors(
                        '',
                        ''
                    )
                );


            if ($error === '') {
                $error =
                    'File gagal diupload.';
            }


            $this->_error(
                $error
            );
        }


        $upload =
            $this->upload->data();


        /* =====================================================
           DATA DATABASE
        ===================================================== */

        $data = array(

            'point_id' =>
                $point_id,

            'tahun' =>
                $tahun,

            /*
             * INI WAJIB.
             *
             * Jangan dihilangkan.
             *
             * BOSP -> BOSP
             * BOPD -> BOPD
             */
            'sumber_dana' =>
                $sumber_dana,

            'nama_file' =>
                $upload['file_name'],

            'nama_file_asli' =>
                $upload['orig_name'],

            'ekstensi' =>
                strtolower(
                    ltrim(
                        $upload['file_ext'],
                        '.'
                    )
                ),

            'tipe_file' =>
                $upload['file_type'],

            'ukuran_file' =>
                (int)
                $upload['file_size'] *
                1024,

            'lokasi_file' =>
                'uploads/inspektorat/' .
                $tahun .
                '/' .
                $upload['file_name'],

            'keterangan' =>
                trim(
                    (string)
                    $this->input->post(
                        'keterangan',
                        true
                    )
                ),

            'uploaded_by' =>
                $this->session->userdata(
                    'user_id'
                ),

            'uploaded_at' =>
                date('Y-m-d H:i:s')
        );


        /* =====================================================
           SIMPAN DATABASE
        ===================================================== */

        $insert =
            $this->Upload_model->insert_file(
                $data
            );


        if (!$insert) {

            /* Hapus file fisik jika DB gagal */

            $file_path =
                $upload_path .
                $upload['file_name'];


            if (
                file_exists($file_path)
            ) {

                @unlink(
                    $file_path
                );
            }


            log_message(
                'error',
                'UPLOAD DB GAGAL | ' .
                json_encode($data)
            );


            $this->_error(
                'File berhasil diupload tetapi gagal disimpan ke database.'
            );
        }


        /* =====================================================
           SUCCESS
        ===================================================== */

        $this->session->set_flashdata(
            'success',
            'Berkas berhasil diupload: ' .
            $upload['orig_name'] .
            ' — ' .
            $tahun .
            ' / ' .
            $sumber_dana
        );


        redirect(
            'upload'
        );
    }

public function preview($id)
{
    $file = $this->Upload_model->get_file($id);

    if (!$file) {
        show_404();
    }

    $path = FCPATH . $file->lokasi_file;

    if (!file_exists($path)) {
        show_error('File tidak ditemukan di server.');
    }

    $ext = strtolower(
        pathinfo($file->nama_file_asli, PATHINFO_EXTENSION)
    );

    /*
    |--------------------------------------------------------------------------
    | FILE YANG BISA DITAMPILKAN LANGSUNG DI BROWSER
    |--------------------------------------------------------------------------
    */

    $inline_types = array(
        'pdf'  => 'application/pdf',

        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'gif'  => 'image/gif',
        'webp' => 'image/webp'
    );

    if (isset($inline_types[$ext])) {

        header(
            'Content-Type: ' .
            $inline_types[$ext]
        );

        header(
            'Content-Length: ' . filesize($path)
        );

        header(
            'Content-Disposition: inline; filename="' .
            basename($file->nama_file_asli) .
            '"'
        );

        header('X-Content-Type-Options: nosniff');

        readfile($path);
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | WORD / EXCEL
    |--------------------------------------------------------------------------
    |
    | Browser tidak dapat merender file Office secara native.
    | Karena aplikasi Anda online, kita arahkan ke Google Viewer.
    |
    */

    if (in_array(
        $ext,
        array('doc', 'docx', 'xls', 'xlsx'),
        true
    )) {

        $file_url = base_url(
            $file->lokasi_file
        );

        $viewer_url =
            'https://docs.google.com/gview?embedded=1&url=' .
            urlencode($file_url);

        redirect($viewer_url);
    }


    /*
    |--------------------------------------------------------------------------
    | POWERPOINT
    |--------------------------------------------------------------------------
    */

    if (in_array(
        $ext,
        array('ppt', 'pptx'),
        true
    )) {

        $file_url = base_url(
            $file->lokasi_file
        );

        $viewer_url =
            'https://docs.google.com/gview?embedded=1&url=' .
            urlencode($file_url);

        redirect($viewer_url);
    }


    /*
    |--------------------------------------------------------------------------
    | FILE LAIN
    |--------------------------------------------------------------------------
    */

    $this->session->set_flashdata(
        'error',
        'Format file "' . strtoupper($ext) .
        '" tidak mendukung preview. Silakan download file.'
    );

    redirect('upload');
}
    /* =========================================================
       DOWNLOAD
    ========================================================= */

    public function download($id)
    {
        $id = (int) $id;


        $file =
            $this->Upload_model->get_file(
                $id
            );


        if (!$file) {
            show_404();
        }


        $path =
            FCPATH .
            $file->lokasi_file;


        if (
            !file_exists($path)
        ) {

            show_error(
                'File tidak ditemukan di server.'
            );
        }


        force_download(
            $file->nama_file_asli,
            file_get_contents($path)
        );
    }


    /* =========================================================
       DELETE FILE
    ========================================================= */

    public function delete_file($id)
    {
        $id = (int) $id;


        $file =
            $this->Upload_model->get_file(
                $id
            );


        if (!$file) {
            show_404();
        }


        $path =
            FCPATH .
            $file->lokasi_file;


        if (
            file_exists($path)
        ) {

            @unlink($path);
        }


        $this->Upload_model->delete_file(
            $id
        );


        $this->session->set_flashdata(
            'success',
            'Berkas berhasil dihapus.'
        );


        redirect(
            'upload'
        );
    }


    /* =========================================================
       TAMBAH POINT
    ========================================================= */

    public function tambah_point()
    {
        $data = array(
            'title' => 'Tambah Point Dokumen'
        );


        $this->load->view(
            'layouts/header',
            $data
        );

        $this->load->view(
            'layouts/sidebar'
        );

        $this->load->view(
            'layouts/topbar'
        );

        $this->load->view(
            'upload/form',
            $data
        );

        $this->load->view(
            'layouts/footer'
        );
    }


    /* =========================================================
       SIMPAN POINT
    ========================================================= */

    public function simpan_point()
    {
        $nomor =
            (int) $this->input->post(
                'nomor'
            );


        $nama =
            trim(
                (string)
                $this->input->post(
                    'nama_point',
                    true
                )
            );


        $keterangan =
            trim(
                (string)
                $this->input->post(
                    'keterangan',
                    true
                )
            );


        if (
            $nomor <= 0 ||
            $nama === ''
        ) {

            $this->session->set_flashdata(
                'error',
                'Nomor dan nama point wajib diisi.'
            );

            redirect(
                'upload/tambah_point'
            );
        }


        $data = array(

            'nomor' =>
                $nomor,

            'nama_point' =>
                $nama,

            'keterangan' =>
                $keterangan,

            'aktif' =>
                1,

            'created_at' =>
                date('Y-m-d H:i:s')
        );


        if (
            !$this->Upload_model->insert_point(
                $data
            )
        ) {

            $this->session->set_flashdata(
                'error',
                'Point gagal ditambahkan.'
            );

            redirect(
                'upload/tambah_point'
            );
        }


        $this->session->set_flashdata(
            'success',
            'Point berhasil ditambahkan.'
        );


        redirect(
            'upload'
        );
    }


    /* =========================================================
       EDIT POINT
    ========================================================= */

    public function edit_point($id)
    {
        $id = (int) $id;


        $point =
            $this->Upload_model->get_point(
                $id
            );


        if (!$point) {
            show_404();
        }


        $data = array(
            'title' => 'Edit Point Dokumen',
            'point' => $point
        );


        $this->load->view(
            'layouts/header',
            $data
        );

        $this->load->view(
            'layouts/sidebar'
        );

        $this->load->view(
            'layouts/topbar'
        );

        $this->load->view(
            'upload/form',
            $data
        );

        $this->load->view(
            'layouts/footer'
        );
    }


    /* =========================================================
       UPDATE POINT
    ========================================================= */

    public function update_point($id)
    {
        $id = (int) $id;


        $point =
            $this->Upload_model->get_point(
                $id
            );


        if (!$point) {
            show_404();
        }


        $nomor =
            (int) $this->input->post(
                'nomor'
            );


        $nama =
            trim(
                (string)
                $this->input->post(
                    'nama_point',
                    true
                )
            );


        $keterangan =
            trim(
                (string)
                $this->input->post(
                    'keterangan',
                    true
                )
            );


        if (
            $nomor <= 0 ||
            $nama === ''
        ) {

            $this->session->set_flashdata(
                'error',
                'Nomor dan nama point wajib diisi.'
            );

            redirect(
                'upload/edit_point/' . $id
            );
        }


        $data = array(

            'nomor' =>
                $nomor,

            'nama_point' =>
                $nama,

            'keterangan' =>
                $keterangan,

            'updated_at' =>
                date('Y-m-d H:i:s')
        );


        if (
            !$this->Upload_model->update_point(
                $id,
                $data
            )
        ) {

            $this->session->set_flashdata(
                'error',
                'Point gagal diperbarui.'
            );

            redirect(
                'upload/edit_point/' . $id
            );
        }


        $this->session->set_flashdata(
            'success',
            'Point berhasil diperbarui.'
        );


        redirect(
            'upload'
        );
    }


    /* =========================================================
       DELETE POINT
    ========================================================= */

    public function delete_point($id)
    {
        $id = (int) $id;


        $point =
            $this->Upload_model->get_point(
                $id
            );


        if (!$point) {
            show_404();
        }


        /*
         * Ambil semua file point
         * supaya file fisik tidak tertinggal.
         */

        $files =
            $this->Upload_model
                ->get_files_by_point(
                    $id
                );


        foreach ($files as $file) {

            $path =
                FCPATH .
                $file->lokasi_file;


            if (
                file_exists($path)
            ) {

                @unlink($path);
            }
        }


        /*
         * Hapus point.
         *
         * Jika database memiliki FK CASCADE,
         * berkas akan ikut terhapus.
         */

        $this->Upload_model->delete_point(
            $id
        );


        $this->session->set_flashdata(
            'success',
            'Point dan seluruh berkas di dalamnya berhasil dihapus.'
        );


        redirect(
            'upload'
        );
    }


    /* =========================================================
       ERROR HELPER
    ========================================================= */

    private function _error($message)
    {
        $this->session->set_flashdata(
            'error',
            $message
        );

        redirect(
            'upload'
        );
    }


    public function download_all()
{
    /*
    |--------------------------------------------------------------------------
    | CEK ROLE
    |--------------------------------------------------------------------------
    */

    $role_id   = (int) $this->session->userdata('role_id');
    $role      = strtolower(trim((string) $this->session->userdata('role')));
    $role_name = strtolower(trim((string) $this->session->userdata('role_name')));

    $isAdmin =
        $role_id === 1 ||
        $role === 'admin' ||
        $role === 'administrator' ||
        $role_name === 'admin' ||
        $role_name === 'administrator';

    if (!$isAdmin) {
        show_error(
            'Anda tidak memiliki akses untuk mengunduh seluruh berkas.',
            403,
            'Akses Ditolak'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CEK ZIPARCHIVE
    |--------------------------------------------------------------------------
    */

    if (!class_exists('ZipArchive')) {

        show_error(
            'Ekstensi PHP ZipArchive belum aktif di server.',
            500,
            'ZIP Tidak Tersedia'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | AMBIL SEMUA BERKAS
    |--------------------------------------------------------------------------
    */

    $files = $this->Upload_model->get_all_files_for_zip();

    if (empty($files)) {

        $this->session->set_flashdata(
            'error',
            'Belum ada berkas yang dapat diunduh.'
        );

        redirect('upload');
    }


    /*
    |--------------------------------------------------------------------------
    | FOLDER TEMPORARY
    |--------------------------------------------------------------------------
    */

    $temp_dir = FCPATH . 'uploads/inspektorat/temp_zip/';

    if (!is_dir($temp_dir)) {

        if (!mkdir($temp_dir, 0755, true)) {

            show_error(
                'Folder temporary ZIP tidak dapat dibuat.',
                500
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | NAMA ZIP
    |--------------------------------------------------------------------------
    */

    $zip_filename =
        'BispVentory_Berkas_Inspektorat_' .
        date('Y-m-d_H-i-s') .
        '.zip';

    $zip_path =
        $temp_dir . $zip_filename;


    /*
    |--------------------------------------------------------------------------
    | BUAT ZIP
    |--------------------------------------------------------------------------
    */

    $zip = new ZipArchive();

    $result = $zip->open(
        $zip_path,
        ZipArchive::CREATE |
        ZipArchive::OVERWRITE
    );

    if ($result !== true) {

        show_error(
            'ZIP tidak dapat dibuat. Kode: ' . $result,
            500
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ROOT FOLDER
    |--------------------------------------------------------------------------
    */

    $root_folder = 'BispVentory_Berkas_Inspektorat/';

    $zip->addEmptyDir($root_folder);


    /*
    |--------------------------------------------------------------------------
    | TRACK FILE
    |--------------------------------------------------------------------------
    */

    $jumlah_berhasil = 0;
    $jumlah_gagal    = 0;
    $used_zip_files = array();


    /*
    |--------------------------------------------------------------------------
    | MASUKKAN FILE KE ZIP
    |--------------------------------------------------------------------------
    */

    foreach ($files as $file) {


        /*
        | Hanya 2025 / 2026
        */

        if (!in_array(
            (int) $file->tahun,
            array(2025, 2026),
            true
        )) {
            continue;
        }


        /*
        | Hanya BOSP / BOPD
        */

        $sumber_dana = strtoupper(
            trim((string) $file->sumber_dana)
        );

        if (!in_array(
            $sumber_dana,
            array('BOSP', 'BOPD'),
            true
        )) {

            $sumber_dana = 'BOSP';
        }


        /*
        |--------------------------------------------------------------------------
        | NAMA POINT
        |--------------------------------------------------------------------------
        */

        $nomor = str_pad(
            (int) $file->nomor,
            2,
            '0',
            STR_PAD_LEFT
        );


        $nama_point = trim(
            (string) $file->nama_point
        );


        /*
        | Bersihkan karakter yang tidak aman
        */

        $nama_point = preg_replace(
            '/[\\\\\/:*?"<>|]+/',
            '-',
            $nama_point
        );


        $nama_point = trim(
            preg_replace(
                '/\s+/',
                ' ',
                $nama_point
            )
        );


        /*
        |--------------------------------------------------------------------------
        | STRUKTUR FOLDER
        |--------------------------------------------------------------------------
        */

        $point_folder =
            $nomor . '. ' . $nama_point;


        $year_folder =
            (string) $file->tahun;


        $fund_folder =
            $sumber_dana;


        $zip_folder =
            $root_folder .
            $point_folder . '/' .
            $year_folder . '/' .
            $fund_folder . '/';


        /*
        |--------------------------------------------------------------------------
        | BUAT FOLDER
        |--------------------------------------------------------------------------
        */

        $zip->addEmptyDir(
            $root_folder .
            $point_folder
        );

        $zip->addEmptyDir(
            $root_folder .
            $point_folder . '/' .
            $year_folder
        );

        $zip->addEmptyDir(
            $zip_folder
        );


        /*
        |--------------------------------------------------------------------------
        | LOKASI FILE ASLI
        |--------------------------------------------------------------------------
        */

        $file_path =
            FCPATH .
            ltrim(
                $file->lokasi_file,
                '/\\'
            );


        /*
        | File tidak ditemukan
        */

        if (!file_exists($file_path)) {

            $jumlah_gagal++;

            continue;
        }


        /*
        |--------------------------------------------------------------------------
        | NAMA FILE ASLI
        |--------------------------------------------------------------------------
        */

        $original_name =
            trim(
                (string) $file->nama_file_asli
            );


        if ($original_name === '') {

            $original_name =
                basename($file_path);
        }


        /*
        |--------------------------------------------------------------------------
        | BERSIHKAN NAMA FILE
        |--------------------------------------------------------------------------
        */

        $original_name = preg_replace(
            '/[\\\\\/:*?"<>|]+/',
            '_',
            $original_name
        );


        $original_name = trim(
            $original_name
        );


        /*
        |--------------------------------------------------------------------------
        | CEGAH FILE DENGAN NAMA SAMA
        |--------------------------------------------------------------------------
        */

        $zip_file_path =
            $zip_folder .
            $original_name;


        /*
        | Jika nama file sama,
        | tambahkan nomor.
        */

        $counter = 1;

        while (
            isset($used_zip_files[$zip_file_path])
        ) {

            $pathinfo =
                pathinfo($original_name);

            $base_name =
                isset($pathinfo['filename'])
                    ? $pathinfo['filename']
                    : 'berkas';

            $extension =
                isset($pathinfo['extension'])
                    ? '.' . $pathinfo['extension']
                    : '';

            $new_name =
                $base_name .
                ' (' .
                $counter .
                ')' .
                $extension;

            $zip_file_path =
                $zip_folder .
                $new_name;

            $counter++;
        }


        $used_zip_files[$zip_file_path] = true;


        /*
        |--------------------------------------------------------------------------
        | TAMBAHKAN FILE
        |--------------------------------------------------------------------------
        */

        if (
            $zip->addFile(
                $file_path,
                $zip_file_path
            )
        ) {

            $jumlah_berhasil++;

        } else {

            $jumlah_gagal++;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | TUTUP ZIP
    |--------------------------------------------------------------------------
    */

    $zip->close();


    /*
    |--------------------------------------------------------------------------
    | CEK HASIL
    |--------------------------------------------------------------------------
    */

    if (!file_exists($zip_path)) {

        show_error(
            'File ZIP gagal dibuat.',
            500
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD
    |--------------------------------------------------------------------------
    */

    $this->load->helper('download');

    force_download(
        $zip_filename,
        file_get_contents($zip_path)
    );


    /*
    |--------------------------------------------------------------------------
    | HAPUS ZIP TEMPORARY
    |--------------------------------------------------------------------------
    */

    if (file_exists($zip_path)) {

        unlink($zip_path);
    }
}
}