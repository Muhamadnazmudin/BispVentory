<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Upload extends MY_Controller
{
    /**
     * =========================================================
     * KONFIGURASI
     * =========================================================
     */

    protected $allowed_roles = array(
        'admin',
        'operator'
    );

    protected $allowed_years = array(
        2025,
        2026
    );

    protected $max_file_size = 51200; // KB = 50 MB


    /**
     * =========================================================
     * CONSTRUCTOR
     * =========================================================
     */

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

        /*
         * BispVentory menggunakan:
         *
         * users.role
         *
         * contoh:
         * admin
         * operator
         */

        $role = strtolower(
            trim(
                (string) $this->session->userdata('role')
            )
        );

        if (!in_array($role, $this->allowed_roles, true)) {

            show_error(
                'Anda tidak memiliki akses ke halaman upload berkas.',
                403,
                'Akses Ditolak'
            );
        }
    }


    /**
     * =========================================================
     * INDEX
     * =========================================================
     *
     * Menampilkan seluruh point Inspektorat.
     *
     * Setiap point dapat memiliki:
     *
     * 2025
     *  ├── file 1
     *  ├── file 2
     *  └── dst
     *
     * 2026
     *  ├── file 1
     *  ├── file 2
     *  └── dst
     *
     */

    public function index()
    {
        $keyword = trim(
            (string) $this->input->get('q', true)
        );

        $tahun = (int) $this->input->get('tahun');

        /*
         * Tahun hanya sebagai filter tampilan.
         * Jika tidak valid, gunakan 2025.
         */

        if (!in_array($tahun, $this->allowed_years, true)) {
            $tahun = 2025;
        }


        /*
         * Ambil seluruh point
         */

        $points = $this->Upload_model->get_points($keyword);


        /*
         * Lampirkan file 2025 dan 2026
         */

        if (!empty($points)) {

            foreach ($points as &$point) {

                $point->files_2025 =
                    $this->Upload_model->get_files_by_point(
                        $point->id,
                        2025
                    );

                $point->files_2026 =
                    $this->Upload_model->get_files_by_point(
                        $point->id,
                        2026
                    );
            }

            unset($point);
        }


        /*
         * Data view
         */

        $data = array(
            'title'   => 'Upload Berkas Inspektorat',
            'points'  => $points,
            'keyword' => $keyword,
            'tahun'   => $tahun,
            'stats'   => $this->Upload_model->get_stats()
        );


        /*
         * Layout
         */

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


    /**
     * =========================================================
     * UPLOAD FILE
     * =========================================================
     */

    public function upload_file($point_id)
    {
        $point_id = (int) $point_id;


        /*
         * Validasi point
         */

        if ($point_id <= 0) {

            $this->set_error(
                'Point dokumen tidak valid.'
            );

            redirect('upload');
        }


        $point = $this->Upload_model->get_point($point_id);


        if (!$point) {

            $this->set_error(
                'Point dokumen tidak ditemukan.'
            );

            redirect('upload');
        }


        /*
         * Validasi tahun
         */

        $tahun = (int) $this->input->post('tahun');


        if (!in_array($tahun, $this->allowed_years, true)) {

            $this->set_error(
                'Tahun dokumen tidak valid. Pilih tahun 2025 atau 2026.'
            );

            redirect('upload');
        }


        /*
         * Pastikan file benar-benar dikirim
         */

        if (
            !isset($_FILES['berkas']) ||
            !is_array($_FILES['berkas'])
        ) {

            $this->set_error(
                'File belum dipilih.'
            );

            redirect('upload');
        }


        $file_error = isset($_FILES['berkas']['error'])
            ? (int) $_FILES['berkas']['error']
            : UPLOAD_ERR_NO_FILE;


        /*
         * Validasi error PHP upload
         */

        if ($file_error !== UPLOAD_ERR_OK) {

            $this->set_error(
                $this->get_upload_error_message($file_error)
            );

            redirect('upload');
        }


        /*
         * Validasi nama file
         */

        $original_name = isset($_FILES['berkas']['name'])
            ? trim($_FILES['berkas']['name'])
            : '';


        if ($original_name === '') {

            $this->set_error(
                'Nama file tidak ditemukan.'
            );

            redirect('upload');
        }


        /*
         * Validasi ukuran
         */

        $file_size = isset($_FILES['berkas']['size'])
            ? (int) $_FILES['berkas']['size']
            : 0;


        if ($file_size <= 0) {

            $this->set_error(
                'File kosong atau tidak dapat dibaca server.'
            );

            redirect('upload');
        }


        if ($file_size > ($this->max_file_size * 1024)) {

            $this->set_error(
                'Ukuran file terlalu besar. Maksimal 50 MB.'
            );

            redirect('upload');
        }


        /*
         * Folder:
         *
         * uploads/
         * └── inspektorat/
         *     ├── 2025/
         *     └── 2026/
         */

        $upload_path =
            FCPATH .
            'uploads/inspektorat/' .
            $tahun .
            '/';


        /*
         * Pastikan folder tersedia
         */

        if (!is_dir($upload_path)) {

            if (!@mkdir($upload_path, 0755, true)) {

                $this->set_error(
                    'Folder penyimpanan tidak dapat dibuat oleh server.'
                );

                redirect('upload');
            }
        }


        /*
         * Pastikan folder writable
         */

        if (!is_writable($upload_path)) {

            $this->set_error(
                'Folder penyimpanan tidak memiliki izin tulis.'
            );

            redirect('upload');
        }


        /*
         * Konfigurasi upload CodeIgniter
         */

        $config = array(

            'upload_path'      => $upload_path,

            'allowed_types'    =>
                'pdf|' .
                'doc|' .
                'docx|' .
                'xls|' .
                'xlsx|' .
                'ppt|' .
                'pptx|' .
                'jpg|' .
                'jpeg|' .
                'png|' .
                'gif|' .
                'webp|' .
                'zip|' .
                'rar',

            'max_size'         => $this->max_file_size,

            /*
             * Nama file fisik dibuat random
             */
            'encrypt_name'     => true,

            'remove_spaces'    => true,

            /*
             * Proteksi MIME
             */
            'detect_mime'      => true,

            'mod_mime_fix'     => true
        );


        /*
         * Load library
         */

        $this->load->library('upload');

        $this->upload->initialize($config);


        /*
         * Jalankan upload
         */

        if (!$this->upload->do_upload('berkas')) {

            $error = strip_tags(
                $this->upload->display_errors('', '')
            );


            if ($error === '') {

                $error =
                    'File gagal diupload. ' .
                    'Pastikan format dan ukuran file sesuai.';
            }


            $this->set_error($error);

            redirect('upload');
        }


        /*
         * Data hasil upload
         */

        $upload = $this->upload->data();


        $stored_name = $upload['file_name'];

        $original_name =
            $upload['orig_name'];


        /*
         * Ekstensi
         */

        $extension = strtolower(
            ltrim(
                $upload['file_ext'],
                '.'
            )
        );


        /*
         * Ukuran dalam byte
         */

        $size_bytes = isset($upload['file_size'])
            ? (int) round($upload['file_size'] * 1024)
            : $file_size;


        /*
         * Lokasi relatif
         */

        $relative_path =
            'uploads/inspektorat/' .
            $tahun .
            '/' .
            $stored_name;


        /*
         * Data database
         */

        $data = array(

            'point_id' =>
                $point_id,

            'tahun' =>
                $tahun,

            'nama_file' =>
                $stored_name,

            'nama_file_asli' =>
                $original_name,

            'ekstensi' =>
                $extension,

            'tipe_file' =>
                isset($upload['file_type'])
                    ? $upload['file_type']
                    : '',

            'ukuran_file' =>
                $size_bytes,

            'lokasi_file' =>
                $relative_path,

            'keterangan' =>
                trim(
                    (string) $this->input->post(
                        'keterangan',
                        true
                    )
                ),

            'uploaded_by' =>
                $this->session->userdata('user_id'),

            'uploaded_at' =>
                date('Y-m-d H:i:s')
        );


        /*
         * Simpan ke database
         */

        $insert = $this->Upload_model->insert_file(
            $data
        );


        /*
         * Database gagal:
         * hapus file fisik supaya tidak menjadi file yatim
         */

        if (!$insert) {

            $physical_file =
                $upload_path .
                $stored_name;


            if (is_file($physical_file)) {
                @unlink($physical_file);
            }


            $this->set_error(
                'File berhasil diupload tetapi gagal disimpan ke database.'
            );

            redirect('upload');
        }


        /*
         * Berhasil
         */

        $this->set_success(
            'Berkas berhasil diupload: ' .
            $original_name
        );


        redirect('upload');
    }


    /**
 * =========================================================
 * PREVIEW FILE
 * =========================================================
 */
public function preview($id)
{
    $id = (int) $id;

    if ($id <= 0) {
        show_404();
    }

    $file = $this->Upload_model->get_file($id);

    if (!$file) {
        show_404();
    }

    $path = FCPATH . ltrim($file->lokasi_file, '/\\');

    if (!is_file($path)) {
        show_error(
            'File tidak ditemukan di server.',
            404,
            'File Tidak Ditemukan'
        );
    }

    /*
     * Pastikan file berada di folder Inspektorat
     */
    $base_dir = realpath(
        FCPATH . 'uploads/inspektorat'
    );

    $real_file = realpath($path);

    if (
        !$base_dir ||
        !$real_file ||
        strpos($real_file, $base_dir) !== 0
    ) {
        show_error(
            'Lokasi file tidak valid.',
            403,
            'Akses Ditolak'
        );
    }

    $ext = strtolower(
        trim($file->ekstensi)
    );


    /*
     * =====================================================
     * PDF
     * =====================================================
     */

    if ($ext === 'pdf') {

        header('Content-Type: application/pdf');

        header(
            'Content-Disposition: inline; filename="' .
            basename($file->nama_file_asli) .
            '"'
        );

        header(
            'Content-Length: ' . filesize($real_file)
        );

        readfile($real_file);
        exit;
    }


    /*
     * =====================================================
     * GAMBAR
     * =====================================================
     */

    if (
        in_array(
            $ext,
            array(
                'jpg',
                'jpeg',
                'png',
                'gif',
                'webp'
            ),
            true
        )
    ) {

        $mime = get_mime_by_extension($ext);

        if (!$mime) {
            $mime = 'application/octet-stream';
        }

        header(
            'Content-Type: ' . $mime
        );

        header(
            'Content-Disposition: inline; filename="' .
            basename($file->nama_file_asli) .
            '"'
        );

        header(
            'Content-Length: ' . filesize($real_file)
        );

        readfile($real_file);
        exit;
    }


    /*
     * =====================================================
     * EXCEL
     * XLS / XLSX
     * =====================================================
     */

    if (
        in_array(
            $ext,
            array('xls', 'xlsx'),
            true
        )
    ) {

        $this->preview_excel(
            $real_file,
            $file
        );

        exit;
    }


    /*
     * =====================================================
     * WORD
     * DOCX
     * =====================================================
     */

    if ($ext === 'docx') {

        $this->preview_docx(
            $real_file,
            $file
        );

        exit;
    }


    /*
     * DOC lama belum kita render.
     */

    if ($ext === 'doc') {

        $this->preview_not_supported(
            $file,
            'Microsoft Word format DOC lama belum dapat dipreview langsung. Silakan download file.'
        );

        exit;
    }


    /*
     * PPT / PPTX
     */

    if (
        in_array(
            $ext,
            array('ppt', 'pptx'),
            true
        )
    ) {

        $this->preview_not_supported(
            $file,
            'File PowerPoint belum dapat dipreview langsung. Silakan download file.'
        );

        exit;
    }


    /*
     * ZIP / RAR
     */

    if (
        in_array(
            $ext,
            array('zip', 'rar'),
            true
        )
    ) {

        $this->preview_not_supported(
            $file,
            'File arsip ZIP/RAR tidak dapat dipreview. Silakan download file.'
        );

        exit;
    }


    /*
     * Format lain
     */

    $this->preview_not_supported(
        $file,
        'Format file ini belum mendukung preview.'
    );
}

/**
 * =========================================================
 * PREVIEW EXCEL
 * =========================================================
 */
protected function preview_excel($path, $file)
{
    /*
     * PhpSpreadsheet
     */

    $autoload = FCPATH . 'vendor/autoload.php';

    if (!is_file($autoload)) {

        $this->preview_not_supported(
            $file,
            'Library PhpSpreadsheet belum tersedia.'
        );

        return;
    }

    require_once $autoload;

    try {

        $spreadsheet =
            \PhpOffice\PhpSpreadsheet\IOFactory::load(
                $path
            );

    } catch (Exception $e) {

        $this->preview_not_supported(
            $file,
            'File Excel tidak dapat dibaca atau rusak.'
        );

        return;
    }


    /*
     * Ambil semua worksheet
     */

    $sheets =
        $spreadsheet->getWorksheetIterator();


    $html = '';

    $html .= $this->preview_header(
        $file,
        'Excel'
    );


    /*
     * Tab sheet
     */

    $sheet_list = array();

    foreach ($sheets as $sheet) {

        $sheet_list[] =
            $sheet->getTitle();
    }


    if (!empty($sheet_list)) {

        $html .= '<div class="sheet-tabs">';

        foreach ($sheet_list as $index => $sheet_name) {

            $active =
                $index === 0
                    ? ' active'
                    : '';

            $html .=
                '<span class="sheet-tab' .
                $active .
                '">' .
                htmlspecialchars(
                    $sheet_name,
                    ENT_QUOTES,
                    'UTF-8'
                ) .
                '</span>';
        }

        $html .= '</div>';
    }


    /*
     * Render worksheet
     */

    foreach ($spreadsheet->getWorksheetIterator() as $index => $worksheet) {

        if ($index > 0) {
            $html .= '<div class="sheet-separator"></div>';
        }

        $html .= '<div class="sheet-title">';

        $html .= htmlspecialchars(
            $worksheet->getTitle(),
            ENT_QUOTES,
            'UTF-8'
        );

        $html .= '</div>';


        $html .= '<div class="table-wrap">';

        $html .= '<table class="excel-table">';


        foreach (
            $worksheet->getRowIterator()
            as $row
        ) {

            $html .= '<tr>';


            foreach (
                $row->getCellIterator()
                as $cell
            ) {

                $value =
                    $cell->getFormattedValue();


                $html .= '<td>';

                $html .= nl2br(
                    htmlspecialchars(
                        (string) $value,
                        ENT_QUOTES,
                        'UTF-8'
                    )
                );

                $html .= '</td>';
            }


            $html .= '</tr>';
        }


        $html .= '</table>';

        $html .= '</div>';
    }


    $html .= '</body></html>';


    echo $html;
}
/**
 * =========================================================
 * PREVIEW DOCX
 * =========================================================
 */
protected function preview_docx($path, $file)
{
    if (!class_exists('ZipArchive')) {

        $this->preview_not_supported(
            $file,
            'Ekstensi ZIP PHP tidak tersedia sehingga DOCX tidak dapat dibaca.'
        );

        return;
    }


    $zip = new ZipArchive();

    if ($zip->open($path) !== true) {

        $this->preview_not_supported(
            $file,
            'Dokumen Word tidak dapat dibuka.'
        );

        return;
    }


    $document_xml =
        $zip->getFromName(
            'word/document.xml'
        );


    $zip->close();


    if (!$document_xml) {

        $this->preview_not_supported(
            $file,
            'Isi dokumen Word tidak dapat dibaca.'
        );

        return;
    }


    /*
     * XML Word namespace
     */

    $xml = simplexml_load_string(
        $document_xml
    );


    if (!$xml) {

        $this->preview_not_supported(
            $file,
            'Struktur dokumen Word tidak valid.'
        );

        return;
    }


    $xml->registerXPathNamespace(
        'w',
        'http://schemas.openxmlformats.org/wordprocessingml/2006/main'
    );


    $paragraphs =
        $xml->xpath('//w:p');


    $content = '';


    if ($paragraphs) {

        foreach ($paragraphs as $paragraph) {

            $text = '';

            $texts =
                $paragraph->xpath('.//w:t');


            if ($texts) {

                foreach ($texts as $t) {

                    $text .=
                        (string) $t;
                }
            }


            if (trim($text) !== '') {

                $content .=
                    '<p>' .
                    nl2br(
                        htmlspecialchars(
                            $text,
                            ENT_QUOTES,
                            'UTF-8'
                        )
                    ) .
                    '</p>';
            }
        }
    }


    if (trim($content) === '') {

        $content =
            '<div class="empty-preview">' .
            'Tidak ada teks yang dapat ditampilkan.' .
            '</div>';
    }


    $html = '';

    $html .= $this->preview_header(
        $file,
        'Microsoft Word'
    );


    $html .=
        '<div class="word-preview">' .
        $content .
        '</div>';


    $html .= '</body></html>';


    echo $html;
}

/**
 * =========================================================
 * HEADER PREVIEW
 * =========================================================
 */
protected function preview_header($file, $type)
{
    $title =
        htmlspecialchars(
            $file->nama_file_asli,
            ENT_QUOTES,
            'UTF-8'
        );


    $type =
        htmlspecialchars(
            $type,
            ENT_QUOTES,
            'UTF-8'
        );


    $download_url =
        site_url(
            'upload/download/' .
            (int) $file->id
        );


    $html = '<!DOCTYPE html>';

    $html .= '<html lang="id">';

    $html .= '<head>';

    $html .= '<meta charset="utf-8">';

    $html .=
        '<meta name="viewport" content="width=device-width, initial-scale=1">';

    $html .= '<title>Preview - ' . $title . '</title>';


    $html .= '<style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f4f6fb;
            color: #343a40;
            font-family:
                Arial,
                Helvetica,
                sans-serif;
        }

        .preview-header {
            position: sticky;
            top: 0;
            z-index: 100;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            padding: 14px 20px;

            background: #fff;

            border-bottom: 1px solid #e4e8f0;

            box-shadow:
                0 2px 10px rgba(0,0,0,.05);
        }

        .preview-title {
            min-width: 0;
        }

        .preview-title strong {
            display: block;

            overflow: hidden;

            text-overflow: ellipsis;

            white-space: nowrap;

            font-size: 15px;
        }

        .preview-type {
            margin-top: 3px;

            color: #8a94a6;

            font-size: 12px;
        }

        .download-btn {
            display: inline-flex;

            align-items: center;

            gap: 7px;

            padding: 9px 14px;

            border-radius: 8px;

            color: #fff;

            background: #4e73df;

            text-decoration: none;

            font-size: 12px;

            font-weight: 700;

            white-space: nowrap;
        }

        .download-btn:hover {
            color: #fff;

            background: #3d5fc4;

            text-decoration: none;
        }

        .sheet-tabs {
            display: flex;

            gap: 5px;

            padding: 12px 20px;

            background: #fff;

            border-bottom: 1px solid #e5e7eb;

            overflow-x: auto;
        }

        .sheet-tab {
            padding: 7px 12px;

            border-radius: 7px;

            background: #f0f2f6;

            color: #687386;

            font-size: 11px;

            font-weight: 600;

            white-space: nowrap;
        }

        .sheet-tab.active {
            color: #fff;

            background: #4e73df;
        }

        .sheet-title {
            padding: 15px 20px 8px;

            color: #4e73df;

            font-size: 14px;

            font-weight: 800;
        }

        .table-wrap {
            margin: 0 20px 20px;

            overflow: auto;

            max-height: calc(100vh - 160px);

            background: #fff;

            border: 1px solid #e1e5eb;

            border-radius: 8px;
        }

        .excel-table {
            width: 100%;

            border-collapse: collapse;

            font-size: 12px;

            background: #fff;
        }

        .excel-table td {
            min-width: 80px;

            padding: 7px 9px;

            border-right: 1px solid #e5e7eb;

            border-bottom: 1px solid #e5e7eb;

            vertical-align: top;

            white-space: pre-wrap;
        }

        .excel-table tr:first-child td {
            background: #f5f7fb;

            font-weight: 700;
        }

        .excel-table tr:hover td {
            background: #f9fbff;
        }

        .sheet-separator {
            height: 12px;

            background: #f4f6fb;
        }

        .word-preview {
            max-width: 900px;

            min-height: calc(100vh - 90px);

            margin: 25px auto;

            padding: 50px 60px;

            background: #fff;

            border: 1px solid #e2e6ee;

            border-radius: 5px;

            box-shadow:
                0 4px 18px rgba(0,0,0,.05);

            line-height: 1.7;

            font-size: 14px;
        }

        .word-preview p {
            margin: 0 0 12px;
        }

        .empty-preview {
            padding: 40px;

            text-align: center;

            color: #8a94a6;
        }

        .unsupported {
            max-width: 500px;

            margin: 100px auto;

            padding: 35px;

            text-align: center;

            background: #fff;

            border-radius: 12px;

            box-shadow:
                0 5px 25px rgba(0,0,0,.08);
        }

        @media(max-width: 768px) {

            .preview-header {
                padding: 12px;
            }

            .preview-title strong {
                max-width: 180px;
            }

            .word-preview {
                margin: 10px;

                padding: 25px 20px;
            }

            .table-wrap {
                margin: 0 10px 10px;
            }
        }

    </style>';


    $html .= '</head>';

    $html .= '<body>';


    $html .=
        '<div class="preview-header">';

    $html .=
        '<div class="preview-title">';

    $html .=
        '<strong>' .
        $title .
        '</strong>';

    $html .=
        '<div class="preview-type">' .
        $type .
        '</div>';

    $html .=
        '</div>';


    $html .=
        '<a class="download-btn" href="' .
        htmlspecialchars(
            $download_url,
            ENT_QUOTES,
            'UTF-8'
        ) .
        '">';

    $html .=
        '⬇ Download';

    $html .=
        '</a>';

    $html .=
        '</div>';


    return $html;
}
/**
 * =========================================================
 * FORMAT BELUM SUPPORT
 * =========================================================
 */
