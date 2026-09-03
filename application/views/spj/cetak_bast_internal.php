<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/*
|--------------------------------------------------------------------------
| BULAN
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| HARI
|--------------------------------------------------------------------------
*/

$hari = array(
    'Sunday'    => 'Minggu',
    'Monday'    => 'Senin',
    'Tuesday'   => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday'  => 'Kamis',
    'Friday'    => 'Jumat',
    'Saturday'  => 'Sabtu'
);


/*
|--------------------------------------------------------------------------
| ANGKA KE HURUF
|--------------------------------------------------------------------------
*/

function angka_ke_huruf_bast($angka)
{
    $angka = (int) $angka;

    $huruf = array(
        1  => 'Satu',
        2  => 'Dua',
        3  => 'Tiga',
        4  => 'Empat',
        5  => 'Lima',
        6  => 'Enam',
        7  => 'Tujuh',
        8  => 'Delapan',
        9  => 'Sembilan',
        10 => 'Sepuluh',
        11 => 'Sebelas',
        12 => 'Dua Belas',
        13 => 'Tiga Belas',
        14 => 'Empat Belas',
        15 => 'Lima Belas',
        16 => 'Enam Belas',
        17 => 'Tujuh Belas',
        18 => 'Delapan Belas',
        19 => 'Sembilan Belas',
        20 => 'Dua Puluh',
        21 => 'Dua Puluh Satu',
        22 => 'Dua Puluh Dua',
        23 => 'Dua Puluh Tiga',
        24 => 'Dua Puluh Empat',
        25 => 'Dua Puluh Lima',
        26 => 'Dua Puluh Enam',
        27 => 'Dua Puluh Tujuh',
        28 => 'Dua Puluh Delapan',
        29 => 'Dua Puluh Sembilan',
        30 => 'Tiga Puluh',
        31 => 'Tiga Puluh Satu'
    );

    return isset($huruf[$angka])
        ? $huruf[$angka]
        : (string) $angka;
}


/*
|--------------------------------------------------------------------------
| DATA BAST INTERNAL
|--------------------------------------------------------------------------
*/

$nomor_bast_internal =
    !empty($kebutuhan->nomor_bast_internal)
        ? trim($kebutuhan->nomor_bast_internal)
        : '-';


/*
|--------------------------------------------------------------------------
| TANGGAL BAST INTERNAL
|--------------------------------------------------------------------------
|
| Ini tetap digunakan untuk tanggal dokumen BAST Internal.
|
*/

$tanggal_bast_internal =
    !empty($kebutuhan->tanggal_bast_internal)
        ? strtotime($kebutuhan->tanggal_bast_internal)
        : false;


if ($tanggal_bast_internal !== false) {

    $tanggal_internal_hari =
        date('j', $tanggal_bast_internal);

    $tanggal_internal_hari_huruf =
        angka_ke_huruf_bast(
            $tanggal_internal_hari
        );

    $tanggal_internal_bulan =
        $bulan[
            (int) date(
                'n',
                $tanggal_bast_internal
            )
        ];

    $tanggal_internal_tahun =
        date(
            'Y',
            $tanggal_bast_internal
        );

    $nama_hari_internal =
        $hari[
            date(
                'l',
                $tanggal_bast_internal
            )
        ];

    $tanggal_lengkap_bast =
        date(
            'd',
            $tanggal_bast_internal
        ) .
        ' ' .
        $tanggal_internal_bulan .
        ' ' .
        $tanggal_internal_tahun;

} else {

    $tanggal_internal_hari = '-';
    $tanggal_internal_hari_huruf = '-';
    $tanggal_internal_bulan = '-';
    $tanggal_internal_tahun = '-';
    $nama_hari_internal = '-';
    $tanggal_lengkap_bast = '-';
}


/*
|--------------------------------------------------------------------------
| DATA BAST PEMERIKSAAN
|--------------------------------------------------------------------------
|
| Nomor dan tanggal diambil dari BAST Pemeriksaan.
|
*/

