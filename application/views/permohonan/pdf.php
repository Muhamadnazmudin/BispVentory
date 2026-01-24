<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Surat Pengajuan Kebutuhan Barang</title>

<style>
body{
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    line-height: 1.5;
    margin: 30px;
}

/* KOP */
.kop{
    width: 100%;
    margin-left: 30px;
}

.kop td{
    vertical-align: middle;
}
.logo{
    width: 90px;
    text-align: center;
}
.logo-img{
    width: 90px;
}

.kop-text{
    text-align: center;
    padding-right: 90px; /* kompensasi logo kiri */
}
.kop-text h4{
    margin: 0;
    font-size: 13px;
    font-weight: bold;
}
.kop-text p{
    margin-top: 4px;
    font-size: 11px;
    line-height: 1.4;
}


/* GARIS */
.garis-1{
    border-top: 2px solid #000;
    margin-top: 8px;
}
.garis-2{
    border-top: 1px solid #000;
    margin-top: 2px;
}

/* INFO SURAT */
.info{
    margin-top: 15px;
}
.info td{
    vertical-align: top;
}

/* JUDUL */
.judul{
    text-align: center;
    font-weight: bold;
    margin: 20px 0 15px 0;
    text-transform: uppercase;
}

/* PARAGRAF */
.paragraf{
    text-align: justify;
}

/* TABEL BARANG */
.table{
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}
.table th,
.table td{
    border: 1px solid #000;
    padding: 6px;
}
.table th{
    text-align: center;
}

/* TTD */
.ttd{
    width: 100%;
    margin-top: 40px;
}
.ttd td{
    width: 50%;
    vertical-align: top;
}
.center{
    text-align: center;
}
.right{
    text-align: right;
}
.ttd{
    margin-top: 40px;
}
.no-border td{
    border: none;
}
.text-center{
    text-align: center;
}

</style>

</head>
<body>

<!-- KOP SURAT -->
<table class="kop">
<tr>
    <td class="logo">
    <img src="assets/img/logobispar.png" class="logo-img">
</td>

    <td class="kop-text">
        <h4>PEMERINTAH DAERAH PROVINSI JAWA BARAT</h4>
        <h4>DINAS PENDIDIKAN</h4>
        <h4>CABANG DINAS PENDIDIKAN WILAYAH X</h4>
        <h4>SMK NEGERI 1 CILIMUS</h4>
        <p>
            Jalan Eyang Kyai Hasan Maulani Caracas<br>
            Telp. (0232) 8910145 Email :
            <u>smkn_1cilimus@yahoo.com</u><br>
            Kabupaten Kuningan 45556
        </p>
    </td>
</tr>
</table>

<div class="garis-1"></div>
<div class="garis-2"></div>

<!-- INFO SURAT -->
<table class="info">
<tr>
    <td width="70%">
        Nomor&nbsp;&nbsp;&nbsp;&nbsp;: <?= $permohonan->nomor_surat ?><br>
        Perihal&nbsp;&nbsp;: Pengajuan Kebutuhan Barang
    </td>
</tr>
</table>


<!-- JUDUL -->
<div class="judul">
SURAT PENGAJUAN KEBUTUHAN BARANG/JASA SEKOLAH
</div>

<!-- ISI -->
<?php
$bulan_en = date('F', strtotime($permohonan->tanggal));
$bulan_id = [
 'January'=>'Januari','February'=>'Februari','March'=>'Maret',
 'April'=>'April','May'=>'Mei','June'=>'Juni',
 'July'=>'Juli','August'=>'Agustus','September'=>'September',
 'October'=>'Oktober','November'=>'November','December'=>'Desember'
];
?>

<p class="paragraf">
Berdasarkan rencana kegiatan anggaran sekolah tahun
<?= date('Y',strtotime($permohonan->tanggal)) ?>,
selaku tim pengadaan mengajukan kebutuhan
<b><?= $permohonan->jenis_kebutuhan ?></b>
bulan <b><?= $bulan_id[$bulan_en] ?></b>
karena diperlukan untuk menunjang kegiatan belajar mengajar
dengan rincian sebagai berikut:
</p>


<!-- TABEL -->
<table class="table">
<thead>
<tr>
    <th width="5%">No</th>
    <th>Nama Barang/Jasa</th>
    <th width="15%">Unit</th>
    <th width="15%">Satuan</th>
</tr>
</thead>
<tbody>
<?php $no=1; foreach($detail as $d): ?>
<tr>
    <td class="center"><?= $no++ ?></td>
    <td><?= $d->nama_barang ?></td>
    <td class="center"><?= $d->jumlah ?></td>
    <td class="center"><?= $d->satuan ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<p class="paragraf">
Demikian surat pengajuan pengadaan barang ini dibuat dengan sebenarnya,
dan dapat direalisasikan sesuai ajuan kebutuhan.
</p>

<!-- TTD -->
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
