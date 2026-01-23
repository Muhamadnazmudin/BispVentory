<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_model');
        $this->load->library('pdf'); // untuk export PDF
    }

    /* ===============================
       LAPORAN BARANG MASUK
    =============================== */
    public function masuk()
    {
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');

        $data['title'] = 'Laporan Barang Masuk';
        $data['list']  = $this->Laporan_model->barang_masuk($bulan, $tahun);

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('laporan/barang_masuk',$data);
        $this->load->view('layouts/footer');
    }

    /* ===============================
       EXPORT PDF BARANG MASUK
    =============================== */
    public function barang_masuk_pdf()
{
    $bulan = $this->input->get('bulan');
    $tahun = $this->input->get('tahun');

    $data['list'] = $this->Laporan_model->barang_masuk($bulan, $tahun);

    // PREVIEW PDF
    $this->pdf->load_view(
        'laporan/barang_masuk_pdf',
        $data,
        'A4',
        'landscape',
        true, // preview
        'laporan-barang-masuk.pdf'
    );
}

public function barang_masuk_excel()
{
    $bulan = $this->input->get('bulan');
    $tahun = $this->input->get('tahun');

    $list = $this->Laporan_model->barang_masuk($bulan, $tahun);

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=laporan-barang-masuk.xls");

    echo '
    <html>
    <head>
        <style>
            body { font-family: Arial; }
            .title {
                font-size:16px;
                font-weight:bold;
                text-align:center;
            }
            table {
                border-collapse: collapse;
                width:100%;
            }
            th {
                background:#d9d9d9;
                font-weight:bold;
                text-align:center;
                border:1px solid #000;
                padding:6px;
            }
            td {
                border:1px solid #000;
                padding:6px;
            }
            .text-center { text-align:center; }
        </style>
    </head>
    <body>

    <div class="title">LAPORAN BARANG MASUK</div>
    <br>

    <table>
        <tr>
            <th width="5%">No</th>
            <th width="12%">Tanggal</th>
            <th>Nama Barang</th>
            <th>Merk</th>
            <th width="8%">Jumlah</th>
            <th>Perolehan</th>
            <th>Toko</th>
        </tr>';

    $no = 1;
    foreach ($list as $r) {
        echo '
        <tr>
            <td class="text-center">'.$no++.'</td>
            <td>'.date('d-m-Y', strtotime($r->tanggal)).'</td>
            <td>'.$r->nama_barang.'</td>
            <td>'.$r->merk.'</td>
            <td class="text-center">'.$r->jumlah.'</td>
            <td>'.$r->perolehan.'</td>
            <td>'.$r->toko.'</td>
        </tr>';
    }

    echo '
    </table>
    </body>
    </html>';
}


    /* ===============================
   LAPORAN BARANG KELUAR
=============================== */
public function keluar()
{
    $bulan = $this->input->get('bulan');
    $tahun = $this->input->get('tahun');

    $data['title'] = 'Laporan Barang Keluar';
    $data['list']  = $this->Laporan_model->barang_keluar($bulan, $tahun);

    $this->load->view('layouts/header');
    $this->load->view('layouts/sidebar');
    $this->load->view('layouts/topbar');
    $this->load->view('laporan/barang_keluar', $data);
    $this->load->view('layouts/footer');
}

/* ===============================
   PREVIEW PDF BARANG KELUAR
=============================== */
public function barang_keluar_pdf()
{
    $bulan = $this->input->get('bulan');
    $tahun = $this->input->get('tahun');

    $data['list'] = $this->Laporan_model->barang_keluar($bulan, $tahun);

    $this->pdf->load_view(
        'laporan/barang_keluar_pdf',
        $data,
        'A4',
        'landscape',
        true, // preview (new tab)
        'laporan-barang-keluar.pdf'
    );
}