/*
|--------------------------------------------------------------------------
| DATA BAST PEMERIKSAAN
|--------------------------------------------------------------------------
|
| Data langsung dari spj_bast_pemeriksaan.
|
*/

$nomor_bast_pemeriksaan =
    !empty($bast_pemeriksaan->nomor_bast)
        ? trim($bast_pemeriksaan->nomor_bast)
        : '-';


$tanggal_bast_pemeriksaan =
    !empty($bast_pemeriksaan->tanggal_pemeriksaan)
        ? strtotime($bast_pemeriksaan->tanggal_pemeriksaan)
        : false;


/*
|--------------------------------------------------------------------------
| TANGGAL BERITA ACARA PEMERIKSAAN
|--------------------------------------------------------------------------
*/

if ($tanggal_bast_pemeriksaan !== false) {

    $tanggal_pemeriksaan_hari =
        date(
            'j',
            $tanggal_bast_pemeriksaan
        );

    $tanggal_pemeriksaan_bulan =
        $bulan[
            (int) date(
                'n',
                $tanggal_bast_pemeriksaan
            )
        ];

    $tanggal_pemeriksaan_tahun =
        date(
            'Y',
            $tanggal_bast_pemeriksaan
        );

    $tanggal_lengkap_pemeriksaan =
        date(
            'j',
            $tanggal_bast_pemeriksaan
        ) .
        ' ' .
        $tanggal_pemeriksaan_bulan .
        ' ' .
        $tanggal_pemeriksaan_tahun;

} else {

    $tanggal_pemeriksaan_hari = '-';
    $tanggal_pemeriksaan_bulan = '-';
    $tanggal_pemeriksaan_tahun = '-';
    $tanggal_lengkap_pemeriksaan = '-';
}


/*
|--------------------------------------------------------------------------
| NAMA KODERING
|--------------------------------------------------------------------------
|
| Yang ditampilkan adalah nama_kodering,
| bukan kode/kodering angka.
|
*/

$nama_kodering = '';


if (!empty($detail)) {

    foreach ($detail as $row) {

        if (
            isset($row->nama_kodering) &&
            trim($row->nama_kodering) !== ''
        ) {

            $nama_kodering =
                trim($row->nama_kodering);

            break;
        }
    }
}


if ($nama_kodering === '') {
    $nama_kodering = '-';
}


/*
|--------------------------------------------------------------------------
| LOGO
|--------------------------------------------------------------------------
*/

$logo_path =
    FCPATH . 'assets/img/logoprovinsi.png';

$logo_base64 = '';

if (is_file($logo_path)) {

    $logo_data =
        file_get_contents($logo_path);

    if ($logo_data !== false) {

        $logo_base64 =
            'data:image/png;base64,' .
            base64_encode($logo_data);
    }
}

