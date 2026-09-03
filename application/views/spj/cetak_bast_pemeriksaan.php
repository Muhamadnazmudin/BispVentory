<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/*
|--------------------------------------------------------------------------
| HELPER ESCAPE
|--------------------------------------------------------------------------
*/

$esc = function ($value) {
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
};


/*
|--------------------------------------------------------------------------
| DATA DASAR
|--------------------------------------------------------------------------
*/

$nomor_bast =
    !empty($bast->nomor_bast)
        ? $bast->nomor_bast
        : '-';


$nomor_keputusan =
    !empty($nomor_keputusan)
        ? $nomor_keputusan
        : '';


$nomor_invoice =
    !empty($bast->nomor_invoice)
        ? $bast->nomor_invoice
        : '-';


$nomor_pesanan =
    !empty($bast->nomor_pesanan)
        ? $bast->nomor_pesanan
        : '-';


$nama_penyedia =
    !empty($bast->nama_penyedia)
        ? $bast->nama_penyedia
        : '-';


$kegiatan =
    !empty($bast->kegiatan)
        ? $bast->kegiatan
        : '';


/*
|--------------------------------------------------------------------------
| TANGGAL PEMERIKSAAN
|--------------------------------------------------------------------------
*/

$tanggal_pemeriksaan =
    !empty($bast->tanggal_pemeriksaan)
        ? strtotime($bast->tanggal_pemeriksaan)
        : time();


$tanggal_angka =
    date(
        'd',
        $tanggal_pemeriksaan
    );


$bulan_indonesia = array(
    1  => 'Januari',
    2  => 'Februari',
    3  => 'Maret',
    4  => 'April',
    5  => 'Mei',
    6  => 'Juni',
    7  => 'Juli',
    8  => 'Agustus',
    9  => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
);


$bulan_angka =
    (int) date(
        'n',
        $tanggal_pemeriksaan
    );


$bulan_nama =
    isset($bulan_indonesia[$bulan_angka])
        ? $bulan_indonesia[$bulan_angka]
        : '';


$tahun_angka =
    date(
        'Y',
        $tanggal_pemeriksaan
    );


$tanggal_lengkap =
    $tanggal_angka .
    ' ' .
    $bulan_nama .
    ' ' .
    $tahun_angka;


/*
|--------------------------------------------------------------------------
| DATA TERBILANG
|--------------------------------------------------------------------------
|
| Controller sudah mengirim:
| $nama_hari
| $tanggal_terbilang
| $nama_bulan
| $tahun_terbilang
|
*/

$nama_hari =
    !empty($nama_hari)
        ? $nama_hari
        : '';


$tanggal_terbilang =
    !empty($tanggal_terbilang)
        ? $tanggal_terbilang
        : '';


$nama_bulan =
    !empty($nama_bulan)
        ? $nama_bulan
        : $bulan_nama;


$tahun_terbilang =
    !empty($tahun_terbilang)
        ? $tahun_terbilang
        : $tahun_angka;


/*
|--------------------------------------------------------------------------
| PEMERIKSA
|--------------------------------------------------------------------------
*/

$pemeriksa_nama =
    !empty($pemeriksa_nama)
        ? $pemeriksa_nama
        : '-';


$pemeriksa_jabatan =
    !empty($pemeriksa_jabatan)
        ? $pemeriksa_jabatan
        : '-';


