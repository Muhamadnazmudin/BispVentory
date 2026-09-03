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
}