?>
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>BAST Internal</title>

    <style>

        @page {

            size: A4 portrait;

            margin:
                15mm
                15mm
                14mm
                15mm;
        }


        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            padding: 0;

            color: #000;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            font-size: 9.5pt;

            line-height: 1.2;
        }


        /* =====================================================
           KOP
        ===================================================== */

        .kop {

            width: 100%;

            border-collapse: collapse;

            margin-bottom: 2px;
        }


        .kop td {

            padding: 0;

            vertical-align: middle;
        }


        .logo {

            width: 75px;

            text-align: center;
        }


        .logo img {

            width: 80px;

            height: 80px;

            object-fit: contain;

            position: relative;

            left: 80px;
        }


        .kop-text {

            text-align: center;

            line-height: 1.02;

            padding-right: 45px !important;
        }


        .kop-text .baris {

            font-size: 9.5pt;
        }


        .kop-text .sekolah {

            margin-top: 2px;

            font-size: 15pt;

            font-weight: bold;
        }


        .kop-text .alamat {

            font-size: 9pt;

            font-style: italic;
        }


        .kop-text .kontak {

            font-size: 8.5pt;
        }


        .kop-text .kabupaten {

            font-size: 8.5pt;

            font-style: italic;
        }


        .garis-kop {

            border-top: 3px double #000;

            margin-top: 4px;

            margin-bottom: 6px;

            height: 1px;
        }


        /* =====================================================
           JUDUL
        ===================================================== */

        .judul {

            text-align: center;

            font-size: 11pt;

            font-weight: bold;

            margin-top: 2px;

            margin-bottom: 6px;
        }


        .nomor {

            text-align: center;

            font-size: 9.5pt;

            font-weight: bold;

            margin-bottom: 15px;
        }


        /* =====================================================
           PARAGRAF
        ===================================================== */

        .paragraf {

            text-align: justify;

            margin-bottom: 9px;

            line-height: 1.25;
        }


        /* =====================================================
           DATA PIHAK
        ===================================================== */

        .pihak {

            width: 100%;

            border-collapse: collapse;

            margin-top: 4px;

            margin-bottom: 8px;
        }


        .pihak td {

            padding: 1px 0;

            vertical-align: top;
        }


        .pihak .label {

            width: 48px;
        }


        .pihak .titik {

            width: 12px;

            text-align: center;
        }


        /* =====================================================
           URAIAN
        ===================================================== */

        .info-belanja {

            margin-top: 4px;

            margin-bottom: 8px;

            text-align: justify;

            line-height: 1.25;
        }


        .info-belanja strong {

            font-weight: bold;
        }


        /* =====================================================
           TABEL BARANG
        ===================================================== */

        .tabel-barang {

            width: 100%;

            border-collapse: collapse;

            margin-top: 7px;

            margin-bottom: 14px;

            font-size: 8.8pt;
        }


        .tabel-barang th,
        .tabel-barang td {

            border: 1px solid #000;

            padding: 3px 4px;

            vertical-align: middle;
        }


        .tabel-barang th {

            text-align: center;

            font-weight: bold;
        }


        .tabel-barang .no {

            width: 7%;

            text-align: center;
        }


        .tabel-barang .nama {

            width: 53%;

            text-align: left;
        }


        .tabel-barang .jumlah {

            width: 15%;

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

            text-align: justify;

            line-height: 1.25;

            margin-top: 5px;

            margin-bottom: 17px;
        }


        /* =====================================================
           TANDA TANGAN
        ===================================================== */

        .ttd {

            width: 100%;

            border-collapse: collapse;

            margin-top: 4px;
        }


        .ttd td {

            width: 50%;

            padding: 40;

            vertical-align: top;
        }


        .ttd-kiri {

            text-align: left;

            padding-right: 20px !important;
        }


        .ttd-kanan {

            text-align: left;

            padding-left: 65px !important;
        }


        .ttd-tempat {

            min-height: 52px;

            line-height: 1.25;
        }


        .ttd-nama {

            margin-top: 55px;

            font-weight: bold;

            text-decoration: underline;
        }


        .ttd-nip {

            margin-top: 2px;

            font-size: 9pt;
        }

    </style>

</head>


<body>


<!-- =====================================================
     KOP SURAT
====================================================== -->

<table class="kop">

    <tr>

        <td class="logo">

            <?php if (!empty($logo_base64)): ?>

                <img
                    src="<?= $logo_base64 ?>"
                    alt="Logo"
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

                Telp.
                <?= html_escape($telepon) ?>,

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
     JUDUL
====================================================== -->

<div class="judul">

    BERITA ACARA SERAH TERIMA BARANG

</div>


<!-- =====================================================
     NOMOR BAST INTERNAL
====================================================== -->

<div class="nomor">

    NOMOR:
    <?= html_escape($nomor_bast_internal) ?>

</div>


<!-- =====================================================
     PEMBUKA
====================================================== -->

<div class="paragraf">

    Pada hari ini
    <strong>
        <?= html_escape($nama_hari_internal) ?>
    </strong>

    tanggal
    <strong>
        <?= html_escape($tanggal_internal_hari_huruf) ?>
    </strong>

    bulan
    <strong>
        <?= html_escape($tanggal_internal_bulan) ?>
    </strong>

    tahun
    <strong>
        <?= html_escape($tanggal_internal_tahun) ?>
    </strong>,

    saya yang bertanda tangan dibawah ini :

