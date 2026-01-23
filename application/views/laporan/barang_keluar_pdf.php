<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Barang Keluar</title>
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
    <h2>PEMERINTAH PROVINSI JAWA BARAT</h2>
    <h3>CABANG DINAS PENDIDIKAN WILAYAH X</h3>
    <h3>SMK Negeri 1 Cilimus</h3>
    <p>Jl. Eyang kyai Hasan Maulani, Caracas-Cilimus Telp. (021) 123456</p>
</div>
<div class="line"></div>
<div class="line2"></div>

<h3 class="text-center">LAPORAN BARANG KELUAR</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Barang</th>
            <th>Merk</th>
            <th>Jumlah</th>
            <th>Pemohon</th>
            <th>Keterangan</th>
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
            <td><?= ucfirst($r->pemohon) ?></td>
            <td><?= $r->keterangan ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
