<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Barang Masuk</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
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

<!-- KOP SURAT -->
<div class="kop">
    <h2>PEMERINTAH KABUPATEN XXXXX</h2>
    <h3>SEKOLAH MENENGAH XXXXX</h3>
    <p>Alamat : Jl. Pendidikan No. 123 Telp. (021) 123456</p>
</div>
<div class="line"></div>
<div class="line2"></div>

<h3 class="text-center">LAPORAN BARANG MASUK</h3>

<table>
    <thead>
        <tr>
            <th width="4%">No</th>
            <th width="10%">Tanggal</th>
            <th>Nama Barang</th>
            <th>Merk</th>
            <th width="8%">Jumlah</th>
            <th width="8%">Satuan</th>
            <th width="15%">Perolehan</th>
            <th width="15%">Toko</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach($list as $r): ?>
        <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= date('d-m-Y', strtotime($r->tanggal)) ?></td>
            <td><?= $r->nama_barang ?></td>
            <td><?= $r->merk ?></td>
            <td class="text-center"><?= $r->jumlah ?></td>
            <td class="text-center"><?= $r->satuan ?></td>
            <td><?= $r->perolehan ?></td>
            <td><?= $r->toko ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br><br>

<table width="100%" border="0">
<tr>
    <td width="70%"></td>
    <td class="text-center">
        <?= date('d F Y') ?><br>
        Kepala Sekolah<br><br><br><br>
        <b>( ___________________ )</b>
    </td>
</tr>
</table>

</body>
</html>