$pemeriksa_nip =
    !empty($pemeriksa_nip)
        ? $pemeriksa_nip
        : '-';

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        BAST Pemeriksaan
    </title>


    <style>

        @page {
            margin: 25px 45px 35px 45px;
        }


        * {
            box-sizing: border-box;
        }


        body {
            margin: 0;
            padding: 0;

            font-family:
                DejaVu Sans,
                Arial,
                sans-serif;

            font-size: 10.5px;
            color: #000;

            line-height: 1.45;
        }


        /*
        |--------------------------------------------------------------------------
        | KOP
        |--------------------------------------------------------------------------
        */

        .kop-surat {

            position: relative;

            width: 100%;

            min-height: 132px;

            text-align: center;

            margin: 0 auto;

            padding: 0;
        }


        /*
        |--------------------------------------------------------------------------
        | LOGO
        |--------------------------------------------------------------------------
        |
        | Logo ditempatkan relatif terhadap kop.
        | Tidak menggunakan posisi halaman.
        |
        */

        .kop-logo {

            position: absolute;

            left: 72px;
            top: 8px;

            width: 78px;

            text-align: center;
        }


        .kop-logo img {

            display: block;

            width: 76px;

            height: auto;

            margin: 0 auto;
        }


        /*
        |--------------------------------------------------------------------------
        | BLOK TEKS KOP
        |--------------------------------------------------------------------------
        */

        .kop-teks {

            width: 76%;

            margin-left: 20%;

            margin-right: 4%;

            text-align: center;

            line-height: 1.25;
        }


        .kop-instansi {

            font-size: 13px;

            font-weight: normal;

            margin-bottom: 3px;
        }


        .kop-dinas {

            font-size: 13px;

            font-weight: normal;

            margin-bottom: 3px;
        }


        .kop-cabang {

            font-size: 13px;

            font-weight: normal;

            margin-bottom: 5px;
        }


        .kop-sekolah {

            font-size: 18px;

            font-weight: bold;

            margin-bottom: 7px;
        }


        .kop-alamat {

            font-size: 10px;

            margin-bottom: 3px;
        }


        .kop-telepon {

            font-size: 10px;
        }


        /*
        |--------------------------------------------------------------------------
        | GARIS KOP
        |--------------------------------------------------------------------------
        */

        .garis-kop {

            width: 100%;

            border-bottom: 2px solid #000;

            margin-top: 2px;

            margin-bottom: 18px;
        }


        /*
        |--------------------------------------------------------------------------
        | JUDUL
        |--------------------------------------------------------------------------
        */

        .judul {

            text-align: center;

            margin-top: 0;

            margin-bottom: 2px;

            font-size: 14px;

            font-weight: bold;

            text-transform: uppercase;
        }


        .subjudul {

            text-align: center;

            margin-bottom: 18px;

            font-size: 10.5px;
        }


        /*
        |--------------------------------------------------------------------------
        | NOMOR BAST
        |--------------------------------------------------------------------------
        */

        .nomor-bast {

            text-align: center;

            margin-bottom: 20px;

            font-size: 10.5px;

            font-weight: bold;
        }


        /*
        |--------------------------------------------------------------------------
        | PARAGRAF
        |--------------------------------------------------------------------------
        */

        p {

            margin-top: 0;

            margin-bottom: 10px;

            text-align: justify;

            line-height: 1.55;
        }


        /*
        |--------------------------------------------------------------------------
        | IDENTITAS PEMERIKSA
        |--------------------------------------------------------------------------
        */

        .identitas {

            margin-top: 8px;

            margin-bottom: 12px;

            width: 100%;
        }


        .identitas td {

            padding: 2px 0;

            vertical-align: top;

            font-size: 10.5px;
        }


        .identitas .label {

            width: 95px;
        }


        .identitas .titik {

            width: 15px;

            text-align: center;
        }


        /*
        |--------------------------------------------------------------------------
        | TABEL RINCIAN
        |--------------------------------------------------------------------------
        */

        .judul-rincian {

            margin-top: 10px;

            margin-bottom: 8px;

            text-align: left;

            font-size: 10.5px;
        }


        .tabel-rincian {

            width: 100%;

            border-collapse: collapse;

            margin-top: 5px;

            margin-bottom: 14px;

            table-layout: fixed;
        }


        .tabel-rincian th {

            border: 1px solid #000;

            padding: 6px 5px;

            text-align: center;

            vertical-align: middle;

            font-size: 9.5px;

            font-weight: bold;
        }


        .tabel-rincian td {

            border: 1px solid #000;

            padding: 5px;

            vertical-align: top;

            font-size: 9.5px;
        }


        .col-no {
            width: 7%;
            text-align: center;
        }


        .col-kodering {
            width: 19%;
        }


        .col-nama {
            width: 42%;
        }


        .col-jumlah {
            width: 12%;
            text-align: center;
        }


        .col-satuan {
            width: 20%;
            text-align: center;
        }


        /*
        |--------------------------------------------------------------------------
        | KETERANGAN / HASIL
        |--------------------------------------------------------------------------
        */

        .bagian-hasil {

            margin-top: 10px;

            margin-bottom: 12px;
        }


        /*
        |--------------------------------------------------------------------------
        | TANDA TANGAN
        |--------------------------------------------------------------------------
        */

        .ttd-wrapper {

            width: 100%;

            margin-top: 35px;

            page-break-inside: avoid;
        }


        .ttd {

            width: 48%;

            margin-left: auto;

            text-align: center;

            font-size: 10.5px;
        }


        .ttd-jabatan {

            min-height: 42px;

            margin-top: 3px;

            margin-bottom: 55px;
        }


        .ttd-nama {

            font-weight: bold;

            text-decoration: underline;
        }


        .ttd-nip {

            margin-top: 2px;
        }


        /*
        |--------------------------------------------------------------------------
        | UTILITIES
        |--------------------------------------------------------------------------
        */

        .text-center {
            text-align: center;
        }


        .text-left {
            text-align: left;
        }


        .text-right {
            text-align: right;
        }


        .nowrap {
            white-space: nowrap;
        }

    </style>

