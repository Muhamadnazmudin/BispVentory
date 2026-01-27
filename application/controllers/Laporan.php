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

    // ===============================
    // PENENTUAN PERIODE & NAMA FILE
    // ===============================
    $namaBulan = [
        1=>'januari',2=>'februari',3=>'maret',4=>'april',
        5=>'mei',6=>'juni',7=>'juli',8=>'agustus',
        9=>'september',10=>'oktober',11=>'november',12=>'desember'
    ];

    $periodeText = 'semua-periode';

    if (!empty($bulan) && !empty($tahun)) {
        $periodeText = $namaBulan[(int)$bulan].'-'.$tahun;
    } elseif (!empty($tahun)) {
        $periodeText = 'tahun-'.$tahun;
    }

    // NAMA FILE FINAL
    $filename = 'laporan-stok-'.$periodeText.'.pdf';

    // kirim juga ke view (opsional, kalau mau ditampilkan di PDF)
    $data['bulan'] = $bulan;
    $data['tahun'] = $tahun;

    // ===============================
    // LOAD PDF
    // ===============================
    $this->pdf->load_view(
        'laporan/stok_pdf',
        $data,
        'A4',
        'portrait',
        true,
        $filename
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

    // ===============================
    // PENENTUAN PERIODE
    // ===============================
    $namaBulan = [
        1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
        5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
        9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
    ];

    $periode = 'SEMUA PERIODE';

    if (!empty($bulan) && !empty($tahun)) {
        $periode = 'Bulan '.$namaBulan[(int)$bulan].' '.$tahun;
    } elseif (!empty($tahun)) {
        $periode = 'Tahun '.$tahun;
    }

    // ===============================
    // HEADER EXCEL
    // ===============================
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=laporan-stok.xls");

    // ===============================
    // OUTPUT HTML EXCEL
    // ===============================
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
            .subtitle {
                font-size:12px;
                text-align:center;
                margin-bottom:10px;
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

        <div class="title">LAPORAN SISA STOK BARANG</div>
        <div class="subtitle">Periode: <b>'.$periode.'</b></div>

        <table>
            <tr>
                <th width="5%">No</th>
                <th>Nama Barang</th>
                <th>Merk</th>
                <th width="10%">Satuan</th>
                <th width="12%">Sisa Stok</th>
            </tr>';

    $no = 1;
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

    echo '
        </table>

    </body>
    </html>';
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
    public function mutasi()
{
    $bulan_awal  = $this->input->get('bulan_awal') ?? 1;
    $bulan_akhir = $this->input->get('bulan_akhir') ?? 12;
    $tahun       = $this->input->get('tahun') ?? date('Y');

    $data['title']       = 'Laporan Mutasi Barang';
    $data['bulan_awal']  = $bulan_awal;
    $data['bulan_akhir'] = $bulan_akhir;
    $data['tahun']       = $tahun;

    // ambil data per bulan
    $data['data_bulan'] = [];

    for ($b = $bulan_awal; $b <= $bulan_akhir; $b++) {
        $data['data_bulan'][$b] = $this->Laporan_model
            ->mutasi_bulanan($b, $tahun);
    }

    $this->load->view('layouts/header');
    $this->load->view('layouts/sidebar');
    $this->load->view('layouts/topbar');
    $this->load->view('laporan/laporan_mutasi', $data);
    $this->load->view('layouts/footer');
}
public function mutasi_pdf()
{
    $bulan_awal  = $this->input->get('bulan_awal') ?? 1;
    $bulan_akhir = $this->input->get('bulan_akhir') ?? 12;
    $tahun       = $this->input->get('tahun') ?? date('Y');

    $data['bulan_awal']  = $bulan_awal;
    $data['bulan_akhir'] = $bulan_akhir;
    $data['tahun']       = $tahun;

    $data['data_bulan'] = [];
    for ($b=$bulan_awal; $b<=$bulan_akhir; $b++) {
        $data['data_bulan'][$b] = $this->Laporan_model->mutasi_bulanan($b, $tahun);
    }

    $this->pdf->load_view(
        'laporan/laporan_mutasi_pdf',
        $data,
        'A4',
        'landscape',
        true,
        'laporan-mutasi.pdf'
    );
}

public function mutasi_excel()
{
    $bulan_awal  = $this->input->get('bulan_awal') ?? 1;
    $bulan_akhir = $this->input->get('bulan_akhir') ?? 12;
    $tahun       = $this->input->get('tahun') ?? date('Y');

    $namaBulan = [
        1=>'JAN',2=>'FEB',3=>'MAR',4=>'APR',
        5=>'MEI',6=>'JUN',7=>'JUL',8=>'AGU',
        9=>'SEP',10=>'OKT',11=>'NOV',12=>'DES'
    ];

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=laporan-mutasi.xls");

    echo '<table border="1">';

    /* ================= HEADER 1 ================= */
    echo '<tr>
        <th rowspan="2">No</th>
        <th rowspan="2">Kode Rekening</th>
        <th rowspan="2">Nama Barang</th>
        <th rowspan="2">Merk</th>
        <th rowspan="2">No Faktur</th>
        <th rowspan="2">No Kwitansi</th>
        <th rowspan="2">No BAST</th>';

    for ($b=$bulan_awal; $b<=$bulan_akhir; $b++) {
        echo '<th colspan="12">MUTASI '.$namaBulan[$b].' '.$tahun.'</th>';
    }
    echo '</tr>';

    /* ================= HEADER 2 ================= */
    echo '<tr>';
    for ($b=$bulan_awal; $b<=$bulan_akhir; $b++) {
        echo '
            <th colspan="4">Masuk</th>
            <th colspan="4">Keluar</th>
            <th colspan="4">Saldo</th>';
    }
    echo '</tr>';

    /* ================= HEADER 3 ================= */
    echo '<tr>
        <th></th><th></th><th></th><th></th>
        <th></th><th></th><th></th>';

    for ($b=$bulan_awal; $b<=$bulan_akhir; $b++) {
        for ($i=0;$i<3;$i++) {
            echo '<th>Vol</th><th>Satuan</th><th>Harga</th><th>Jumlah</th>';
        }
    }
    echo '</tr>';

    /* ================= DATA ================= */
    $barang = $this->db->get('barang')->result();
    $no = 1;

    foreach ($barang as $brg) {

        // ambil dokumen (sekali saja per barang)
        $doc = $this->db->select('no_faktur, no_kwitansi, no_bast')
                        ->from('barang_masuk')
                        ->where('id_barang', $brg->id_barang)
                        ->where('YEAR(tanggal)', $tahun)
                        ->order_by('tanggal','ASC')
                        ->limit(1)
                        ->get()
                        ->row();

        echo '<tr>';
        echo '<td>'.$no++.'</td>';
        echo '<td>'.$brg->kode_barang.'</td>';
        echo '<td>'.$brg->nama_barang.'</td>';
        echo '<td>'.$brg->merk.'</td>';
        echo '<td>'.($doc->no_faktur ?? '-').'</td>';
        echo '<td>'.($doc->no_kwitansi ?? '-').'</td>';
        echo '<td>'.($doc->no_bast ?? '-').'</td>';

        for ($b=$bulan_awal; $b<=$bulan_akhir; $b++) {

            $list = $this->Laporan_model->mutasi_bulanan($b, $tahun);
            $row  = null;

            foreach ($list as $r) {
                if ($r->nama_barang == $brg->nama_barang) {
                    $row = $r;
                    break;
                }
            }

            if ($row) {
                $saldo_vol   = $row->masuk_vol - $row->keluar_vol;
                $saldo_total = $saldo_vol * $row->harga;

                echo '
                <td>'.$row->masuk_vol.'</td>
                <td>'.$row->satuan.'</td>
                <td>'.$row->harga.'</td>
                <td>'.$row->masuk_total.'</td>

                <td>'.$row->keluar_vol.'</td>
                <td>'.$row->satuan.'</td>
                <td>'.$row->harga.'</td>
                <td>'.$row->keluar_total.'</td>

                <td>'.$saldo_vol.'</td>
                <td>'.$row->satuan.'</td>
                <td>'.$row->harga.'</td>
                <td>'.$saldo_total.'</td>';
            } else {
                echo str_repeat('<td>0</td>', 12);
            }
        }

        echo '</tr>';
    }

    echo '</table>';
}

}
