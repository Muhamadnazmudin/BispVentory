<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/* =========================================================
   DATA DASAR
========================================================= */

$nomor_surat = !empty($kebutuhan->nomor_surat)
    ? trim($kebutuhan->nomor_surat)
    : '-';

$perihal = !empty($kebutuhan->perihal)
    ? trim($kebutuhan->perihal)
    : 'Pengajuan Kebutuhan Barang';

$kegiatan = !empty($kebutuhan->kegiatan)
    ? trim($kebutuhan->kegiatan)
    : 'kegiatan sekolah';


/* =========================================================
   FORMAT TANGGAL
========================================================= */

$bulan = array(
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

$tanggal_pdf = '-';

if (!empty($kebutuhan->tanggal)) {

    $timestamp = strtotime($kebutuhan->tanggal);

    if ($timestamp !== false) {

        $tanggal_pdf =
            date('j', $timestamp) .
            ' ' .
            $bulan[(int) date('n', $timestamp)] .
            ' ' .
            date('Y', $timestamp);
    }
}


/* =========================================================
   TAHUN ANGGARAN
========================================================= */

$tahun_anggaran = date('Y');

if (!empty($kebutuhan->tanggal)) {

    $timestamp = strtotime($kebutuhan->tanggal);

    if ($timestamp !== false) {
        $tahun_anggaran = date('Y', $timestamp);
    }
}


/* =========================================================
   NAMA KEBUTUHAN DARI KODERING / KATEGORI
========================================================= */

$daftar_kebutuhan = array();

if (!empty($detail)) {

    foreach ($detail as $row) {

        if (
            isset($row->nama_kategori) &&
            trim($row->nama_kategori) !== ''
        ) {

            $nama_kategori =
                trim($row->nama_kategori);

            $daftar_kebutuhan[] =
                $nama_kategori;
        }
    }
}


/* =========================================================
   HILANGKAN DUPLIKAT
========================================================= */

$daftar_kebutuhan =
    array_unique($daftar_kebutuhan);


/* =========================================================
   GABUNG NAMA KEBUTUHAN
========================================================= */

if (!empty($daftar_kebutuhan)) {

    $nama_kebutuhan =
        implode(', ', $daftar_kebutuhan);

} else {

    $nama_kebutuhan =
        'Barang/Jasa';
}


/* =========================================================
   TANGGAL DAN KOTA
========================================================= */

$kota_tanggal =
    'Kuningan, ' . $tanggal_pdf;


/* =========================================================
   IDENTITAS SEKOLAH
========================================================= */

$nama_sekolah =
    !empty($nama_sekolah)
        ? $nama_sekolah
        : 'SMK NEGERI 1 CILIMUS';

$alamat =
    !empty($alamat)
        ? $alamat
        : 'Jalan Eyang Kyai Hasan Maulani Caracas Cilimus';

$telepon =
    !empty($telepon)
        ? $telepon
        : '(0232) 8910145';

$email =
    !empty($email)
        ? $email
        : 'smkn_1cilimus@yahoo.com';

$kabupaten =
    !empty($kabupaten)
        ? $kabupaten
        : 'Kabupaten Kuningan 45556';


/* =========================================================
   DATA TANDA TANGAN
========================================================= */

$kepala_nama =
    !empty($kepala_nama)
        ? $kepala_nama
        : 'Drs. ROSIDIN';

$kepala_nip =
    !empty($kepala_nip)
        ? $kepala_nip
        : 'NIP. 196707061994031014';

$pengaju_nama =
    !empty($pengaju_nama)
        ? $pengaju_nama
        : 'M. HENDI GUNTARA, S.Pd';

$pengaju_nip =
    !empty($pengaju_nip)
        ? $pengaju_nip
        : 'NIP. 19940828 202221 1 006';


/* =========================================================
   LOGO SEKOLAH
========================================================= */

$logo_path =
    FCPATH . 'assets/img/logobispar.png';

$logo_base64 = '';

if (file_exists($logo_path)) {

    $logo_data =
        file_get_contents($logo_path);

    if ($logo_data !== false) {

        $logo_type =
            strtolower(
                pathinfo(
                    $logo_path,
                    PATHINFO_EXTENSION
                )
            );

        if ($logo_type === 'jpg') {
            $logo_type = 'jpeg';
        }

        $logo_base64 =
            'data:image/' .
            $logo_type .
            ';base64,' .
            base64_encode($logo_data);
    }
}

?>
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Surat Pengajuan Kebutuhan
    </title>


    <style>

        @page {

            size: A4 portrait;

            margin:
                17mm
                18mm
                15mm
                18mm;
        }


        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            padding: 0;

            color: #000;

            background: #fff;

            font-family:
                "Times New Roman",
                Times,
                serif;

            font-size: 11pt;

            line-height: 1.25;
        }


        /* =====================================================
           KOP SURAT
        ===================================================== */

        .kop {

            width: 100%;

            border-collapse: collapse;

            margin: 0;

            padding: 0;
        }


        .kop td {

            padding: 0;

            vertical-align: middle;
        }


        .kop-logo {

            width: 75px;

            text-align: left;
        }


        .kop-logo img {

            display: block;

            width: 63px;

            height: 63px;

            object-fit: contain;
        }


        .kop-text {

            padding-right: 40px !important;

            text-align: center;

            line-height: 1.05;
        }


        .kop-text .baris {

            font-size: 11pt;

            font-weight: normal;
        }


        .kop-text .sekolah {

            margin-top: 2px;

            font-size: 16pt;

            font-weight: bold;
        }


        .kop-text .alamat {

            margin-top: 2px;

            font-size: 10pt;

            font-style: italic;
        }


        .kop-text .kontak {

            font-size: 9.5pt;
        }


        .kop-text .kabupaten {

            font-size: 9.5pt;

            font-style: italic;
        }


        .garis-kop {

            width: 100%;

            height: 1px;

            margin-top: 6px;

            margin-bottom: 11px;

            border-top: 2px solid #000;
        }


        /* =====================================================
           IDENTITAS SURAT
        ===================================================== */

        .identitas {

            width: 100%;

            border-collapse: collapse;

            margin-bottom: 12px;

            font-size: 10.5pt;
        }


        .identitas td {

            padding: 1px 0;

            vertical-align: top;
        }


        .identitas .label {

            width: 82px;
        }


        .identitas .titik {

            width: 10px;

            text-align: center;
        }


        /* =====================================================
           JUDUL
        ===================================================== */

        .judul {

            margin-bottom: 17px;

            text-align: center;

            font-size: 12pt;

            font-weight: bold;

            text-decoration: underline;
        }


        /* =====================================================
           PARAGRAF PEMBUKA
        ===================================================== */

        .paragraf {

            margin-bottom: 13px;

            text-align: justify;

            font-size: 10.5pt;

            line-height: 1.4;
        }


        .paragraf strong {

            font-weight: bold;
        }


        /* =====================================================
           TABEL BARANG
        ===================================================== */

        .tabel-barang {

            width: 100%;

            border-collapse: collapse;

            margin-top: 6px;

            margin-bottom: 17px;

            font-size: 9.5pt;

            page-break-inside: auto;
        }


        .tabel-barang thead {

            display: table-header-group;
        }


        .tabel-barang tr {

            page-break-inside: avoid;

            page-break-after: auto;
        }


        .tabel-barang th,
        .tabel-barang td {

            padding: 4px 5px;

            border: 1px solid #000;

            vertical-align: middle;
        }


        .tabel-barang th {

            background: #fff;

            text-align: center;

            font-weight: bold;
        }


        .tabel-barang .no {

            width: 7%;

            text-align: center;
        }


        .tabel-barang .nama {

            width: 48%;

            text-align: left;
        }


        .tabel-barang .jumlah {

            width: 20%;

            text-align: center;
        }


        .tabel-barang .satuan {

            width: 25%;

            text-align: center;
        }


        /* =====================================================
           PENUTUP
        ===================================================== */

        .penutup {

            margin-top: 4px;

            margin-bottom: 18px;

            text-align: justify;

            font-size: 10.5pt;

            line-height: 1.4;
        }


        /* =====================================================
           TANDA TANGAN
        ===================================================== */

        .ttd {

            width: 100%;

            border-collapse: collapse;

            margin-top: 8px;
        }


        .ttd td {

            width: 50%;

            padding: 0;

            vertical-align: top;

            font-size: 10.5pt;
        }


        .ttd-kiri {

            padding-right: 25px !important;

            text-align: left;
        }


        .ttd-kanan {

            padding-left: 90px !important;

            text-align: left;
        }


        .ttd-jabatan {

            min-height: 120px;

            line-height: 1.3;
        }


        .ttd-nama {

            margin-top: 20px;

            font-weight: bold;

            text-decoration: underline;
        }


        .ttd-nip {

            margin-top: 2px;

            font-size: 10pt;
        }


        /* =====================================================
           HINDARI POTONGAN ELEMEN
        ===================================================== */

        .kop,
        .identitas,
        .judul,
        .penutup,
        .ttd {

            page-break-inside: avoid;
        }

    </style>

