<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Sisa Stok</title>
    <style>
        body { font-family: Arial; font-size: 12px; }
        .kop { text-align: center; }
        .kop h2, .kop h3 { margin: 0; }
        .kop p { margin: 2px 0; font-size: 11px; }
        .line { border-bottom: 3px solid #000; margin: 8px 0 2px; }
        .line2 { border-bottom: 1px solid #000; margin-bottom: 15px; }

        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #f2f2f2; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

<div class="kop">
    <h2>PEMERINTAH KABUPATEN XXXXX</h2>
    <h3>SEKOLAH MENENGAH XXXXX</h3>
    <p>Jl. Pendidikan No. 123 Telp. (021) 123456</p>
</div>
<div class="line"></div>
<div class="line2"></div>
<?php
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
?>

<h3 class="text-center">LAPORAN SISA STOK BARANG</h3>
<p class="text-center" style="margin-top:-5px; font-size:12px;">
    Periode: <b><?= $periode ?></b>
</p>


<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>Nama Barang</th>
            <th>Merk</th>
            <th width="10%">Satuan</th>
            <th width="10%">Sisa Stok</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach($list as $r): ?>
        <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= $r->nama_barang ?></td>
            <td><?= $r->merk ?></td>
            <td class="text-center"><?= $r->satuan ?></td>
            <td class="text-center"><b><?= $r->stok ?></b></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
