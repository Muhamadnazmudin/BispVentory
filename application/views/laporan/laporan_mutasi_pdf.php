<?php
$namaBulan = [
    1=>'JANUARI',2=>'FEBRUARI',3=>'MARET',4=>'APRIL',
    5=>'MEI',6=>'JUNI',7=>'JULI',8=>'AGUSTUS',
    9=>'SEPTEMBER',10=>'OKTOBER',11=>'NOVEMBER',12=>'DESEMBER'
];
?>

<style>
body {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 11px;
}
h3, h4 {
    text-align: center;
    margin: 5px 0;
}
table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 20px;
}
th, td {
    border: 1px solid #000;
    padding: 4px;
}
th {
    background: #eaeaea;
    text-align: center;
}
.text-center { text-align: center; }
.text-right  { text-align: right; }
</style>

<h3>LAPORAN MUTASI BARANG</h3>

<?php foreach ($data_bulan as $bulan => $list): ?>

<h4>MUTASI <?= $namaBulan[$bulan] ?> <?= $tahun ?></h4>

<table>
<thead>
<tr>
    <th width="4%">No</th>
    <th>Nama Barang</th>
    <th width="12%">Merk</th>
    <th width="8%">Satuan</th>
    <th width="10%">Harga</th>
    <th width="8%">Masuk</th>
    <th width="8%">Keluar</th>
    <th width="8%">Saldo</th>
</tr>
</thead>
<tbody>

<?php
$no = 1;
foreach ($list as $r):
    $saldo = $r->masuk_vol - $r->keluar_vol;
?>
<tr>
    <td class="text-center"><?= $no++ ?></td>
    <td><?= $r->nama_barang ?></td>
    <td><?= $r->merk ?></td>
    <td class="text-center"><?= $r->satuan ?></td>
    <td class="text-right"><?= number_format($r->harga,0,',','.') ?></td>
    <td class="text-center"><?= $r->masuk_vol ?></td>
    <td class="text-center"><?= $r->keluar_vol ?></td>
    <td class="text-center"><?= $saldo ?></td>
</tr>
<?php endforeach; ?>

<?php if (empty($list)): ?>
<tr>
    <td colspan="8" class="text-center">Tidak ada transaksi</td>
</tr>
<?php endif; ?>

</tbody>
</table>

<?php endforeach; ?>
