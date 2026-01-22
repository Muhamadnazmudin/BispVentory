<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Permohonan Barang</title>

<style>
body {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    line-height: 1.4;
}
.header {
    text-align: center;
}
.header h3 {
    margin: 0;
    font-size: 14px;
}
.header p {
    margin: 2px 0;
    font-size: 11px;
}
hr {
    border: 1px solid #000;
    margin: 10px 0;
}
table {
    width: 100%;
    border-collapse: collapse;
}
table th, table td {
    border: 1px solid #000;
    padding: 5px;
}
.no-border td {
    border: none;
}
.text-center {
    text-align: center;
}
.text-right {
    text-align: right;
}
.ttd {
    margin-top: 40px;
}
</style>

</head>
<body>

<!-- KOP SURAT -->
<div class="header">
    <h3>PEMERINTAH KABUPATEN / KOTA XXXXX</h3>
    <h3>DINAS PENDIDIKAN</h3>
    <h3>NAMA SEKOLAH</h3>
    <p>Alamat Sekolah – Telp. (0000) 000000</p>
</div>

<hr>

<!-- INFO SURAT -->
<table class="no-border">
<tr>
    <td width="70%">
        Nomor : ____________<br>
        Lampiran : -<br>
        Perihal : <b>Permohonan Barang</b>
    </td>
    <td width="30%" class="text-right">
        <?= date('d F Y', strtotime($permohonan->tanggal)) ?>
    </td>
</tr>
</table>

<br>

<p>
Dengan hormat,<br><br>
Yang bertanda tangan di bawah ini mengajukan permohonan barang dengan rincian sebagai berikut:
</p>

<!-- DATA PEMOHON -->
<table class="no-border">
<tr>
    <td width="25%">Nama Pemohon</td>
    <td width="5%">:</td>
    <td>
        <?php if($permohonan->pemohon == 'guru'): ?>
            <?= $permohonan->nama_guru ?>
        <?php elseif($permohonan->pemohon == 'siswa'): ?>
            <?= $permohonan->nama_siswa ?>
        <?php else: ?>
            -
        <?php endif; ?>
    </td>
</tr>
</table>

<br>

<!-- TABEL BARANG -->
<table>
<thead>
<tr>
    <th width="5%">No</th>
    <th>Nama Barang</th>
    <th>Merk</th>
    <th width="15%">Jumlah</th>
    <th width="15%">Satuan</th>
</tr>
</thead>
<tbody>

<?php if(!empty($detail)): ?>
<?php $no=1; foreach($detail as $d): ?>
<tr>
    <td class="text-center"><?= $no++ ?></td>
    <td><?= $d->nama_barang ?></td>
    <td><?= $d->merk ?></td>
    <td class="text-right"><?= $d->jumlah ?></td>
    <td class="text-center"><?= $d->satuan ?></td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="5" class="text-center">Tidak ada data barang</td>
</tr>
<?php endif; ?>

</tbody>
</table>

<br>

<p>
Demikian permohonan ini disampaikan.  
Atas perhatian dan persetujuannya kami ucapkan terima kasih.
</p>

<!-- TANDA TANGAN -->
<table class="no-border ttd">
<tr>
    <td width="50%" class="text-center">
        Pemohon<br><br><br><br>
        <b>
        <?php if($permohonan->pemohon == 'guru'): ?>
            <?= $permohonan->nama_guru ?>
        <?php elseif($permohonan->pemohon == 'siswa'): ?>
            <?= $permohonan->nama_siswa ?>
        <?php endif; ?>
        </b>
    </td>
    <td width="50%" class="text-center">
        Mengetahui,<br>
        Admin / Tata Usaha<br><br><br><br>
        <b>______________________</b>
    </td>
</tr>
</table>

</body>
</html>