</head>


<body>


    <!-- =====================================================
         KOP SURAT
    ===================================================== -->

    <table class="kop">

        <tr>

            <td class="kop-logo">

                <?php if (!empty($logo_base64)): ?>

                    <img
                        src="<?= $logo_base64 ?>"
                        alt="Logo Sekolah"
                    >

                <?php endif; ?>

            </td>


            <td class="kop-text">

                <div class="baris">

                    PEMERINTAH DAERAH PROVINSI JAWA BARAT

                </div>


                <div class="baris">

                    DINAS PENDIDIKAN

                </div>


                <div class="baris">

                    CABANG DINAS PENDIDIKAN WILAYAH X

                </div>


                <div class="sekolah">

                    <?= html_escape($nama_sekolah) ?>

                </div>


                <div class="alamat">

                    <?= html_escape($alamat) ?>

                </div>


                <div class="kontak">

                    Telp. <?= html_escape($telepon) ?>,
                    Email:
                    <?= html_escape($email) ?>

                </div>


                <div class="kabupaten">

                    <?= html_escape($kabupaten) ?>

                </div>

            </td>

        </tr>

    </table>


    <div class="garis-kop"></div>


    <!-- =====================================================
         IDENTITAS SURAT
    ===================================================== -->

    <table class="identitas">

        <tr>

            <td class="label">

                Nomor

            </td>

            <td class="titik">

                :

            </td>

            <td>

                <?= html_escape($nomor_surat) ?>

            </td>

        </tr>


        <tr>

            <td class="label">

                Perihal

            </td>

            <td class="titik">

                :

            </td>

            <td>

                <?= html_escape($perihal) ?>

            </td>

        </tr>

    </table>


    <!-- =====================================================
         JUDUL
    ===================================================== -->

    <div class="judul">

        SURAT PENGAJUAN KEBUTUHAN BARANG/JASA SEKOLAH

    </div>


    <!-- =====================================================
         PARAGRAF PEMBUKA
    ===================================================== -->

    <div class="paragraf">

        Berdasarkan rencana kegiatan anggaran sekolah
        tahun
        <strong>
            <?= html_escape($tahun_anggaran) ?>
        </strong>,
        selaku tim pengadaan mengajukan kebutuhan
        <strong>
            <?= html_escape($nama_kebutuhan) ?>
        </strong>
        untuk memenuhi kebutuhan sekolah
        <strong>
            <?= html_escape($kegiatan) ?>
        </strong>.
        Adapun rincian kebutuhan yang diajukan adalah
        sebagai berikut:

    </div>


    <!-- =====================================================
         TABEL BARANG
    ===================================================== -->

    <table class="tabel-barang">

        <thead>

            <tr>

                <th class="no">
                    No
                </th>

                <th class="nama">
                    Nama Barang/Jasa
                </th>

                <th class="jumlah">
                    Unit
                </th>

                <th class="satuan">
                    Satuan
                </th>

            </tr>

        </thead>


        <tbody>

            <?php if (!empty($detail)): ?>

                <?php $no = 1; ?>


                <?php foreach ($detail as $row): ?>

                    <?php

                    $jumlah =
                        isset($row->jumlah)
                            ? (float) $row->jumlah
                            : 0;

                    if (
                        floor($jumlah) ==
                        $jumlah
                    ) {

                        $jumlah_tampil =
                            number_format(
                                $jumlah,
                                0,
                                ',',
                                '.'
                            );

                    } else {

                        $jumlah_tampil =
                            number_format(
                                $jumlah,
                                2,
                                ',',
                                '.'
                            );

                        $jumlah_tampil =
                            rtrim(
                                rtrim(
                                    $jumlah_tampil,
                                    '0'
                                ),
                                ','
                            );
                    }

                    ?>


                    <tr>

                        <td class="no">

                            <?= $no ?>.

                        </td>


                        <td class="nama">

                            <?= html_escape(
                                isset($row->nama_barang)
                                    ? $row->nama_barang
                                    : ''
                            ) ?>

                        </td>


                        <td class="jumlah">

                            <?= html_escape(
                                $jumlah_tampil
                            ) ?>

                        </td>


                        <td class="satuan">

                            <?= html_escape(
                                isset($row->satuan)
                                    ? $row->satuan
                                    : ''
                            ) ?>

                        </td>

                    </tr>


                    <?php $no++; ?>

                <?php endforeach; ?>


            <?php else: ?>

                <tr>

                    <td
                        colspan="4"
                        style="text-align:center;"
                    >

                        Tidak ada rincian kebutuhan.

                    </td>

                </tr>

            <?php endif; ?>

        </tbody>

    </table>


    <!-- =====================================================
         PENUTUP
    ===================================================== -->

    <div class="penutup">

        Demikian surat pengajuan pengadaan barang ini
        dibuat dengan sebenarnya, dan dapat
        direalisasikan sesuai ajuan kebutuhan.

    </div>


    <!-- =====================================================
         TANDA TANGAN
    ===================================================== -->

    <table class="ttd">

        <tr>

            <!-- =================================================
                 KEPALA SEKOLAH
            ================================================== -->

            <td class="ttd-kiri">

                <div class="ttd-jabatan">

                    Menyetujui,<br>

                    Kepala SMKN 1 Cilimus

                </div>


                <div class="ttd-nama">

                    <?= html_escape($kepala_nama) ?>

                </div>


                <div class="ttd-nip">

                    <?= html_escape($kepala_nip) ?>

                </div>

            </td>


            <!-- =================================================
                 TIM PENGADAAN
            ================================================== -->

            <td class="ttd-kanan">

                <div class="ttd-jabatan">

                    <?= html_escape($kota_tanggal) ?><br>

                    Diajukan Oleh,<br>

                    Tim Pengadaan Barang

                </div>


                <div class="ttd-nama">

                    <?= html_escape($pengaju_nama) ?>

                </div>


                <div class="ttd-nip">

                    <?= html_escape($pengaju_nip) ?>

                </div>

            </td>

        </tr>

    </table>


</body>

</html>