</head>


<body>


<!-- =========================================================
     KOP SURAT
========================================================= -->

<div class="kop-surat">


    <!-- LOGO -->

    <div class="kop-logo">

        <?php if (!empty($logo_base64)): ?>

            <img
                src="<?= $logo_base64 ?>"
                alt="Logo Provinsi Jawa Barat"
            >

        <?php endif; ?>

    </div>


    <!-- TEKS KOP -->

    <div class="kop-teks">

        <div class="kop-instansi">
            PEMERINTAH DAERAH PROVINSI JAWA BARAT
        </div>

        <div class="kop-dinas">
            DINAS PENDIDIKAN
        </div>

        <div class="kop-cabang">
            CABANG DINAS PENDIDIKAN WILAYAH X
        </div>

        <div class="kop-sekolah">
            SMK NEGERI 1 CILIMUS
        </div>

        <div class="kop-alamat">
            Jalan Eyang Kuwu Sangkan Cilimus, Kabupaten Kuningan 45556
        </div>

        <div class="kop-telepon">
            Telp. (0232) 8910145
        </div>

    </div>

</div>


<div class="garis-kop"></div>


<!-- =========================================================
     JUDUL
========================================================= -->

<div class="judul">
    BERITA ACARA PEMERIKSAAN BARANG
</div>


<div class="subjudul">
    Nomor: <?= $esc($nomor_bast) ?>
</div>


<!-- =========================================================
     PEMBUKA
========================================================= -->

<p>
    Pada hari ini
    <strong><?= $esc($nama_hari) ?></strong>
    tanggal
    <strong><?= $esc($tanggal_terbilang) ?></strong>
    bulan
    <strong><?= $esc($nama_bulan) ?></strong>
    tahun
    <strong><?= $esc($tahun_terbilang) ?></strong>,
    kami yang bertanda tangan dibawah ini petugas/tim Pemeriksaan Barang
    berdasarkan Surat Keputusan No
    <strong><?= $esc($nomor_keputusan) ?></strong>,
    menerangkan:
</p>


<!-- =========================================================
     IDENTITAS PEMERIKSA
========================================================= -->