protected function preview_not_supported($file, $message)
{
    $title =
        htmlspecialchars(
            $file->nama_file_asli,
            ENT_QUOTES,
            'UTF-8'
        );


    $download_url =
        site_url(
            'upload/download/' .
            (int) $file->id
        );


    echo '<!DOCTYPE html>';

    echo '<html lang="id">';

    echo '<head>';

    echo '<meta charset="utf-8">';

    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';

    echo '<title>Preview - ' . $title . '</title>';

    echo '<style>

        body {
            margin: 0;

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            background: #f4f6fb;

            font-family: Arial, sans-serif;
        }

        .unsupported {
            width: calc(100% - 30px);

            max-width: 500px;

            padding: 35px;

            text-align: center;

            background: #fff;

            border-radius: 14px;

            box-shadow:
                0 8px 30px rgba(0,0,0,.08);
        }

        .icon {
            font-size: 45px;

            margin-bottom: 15px;
        }

        h3 {
            margin-bottom: 10px;

            color: #343a40;
        }

        p {
            color: #7b8494;

            line-height: 1.6;

            font-size: 13px;
        }

        a {
            display: inline-block;

            margin-top: 15px;

            padding: 10px 18px;

            border-radius: 8px;

            color: #fff;

            background: #4e73df;

            text-decoration: none;

            font-size: 12px;

            font-weight: 700;
        }

    </style>';

    echo '</head>';

    echo '<body>';

    echo '<div class="unsupported">';

    echo '<div class="icon">📄</div>';

    echo '<h3>Preview Tidak Tersedia</h3>';

    echo '<p>' .
        htmlspecialchars(
            $message,
            ENT_QUOTES,
            'UTF-8'
        ) .
        '</p>';

    echo '<a href="' .
        htmlspecialchars(
            $download_url,
            ENT_QUOTES,
            'UTF-8'
        ) .
        '">Download Berkas</a>';

    echo '</div>';

    echo '</body>';

    echo '</html>';
}
    /**
     * =========================================================
     * DOWNLOAD
     * =========================================================
     */

    public function download($id)
    {
        $id = (int) $id;


        if ($id <= 0) {
            show_404();
        }


        $file =
            $this->Upload_model->get_file($id);


        if (!$file) {
            show_404();
        }


        /*
         * Lokasi file
         */

        $path =
            FCPATH .
            ltrim(
                $file->lokasi_file,
                '/\\'
            );


        /*
         * Pastikan file benar-benar ada
         */

        if (!is_file($path)) {

            show_error(
                'File tidak ditemukan di server.',
                404,
                'File Tidak Ditemukan'
            );
        }


        /*
         * Pastikan file berada di folder
         * uploads/inspektorat
         */

        $real_base =
            realpath(
                FCPATH .
                'uploads/inspektorat'
            );

        $real_file =
            realpath($path);


        if (
            !$real_base ||
            !$real_file ||
            strpos(
                $real_file,
                $real_base
            ) !== 0
        ) {

            show_error(
                'Lokasi file tidak valid.',
                403,
                'Akses Ditolak'
            );
        }


        /*
         * Nama download menggunakan nama asli.
         */

        force_download(
            $file->nama_file_asli,
            file_get_contents($real_file)
        );
    }


    /**
     * =========================================================
     * DELETE FILE
     * =========================================================
     */

    public function delete_file($id)
    {
        $id = (int) $id;


        if ($id <= 0) {

            $this->set_error(
                'ID berkas tidak valid.'
            );

            redirect('upload');
        }


        $file =
            $this->Upload_model->get_file($id);


        if (!$file) {

            $this->set_error(
                'Berkas tidak ditemukan.'
            );

            redirect('upload');
        }


        /*
         * Lokasi fisik
         */

        $path =
            FCPATH .
            ltrim(
                $file->lokasi_file,
                '/\\'
            );


        /*
         * Hapus file fisik
         */

        if (is_file($path)) {

            if (!@unlink($path)) {

                $this->set_error(
                    'File ditemukan tetapi gagal dihapus dari server.'
                );

                redirect('upload');
            }
        }


        /*
         * Hapus database
         */

        $deleted =
            $this->Upload_model->delete_file($id);


        if (!$deleted) {

            $this->set_error(
                'File fisik sudah dihapus, tetapi data database gagal dihapus.'
            );

            redirect('upload');
        }


        $this->set_success(
            'Berkas berhasil dihapus.'
        );


        redirect('upload');
    }


    /**
     * =========================================================
     * TAMBAH POINT
     * =========================================================
     */

    public function tambah_point()
    {
        $data = array(
            'title' => 'Tambah Point Dokumen',
            'point' => null
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


    /**
     * =========================================================
     * SIMPAN POINT
     * =========================================================
     */

    public function simpan_point()
    {
        $nomor =
            (int) $this->input->post(
                'nomor'
            );


        $nama =
            trim(
                (string) $this->input->post(
                    'nama_point',
                    true
                )
            );


        $keterangan =
            trim(
                (string) $this->input->post(
                    'keterangan',
                    true
                )
            );


        /*
         * Validasi
         */

        if ($nomor <= 0) {

            $this->set_error(
                'Nomor point wajib diisi.'
            );

            redirect('upload/tambah_point');
        }


        if ($nama === '') {

            $this->set_error(
                'Nama point wajib diisi.'
            );

            redirect('upload/tambah_point');
        }


        /*
         * Data
         */

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


        /*
         * Insert
         */

        if (!$this->Upload_model->insert_point($data)) {

            $this->set_error(
                'Point gagal ditambahkan.'
            );

            redirect('upload/tambah_point');
        }


        $this->set_success(
            'Point berhasil ditambahkan.'
        );


        redirect('upload');
    }


    /**
     * =========================================================
     * EDIT POINT
     * =========================================================
     */

    public function edit_point($id)
    {
        $id = (int) $id;


        if ($id <= 0) {
            show_404();
        }


        $point =
            $this->Upload_model->get_point($id);


        if (!$point) {
            show_404();
        }


        $data = array(

            'title' =>
                'Edit Point Dokumen',

            'point' =>
                $point
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


    /**
     * =========================================================
     * UPDATE POINT
     * =========================================================
     */

    public function update_point($id)
    {
        $id = (int) $id;


        if ($id <= 0) {
            show_404();
        }


        $point =
            $this->Upload_model->get_point($id);


        if (!$point) {
            show_404();
        }


        $nomor =
            (int) $this->input->post(
                'nomor'
            );


        $nama =
            trim(
                (string) $this->input->post(
                    'nama_point',
                    true
                )
            );


        $keterangan =
            trim(
                (string) $this->input->post(
                    'keterangan',
                    true
                )
            );


        /*
         * Validasi
         */

        if ($nomor <= 0) {

            $this->set_error(
                'Nomor point wajib diisi.'
            );

            redirect(
                'upload/edit_point/' . $id
            );
        }


        if ($nama === '') {

            $this->set_error(
                'Nama point wajib diisi.'
            );

            redirect(
                'upload/edit_point/' . $id
            );
        }


        /*
         * Data update
         */

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


        /*
         * Update
         */

        if (
            !$this->Upload_model->update_point(
                $id,
                $data
            )
        ) {

            $this->set_error(
                'Point gagal diperbarui.'
            );

            redirect(
                'upload/edit_point/' . $id
            );
        }


        $this->set_success(
            'Point berhasil diperbarui.'
        );


        redirect('upload');
    }


    /**
     * =========================================================
     * DELETE POINT
     * =========================================================
     */

    public function delete_point($id)
    {
        $id = (int) $id;


        if ($id <= 0) {
            show_404();
        }


        $point =
            $this->Upload_model->get_point($id);


        if (!$point) {
            show_404();
        }


        /*
         * Hapus point melalui model.
         *
         * Model diharapkan menangani:
         * - file database
         * - relasi file
         */

        if (
            !$this->Upload_model->delete_point($id)
        ) {

            $this->set_error(
                'Point gagal dihapus.'
            );

            redirect('upload');
        }


        $this->set_success(
            'Point dan seluruh berkas di dalamnya berhasil dihapus.'
        );


        redirect('upload');
    }


    /**
     * =========================================================
     * HELPER - FLASH SUCCESS
     * =========================================================
     */

    protected function set_success($message)
    {
        $this->session->set_flashdata(
            'success',
            $message
        );
    }


    /**
     * =========================================================
     * HELPER - FLASH ERROR
     * =========================================================
     */

    protected function set_error($message)
    {
        $this->session->set_flashdata(
            'error',
            $message
        );
    }


    /**
     * =========================================================
     * HELPER - ERROR UPLOAD
     * =========================================================
     */

    protected function get_upload_error_message($code)
    {
        switch ($code) {

            case UPLOAD_ERR_INI_SIZE:

                return
                    'Ukuran file melebihi batas upload server (upload_max_filesize).';


            case UPLOAD_ERR_FORM_SIZE:

                return
                    'Ukuran file melebihi batas yang diperbolehkan form.';


            case UPLOAD_ERR_PARTIAL:

                return
                    'File hanya terupload sebagian. Silakan coba lagi.';


            case UPLOAD_ERR_NO_FILE:

                return
                    'Tidak ada file yang dipilih.';


            case UPLOAD_ERR_NO_TMP_DIR:

                return
                    'Folder temporary upload PHP tidak tersedia.';


            case UPLOAD_ERR_CANT_WRITE:

                return
                    'Server tidak dapat menulis file. Periksa permission folder upload.';


            case UPLOAD_ERR_EXTENSION:

                return
                    'Upload dihentikan oleh ekstensi PHP.';


            default:

                return
                    'Terjadi kesalahan saat menerima file dari browser.';
        }
    }
}