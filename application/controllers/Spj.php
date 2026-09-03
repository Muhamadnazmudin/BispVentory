<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spj extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Spj_model');
        $this->load->database();
    }


    /* =========================================================
       INPUT KEBUTUHAN
    ========================================================= */

    public function input_kebutuhan()
    {
        $data['title'] = 'Input Kebutuhan';

        $data['kebutuhan'] =
            $this->Spj_model->get_all_kebutuhan();


        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view(
            'spj/input_kebutuhan/index',
            $data
        );
        $this->load->view('layouts/footer');
    }


    /* =========================================================
       TAMBAH KEBUTUHAN
    ========================================================= */

    public function tambah_kebutuhan()
    {
        if (!$this->input->post()) {

            $data['title'] = 'Tambah Input Kebutuhan';

            $data['kategori'] =
                $this->Spj_model->get_kategori();


            $this->load->view('layouts/header');
            $this->load->view('layouts/sidebar');
            $this->load->view('layouts/topbar');
            $this->load->view(
                'spj/input_kebutuhan/form',
                $data
            );
            $this->load->view('layouts/footer');

            return;
        }


        /* =====================================================
           DATA HEADER SURAT
        ===================================================== */

        $nomor_surat = trim(
            (string) $this->input->post('nomor_surat', true)
        );

        $perihal = trim(
            (string) $this->input->post('perihal', true)
        );

        $kegiatan = trim(
            (string) $this->input->post('kegiatan', true)
        );

        $tanggal = trim(
            (string) $this->input->post('tanggal', true)
        );

        $keterangan = trim(
            (string) $this->input->post('keterangan', true)
        );


        /* =====================================================
           VALIDASI HEADER
        ===================================================== */

        if (
            $nomor_surat === '' ||
            $perihal === '' ||
            $tanggal === ''
        ) {

            $this->session->set_flashdata(
                'error',
                'Nomor surat, perihal, dan tanggal wajib diisi.'
            );

            redirect('spj/tambah_kebutuhan');

            return;
        }


        /* =====================================================
           DATA DETAIL
           
           STRUKTUR FORM BARU:

           id_kategori[0]

           nama_barang[0][0]
           jumlah[0][0]
           satuan[0][0]

           nama_barang[0][1]
           jumlah[0][1]
           satuan[0][1]


           id_kategori[1]

           nama_barang[1][0]
           jumlah[1][0]
           satuan[1][0]

           dst...
        ===================================================== */

        $id_kategori =
            $this->input->post('id_kategori');

        $nama_barang =
            $this->input->post('nama_barang');

        $jumlah =
            $this->input->post('jumlah');

        $satuan =
            $this->input->post('satuan');

        $keterangan_detail =
            $this->input->post('keterangan_detail');


        /*
         * Pastikan struktur utama berupa array.
         */

        if (
            !is_array($id_kategori) ||
            !is_array($nama_barang) ||
            !is_array($jumlah) ||
            !is_array($satuan)
        ) {

            $this->session->set_flashdata(
                'error',
                'Rincian kebutuhan tidak valid.'
            );

            redirect('spj/tambah_kebutuhan');

            return;
        }


        /* =====================================================
           BENTUK DETAIL FLAT
           
           Hasil akhirnya:

           [
               [
                   id_kategori,
                   kodering,
                   nama_barang,
                   jumlah,
                   satuan,
                   keterangan
               ],

               [
                   ...
               ]
           ]
        ===================================================== */

        $details = array();


        foreach ($id_kategori as $index_kelompok => $kategori_id) {


            /* =================================================
               VALIDASI KODERING
            ================================================== */

            $kategori_id =
                (int) $kategori_id;


            if ($kategori_id <= 0) {

                continue;
            }


            /*
             * Ambil kodering dari database.
             *
             * JANGAN percaya kodering yang dikirim
             * dari browser.
             */

            $kategori =
                $this->Spj_model->get_kategori_by_id(
                    $kategori_id
                );


            if (!$kategori) {

                continue;
            }


            /* =================================================
               DATA BARANG DALAM KELOMPOK
            ================================================== */

            $barang_kelompok =
                isset($nama_barang[$index_kelompok])
                    && is_array($nama_barang[$index_kelompok])
                    ? $nama_barang[$index_kelompok]
                    : array();


            $jumlah_kelompok =
                isset($jumlah[$index_kelompok])
                    && is_array($jumlah[$index_kelompok])
                    ? $jumlah[$index_kelompok]
                    : array();


            $satuan_kelompok =
                isset($satuan[$index_kelompok])
                    && is_array($satuan[$index_kelompok])
                    ? $satuan[$index_kelompok]
                    : array();


            $keterangan_kelompok =
                isset($keterangan_detail[$index_kelompok])
                    && is_array($keterangan_detail[$index_kelompok])
                    ? $keterangan_detail[$index_kelompok]
                    : array();


            /* =================================================
               LOOP BARANG
            ================================================== */

            foreach (
                $barang_kelompok
                as $index_barang => $nama
            ) {


                $nama =
                    trim(
                        (string) $nama
                    );


                $jumlah_barang =
                    isset(
                        $jumlah_kelompok[$index_barang]
                    )
                        ? trim(
                            (string)
                            $jumlah_kelompok[$index_barang]
                        )
                        : '';


                $satuan_barang =
                    isset(
                        $satuan_kelompok[$index_barang]
                    )
                        ? trim(
                            (string)
                            $satuan_kelompok[$index_barang]
                        )
                        : '';


                $ket_barang =
                    isset(
                        $keterangan_kelompok[$index_barang]
                    )
                        ? trim(
                            (string)
                            $keterangan_kelompok[$index_barang]
                        )
                        : '';


                /* =============================================
                   LEWATI BARIS KOSONG
                ============================================== */

                if (
                    $nama === '' &&
                    $jumlah_barang === '' &&
                    $satuan_barang === ''
                ) {

                    continue;
                }


                /* =============================================
                   VALIDASI BARANG
                ============================================== */

                if ($nama === '') {

                    $this->session->set_flashdata(
                        'error',
                        'Nama barang pada salah satu rincian belum diisi.'
                    );

                    redirect('spj/tambah_kebutuhan');

                    return;
                }


                if (
                    $jumlah_barang === '' ||
                    !is_numeric($jumlah_barang) ||
                    (float) $jumlah_barang <= 0
                ) {

                    $this->session->set_flashdata(
                        'error',
                        'Jumlah barang harus lebih dari 0.'
                    );

                    redirect('spj/tambah_kebutuhan');

                    return;
                }


                if ($satuan_barang === '') {

                    $this->session->set_flashdata(
                        'error',
                        'Satuan barang pada salah satu rincian belum diisi.'
                    );

                    redirect('spj/tambah_kebutuhan');

                    return;
                }


                /* =============================================
                   MASUKKAN KE DETAIL FLAT
                ============================================== */

                $details[] = array(

                    'id_kategori' =>
                        $kategori->id_kategori,

                    'kodering' =>
                        $kategori->kodering,

                    'nama_barang' =>
                        $nama,

                    'jumlah' =>
                        $jumlah_barang,

                    'satuan' =>
                        $satuan_barang,

                    'keterangan' =>
                        $ket_barang !== ''
                            ? $ket_barang
                            : null

                );

            }

        }


        /* =====================================================
           PASTIKAN ADA BARANG
        ===================================================== */

        if (empty($details)) {

            $this->session->set_flashdata(
                'error',
                'Minimal satu barang kebutuhan harus diisi.'
            );

            redirect('spj/tambah_kebutuhan');

            return;
        }


        /* =====================================================
           HEADER DATABASE
        ===================================================== */

        $header = array(

            'nomor_surat' =>
                $nomor_surat,

            'perihal' =>
                $perihal,

            'kegiatan' =>
                $kegiatan !== ''
                    ? $kegiatan
                    : null,

            'tanggal' =>
                $tanggal,

            'keterangan' =>
                $keterangan !== ''
                    ? $keterangan
                    : null,

            'created_by' =>
                $this->session->userdata('id_user')

        );


        /* =====================================================
           SIMPAN
        ===================================================== */

        $id =
            $this->Spj_model->insert_kebutuhan(
                $header,
                $details
            );


        if ($id) {

            $this->session->set_flashdata(
                'success',
                'Kebutuhan berhasil disimpan.'
            );

            redirect(
                'spj/input_kebutuhan'
            );

            return;
        }


        /* =====================================================
           GAGAL
        ===================================================== */

        $this->session->set_flashdata(
            'error',
            'Gagal menyimpan kebutuhan.'
        );

        redirect(
            'spj/tambah_kebutuhan'
        );
    }


    /* =========================================================
       DETAIL KEBUTUHAN
    ========================================================= */

    public function detail_kebutuhan($id)
    {
        $id = (int) $id;


        $data['title'] =
            'Detail Kebutuhan';


        $data['kebutuhan'] =
            $this->Spj_model->get_kebutuhan(
                $id
            );


        if (!$data['kebutuhan']) {

            show_404();

            return;
        }


        $data['detail'] =
            $this->Spj_model->get_detail(
                $id
            );


        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view(
            'spj/input_kebutuhan/detail',
            $data
        );
        $this->load->view('layouts/footer');
    }


    /* =========================================================
       HAPUS KEBUTUHAN
    ========================================================= */

    public function hapus_kebutuhan($id)
    {
        $id = (int) $id;


        $kebutuhan =
            $this->Spj_model->get_kebutuhan(
                $id
            );


        if (!$kebutuhan) {

            show_404();

            return;
        }


        $hasil =
            $this->Spj_model->delete_kebutuhan(
                $id
            );


        if ($hasil) {

            $this->session->set_flashdata(
                'success',
                'Data kebutuhan berhasil dihapus.'
            );

        } else {

            $this->session->set_flashdata(
                'error',
                'Data kebutuhan gagal dihapus.'
            );

        }


        redirect(
            'spj/input_kebutuhan'
        );
    }


    /* =========================================================
   CETAK PDF SURAT PENGAJUAN KEBUTUHAN
========================================================= */