/* ===============================
   EXPORT EXCEL BARANG KELUAR (RAPI)
=============================== */
public function barang_keluar_excel()
{
    $bulan = $this->input->get('bulan');
    $tahun = $this->input->get('tahun');

    $list = $this->Laporan_model->barang_keluar($bulan, $tahun);

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=laporan-barang-keluar.xls");

    echo '
    <html>
    <head>
        <style>
            body { font-family: Arial; }
            .title {
                font-size:16px;
                font-weight:bold;
                text-align:center;
            }
            table {
                border-collapse: collapse;
                width:100%;
            }
            th {
                background:#d9d9d9;
                font-weight:bold;
                text-align:center;
                border:1px solid #000;
                padding:6px;
            }
            td {
                border:1px solid #000;
                padding:6px;
            }
            .text-center { text-align:center; }
        </style>
    </head>
    <body>

    <div class="title">LAPORAN BARANG KELUAR</div>
    <br>

    <table>
        <tr>
            <th width="5%">No</th>
            <th width="12%">Tanggal</th>
            <th>Nama Barang</th>
            <th>Merk</th>
            <th width="8%">Jumlah</th>
            <th>Pemohon</th>
            <th>Keterangan</th>
        </tr>';

    $no = 1;
    foreach ($list as $r) {
        echo '
        <tr>
            <td class="text-center">'.$no++.'</td>
            <td>'.date('d-m-Y', strtotime($r->tanggal)).'</td>
            <td>'.$r->nama_barang.'</td>
            <td>'.$r->merk.'</td>
            <td class="text-center">'.$r->jumlah.'</td>
            <td>'.ucfirst($r->pemohon).'</td>
            <td>'.$r->keterangan.'</td>
        </tr>';
    }

    echo '
    </table>
    </body>
    </html>';
}


    /* ===============================
       LAPORAN STOK
    =============================== */
    public function stok()
{
    
    $bulan = $this->input->get('bulan');
    $tahun = $this->input->get('tahun');

    $data['title'] = 'Laporan Sisa Stok';
    $data['list']  = $this->Laporan_model->stok($bulan, $tahun);

    $this->load->view('layouts/header');
    $this->load->view('layouts/sidebar');
    $this->load->view('layouts/topbar');
    $this->load->view('laporan/stok', $data);
    $this->load->view('layouts/footer');
}

/* ===============================
   PDF STOK (PREVIEW)
=============================== */
public function stok_pdf()
{
    $bulan = $this->input->get('bulan');
    $tahun = $this->input->get('tahun');

    $data['list'] = $this->Laporan_model->stok($bulan, $tahun);

    $this->pdf->load_view(
        'laporan/stok_pdf',
        $data,
        'A4',
        'portrait',
        true,
        'laporan-stok.pdf'
    );
}


/* ===============================
   EXCEL STOK (RAPI)
=============================== */
public function stok_excel()
{
    $bulan = $this->input->get('bulan');
    $tahun = $this->input->get('tahun');

    $list = $this->Laporan_model->stok($bulan, $tahun);

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=laporan-stok.xls");

    echo '
    <html>
    <head>
        <style>
            body { font-family: Arial; }
            .title { font-size:16px; font-weight:bold; text-align:center; }
            table { border-collapse: collapse; width:100%; }
            th { background:#d9d9d9; font-weight:bold; border:1px solid #000; padding:6px; text-align:center; }
            td { border:1px solid #000; padding:6px; }
            .text-center { text-align:center; }
        </style>
    </head>
    <body>

    <div class="title">LAPORAN SISA STOK BARANG</div><br>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Merk</th>
            <th>Satuan</th>
            <th>Sisa Stok</th>
        </tr>';

    $no=1;
    foreach ($list as $r) {
        echo '
        <tr>
            <td class="text-center">'.$no++.'</td>
            <td>'.$r->nama_barang.'</td>
            <td>'.$r->merk.'</td>
            <td class="text-center">'.$r->satuan.'</td>
            <td class="text-center">'.$r->stok.'</td>
        </tr>';
    }

    echo '</table></body></html>';
}

    /* ===============================
       KARTU PERSEDIAAN
    =============================== */
    public function buku_besar()
    {
        $data['title']  = 'Kartu Persediaan Barang';
        $data['barang'] = $this->Laporan_model->get_barang();

        $id_barang = $this->input->get('id_barang');
        $awal      = $this->input->get('awal');
        $akhir     = $this->input->get('akhir');

        $data['id_barang'] = $id_barang;
        $data['awal']      = $awal;
        $data['akhir']     = $akhir;

        if ($id_barang && $awal && $akhir) {
            $data['saldo_awal'] = $this->Laporan_model
                ->saldo_awal($id_barang, $awal);

            $data['list'] = $this->Laporan_model
                ->kartu_persediaan($id_barang, $awal, $akhir);
        } else {
            $data['saldo_awal'] = null;
            $data['list']       = [];
        }

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('laporan/kartu_persediaan',$data);
        $this->load->view('layouts/footer');
    }
}
