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
    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN FORM
    |--------------------------------------------------------------------------
    */

    if (!$this->input->post()) {

        $data = array(
            'title'    => 'Tambah Input Kebutuhan',
            'kategori' => $this->Spj_model->get_kategori()
        );

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


    /*
    |--------------------------------------------------------------------------
    | DATA HEADER
    |--------------------------------------------------------------------------
    */

    $nomor_surat = trim(
        (string) $this->input->post('nomor_surat', true)
    );

    $nomor_invoice = trim(
        (string) $this->input->post('nomor_invoice', true)
    );

    $nomor_pesanan = trim(
        (string) $this->input->post('nomor_pesanan', true)
    );

    $nama_penyedia = trim(
        (string) $this->input->post('nama_penyedia', true)
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


    /*
    |--------------------------------------------------------------------------
    | VALIDASI HEADER
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | DATA DETAIL
    |--------------------------------------------------------------------------
    |
    | Struktur:
    |
    | id_kategori[0]
    |
    | nama_barang[0][0]
    | jumlah[0][0]
    | satuan[0][0]
    |
    | nama_barang[0][1]
    | jumlah[0][1]
    | satuan[0][1]
    |
    | id_kategori[1]
    | dst...
    |
    |--------------------------------------------------------------------------
    */

    $id_kategori = $this->input->post('id_kategori');

    $nama_barang = $this->input->post('nama_barang');

    $jumlah = $this->input->post('jumlah');

    $satuan = $this->input->post('satuan');

    $keterangan_detail =
        $this->input->post('keterangan_detail');


    /*
    |--------------------------------------------------------------------------
    | VALIDASI STRUKTUR DETAIL
    |--------------------------------------------------------------------------
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


    /*
    |--------------------------------------------------------------------------
    | BENTUK DETAIL FLAT
    |--------------------------------------------------------------------------
    */

    $details = array();


    foreach (
        $id_kategori as $index_kelompok => $kategori_id
    ) {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI KATEGORI
        |--------------------------------------------------------------------------
        */

        $kategori_id = (int) $kategori_id;

        if ($kategori_id <= 0) {
            continue;
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL KATEGORI DARI DATABASE
        |--------------------------------------------------------------------------
        |
        | Kodering diambil dari database.
        | Tidak mempercayai data kodering dari browser.
        |
        */

        $kategori =
            $this->Spj_model->get_kategori_by_id(
                $kategori_id
            );


        if (!$kategori) {
            continue;
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA KELOMPOK
        |--------------------------------------------------------------------------
        */

        $barang_kelompok =
            isset($nama_barang[$index_kelompok]) &&
            is_array($nama_barang[$index_kelompok])
                ? $nama_barang[$index_kelompok]
                : array();


        $jumlah_kelompok =
            isset($jumlah[$index_kelompok]) &&
            is_array($jumlah[$index_kelompok])
                ? $jumlah[$index_kelompok]
                : array();


        $satuan_kelompok =
            isset($satuan[$index_kelompok]) &&
            is_array($satuan[$index_kelompok])
                ? $satuan[$index_kelompok]
                : array();


        $keterangan_kelompok =
            isset($keterangan_detail[$index_kelompok]) &&
            is_array($keterangan_detail[$index_kelompok])
                ? $keterangan_detail[$index_kelompok]
                : array();


        /*
        |--------------------------------------------------------------------------
        | LOOP BARANG
        |--------------------------------------------------------------------------
        */

        foreach (
            $barang_kelompok as $index_barang => $nama
        ) {

            $nama = trim(
                (string) $nama
            );


            $jumlah_barang =
                isset($jumlah_kelompok[$index_barang])
                    ? trim(
                        (string)
                        $jumlah_kelompok[$index_barang]
                    )
                    : '';


            $satuan_barang =
                isset($satuan_kelompok[$index_barang])
                    ? trim(
                        (string)
                        $satuan_kelompok[$index_barang]
                    )
                    : '';


            $ket_barang =
                isset($keterangan_kelompok[$index_barang])
                    ? trim(
                        (string)
                        $keterangan_kelompok[$index_barang]
                    )
                    : '';


            /*
            |--------------------------------------------------------------------------
            | LEWATI BARIS KOSONG
            |--------------------------------------------------------------------------
            */

            if (
                $nama === '' &&
                $jumlah_barang === '' &&
                $satuan_barang === ''
            ) {

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | VALIDASI NAMA BARANG
            |--------------------------------------------------------------------------
            */

            if ($nama === '') {

                $this->session->set_flashdata(
                    'error',
                    'Nama barang pada salah satu rincian belum diisi.'
                );

                redirect('spj/tambah_kebutuhan');

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | VALIDASI JUMLAH
            |--------------------------------------------------------------------------
            */

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


            /*
            |--------------------------------------------------------------------------
            | VALIDASI SATUAN
            |--------------------------------------------------------------------------
            */

            if ($satuan_barang === '') {

                $this->session->set_flashdata(
                    'error',
                    'Satuan barang pada salah satu rincian belum diisi.'
                );

                redirect('spj/tambah_kebutuhan');

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN DETAIL
            |--------------------------------------------------------------------------
            */

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


    /*
    |--------------------------------------------------------------------------
    | PASTIKAN MINIMAL ADA 1 BARANG
    |--------------------------------------------------------------------------
    */

    if (empty($details)) {

        $this->session->set_flashdata(
            'error',
            'Minimal satu barang kebutuhan harus diisi.'
        );

        redirect('spj/tambah_kebutuhan');

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | HEADER DATABASE
    |--------------------------------------------------------------------------
    */

    $header = array(

        'nomor_surat' =>
            $nomor_surat,

        'nomor_invoice' =>
            $nomor_invoice !== ''
                ? $nomor_invoice
                : null,

        'nomor_pesanan' =>
            $nomor_pesanan !== ''
                ? $nomor_pesanan
                : null,

        'nama_penyedia' =>
            $nama_penyedia !== ''
                ? $nama_penyedia
                : null,

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


    /*
    |--------------------------------------------------------------------------
    | SIMPAN KE DATABASE
    |--------------------------------------------------------------------------
    */

    $id =
        $this->Spj_model->insert_kebutuhan(
            $header,
            $details
        );


    /*
    |--------------------------------------------------------------------------
    | BERHASIL
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | GAGAL
    |--------------------------------------------------------------------------
    */

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
    $id = (int) $id;

    if ($id <= 0) {
        show_404();
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | AMBIL DATA KEBUTUHAN
    |--------------------------------------------------------------------------
    */

    $kebutuhan = $this->Spj_model->get_kebutuhan($id);

    if (!$kebutuhan) {
        show_404();
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | DATA FORM
    |--------------------------------------------------------------------------
    */

    $data = array(
        'title'     => 'Edit Input Kebutuhan',
        'kebutuhan' => $kebutuhan,
        'detail'    => $this->Spj_model->get_detail($id),
        'kategori'  => $this->Spj_model->get_kategori()
    );


    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN HALAMAN
    |--------------------------------------------------------------------------
    */

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
    $id = (int) $id;

    if ($id <= 0) {
        show_404();
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | CEK DATA
    |--------------------------------------------------------------------------
    */

    $kebutuhan = $this->Spj_model->get_kebutuhan($id);

    if (!$kebutuhan) {
        show_404();
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | HARUS POST
    |--------------------------------------------------------------------------
    */

    if (!$this->input->post()) {

        redirect(
            'spj/edit_kebutuhan/' . $id
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | DATA HEADER
    |--------------------------------------------------------------------------
    */

    $nomor_surat = trim(
        (string) $this->input->post(
            'nomor_surat',
            true
        )
    );

    $nomor_invoice = trim(
        (string) $this->input->post(
            'nomor_invoice',
            true
        )
    );

    $nomor_pesanan = trim(
        (string) $this->input->post(
            'nomor_pesanan',
            true
        )
    );

    $nama_penyedia = trim(
        (string) $this->input->post(
            'nama_penyedia',
            true
        )
    );

    $perihal = trim(
        (string) $this->input->post(
            'perihal',
            true
        )
    );

    $kegiatan = trim(
        (string) $this->input->post(
            'kegiatan',
            true
        )
    );

    $tanggal = trim(
        (string) $this->input->post(
            'tanggal',
            true
        )
    );

    $keterangan = trim(
        (string) $this->input->post(
            'keterangan',
            true
        )
    );


    /*
    |--------------------------------------------------------------------------
    | VALIDASI HEADER
    |--------------------------------------------------------------------------
    */

    if (
        $nomor_surat === '' ||
        $perihal === '' ||
        $tanggal === ''
    ) {

        $this->session->set_flashdata(
            'error',
            'Nomor surat, perihal, dan tanggal wajib diisi.'
        );

        redirect(
            'spj/edit_kebutuhan/' . $id
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | DATA DETAIL
    |--------------------------------------------------------------------------
    */

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
    |--------------------------------------------------------------------------
    | VALIDASI STRUKTUR DETAIL
    |--------------------------------------------------------------------------
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

        redirect(
            'spj/edit_kebutuhan/' . $id
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | BENTUK DETAIL FLAT
    |--------------------------------------------------------------------------
    */

    $details = array();


    foreach (
        $id_kategori as $index_kelompok => $kategori_id
    ) {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI KATEGORI
        |--------------------------------------------------------------------------
        */

        $kategori_id = (int) $kategori_id;

        if ($kategori_id <= 0) {
            continue;
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL KATEGORI DARI DATABASE
        |--------------------------------------------------------------------------
        |
        | Kodering selalu diambil ulang dari database.
        |
        */

        $kategori =
            $this->Spj_model->get_kategori_by_id(
                $kategori_id
            );


        if (!$kategori) {
            continue;
        }


        /*
        |--------------------------------------------------------------------------
        | DATA KELOMPOK
        |--------------------------------------------------------------------------
        */

        $barang_kelompok =
            isset($nama_barang[$index_kelompok]) &&
            is_array($nama_barang[$index_kelompok])
                ? $nama_barang[$index_kelompok]
                : array();


        $jumlah_kelompok =
            isset($jumlah[$index_kelompok]) &&
            is_array($jumlah[$index_kelompok])
                ? $jumlah[$index_kelompok]
                : array();


        $satuan_kelompok =
            isset($satuan[$index_kelompok]) &&
            is_array($satuan[$index_kelompok])
                ? $satuan[$index_kelompok]
                : array();


        $keterangan_kelompok =
            isset($keterangan_detail[$index_kelompok]) &&
            is_array($keterangan_detail[$index_kelompok])
                ? $keterangan_detail[$index_kelompok]
                : array();


        /*
        |--------------------------------------------------------------------------
        | LOOP BARANG
        |--------------------------------------------------------------------------
        */

        foreach (
            $barang_kelompok as $index_barang => $nama
        ) {

            $nama = trim(
                (string) $nama
            );


            $jumlah_barang =
                isset($jumlah_kelompok[$index_barang])
                    ? trim(
                        (string)
                        $jumlah_kelompok[$index_barang]
                    )
                    : '';


            $satuan_barang =
                isset($satuan_kelompok[$index_barang])
                    ? trim(
                        (string)
                        $satuan_kelompok[$index_barang]
                    )
                    : '';


            $ket_barang =
                isset($keterangan_kelompok[$index_barang])
                    ? trim(
                        (string)
                        $keterangan_kelompok[$index_barang]
                    )
                    : '';


            /*
            |--------------------------------------------------------------------------
            | LEWATI BARIS KOSONG
            |--------------------------------------------------------------------------
            */

            if (
                $nama === '' &&
                $jumlah_barang === '' &&
                $satuan_barang === ''
            ) {

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | VALIDASI NAMA
            |--------------------------------------------------------------------------
            */

            if ($nama === '') {

                $this->session->set_flashdata(
                    'error',
                    'Nama barang pada salah satu rincian belum diisi.'
                );

                redirect(
                    'spj/edit_kebutuhan/' . $id
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | VALIDASI JUMLAH
            |--------------------------------------------------------------------------
            */

            if (
                $jumlah_barang === '' ||
                !is_numeric($jumlah_barang) ||
                (float) $jumlah_barang <= 0
            ) {

                $this->session->set_flashdata(
                    'error',
                    'Jumlah barang harus lebih dari 0.'
                );

                redirect(
                    'spj/edit_kebutuhan/' . $id
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | VALIDASI SATUAN
            |--------------------------------------------------------------------------
            */

            if ($satuan_barang === '') {

                $this->session->set_flashdata(
                    'error',
                    'Satuan barang pada salah satu rincian belum diisi.'
                );

                redirect(
                    'spj/edit_kebutuhan/' . $id
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | MASUKKAN DETAIL
            |--------------------------------------------------------------------------
            */

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


    /*
    |--------------------------------------------------------------------------
    | MINIMAL 1 BARANG
    |--------------------------------------------------------------------------
    */

    if (empty($details)) {

        $this->session->set_flashdata(
            'error',
            'Minimal satu barang harus diisi.'
        );

        redirect(
            'spj/edit_kebutuhan/' . $id
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | HEADER DATABASE
    |--------------------------------------------------------------------------
    */

    $header = array(

        'nomor_surat' =>
            $nomor_surat,

        'nomor_invoice' =>
            $nomor_invoice !== ''
                ? $nomor_invoice
                : null,

        'nomor_pesanan' =>
            $nomor_pesanan !== ''
                ? $nomor_pesanan
                : null,

        'nama_penyedia' =>
            $nama_penyedia !== ''
                ? $nama_penyedia
                : null,

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
                : null
    );


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    $hasil =
        $this->Spj_model->update_kebutuhan(
            $id,
            $header,
            $details
        );


    /*
    |--------------------------------------------------------------------------
    | BERHASIL
    |--------------------------------------------------------------------------
    */

    if ($hasil) {

        $this->session->set_flashdata(
            'success',
            'Data kebutuhan berhasil diperbarui.'
        );

        redirect(
            'spj/input_kebutuhan'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | GAGAL
    |--------------------------------------------------------------------------
    */

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
    | VALIDASI ID
    |--------------------------------------------------------------------------
    */

    $id = (int) $id;

    if ($id <= 0) {
        show_404();
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | LOAD DOMPDF
    |--------------------------------------------------------------------------
    */

    if (!class_exists('\Dompdf\Dompdf')) {

        $composer_autoload =
            FCPATH . 'vendor/autoload.php';

        if (file_exists($composer_autoload)) {
            require_once $composer_autoload;
        }
    }


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
    | DATA KEBUTUHAN
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
    | DETAIL KEBUTUHAN
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
    | DATA BAST PEMERIKSAAN
    |--------------------------------------------------------------------------
    |
    | Sumber:
    | spj_bast_pemeriksaan
    |
    | Tidak menggunakan tabel spj_bast_internal.
    |
    */

    $bast_pemeriksaan =
        $this->Spj_model
            ->get_bast_pemeriksaan_by_kebutuhan($id);

    if (!$bast_pemeriksaan) {

        show_error(
            'BAST Pemeriksaan untuk kebutuhan ini belum ditemukan.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | DATA VIEW
    |--------------------------------------------------------------------------
    */

    $data = array(

        /*
        |----------------------------------------------------------------------
        | DATA DOKUMEN
        |----------------------------------------------------------------------
        */

        'kebutuhan' =>
            $kebutuhan,

        'detail' =>
            $detail,

        'bast_pemeriksaan' =>
            $bast_pemeriksaan,


        /*
        |----------------------------------------------------------------------
        | DATA SEKOLAH
        |----------------------------------------------------------------------
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
        |----------------------------------------------------------------------
        | PEMERIKSA
        |----------------------------------------------------------------------
        */

        'pemeriksa_nama' =>
            'YOSI TAZU SOBIRIN',

        'pemeriksa_jabatan' =>
            'Petugas/Tim Pemeriksa',


        /*
        |----------------------------------------------------------------------
        | PIHAK MENYERAHKAN
        |----------------------------------------------------------------------
        */

        'penyerah_nama' =>
            'Yosi Tazu Sobirin',

        'penyerah_jabatan' =>
            'Petugas/Tim Pemeriksa',

        'penyerah_nip' =>
            'NIP. 199503272025211117',


        /*
        |----------------------------------------------------------------------
        | PIHAK MENERIMA
        |----------------------------------------------------------------------
        */

        'penerima_nama' =>
            'Drs. Rosidin',

        'penerima_jabatan' =>
            'Kepala SMKN 1 Cilimus',

        'penerima_nip' =>
            'NIP. 199503272025211117'
    );


    /*
    |--------------------------------------------------------------------------
    | RENDER VIEW
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
    | NAMA FILE
    |--------------------------------------------------------------------------
    */

    $nomor_surat =
        !empty($kebutuhan->nomor_surat)
            ? $kebutuhan->nomor_surat
            : 'dokumen';

    $nama_file =
        'BAST-Internal-' .
        preg_replace(
            '/[^A-Za-z0-9\-_]/',
            '-',
            $nomor_surat
        ) .
        '.pdf';


    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN PDF
    |--------------------------------------------------------------------------
    */

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

public function download_template_kebutuhan()
{
    /*
    |--------------------------------------------------------------------------
    | LOAD PHP SPREADSHEET
    |--------------------------------------------------------------------------
    */

    require_once FCPATH . 'vendor/autoload.php';

    $spreadsheet =
        new \PhpOffice\PhpSpreadsheet\Spreadsheet();


    /*
    |--------------------------------------------------------------------------
    | SHEET UTAMA
    |--------------------------------------------------------------------------
    */

    $sheet =
        $spreadsheet->getActiveSheet();

    $sheet->setTitle('Sheet1');


    /*
    |--------------------------------------------------------------------------
    | HEADER INPUT
    |--------------------------------------------------------------------------
    */

    $sheet->setCellValue('A2', 'nomor surat');
    $sheet->setCellValue('A3', 'tanggal');
    $sheet->setCellValue('A4', 'perihal');
    $sheet->setCellValue('A5', 'kegiatan');
    $sheet->setCellValue('A6', 'keterangan');
    $sheet->setCellValue('A7', 'Kodering');

    /*
     * FIELD BARU
     */

    $sheet->setCellValue('A8', 'nomor invoice');
    $sheet->setCellValue('A9', 'nomor pesanan');
    $sheet->setCellValue('A10', 'nama CV/penyedia');


    /*
    |--------------------------------------------------------------------------
    | HEADER DETAIL
    |--------------------------------------------------------------------------
    */

    $sheet->setCellValue('A12', 'no');
    $sheet->setCellValue('B12', 'nama barang/jasa');
    $sheet->setCellValue('C12', 'jumlah');
    $sheet->setCellValue('D12', 'satuan');
    $sheet->setCellValue('E12', 'keterangan');


    /*
    |--------------------------------------------------------------------------
    | AMBIL REFERENSI KODERING
    |--------------------------------------------------------------------------
    */

    $kategori =
        $this->Spj_model->get_kategori();


    /*
    |--------------------------------------------------------------------------
    | SHEET REFERENSI
    |--------------------------------------------------------------------------
    */

    $referensi =
        $spreadsheet->createSheet();

    $referensi->setTitle(
        'Referensi_kodering'
    );

    $referensi->setCellValue(
        'A1',
        'Kodering'
    );

    $referensi->setCellValue(
        'B1',
        'Nama Kodering'
    );


    /*
    |--------------------------------------------------------------------------
    | ISI REFERENSI
    |--------------------------------------------------------------------------
    */

    $baris = 2;

    foreach ($kategori as $row) {

        $referensi->setCellValue(
            'A' . $baris,
            $row->kodering
        );

        $referensi->setCellValue(
            'B' . $baris,
            $row->nama_kategori
        );

        $baris++;
    }


    /*
    |--------------------------------------------------------------------------
    | DROPDOWN KODERING
    |--------------------------------------------------------------------------
    */

    if (!empty($kategori)) {

        $jumlah_kategori =
            count($kategori);

        $validation =
            $sheet
                ->getCell('B7')
                ->getDataValidation();

        $validation->setType(
            \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST
        );

        $validation->setErrorStyle(
            \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP
        );

        $validation->setAllowBlank(false);

        $validation->setShowInputMessage(true);

        $validation->setShowErrorMessage(true);

        $validation->setShowDropDown(true);

        $validation->setErrorTitle(
            'Kodering tidak valid'
        );

        $validation->setError(
            'Silakan pilih kodering dari daftar.'
        );

        $validation->setPromptTitle(
            'Pilih Kodering'
        );

        $validation->setPrompt(
            'Pilih nama kodering dari daftar.'
        );

        $validation->setFormula1(
            "'Referensi_kodering'!\$B\$2:\$B\$" .
            ($jumlah_kategori + 1)
        );

        $sheet
            ->getCell('B7')
            ->setDataValidation(
                $validation
            );
    }


    /*
    |--------------------------------------------------------------------------
    | NOMOR URUT DETAIL
    |--------------------------------------------------------------------------
    */

    for ($i = 13; $i <= 112; $i++) {

        $sheet->setCellValue(
            'A' . $i,
            $i - 12
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STYLE HEADER INPUT
    |--------------------------------------------------------------------------
    */

    $sheet
        ->getStyle('A2:A10')
        ->getFont()
        ->setBold(true);


    /*
    |--------------------------------------------------------------------------
    | STYLE HEADER DETAIL
    |--------------------------------------------------------------------------
    */

    $sheet
        ->getStyle('A12:E12')
        ->getFont()
        ->setBold(true);

    $sheet
        ->getStyle('A12:E12')
        ->getAlignment()
        ->setHorizontal(
            \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        );

    $sheet
        ->getStyle('A12:E12')
        ->getFill()
        ->setFillType(
            \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
        )
        ->getStartColor()
        ->setARGB('D9EAF7');


    /*
    |--------------------------------------------------------------------------
    | BORDER DETAIL
    |--------------------------------------------------------------------------
    */

    $sheet
        ->getStyle('A12:E112')
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(
            \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
        );


    /*
    |--------------------------------------------------------------------------
    | BORDER REFERENSI
    |--------------------------------------------------------------------------
    */

    if (!empty($kategori)) {

        $referensi
            ->getStyle(
                'A1:B' .
                ($jumlah_kategori + 1)
            )
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(
                \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
            );

        $referensi
            ->getStyle('A1:B1')
            ->getFont()
            ->setBold(true);
    }


    /*
    |--------------------------------------------------------------------------
    | LEBAR KOLOM SHEET UTAMA
    |--------------------------------------------------------------------------
    */

    $sheet
        ->getColumnDimension('A')
        ->setWidth(22);

    $sheet
        ->getColumnDimension('B')
        ->setWidth(35);

    $sheet
        ->getColumnDimension('C')
        ->setWidth(12);

    $sheet
        ->getColumnDimension('D')
        ->setWidth(15);

    $sheet
        ->getColumnDimension('E')
        ->setWidth(30);


    /*
    |--------------------------------------------------------------------------
    | LEBAR REFERENSI
    |--------------------------------------------------------------------------
    */

    $referensi
        ->getColumnDimension('A')
        ->setWidth(25);

    $referensi
        ->getColumnDimension('B')
        ->setWidth(40);


    /*
    |--------------------------------------------------------------------------
    | FORMAT TANGGAL
    |--------------------------------------------------------------------------
    */

    $sheet
        ->getStyle('B3')
        ->getNumberFormat()
        ->setFormatCode(
            'dd-mm-yyyy'
        );


    /*
    |--------------------------------------------------------------------------
    | FREEZE
    |--------------------------------------------------------------------------
    */

    $sheet->freezePane('A13');

    $referensi->freezePane('A2');


    /*
    |--------------------------------------------------------------------------
    | AKTIFKAN SHEET UTAMA
    |--------------------------------------------------------------------------
    */

    $spreadsheet->setActiveSheetIndex(0);


    /*
    |--------------------------------------------------------------------------
    | NAMA FILE
    |--------------------------------------------------------------------------
    */

    $filename =
        'Template_Input_Kebutuhan_' .
        date('Ymd_His') .
        '.xlsx';


    /*
    |--------------------------------------------------------------------------
    | WRITER
    |--------------------------------------------------------------------------
    */

    $writer =
        new \PhpOffice\PhpSpreadsheet\Writer\Xlsx(
            $spreadsheet
        );


    /*
    |--------------------------------------------------------------------------
    | BERSIHKAN OUTPUT BUFFER
    |--------------------------------------------------------------------------
    */

    while (ob_get_level()) {
        ob_end_clean();
    }


    /*
    |--------------------------------------------------------------------------
    | HEADER DOWNLOAD
    |--------------------------------------------------------------------------
    */

    header(
        'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    );

    header(
        'Content-Disposition: attachment; filename="' .
        $filename .
        '"'
    );

    header(
        'Cache-Control: max-age=0'
    );


    /*
    |--------------------------------------------------------------------------
    | OUTPUT
    |--------------------------------------------------------------------------
    */

    $writer->save(
        'php://output'
    );

    exit;
}
public function import_kebutuhan()
{
    /*
    |--------------------------------------------------------------------------
    | FORM IMPORT
    |--------------------------------------------------------------------------
    */

    if ($this->input->method() !== 'post') {

        $data = array(
            'title' => 'Import Kebutuhan'
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
            'spj/import_kebutuhan',
            $data
        );

        $this->load->view(
            'layouts/footer'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | CEK FILE
    |--------------------------------------------------------------------------
    */

    if (
        empty($_FILES['file_excel']) ||
        empty($_FILES['file_excel']['name'])
    ) {

        $this->session->set_flashdata(
            'error',
            'Silakan pilih file Excel terlebih dahulu.'
        );

        redirect(
            'spj/import_kebutuhan'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | FOLDER TEMPORARY
    |--------------------------------------------------------------------------
    */

    $upload_path =
        FCPATH . 'uploads/import_spj/';

    if (!is_dir($upload_path)) {

        mkdir(
            $upload_path,
            0755,
            true
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CONFIG UPLOAD
    |--------------------------------------------------------------------------
    */

    $config = array(
        'upload_path'   => $upload_path,
        'allowed_types' => 'xlsx|xls',
        'max_size'      => 10240,
        'encrypt_name'  => true
    );

    $this->load->library(
        'upload',
        $config
    );


    /*
    |--------------------------------------------------------------------------
    | UPLOAD
    |--------------------------------------------------------------------------
    */

    if (
        !$this->upload->do_upload(
            'file_excel'
        )
    ) {

        $error = strip_tags(
            $this->upload->display_errors(
                '',
                ''
            )
        );

        $this->session->set_flashdata(
            'error',
            'File Excel gagal diupload: ' .
            $error
        );

        redirect(
            'spj/import_kebutuhan'
        );

        return;
    }


    $upload =
        $this->upload->data();

    $file_path =
        $upload['full_path'];


    /*
    |--------------------------------------------------------------------------
    | PHP SPREADSHEET
    |--------------------------------------------------------------------------
    */

    require_once FCPATH . 'vendor/autoload.php';


    /*
    |--------------------------------------------------------------------------
    | BACA FILE
    |--------------------------------------------------------------------------
    */

    try {

        $spreadsheet =
            \PhpOffice\PhpSpreadsheet\IOFactory::load(
                $file_path
            );

    } catch (\Throwable $e) {

        @unlink($file_path);

        $this->session->set_flashdata(
            'error',
            'File Excel tidak dapat dibaca.'
        );

        redirect(
            'spj/import_kebutuhan'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | SHEET UTAMA
    |--------------------------------------------------------------------------
    */

    $sheet =
        $spreadsheet->getSheet(0);


    /*
    |--------------------------------------------------------------------------
    | HEADER
    |--------------------------------------------------------------------------
    */

    $nomor_surat =
        trim(
            (string)
            $sheet
                ->getCell('B2')
                ->getFormattedValue()
        );


    $tanggal_raw =
        $sheet
            ->getCell('B3')
            ->getValue();


    $perihal =
        trim(
            (string)
            $sheet
                ->getCell('B4')
                ->getFormattedValue()
        );


    $kegiatan =
        trim(
            (string)
            $sheet
                ->getCell('B5')
                ->getFormattedValue()
        );


    $keterangan =
        trim(
            (string)
            $sheet
                ->getCell('B6')
                ->getFormattedValue()
        );


    $nama_kodering =
        trim(
            (string)
            $sheet
                ->getCell('B7')
                ->getFormattedValue()
        );


    /*
    |--------------------------------------------------------------------------
    | FIELD BARU
    |--------------------------------------------------------------------------
    */

    $nomor_invoice =
        trim(
            (string)
            $sheet
                ->getCell('B8')
                ->getFormattedValue()
        );


    $nomor_pesanan =
        trim(
            (string)
            $sheet
                ->getCell('B9')
                ->getFormattedValue()
        );


    $nama_penyedia =
        trim(
            (string)
            $sheet
                ->getCell('B10')
                ->getFormattedValue()
        );


    /*
    |--------------------------------------------------------------------------
    | VALIDASI HEADER
    |--------------------------------------------------------------------------
    */

    $errors = array();


    if ($nomor_surat === '') {

        $errors[] =
            'Nomor surat belum diisi.';
    }


    if ($perihal === '') {

        $errors[] =
            'Perihal belum diisi.';
    }


    if ($nama_kodering === '') {

        $errors[] =
            'Kodering belum dipilih.';
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALISASI TANGGAL
    |--------------------------------------------------------------------------
    */

    $tanggal =
        $this->_normalisasi_tanggal_excel(
            $tanggal_raw
        );


    if (!$tanggal) {

        $errors[] =
            'Tanggal tidak valid. Gunakan format tanggal yang benar.';
    }


    /*
    |--------------------------------------------------------------------------
    | CARI KODERING
    |--------------------------------------------------------------------------
    */

    $kategori =
        $this->Spj_model->get_kategori();


    $kategori_ditemukan = null;


    foreach ($kategori as $row) {

        if (
            strtolower(
                trim($row->nama_kategori)
            )
            ===
            strtolower(
                trim($nama_kodering)
            )
        ) {

            $kategori_ditemukan =
                $row;

            break;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDASI KODERING
    |--------------------------------------------------------------------------
    */

    if (!$kategori_ditemukan) {

        $errors[] =
            'Kodering "' .
            $nama_kodering .
            '" tidak ditemukan di database.';
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL BARANG
    |--------------------------------------------------------------------------
    */

    $details = array();


    /*
    |--------------------------------------------------------------------------
    | BARIS DETAIL
    |--------------------------------------------------------------------------
    |
    | Template baru:
    |
    | Row 12 = header detail
    | Row 13 = data pertama
    | Row 112 = data terakhir
    |
    */

    $highest_row =
        $sheet->getHighestDataRow();


    if ($highest_row < 13) {

        $highest_row = 12;
    }


    /*
    |--------------------------------------------------------------------------
    | BACA DETAIL
    |--------------------------------------------------------------------------
    */

    for (
        $baris = 13;
        $baris <= $highest_row;
        $baris++
    ) {

        /*
        |--------------------------------------------------------------------------
        | NAMA BARANG
        |--------------------------------------------------------------------------
        */

        $nama_barang =
            trim(
                (string)
                $sheet
                    ->getCell(
                        'B' . $baris
                    )
                    ->getFormattedValue()
            );


        /*
        |--------------------------------------------------------------------------
        | JUMLAH
        |--------------------------------------------------------------------------
        */

        $jumlah_raw =
            $sheet
                ->getCell(
                    'C' . $baris
                )
                ->getValue();


        /*
        |--------------------------------------------------------------------------
        | SATUAN
        |--------------------------------------------------------------------------
        */

        $satuan =
            trim(
                (string)
                $sheet
                    ->getCell(
                        'D' . $baris
                    )
                    ->getFormattedValue()
            );


        /*
        |--------------------------------------------------------------------------
        | KETERANGAN
        |--------------------------------------------------------------------------
        */

        $ket_detail =
            trim(
                (string)
                $sheet
                    ->getCell(
                        'E' . $baris
                    )
                    ->getFormattedValue()
            );


        /*
        |--------------------------------------------------------------------------
        | BARIS KOSONG
        |--------------------------------------------------------------------------
        |
        | Kolom B menjadi indikator utama.
        |
        */

        if ($nama_barang === '') {

            continue;
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI JUMLAH
        |--------------------------------------------------------------------------
        */

        if (
            $jumlah_raw === '' ||
            $jumlah_raw === null ||
            !is_numeric($jumlah_raw) ||
            (float) $jumlah_raw <= 0
        ) {

            $errors[] =
                'Baris ' .
                $baris .
                ': jumlah harus berupa angka lebih dari 0.';

            continue;
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI SATUAN
        |--------------------------------------------------------------------------
        */

        if ($satuan === '') {

            $errors[] =
                'Baris ' .
                $baris .
                ': satuan belum diisi.';

            continue;
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN DETAIL
        |--------------------------------------------------------------------------
        */

        $details[] = array(

            'id_kategori' =>
                $kategori_ditemukan
                    ->id_kategori,

            'kodering' =>
                $kategori_ditemukan
                    ->kodering,

            'nama_barang' =>
                $nama_barang,

            'jumlah' =>
                (float) $jumlah_raw,

            'satuan' =>
                $satuan,

            'keterangan' =>
                $ket_detail !== ''
                    ? $ket_detail
                    : null
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HARUS ADA BARANG
    |--------------------------------------------------------------------------
    */

    if (empty($details)) {

        $errors[] =
            'Tidak ada data barang/jasa yang ditemukan. Silakan isi minimal satu barang.';
    }


    /*
    |--------------------------------------------------------------------------
    | JIKA ERROR
    |--------------------------------------------------------------------------
    */

    if (!empty($errors)) {

        @unlink($file_path);

        $pesan =
            '<strong>Import gagal.</strong><br><ul>';


        foreach ($errors as $error) {

            $pesan .=
                '<li>' .
                html_escape($error) .
                '</li>';
        }


        $pesan .= '</ul>';


        $this->session->set_flashdata(
            'error',
            $pesan
        );

        redirect(
            'spj/import_kebutuhan'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | HEADER DATABASE
    |--------------------------------------------------------------------------
    */

    $header = array(

        'nomor_surat' =>
            $nomor_surat,

        'nomor_invoice' =>
            $nomor_invoice !== ''
                ? $nomor_invoice
                : null,

        'nomor_pesanan' =>
            $nomor_pesanan !== ''
                ? $nomor_pesanan
                : null,

        'nama_penyedia' =>
            $nama_penyedia !== ''
                ? $nama_penyedia
                : null,

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
            $this->session
                ->userdata('id_user')
    );


    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATABASE
    |--------------------------------------------------------------------------
    */

    $id_kebutuhan =
        $this->Spj_model->insert_kebutuhan(
            $header,
            $details
        );


    /*
    |--------------------------------------------------------------------------
    | HAPUS FILE TEMPORARY
    |--------------------------------------------------------------------------
    */

    @unlink($file_path);


    /*
    |--------------------------------------------------------------------------
    | GAGAL SIMPAN
    |--------------------------------------------------------------------------
    */

    if (!$id_kebutuhan) {

        $this->session->set_flashdata(
            'error',
            'Gagal menyimpan data hasil import ke database.'
        );

        redirect(
            'spj/import_kebutuhan'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | BERHASIL
    |--------------------------------------------------------------------------
    */

    $this->session->set_flashdata(
        'success',
        'Import berhasil. ' .
        count($details) .
        ' item kebutuhan berhasil disimpan.'
    );


    redirect(
        'spj/input_kebutuhan'
    );
}


private function _normalisasi_tanggal_excel($value)
{
    /*
    |--------------------------------------------------------------------------
    | NILAI KOSONG
    |--------------------------------------------------------------------------
    */

    if (
        $value === null ||
        $value === ''
    ) {

        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | EXCEL SERIAL DATE
    |--------------------------------------------------------------------------
    */

    if (
        is_numeric($value) &&
        (float) $value > 0
    ) {

        try {

            $date =
                \PhpOffice\PhpSpreadsheet\Shared\Date
                    ::excelToDateTimeObject(
                        $value
                    );

            return $date->format(
                'Y-m-d'
            );

        } catch (\Throwable $e) {

            return false;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | STRING DATE
    |--------------------------------------------------------------------------
    */

    $value =
        trim(
            (string) $value
        );


    /*
    |--------------------------------------------------------------------------
    | FORMAT YANG DIDUKUNG
    |--------------------------------------------------------------------------
    */

    $format_list = array(
        'Y-m-d',
        'd-m-Y',
        'd/m/Y',
        'm/d/Y',
        'Y/m/d'
    );


    /*
    |--------------------------------------------------------------------------
    | CEK FORMAT
    |--------------------------------------------------------------------------
    */

    foreach ($format_list as $format) {

        $date =
            DateTime::createFromFormat(
                $format,
                $value
            );


        if (
            $date &&
            $date->format($format) === $value
        ) {

            return $date->format(
                'Y-m-d'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | TIDAK VALID
    |--------------------------------------------------------------------------
    */

    return false;
}
public function detail_bast_internal($id)
{
    $this->load->model('Spj_model');

    $kebutuhan = $this->Spj_model->get_kebutuhan($id);

    if (!$kebutuhan) {

        $this->session->set_flashdata(
            'error',
            'Data kebutuhan tidak ditemukan.'
        );

        redirect('spj/bast_internal');

        return;
    }


    $detail = $this->Spj_model->get_detail($id);


    $data = array(
        'title'     => 'Detail BAST Internal',
        'kebutuhan' => $kebutuhan,
        'detail'    => $detail
    );


    $this->load->view('layouts/header', $data);
    $this->load->view('layouts/sidebar', $data);
    $this->load->view('layouts/topbar', $data);
    $this->load->view('spj/bast_internal/detail', $data);
    $this->load->view('layouts/footer', $data);
}
public function bast_pemeriksaan()
{
    $data['title'] =
        'BAST Pemeriksaan';

    $data['bast'] =
        $this->Spj_model
            ->get_all_bast_pemeriksaan();


    $data['kebutuhan'] =
        $this->Spj_model
            ->get_all_kebutuhan();


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
        'spj/bast_pemeriksaan/index',
        $data
    );

    $this->load->view(
        'layouts/footer'
    );
}
public function tambah_bast_pemeriksaan($id_kebutuhan)
{
    $id_kebutuhan =
        (int) $id_kebutuhan;


    if ($id_kebutuhan <= 0) {

        show_404();

        return;
    }


    $kebutuhan =
        $this->Spj_model
            ->get_kebutuhan(
                $id_kebutuhan
            );


    if (!$kebutuhan) {

        show_404();

        return;
    }


    /*
     * CEK APAKAH SUDAH ADA BAST
     */

    $existing =
        $this->Spj_model
            ->get_bast_pemeriksaan_by_kebutuhan(
                $id_kebutuhan
            );


    if ($existing) {

        redirect(
            'spj/edit_bast_pemeriksaan/' .
            $existing->id_bast_pemeriksaan
        );

        return;
    }


    /*
     * DETAIL KEBUTUHAN
     */

    $detail =
        $this->Spj_model
            ->get_detail(
                $id_kebutuhan
            );


    if (empty($detail)) {

        $this->session->set_flashdata(
            'error',
            'Rincian kebutuhan belum tersedia.'
        );

        redirect(
            'spj/bast_pemeriksaan'
        );

        return;
    }


    /*
     * SIMPAN
     */

    if (
        $this->input->method() === 'post'
    ) {

        $nomor_bast =
            trim(
                (string)
                $this->input->post(
                    'nomor_bast',
                    true
                )
            );


        $nomor_keputusan =
            trim(
                (string)
                $this->input->post(
                    'nomor_keputusan',
                    true
                )
            );


        if (
            $nomor_bast === '' ||
            $nomor_keputusan === ''
        ) {

            $this->session->set_flashdata(
                'error',
                'Nomor BAST dan Nomor Keputusan wajib diisi.'
            );

            redirect(
                'spj/tambah_bast_pemeriksaan/' .
                $id_kebutuhan
            );

            return;
        }


        /*
         * HEADER
         *
         * Tanggal pemeriksaan otomatis
         * mengikuti tanggal kebutuhan.
         */

        $header = array(

            'id_kebutuhan' =>
                $id_kebutuhan,

            'nomor_bast' =>
                $nomor_bast,

            'nomor_keputusan' =>
                $nomor_keputusan,

            'tanggal_pemeriksaan' =>
                $kebutuhan->tanggal,

            'created_by' =>
                $this->session
                    ->userdata('id_user')

        );


        /*
         * SNAPSHOT DETAIL KEBUTUHAN
         */

        $details = array();


        foreach ($detail as $row) {

            $details[] = array(

                'id_kategori' =>
                    $row->id_kategori,

                'kodering' =>
                    $row->kodering,

                'nama_barang' =>
                    $row->nama_barang,

                'jumlah' =>
                    $row->jumlah,

                'satuan' =>
                    $row->satuan,

                'keterangan' =>
                    !empty($row->keterangan)
                        ? $row->keterangan
                        : null

            );
        }


        $id =
            $this->Spj_model
                ->insert_bast_pemeriksaan(
                    $header,
                    $details
                );


        if ($id) {

            $this->session->set_flashdata(
                'success',
                'BAST Pemeriksaan berhasil dibuat.'
            );

            redirect(
                'spj/bast_pemeriksaan'
            );

            return;
        }


        $this->session->set_flashdata(
            'error',
            'Gagal menyimpan BAST Pemeriksaan.'
        );


        redirect(
            'spj/tambah_bast_pemeriksaan/' .
            $id_kebutuhan
        );
    }


    $data = array(

        'title' =>
            'Tambah BAST Pemeriksaan',

        'kebutuhan' =>
            $kebutuhan,

        'detail' =>
            $detail

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
        'spj/bast_pemeriksaan/form',
        $data
    );

    $this->load->view(
        'layouts/footer'
    );
}
public function edit_bast_pemeriksaan($id)
{
    $id = (int) $id;


    if ($id <= 0) {

        show_404();

        return;
    }


    $bast =
        $this->Spj_model
            ->get_bast_pemeriksaan(
                $id
            );


    if (!$bast) {

        show_404();

        return;
    }


    if (
        $this->input->method() === 'post'
    ) {

        $nomor_bast =
            trim(
                (string)
                $this->input->post(
                    'nomor_bast',
                    true
                )
            );


        $nomor_keputusan =
            trim(
                (string)
                $this->input->post(
                    'nomor_keputusan',
                    true
                )
            );


        if (
            $nomor_bast === '' ||
            $nomor_keputusan === ''
        ) {

            $this->session->set_flashdata(
                'error',
                'Nomor BAST dan Nomor Keputusan wajib diisi.'
            );

            redirect(
                'spj/edit_bast_pemeriksaan/' .
                $id
            );

            return;
        }


        /*
         * Tanggal pemeriksaan tetap
         * berasal dari tanggal kebutuhan.
         */

        $header = array(

            'nomor_bast' =>
                $nomor_bast,

            'nomor_keputusan' =>
                $nomor_keputusan,

            'tanggal_pemeriksaan' =>
                $bast->tanggal_kebutuhan

        );


        $detail =
            $this->Spj_model
                ->get_bast_pemeriksaan_detail(
                    $id
                );


        $details = array();


        foreach ($detail as $row) {

            $details[] = array(

                'id_kategori' =>
                    $row->id_kategori,

                'kodering' =>
                    $row->kodering,

                'nama_barang' =>
                    $row->nama_barang,

                'jumlah' =>
                    $row->jumlah,

                'satuan' =>
                    $row->satuan,

                'keterangan' =>
                    $row->keterangan

            );
        }


        $hasil =
            $this->Spj_model
                ->update_bast_pemeriksaan(
                    $id,
                    $header,
                    $details
                );


        if ($hasil) {

            $this->session->set_flashdata(
                'success',
                'BAST Pemeriksaan berhasil diperbarui.'
            );

            redirect(
                'spj/bast_pemeriksaan'
            );

            return;
        }


        $this->session->set_flashdata(
            'error',
            'Gagal memperbarui BAST Pemeriksaan.'
        );


        redirect(
            'spj/edit_bast_pemeriksaan/' .
            $id
        );

        return;
    }


    $data = array(

        'title' =>
            'Edit BAST Pemeriksaan',

        'bast' =>
            $bast,

        'detail' =>
            $this->Spj_model
                ->get_bast_pemeriksaan_detail(
                    $id
                )

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
        'spj/bast_pemeriksaan/edit',
        $data
    );

    $this->load->view(
        'layouts/footer'
    );
}
public function hapus_bast_pemeriksaan($id)
{
    $id = (int) $id;


    if ($id <= 0) {

        show_404();

        return;
    }


    $bast =
        $this->Spj_model
            ->get_bast_pemeriksaan(
                $id
            );


    if (!$bast) {

        show_404();

        return;
    }


    $hasil =
        $this->Spj_model
            ->delete_bast_pemeriksaan(
                $id
            );


    if ($hasil) {

        $this->session->set_flashdata(
            'success',
            'BAST Pemeriksaan berhasil dihapus.'
        );

    } else {

        $this->session->set_flashdata(
            'error',
            'BAST Pemeriksaan gagal dihapus.'
        );
    }


    redirect(
        'spj/bast_pemeriksaan'
    );
}
public function cetak_bast_pemeriksaan($id)
{
    /*
    |--------------------------------------------------------------------------
    | VALIDASI ID
    |--------------------------------------------------------------------------
    */

    $id = (int) $id;

    if ($id <= 0) {
        show_404();
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | LOAD DOMPDF
    |--------------------------------------------------------------------------
    */

    if (!class_exists('\Dompdf\Dompdf')) {

        $dompdf_autoload =
            APPPATH . 'third_party/dompdf/autoload.inc.php';

        if (file_exists($dompdf_autoload)) {
            require_once $dompdf_autoload;
        }
    }

    if (!class_exists('\Dompdf\Dompdf')) {

        show_error(
            'Dompdf belum tersedia.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | AMBIL DATA BAST
    |--------------------------------------------------------------------------
    */

    $bast =
        $this->Spj_model
            ->get_bast_pemeriksaan($id);

    if (!$bast) {
        show_404();
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | AMBIL DETAIL
    |--------------------------------------------------------------------------
    */

    $detail =
        $this->Spj_model
            ->get_bast_pemeriksaan_detail($id);

    if (empty($detail)) {

        show_error(
            'Rincian BAST Pemeriksaan tidak ditemukan.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | TANGGAL PEMERIKSAAN
    |--------------------------------------------------------------------------
    */

    $tanggal_pemeriksaan =
        !empty($bast->tanggal_pemeriksaan)
            ? $bast->tanggal_pemeriksaan
            : date('Y-m-d');


    $timestamp =
        strtotime($tanggal_pemeriksaan);

    if ($timestamp === false) {
        $timestamp = time();
    }


    /*
    |--------------------------------------------------------------------------
    | NAMA HARI
    |--------------------------------------------------------------------------
    */

    $hari = array(
        'Sunday'    => 'Minggu',
        'Monday'    => 'Senin',
        'Tuesday'   => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday'  => 'Kamis',
        'Friday'    => 'Jumat',
        'Saturday'  => 'Sabtu'
    );


    $nama_hari =
        isset(
            $hari[
                date('l', $timestamp)
            ]
        )
            ? $hari[
                date('l', $timestamp)
            ]
            : '';


    /*
    |--------------------------------------------------------------------------
    | NAMA BULAN
    |--------------------------------------------------------------------------
    */

    $bulan = array(
        1  => 'Januari',
        2  => 'Februari',
        3  => 'Maret',
        4  => 'April',
        5  => 'Mei',
        6  => 'Juni',
        7  => 'Juli',
        8  => 'Agustus',
        9  => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    );


    $nomor_hari =
        (int) date(
            'j',
            $timestamp
        );


    $nomor_bulan =
        (int) date(
            'n',
            $timestamp
        );


    $nama_bulan =
        isset(
            $bulan[$nomor_bulan]
        )
            ? $bulan[$nomor_bulan]
            : '';


    $tahun =
        (int) date(
            'Y',
            $timestamp
        );


    /*
    |--------------------------------------------------------------------------
    | TANGGAL ANGKA
    |--------------------------------------------------------------------------
    |
    | Contoh:
    | 06 Juli 2026
    |
    */

    $tanggal_format =
        date(
            'd',
            $timestamp
        ) .
        ' ' .
        $nama_bulan .
        ' ' .
        $tahun;


    /*
    |--------------------------------------------------------------------------
    | ANGKA TERBILANG
    |--------------------------------------------------------------------------
    */

    $angka = array(
        0  => 'Nol',
        1  => 'Satu',
        2  => 'Dua',
        3  => 'Tiga',
        4  => 'Empat',
        5  => 'Lima',
        6  => 'Enam',
        7  => 'Tujuh',
        8  => 'Delapan',
        9  => 'Sembilan',
        10 => 'Sepuluh',
        11 => 'Sebelas',
        12 => 'Dua Belas',
        13 => 'Tiga Belas',
        14 => 'Empat Belas',
        15 => 'Lima Belas',
        16 => 'Enam Belas',
        17 => 'Tujuh Belas',
        18 => 'Delapan Belas',
        19 => 'Sembilan Belas',
        20 => 'Dua Puluh',
        21 => 'Dua Puluh Satu',
        22 => 'Dua Puluh Dua',
        23 => 'Dua Puluh Tiga',
        24 => 'Dua Puluh Empat',
        25 => 'Dua Puluh Lima',
        26 => 'Dua Puluh Enam',
        27 => 'Dua Puluh Tujuh',
        28 => 'Dua Puluh Delapan',
        29 => 'Dua Puluh Sembilan',
        30 => 'Tiga Puluh',
        31 => 'Tiga Puluh Satu'
    );


    $tanggal_terbilang =
        isset(
            $angka[$nomor_hari]
        )
            ? $angka[$nomor_hari]
            : (string) $nomor_hari;


    /*
    |--------------------------------------------------------------------------
    | TAHUN TERBILANG
    |--------------------------------------------------------------------------
    */

    $tahun_terbilang = '';


    if ($tahun == 2026) {

        $tahun_terbilang =
            'Dua Ribu Dua Puluh Enam';

    } elseif ($tahun == 2025) {

        $tahun_terbilang =
            'Dua Ribu Dua Puluh Lima';

    } elseif ($tahun == 2027) {

        $tahun_terbilang =
            'Dua Ribu Dua Puluh Tujuh';

    } else {

        $tahun_terbilang =
            (string) $tahun;
    }


    /*
    |--------------------------------------------------------------------------
    | LOGO
    |--------------------------------------------------------------------------
    |
    | Lokasi logo:
    | assets/img/logoprovinsi.png
    |
    | Base64 digunakan agar Dompdf dapat menampilkan logo
    | tanpa bergantung pada akses URL.
    |
    */

    $logo_path =
        FCPATH . 'assets/img/logoprovinsi.png';


    $logo_base64 = '';


    if (is_file($logo_path)) {

        $logo_data =
            file_get_contents($logo_path);

        if ($logo_data !== false) {

            $logo_base64 =
                'data:image/png;base64,' .
                base64_encode($logo_data);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | NOMOR KEPUTUSAN
    |--------------------------------------------------------------------------
    |
    | Jika database menyimpan:
    | "No 110/PK.02.01/SMKN1 Clms"
    |
    | maka prefix "No" dibuang agar view cukup menampilkan:
    | "No 110/PK.02.01/SMKN1 Clms"
    |
    */

    $nomor_keputusan =
        !empty($bast->nomor_keputusan)
            ? trim($bast->nomor_keputusan)
            : '';


    $nomor_keputusan =
        preg_replace(
            '/^\s*No\.?\s*/i',
            '',
            $nomor_keputusan
        );


    /*
    |--------------------------------------------------------------------------
    | DATA VIEW
    |--------------------------------------------------------------------------
    */

    $data = array(

        /*
        |----------------------------------------------------------------------
        | DATA BAST
        |----------------------------------------------------------------------
        */

        'bast' =>
            $bast,

        'detail' =>
            $detail,


        /*
        |----------------------------------------------------------------------
        | SEKOLAH
        |----------------------------------------------------------------------
        */

        'nama_sekolah' =>
            'SMK NEGERI 1 CILIMUS',

        'alamat' =>
            'Jalan Eyang Kuwu Sangkan Cilimus',

        'telepon' =>
            '(0232) 8910145',

        'email' =>
            'smkn_1cilimus@yahoo.com',

        'kabupaten' =>
            'Kabupaten Kuningan 45556',


        /*
        |----------------------------------------------------------------------
        | LOGO
        |----------------------------------------------------------------------
        */

        'logo_base64' =>
            $logo_base64,


        /*
        |----------------------------------------------------------------------
        | PEMERIKSA
        |----------------------------------------------------------------------
        */

        'pemeriksa_nama' =>
            'Yosi Tazu Sobirin',

        'pemeriksa_jabatan' =>
            'Tim/Petugas Pemeriksa Barang Modal/Barang dan Jasa',

        'pemeriksa_nip' =>
            '199503272025211117',


        /*
        |----------------------------------------------------------------------
        | NOMOR KEPUTUSAN
        |----------------------------------------------------------------------
        */

        'nomor_keputusan' =>
            $nomor_keputusan,


        /*
        |----------------------------------------------------------------------
        | TANGGAL
        |----------------------------------------------------------------------
        */

        'nama_hari' =>
            $nama_hari,

        'nomor_hari' =>
            $nomor_hari,

        'tanggal_format' =>
            $tanggal_format,

        'tanggal_terbilang' =>
            $tanggal_terbilang,

        'nama_bulan' =>
            $nama_bulan,

        'tahun' =>
            $tahun,

        'tahun_terbilang' =>
            $tahun_terbilang

    );


    /*
    |--------------------------------------------------------------------------
    | LOAD VIEW
    |--------------------------------------------------------------------------
    */

    $html =
        $this->load->view(
            'spj/cetak_bast_pemeriksaan',
            $data,
            true
        );


    /*
    |--------------------------------------------------------------------------
    | KONFIGURASI DOMPDF
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
    | BUAT DOMPDF
    |--------------------------------------------------------------------------
    */

    $dompdf =
        new \Dompdf\Dompdf(
            $options
        );


    $dompdf->loadHtml(
        $html
    );


    $dompdf->setPaper(
        'A4',
        'portrait'
    );


    $dompdf->render();


    /*
    |--------------------------------------------------------------------------
    | NAMA FILE PDF
    |--------------------------------------------------------------------------
    */

    $nomor_bast =
        !empty($bast->nomor_bast)
            ? trim($bast->nomor_bast)
            : 'tanpa-nomor';


    $nomor_bast =
        preg_replace(
            '/[^A-Za-z0-9\-_]/',
            '-',
            $nomor_bast
        );


    $nama_file =
        'BAST-Pemeriksaan-' .
        $nomor_bast .
        '.pdf';


    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN PDF
    |--------------------------------------------------------------------------
    */

    $dompdf->stream(
        $nama_file,
        array(
            'Attachment' => false
        )
    );
}
}