<table class="identitas">

    <tr>

        <td class="label">
            Nama
        </td>

        <td class="titik">
            :
        </td>

        <td>
            <?= $esc($pemeriksa_nama) ?>
        </td>

    </tr>


    <tr>

        <td class="label">
            Jabatan
        </td>

        <td class="titik">
            :
        </td>

        <td>
            <?= $esc($pemeriksa_jabatan) ?>
        </td>

    </tr>


    <tr>

        <td class="label">
            NIP
        </td>

        <td class="titik">
            :
        </td>

        <td>
            <?= $esc($pemeriksa_nip) ?>
        </td>

    </tr>

</table>


<!-- =========================================================
     URAIAN
========================================================= -->

<p>

    Dengan ini menyatakan bahwa berdasarkan Invoice nomor
    <strong><?= $esc($nomor_invoice) ?></strong>
    tanggal
    <?= $esc($tanggal_angka) ?>
    <?= $esc($bulan_nama) ?>
    <?= $esc($tahun_angka) ?>
    sebagai realisasi Surat Pesanan nomor
    <strong><?= $esc($nomor_pesanan) ?></strong>
    tanggal
    <?= $esc($tanggal_angka) ?>
    <?= $esc($bulan_nama) ?>
    <?= $esc($tahun_angka) ?>
    yang dipercayakan kepada
    <strong><?= $esc($nama_penyedia) ?></strong>
    selaku penyedia barang
    <?php if (!empty($kegiatan)): ?>
        <?= $esc($kegiatan) ?>
    <?php endif; ?>
    dengan rincian belanja sebagai berikut:
</p>


<!-- =========================================================
     TABEL RINCIAN
========================================================= -->

<table class="tabel-rincian">

    <thead>

        <tr>

            <th class="col-no">
                No.
            </th>

            <th class="col-kodering">
                Kodering
            </th>

            <th class="col-nama">
                Nama Barang/Jasa
            </th>

            <th class="col-jumlah">
                Jumlah
            </th>

            <th class="col-satuan">
                Satuan
            </th>

        </tr>

    </thead>


    <tbody>

        <?php
        $no = 1;
        ?>

        <?php foreach ($detail as $row): ?>

            <tr>

                <td class="col-no">
                    <?= $no++ ?>
                </td>


                <td>
                    <?= $esc(
                        !empty($row->kodering)
                            ? $row->kodering
                            : '-'
                    ) ?>
                </td>


                <td>
                    <?= $esc(
                        !empty($row->nama_barang)
                            ? $row->nama_barang
                            : '-'
                    ) ?>
                </td>


                <td class="col-jumlah">
                    <?= $esc(
                        !empty($row->jumlah)
                            ? $row->jumlah
                            : '0'
                    ) ?>
                </td>


                <td class="col-satuan">
                    <?= $esc(
                        !empty($row->satuan)
                            ? $row->satuan
                            : '-'
                    ) ?>
                </td>

            </tr>

        <?php endforeach; ?>

    </tbody>

</table>


<!-- =========================================================
     HASIL PEMERIKSAAN
========================================================= -->

<div class="bagian-hasil">

    <p>

        Berdasarkan pemeriksaan tanggal
        <strong><?= $esc($tanggal_lengkap) ?></strong>
        maka pekerjaan yang telah dilaksanakan oleh
        <strong><?= $esc($nama_penyedia) ?></strong>
        telah diperiksa dan akan diinventarisir.

    </p>


    <p>

        Demikianlah Berita Acara Pemeriksaan Barang ini dibuat dengan
        sebenarnya untuk dapat dipergunakan sebagaimana mestinya.

    </p>

</div>


<!-- =========================================================
     TANDA TANGAN
========================================================= -->

<div class="ttd-wrapper">

    <div class="ttd">

        <div>
            Cilimus, <?= $esc($tanggal_lengkap) ?>
        </div>


        <div class="ttd-jabatan">

            <?= $esc($pemeriksa_jabatan) ?>

        </div>


        <div class="ttd-nama">

            <?= $esc($pemeriksa_nama) ?>

        </div>


        <div class="ttd-nip">

            NIP. <?= $esc($pemeriksa_nip) ?>

        </div>

    </div>

</div>


</body>

</html>