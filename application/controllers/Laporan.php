<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
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
        1=>'JANUARI',2=>'FEBRUARI',3=>'MARET',4=>'APRIL',
        5=>'MEI',6=>'JUNI',7=>'JULI',8=>'AGUSTUS',
        9=>'SEPTEMBER',10=>'OKTOBER',11=>'NOVEMBER',12=>'DESEMBER'
    ];

    $spreadsheet = new Spreadsheet();

    /* =====================================================
       SHEET 1 : LAPORAN MUTASI
    ===================================================== */
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Laporan Mutasi');

    $row1=1; $row2=2; $row3=3;

    // ===== KOLOM KIRI =====
    $sheet->setCellValueByColumnAndRow(1,$row1,'No');
    $sheet->mergeCellsByColumnAndRow(1,$row1,1,$row3);

    $sheet->setCellValueByColumnAndRow(2,$row1,'Kode Rekening');
    $sheet->mergeCellsByColumnAndRow(2,$row1,2,$row3);

    $sheet->setCellValueByColumnAndRow(3,$row1,'Kode');
    $sheet->mergeCellsByColumnAndRow(3,$row1,3,$row3);

    $sheet->setCellValueByColumnAndRow(4,$row1,'Nama Barang');
    $sheet->mergeCellsByColumnAndRow(4,$row1,4,$row3);

    $sheet->setCellValueByColumnAndRow(5,$row1,'Merk');
    $sheet->mergeCellsByColumnAndRow(5,$row1,5,$row3);

    // MUTASI mulai kolom 6
    $col = 6;

    for ($b=$bulan_awal; $b<=$bulan_akhir; $b++) {

        $sheet->mergeCellsByColumnAndRow($col,$row1,$col+11,$row1);
        $sheet->setCellValueByColumnAndRow($col,$row1,'MUTASI '.$namaBulan[$b].' '.$tahun);

        $sheet->mergeCellsByColumnAndRow($col,$row2,$col+3,$row2);
        $sheet->setCellValueByColumnAndRow($col,$row2,'PENAMBAHAN');

        $sheet->mergeCellsByColumnAndRow($col+4,$row2,$col+7,$row2);
        $sheet->setCellValueByColumnAndRow($col+4,$row2,'PENGURANGAN');

        $sheet->mergeCellsByColumnAndRow($col+8,$row2,$col+11,$row2);
        $sheet->setCellValueByColumnAndRow($col+8,$row2,'SALDO AKHIR');

        $sub = ['Vol','Satuan','Harga Satuan','Jumlah (Rp)'];
        $c = $col;
        for ($i=0;$i<3;$i++) {
            foreach ($sub as $s) {
                $sheet->setCellValueByColumnAndRow($c,$row3,$s);
                $c++;
            }
        }

        $col += 12;
    }

    // STYLE HEADER
    $lastCol = $col-1;
    $sheet->getStyleByColumnAndRow(1,1,$lastCol,3)->applyFromArray([
        'font'=>['bold'=>true],
        'alignment'=>[
            'horizontal'=>Alignment::HORIZONTAL_CENTER,
            'vertical'=>Alignment::VERTICAL_CENTER
        ],
        'fill'=>[
            'fillType'=>Fill::FILL_SOLID,
            'startColor'=>['rgb'=>'FFF200']
        ]
    ]);

    /* ================= DATA ================= */
    $row = 4;
    $no  = 1;

    $barang = $this->db->query("
        SELECT b.id_barang, b.nama_barang, b.merk, kb.kodering
        FROM barang b
        JOIN kategori_barang kb ON kb.id_kategori=b.id_kategori
        ORDER BY kb.kodering, b.nama_barang
    ")->result();

    $data_bulan=[];
    for ($b=$bulan_awal;$b<=$bulan_akhir;$b++){
        $data_bulan[$b]=$this->Laporan_model->mutasi_bulanan($b,$tahun);
    }

    $saldo=[];

    foreach($barang as $brg){
        $sheet->setCellValueByColumnAndRow(1,$row,$no++);
        $sheet->setCellValueByColumnAndRow(2,$row,$brg->kodering);
        $sheet->setCellValueByColumnAndRow(3,$row,'');
        $sheet->setCellValueByColumnAndRow(4,$row,$brg->nama_barang);
        $sheet->setCellValueByColumnAndRow(5,$row,$brg->merk);

        $saldo[$brg->id_barang]=0;
        $col=6;

        for($b=$bulan_awal;$b<=$bulan_akhir;$b++){
            $rdata=null;
            foreach($data_bulan[$b] as $r){
                if($r->id_barang==$brg->id_barang){ $rdata=$r; break; }
            }

            if($rdata){
                $saldo[$brg->id_barang]+=$rdata->masuk_vol-$rdata->keluar_vol;
                $vals=[
                    $rdata->masuk_vol,$rdata->satuan,$rdata->harga,$rdata->masuk_total,
                    $rdata->keluar_vol,$rdata->satuan,$rdata->harga,$rdata->keluar_total,
                    $saldo[$brg->id_barang],$rdata->satuan,$rdata->harga,
                    $saldo[$brg->id_barang]*$rdata->harga
                ];
                foreach($vals as $v){
                    $sheet->setCellValueByColumnAndRow($col++,$row,$v);
                }
            } else {
                for($i=0;$i<12;$i++){
                    $sheet->setCellValueByColumnAndRow($col++,$row,0);
                }
            }
        }
        $row++;
    }

    /* ================= OUTPUT ================= */
    /* =====================================================
   SHEET 2 : DETAIL BARANG MASUK
===================================================== */
$sheet2 = $spreadsheet->createSheet();
$sheet2->setTitle('Detail Barang Masuk');

// Header
$headers = [
    'Tanggal',
    'Nama Barang',
    'Merk',
    'Jumlah',
    'Satuan',
    'No Faktur',
    'No Kwitansi',
    'No BAST',
    'Perolehan'
];

$col = 1;
foreach ($headers as $h) {
    $sheet2->setCellValueByColumnAndRow($col++, 1, $h);
}

// Style header
$sheet2->getStyle('A1:I1')->applyFromArray([
    'font' => ['bold' => true],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
    ]
]);