</div>


<!-- =====================================================
     PEMERIKSA
====================================================== -->

<div class="paragraf">

    Dari tim pemeriksa barang,

</div>


<table class="pihak">

    <tr>

        <td class="label">
            Nama
        </td>

        <td class="titik">
            :
        </td>

        <td>
            <?= html_escape($pemeriksa_nama) ?>
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
            <?= html_escape($pemeriksa_jabatan) ?>
        </td>

    </tr>

</table>


<!-- =====================================================
     PENYERAH
====================================================== -->

<div class="paragraf">

    Menyerahkan barang kepada,

</div>


<table class="pihak">

    <tr>

        <td class="label">
            Nama
        </td>

        <td class="titik">
            :
        </td>

        <td>
            <?= html_escape($penyerah_nama) ?>
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
            <?= html_escape($penyerah_jabatan) ?>
        </td>

    </tr>

</table>


<!-- =====================================================
     URAIAN
====================================================== -->

<div class="info-belanja">

    Tim pemeriksa barang
    <?= html_escape($nama_sekolah) ?>

    telah memeriksa barang yang diserahkan oleh
    penyedia berupa belanja

    <strong>
        <?= html_escape($nama_kodering) ?>
    </strong>

    sesuai dengan Berita Acara Pemeriksaan Barang
    tanggal

    <strong>
        <?= html_escape($tanggal_lengkap_pemeriksaan) ?>
    </strong>.

    Nomor

    <strong>
        <?= html_escape($nomor_bast_pemeriksaan) ?>
    </strong>

    sebagaimana daftar terlampir berikut:

</div>


<!-- =====================================================
     TABEL BARANG
====================================================== -->

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

                <tr>

                    <td class="no">
                        <?= $no++ ?>
                    </td>


                    <td class="nama">

                        <?= html_escape(
                            $row->nama_barang
                        ) ?>

                    </td>


                    <td class="jumlah">

                        <?= html_escape(
                            rtrim(
                                rtrim(
                                    number_format(
                                        (float) $row->jumlah,
                                        2,
                                        ',',
                                        '.'
                                    ),
                                    '0'
                                ),
                                ','
                            )
                        ) ?>

                    </td>


                    <td class="satuan">

                        <?= html_escape(
                            $row->satuan
                        ) ?>

                    </td>

                </tr>

            <?php endforeach; ?>

        <?php endif; ?>

    </tbody>

</table>


<!-- =====================================================
     PENUTUP
====================================================== -->

<div class="penutup">

    Barang diatas sudah terinventarisir kemudian sudah bisa
    dan dapat didistribusikan. Demikian Berita Acara
    Penerimaan Barang ini dibuat untuk dipergunakan
    sebagaimana mestinya.

</div>


<!-- =====================================================
     TANDA TANGAN
====================================================== -->

<table class="ttd">

    <tr>

        <td class="ttd-kiri">

            <div class="ttd-tempat">

                Yang menyerahkan,<br>

                <?= html_escape(
                    $penyerah_jabatan
                ) ?>

            </div>


            <div class="ttd-nama">

                <?= html_escape(
                    $penyerah_nama
                ) ?>

            </div>


            <div class="ttd-nip">

                <?= html_escape(
                    $penyerah_nip
                ) ?>

            </div>

        </td>


        <td class="ttd-kanan">

            <div class="ttd-tempat">

                Kuningan,

                <?= html_escape(
                    $tanggal_lengkap_bast
                ) ?>

                <br>

                Yang Menerima,<br>

                <?= html_escape(
                    $penerima_jabatan
                ) ?>

            </div>


            <div class="ttd-nama">

                <?= html_escape(
                    $penerima_nama
                ) ?>

            </div>


            <div class="ttd-nip">

                <?= html_escape(
                    $penerima_nip
                ) ?>

            </div>

        </td>

    </tr>

</table>


</body>

</html>