public function cetak_kebutuhan($id)
{
    $id = (int) $id;

    if ($id <= 0) {
        show_404();
        return;
    }


    /* =====================================================
       AMBIL DATA HEADER
    ===================================================== */

    $kebutuhan =
        $this->Spj_model->get_kebutuhan($id);


    if (!$kebutuhan) {
        show_404();
        return;
    }


    /* =====================================================
       AMBIL DETAIL BARANG
    ===================================================== */

    $detail =
        $this->Spj_model->get_detail($id);


    if (empty($detail)) {

        $this->session->set_flashdata(
            'error',
            'Data barang pada kebutuhan ini belum tersedia.'
        );

        redirect('spj/detail_kebutuhan/' . $id);

        return;
    }


    /* =====================================================
       DATA PDF
    ===================================================== */

    $data = array(

        'kebutuhan' => $kebutuhan,

        'detail' => $detail,

        /*
         * Identitas sekolah
         */

        'nama_sekolah' =>
            'SMK NEGERI 1 CILIMUS',

        'alamat' =>
            'Jalan Eyang Kyai Hasan Maulani Caracas Cilimus',

        'telepon' =>
            '(0232) 8910145',

        'email' =>
            'smkn_1cilimus@yahoo.com',

        'kabupaten' =>
            'Kabupaten Kuningan 45556',


        /*
         * Pihak tanda tangan
         *
         * Nanti bisa kita pindahkan ke
         * pengaturan sekolah.
         */

        'kepala_nama' =>
            'Drs. ROSIDIN',

        'kepala_nip' =>
            'NIP. 196707061994031014',

        'pengaju_nama' =>
            'M. HENDI GUNTARA, S.Pd',

        'pengaju_nip' =>
            'NIP. 19940828 202221 1 006'

    );


    /* =====================================================
       LOAD DOMPDF
    ===================================================== */

    require_once APPPATH . 'third_party/dompdf/autoload.inc.php';


    $dompdf =
        new \Dompdf\Dompdf();


    $dompdf->set_option(
        'isRemoteEnabled',
        true
    );


    $dompdf->set_option(
        'isHtml5ParserEnabled',
        true
    );


    $html =
        $this->load->view(
            'spj/pdf/kebutuhan',
            $data,
            true
        );


    $dompdf->loadHtml($html);


    /* =====================================================
       A4 PORTRAIT
    ===================================================== */

    $dompdf->setPaper(
        'A4',
        'portrait'
    );


    $dompdf->render();


    /* =====================================================
       NAMA FILE
    ===================================================== */

    $nama_file =
        'Surat_Pengajuan_Kebutuhan_' .
        preg_replace(
            '/[^A-Za-z0-9_\-]/',
            '_',
            $kebutuhan->nomor_surat
        ) .
        '.pdf';


    /* =====================================================
       OUTPUT PDF
    ===================================================== */

    $dompdf->stream(
        $nama_file,
        array(
            'Attachment' => false
        )
    );
}