// Data
$row = 2;
$detail = $this->db->query("
    SELECT 
        bm.tanggal,
        b.nama_barang,
        b.merk,
        bm.jumlah,
        bm.satuan,
        bm.no_faktur,
        bm.no_kwitansi,
        bm.no_bast,
        bm.perolehan
    FROM barang_masuk bm
    JOIN barang b ON b.id_barang = bm.id_barang
    WHERE YEAR(bm.tanggal) = ?
    ORDER BY bm.tanggal ASC
", [$tahun])->result();

foreach ($detail as $d) {
    $sheet2->setCellValueByColumnAndRow(1, $row, date('d-m-Y', strtotime($d->tanggal)));
    $sheet2->setCellValueByColumnAndRow(2, $row, $d->nama_barang);
    $sheet2->setCellValueByColumnAndRow(3, $row, $d->merk);
    $sheet2->setCellValueByColumnAndRow(4, $row, $d->jumlah);
    $sheet2->setCellValueByColumnAndRow(5, $row, $d->satuan);
    $sheet2->setCellValueByColumnAndRow(6, $row, $d->no_faktur);
    $sheet2->setCellValueByColumnAndRow(7, $row, $d->no_kwitansi);
    $sheet2->setCellValueByColumnAndRow(8, $row, $d->no_bast);
    $sheet2->setCellValueByColumnAndRow(9, $row, $d->perolehan);
    $row++;
}

    $writer=new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=laporan-mutasi-$tahun.xlsx");
    $writer->save('php://output');
    exit;
}
public function rekap_kendali()
{
    $tahun = $this->input->get('tahun') ?? date('Y');

    $this->load->model('Rekap_kendali_model');

    $data['title'] = 'Rekap Kendali';
    $data['tahun'] = $tahun;
    $data['rekap'] = $this->Rekap_kendali_model->get_rekap($tahun);

    $this->load->view('layouts/header');
    $this->load->view('layouts/sidebar');
    $this->load->view('layouts/topbar');
    $this->load->view('laporan/rekap_kendali', $data);
    $this->load->view('layouts/footer');
}
public function export_excel()
{
    $tahun = $this->input->get('tahun');
    $rekap = $this->Laporan_model->getRekap($tahun);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    /* =====================================================
       HEADER (2 BARIS)
    ===================================================== */
    $row1 = 1;
    $row2 = 2;
    $col  = 1;

    // Kodering
    $sheet->setCellValueByColumnAndRow($col, $row1, 'Kodering');
    $sheet->mergeCellsByColumnAndRow($col, $row1, $col, $row2);
    $col++;

    // Uraian
    $sheet->setCellValueByColumnAndRow($col, $row1, 'Uraian');
    $sheet->mergeCellsByColumnAndRow($col, $row1, $col, $row2);
    $col++;

    // Saldo Awal
    $sheet->setCellValueByColumnAndRow($col, $row1, 'Saldo Awal');
    $sheet->mergeCellsByColumnAndRow($col, $row1, $col, $row2);
    $col++;

    // JANUARI - DESEMBER
    for ($b = 1; $b <= 12; $b++) {

        $sheet->setCellValueByColumnAndRow($col, $row1, strtoupper(bulan_id($b)));
        $sheet->mergeCellsByColumnAndRow($col, $row1, $col + 2, $row1);

        $sheet->setCellValueByColumnAndRow($col,     $row2, 'Masuk');
        $sheet->setCellValueByColumnAndRow($col + 1, $row2, 'Keluar');
        $sheet->setCellValueByColumnAndRow($col + 2, $row2, 'Saldo');

        $col += 3;
    }

    // TOTAL
    $sheet->setCellValueByColumnAndRow($col, $row1, 'TOTAL');
    $sheet->mergeCellsByColumnAndRow($col, $row1, $col + 2, $row1);

    $sheet->setCellValueByColumnAndRow($col,     $row2, 'Masuk');
    $sheet->setCellValueByColumnAndRow($col + 1, $row2, 'Keluar');
    $sheet->setCellValueByColumnAndRow($col + 2, $row2, 'Saldo');

    /* =====================================================
       DATA
    ===================================================== */
    $rowNum = 3;

    foreach ($rekap as $r) {

        $col = 1;

        // Kodering
        $sheet->setCellValueByColumnAndRow($col++, $rowNum, $r['kode']);

        // Uraian
        $sheet->setCellValueByColumnAndRow($col++, $rowNum, $r['uraian']);

        // Saldo Awal
        $sheet->setCellValueByColumnAndRow($col++, $rowNum, $r['saldo_awal']);

        $totalMasuk  = 0;
        $totalKeluar = 0;
        $saldoAkhir  = 0;

        for ($b = 1; $b <= 12; $b++) {

            $masuk  = $r['bulan'][$b]['masuk'] ?? 0;
            $keluar = $r['bulan'][$b]['keluar'] ?? 0;
            $saldo  = $r['bulan'][$b]['saldo'] ?? 0;

            $totalMasuk  += $masuk;
            $totalKeluar += $keluar;
            $saldoAkhir   = $saldo;

            $sheet->setCellValueByColumnAndRow($col++, $rowNum, $masuk);
            $sheet->setCellValueByColumnAndRow($col++, $rowNum, $keluar);
            $sheet->setCellValueByColumnAndRow($col++, $rowNum, $saldo);
        }

        // TOTAL
        $sheet->setCellValueByColumnAndRow($col++, $rowNum, $totalMasuk);
        $sheet->setCellValueByColumnAndRow($col++, $rowNum, $totalKeluar);
        $sheet->setCellValueByColumnAndRow($col++, $rowNum, $saldoAkhir);

        $rowNum++;
    }

    /* =====================================================
       OUTPUT
    ===================================================== */
    $writer = new Xlsx($spreadsheet);
    $filename = "rekap-$tahun.xlsx";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $writer->save('php://output');
    exit;
}

}