public function edit_kebutuhan($id)
{
    $data['title'] = 'Edit Input Kebutuhan';

    $data['kebutuhan'] =
        $this->Spj_model->get_kebutuhan($id);

    if (!$data['kebutuhan']) {
        show_404();
    }

    $data['detail'] =
        $this->Spj_model->get_detail($id);

    $data['kategori'] =
        $this->Spj_model->get_kategori();


    $this->load->view('layouts/header');
    $this->load->view('layouts/sidebar');
    $this->load->view('layouts/topbar');

    $this->load->view(
        'spj/input_kebutuhan/edit',
        $data
    );

    $this->load->view('layouts/footer');
}
public function update_kebutuhan($id)
{
    $kebutuhan =
        $this->Spj_model->get_kebutuhan($id);

    if (!$kebutuhan) {
        show_404();
    }


    if (!$this->input->post()) {
        redirect('spj/edit_kebutuhan/' . $id);
    }


    $nomor_surat =
        trim(
            (string) $this->input->post(
                'nomor_surat',
                true
            )
        );

    $perihal =
        trim(
            (string) $this->input->post(
                'perihal',
                true
            )
        );

    $kegiatan =
        trim(
            (string) $this->input->post(
                'kegiatan',
                true
            )
        );

    $tanggal =
        $this->input->post(
            'tanggal',
            true
        );

    $keterangan =
        trim(
            (string) $this->input->post(
                'keterangan',
                true
            )
        );


    $id_kategori =
        $this->input->post('id_kategori');

    $nama_barang =
        $this->input->post('nama_barang');

    $jumlah =
        $this->input->post('jumlah');

    $satuan =
        $this->input->post('satuan');

    $ket_detail =
        $this->input->post('keterangan_detail');


    if (
        empty($nomor_surat) ||
        empty($perihal) ||
        empty($tanggal)
    ) {

        $this->session->set_flashdata(
            'error',
            'Nomor surat, perihal, dan tanggal wajib diisi.'
        );

        redirect(
            'spj/edit_kebutuhan/' . $id
        );
    }


    $details = array();


    if (is_array($id_kategori)) {

        foreach ($id_kategori as $i => $kategori_id) {

            $kategori_id =
                trim(
                    (string) $kategori_id
                );

            $nama =
                isset($nama_barang[$i])
                    ? trim(
                        (string) $nama_barang[$i]
                    )
                    : '';

            $qty =
                isset($jumlah[$i])
                    ? $jumlah[$i]
                    : '';

            $unit =
                isset($satuan[$i])
                    ? trim(
                        (string) $satuan[$i]
                    )
                    : '';

            $ket =
                isset($ket_detail[$i])
                    ? trim(
                        (string) $ket_detail[$i]
                    )
                    : null;


            /*
             * BARIS KOSONG DIABAIKAN
             */
            if (
                $kategori_id === '' &&
                $nama === '' &&
                $qty === '' &&
                $unit === ''
            ) {
                continue;
            }


            /*
             * BARIS TIDAK LENGKAP
             */
            if (
                $kategori_id === '' ||
                $nama === '' ||
                $qty === '' ||
                $unit === ''
            ) {

                $this->session->set_flashdata(
                    'error',
                    'Data barang belum lengkap.'
                );

                redirect(
                    'spj/edit_kebutuhan/' . $id
                );
            }


            /*
             * AMBIL KODERING DARI KATEGORI
             */
            $kategori =
                $this->db
                    ->select(
                        'id_kategori, kodering'
                    )
                    ->where(
                        'id_kategori',
                        $kategori_id
                    )
                    ->get(
                        'kategori_barang'
                    )
                    ->row();


            if (!$kategori) {

                $this->session->set_flashdata(
                    'error',
                    'Kategori barang tidak ditemukan.'
                );

                redirect(
                    'spj/edit_kebutuhan/' . $id
                );
            }


            $details[] = array(

                'id_kategori' =>
                    $kategori->id_kategori,

                'kodering' =>
                    $kategori->kodering,

                'nama_barang' =>
                    $nama,

                'jumlah' =>
                    $qty,

                'satuan' =>
                    $unit,

                'keterangan' =>
                    ($ket !== '')
                        ? $ket
                        : null
            );
        }
    }


    if (empty($details)) {

        $this->session->set_flashdata(
            'error',
            'Minimal satu barang harus diisi.'
        );

        redirect(
            'spj/edit_kebutuhan/' . $id
        );
    }


    $header = array(

        'nomor_surat' =>
            $nomor_surat,

        'perihal' =>
            $perihal,

        'kegiatan' =>
            $kegiatan,

        'tanggal' =>
            $tanggal,

        'keterangan' =>
            $keterangan
    );


    $hasil =
        $this->Spj_model->update_kebutuhan(
            $id,
            $header,
            $details
        );


    if ($hasil) {

        $this->session->set_flashdata(
            'success',
            'Data kebutuhan berhasil diperbarui.'
        );

        redirect(
            'spj/input_kebutuhan'
        );
    }


    $this->session->set_flashdata(
        'error',
        'Gagal memperbarui data kebutuhan.'
    );

    redirect(
        'spj/edit_kebutuhan/' . $id
    );
}
public function bast_internal()
{
    $data['title'] = 'BAST Internal';
    $data['kebutuhan'] = $this->Spj_model->get_all_kebutuhan();

    $this->load->view('layouts/header');
    $this->load->view('layouts/sidebar');
    $this->load->view('layouts/topbar');
    $this->load->view('spj/bast_internal/index', $data);
    $this->load->view('layouts/footer');
}
public function cetak_bast_internal($id)
{
    /*
    |--------------------------------------------------------------------------
    | LOAD DOMPDF
    |--------------------------------------------------------------------------
    */

    if (!class_exists('\Dompdf\Dompdf')) {

        /*
        | Composer
        */
        $composer_autoload = FCPATH . 'vendor/autoload.php';

        if (file_exists($composer_autoload)) {
            require_once $composer_autoload;
        }
    }


    /*
    | Jika masih belum tersedia, coba third_party Dompdf
    */

    if (!class_exists('\Dompdf\Dompdf')) {

        $dompdf_autoload =
            APPPATH . 'third_party/dompdf/autoload.inc.php';

        if (file_exists($dompdf_autoload)) {
            require_once $dompdf_autoload;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | CEK DOMPDF
    |--------------------------------------------------------------------------
    */

    if (!class_exists('\Dompdf\Dompdf')) {

        show_error(
            'Dompdf belum tersedia. Pastikan library Dompdf sudah terpasang.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | AMBIL DATA KEBUTUHAN
    |--------------------------------------------------------------------------
    */

    $kebutuhan =
        $this->Spj_model->get_kebutuhan($id);

    if (!$kebutuhan) {
        show_404();
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | AMBIL DETAIL KEBUTUHAN
    |--------------------------------------------------------------------------
    */

    $detail =
        $this->Spj_model->get_detail($id);

    if (empty($detail)) {

        show_error(
            'Rincian kebutuhan tidak ditemukan.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | DATA BAST INTERNAL
    |--------------------------------------------------------------------------
    */

    $data = array(

        'kebutuhan' => $kebutuhan,

        'detail' => $detail,


        /*
        |--------------------------------------------------------------------------
        | DATA SEKOLAH
        |--------------------------------------------------------------------------
        */

        'nama_sekolah' =>
            'SMK NEGERI 1 CILIMUS',

        'alamat' =>
            'Jalan Baru Lingkar Caracas Cilimus',

        'telepon' =>
            '(0232) 8910145',

        'email' =>
            'smkn_1cilimus@yahoo.com',

        'kabupaten' =>
            'Kabupaten Kuningan 45556',


        /*
        |--------------------------------------------------------------------------
        | PEMERIKSA
        |--------------------------------------------------------------------------
        */

        'pemeriksa_nama' =>
            'YOSI TAZU SOBIRIN',

        'pemeriksa_jabatan' =>
            'Petugas/Tim Pemeriksa',


        /*
        |--------------------------------------------------------------------------
        | PIHAK MENYERAHKAN
        |--------------------------------------------------------------------------
        */

        'penyerah_nama' =>
            'Drs. ROSIDIN',

        'penyerah_jabatan' =>
            'Kepala Sekolah SMKN 1 Cilimus',

        'penyerah_nip' =>
            'NIP. 196707061994031014',


        /*
        |--------------------------------------------------------------------------
        | PIHAK MENERIMA
        |--------------------------------------------------------------------------
        */

        'penerima_nama' =>
            'YOSI TAZU SOBIRIN',

        'penerima_jabatan' =>
            'Kepala SMK Negeri 1 Cilimus',

        'penerima_nip' =>
            'NIP. 199503272025211117'
    );


    /*
    |--------------------------------------------------------------------------
    | LOAD VIEW
    |--------------------------------------------------------------------------
    */

    $html =
        $this->load->view(
            'spj/cetak_bast_internal',
            $data,
            true
        );


    /*
    |--------------------------------------------------------------------------
    | DOMPDF OPTIONS
    |--------------------------------------------------------------------------
    */

    $options =
        new \Dompdf\Options();

    $options->set(
        'isHtml5ParserEnabled',
        true
    );

    $options->set(
        'isRemoteEnabled',
        true
    );


    /*
    |--------------------------------------------------------------------------
    | GENERATE PDF
    |--------------------------------------------------------------------------
    */

    $dompdf =
        new \Dompdf\Dompdf($options);

    $dompdf->loadHtml($html);

    $dompdf->setPaper(
        'A4',
        'portrait'
    );

    $dompdf->render();


    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN PDF DI BROWSER
    |--------------------------------------------------------------------------
    */

    $nama_file =
        'BAST-Internal-' .
        preg_replace(
            '/[^A-Za-z0-9\-_]/',
            '-',
            $kebutuhan->nomor_surat
        ) .
        '.pdf';


    $dompdf->stream(
        $nama_file,
        array(
            'Attachment' => false
        )
    );
}
public function edit_bast_internal($id)
{
    /*
    |--------------------------------------------------------------------------
    | AMBIL DATA KEBUTUHAN
    |--------------------------------------------------------------------------
    */

    $kebutuhan =
        $this->Spj_model->get_kebutuhan($id);

    if (!$kebutuhan) {
        show_404();
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA BAST
    |--------------------------------------------------------------------------
    */

    if ($this->input->method() === 'post') {

        $nomor_bast =
            trim(
                $this->input->post(
                    'nomor_bast_internal',
                    true
                )
            );

        $tanggal_bast =
            $this->input->post(
                'tanggal_bast_internal',
                true
            );


        /*
        |----------------------------------------------------------------------
        | VALIDASI
        |----------------------------------------------------------------------
        */

        if (empty($nomor_bast) || empty($tanggal_bast)) {

            $this->session->set_flashdata(
                'error',
                'Nomor BAST dan tanggal BAST wajib diisi.'
            );

            redirect(
                'spj/edit_bast_internal/' . $id
            );

            return;
        }


        /*
        |----------------------------------------------------------------------
        | UPDATE
        |----------------------------------------------------------------------
        */

        $data = array(

            'nomor_bast_internal' =>
                $nomor_bast,

            'tanggal_bast_internal' =>
                $tanggal_bast

        );


        $update =
            $this->Spj_model->update_bast_internal(
                $id,
                $data
            );


        if ($update) {

            $this->session->set_flashdata(
                'success',
                'Data BAST Internal berhasil disimpan.'
            );

            redirect(
                'spj/bast_internal'
            );

            return;
        }


        $this->session->set_flashdata(
            'error',
            'Gagal menyimpan data BAST Internal.'
        );

        redirect(
            'spj/edit_bast_internal/' . $id
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | FORM
    |--------------------------------------------------------------------------
    */

    $data = array(

        'title' =>
            'Edit BAST Internal',

        'kebutuhan' =>
            $kebutuhan

    );


    $this->load->view(
        'layouts/header'
    );

    $this->load->view(
        'layouts/sidebar'
    );

    $this->load->view(
        'layouts/topbar'
    );

    $this->load->view(
        'spj/edit_bast_internal',
        $data
    );

    $this->load->view(
        'layouts/footer'
    );
}
}