<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| DATA DASHBOARD
|--------------------------------------------------------------------------
| Dashboard sekarang difokuskan pada alur SPJ:
|
| Kebutuhan
|    ↓
| BAST Pemeriksaan
|    ↓
| BAST Internal
|
| Tidak lagi menggunakan data master lama seperti:
| kategori, ruangan, guru, siswa, maupun stok.
|--------------------------------------------------------------------------
*/

$total_barang = (int) ($barang ?? 0);

$total_spj_kebutuhan   = (int) ($spj_kebutuhan ?? 0);
$total_spj_pemeriksaan = (int) ($spj_pemeriksaan ?? 0);
$total_spj_internal    = (int) ($spj_internal ?? 0);


/*
|--------------------------------------------------------------------------
| HITUNG PROGRES
|--------------------------------------------------------------------------
*/

$total_dokumen = $total_spj_kebutuhan;

$persen_pemeriksaan = 0;
$persen_internal    = 0;

if ($total_dokumen > 0) {

    $persen_pemeriksaan = min(
        100,
        round(($total_spj_pemeriksaan / $total_dokumen) * 100)
    );

    $persen_internal = min(
        100,
        round(($total_spj_internal / $total_dokumen) * 100)
    );
}

?>


<div class="container-fluid">


    <!-- =========================================================
         HEADER
    ========================================================== -->

    <div class="mb-4">

        <div class="d-flex align-items-center">

            <div class="mr-3">

                <div
                    class="d-flex align-items-center justify-content-center bg-primary rounded-circle"
                    style="width:48px;height:48px;"
                >

                    <i class="fas fa-tachometer-alt text-white"></i>

                </div>

            </div>

            <div>

                <h1 class="h3 mb-1 font-weight-bold text-gray-800">
                    Dashboard
                </h1>

                <div class="text-muted small">
                    Ringkasan proses dan dokumen SPJ BispVentory
                </div>

            </div>

        </div>

    </div>



    <!-- =========================================================
         STATISTIK UTAMA
    ========================================================== -->

    <div class="row">


        <!-- KEBUTUHAN -->

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-primary shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-2">
                                Kebutuhan
                            </div>

                            <div class="h3 mb-1 font-weight-bold text-gray-800">
                                <?= number_format($total_spj_kebutuhan); ?>
                            </div>

                            <div class="small text-muted">
                                Dokumen kebutuhan
                            </div>

                        </div>

                        <div>

                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <!-- DETAIL BARANG -->

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-info shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="text-xs font-weight-bold text-info text-uppercase mb-2">
                                Detail Barang
                            </div>

                            <div class="h3 mb-1 font-weight-bold text-gray-800">
                                <?= number_format($total_barang); ?>
                            </div>

                            <div class="small text-muted">
                                Item pada kebutuhan SPJ
                            </div>

                        </div>

                        <div>

                            <i class="fas fa-boxes fa-2x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <!-- PEMERIKSAAN -->

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-warning shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-2">
                                BAST Pemeriksaan
                            </div>

                            <div class="h3 mb-1 font-weight-bold text-gray-800">
                                <?= number_format($total_spj_pemeriksaan); ?>
                            </div>

                            <div class="small text-muted">
                                Dokumen pemeriksaan
                            </div>

                        </div>

                        <div>

                            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <!-- INTERNAL -->

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-success shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="text-xs font-weight-bold text-success text-uppercase mb-2">
                                BAST Internal
                            </div>

                            <div class="h3 mb-1 font-weight-bold text-gray-800">
                                <?= number_format($total_spj_internal); ?>
                            </div>

                            <div class="small text-muted">
                                Dokumen BAST internal
                            </div>

                        </div>

                        <div>

                            <i class="fas fa-file-signature fa-2x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- =========================================================
         PROSES SPJ
    ========================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header py-3">

            <div class="d-flex align-items-center justify-content-between">

                <div>

                    <h6 class="m-0 font-weight-bold text-gray-800">
                        Proses SPJ
                    </h6>

                    <div class="small text-muted mt-1">
                        Tahapan dokumen dari kebutuhan sampai BAST internal
                    </div>

                </div>

                <i class="fas fa-route text-primary"></i>

            </div>

        </div>


        <div class="card-body">

            <div class="row align-items-stretch">


                <!-- =================================================
                     STEP 1
                ================================================== -->

                <div class="col-lg-4 mb-4 mb-lg-0">

                    <div class="h-100 border rounded p-4">

                        <div class="d-flex align-items-center mb-3">

                            <div
                                class="d-flex align-items-center justify-content-center bg-primary rounded-circle mr-3"
                                style="width:42px;height:42px;"
                            >

                                <span class="text-white font-weight-bold">
                                    1
                                </span>

                            </div>

                            <div>

                                <div class="font-weight-bold text-gray-800">
                                    Input Kebutuhan
                                </div>

                                <div class="small text-muted">
                                    Tahap awal SPJ
                                </div>

                            </div>

                        </div>


                        <div class="d-flex align-items-end mb-2">

                            <div class="h2 mb-0 font-weight-bold text-primary">
                                <?= number_format($total_spj_kebutuhan); ?>
                            </div>

                            <div class="small text-muted ml-2 mb-1">
                                dokumen
                            </div>

                        </div>


                        <div class="progress" style="height:6px;">

                            <div
                                class="progress-bar bg-primary"
                                role="progressbar"
                                style="width:100%;"
                            ></div>

                        </div>

                    </div>

                </div>



                <!-- =================================================
                     STEP 2
                ================================================== -->

                <div class="col-lg-4 mb-4 mb-lg-0">

                    <div class="h-100 border rounded p-4">

                        <div class="d-flex align-items-center mb-3">

                            <div
                                class="d-flex align-items-center justify-content-center bg-warning rounded-circle mr-3"
                                style="width:42px;height:42px;"
                            >

                                <span class="text-white font-weight-bold">
                                    2
                                </span>

                            </div>

                            <div>

                                <div class="font-weight-bold text-gray-800">
                                    BAST Pemeriksaan
                                </div>

                                <div class="small text-muted">
                                    Pemeriksaan barang
                                </div>

                            </div>

                        </div>


                        <div class="d-flex align-items-end mb-2">

                            <div class="h2 mb-0 font-weight-bold text-warning">
                                <?= number_format($total_spj_pemeriksaan); ?>
                            </div>

                            <div class="small text-muted ml-2 mb-1">
                                dokumen
                            </div>

                        </div>


                        <div class="progress mb-2" style="height:6px;">

                            <div
                                class="progress-bar bg-warning"
                                role="progressbar"
                                style="width:<?= $persen_pemeriksaan; ?>%;"
                            ></div>

                        </div>


                        <div class="small text-muted">
                            <?= $persen_pemeriksaan; ?>% dari kebutuhan
                        </div>

                    </div>

                </div>



                <!-- =================================================
                     STEP 3
                ================================================== -->

                <div class="col-lg-4">

                    <div class="h-100 border rounded p-4">

                        <div class="d-flex align-items-center mb-3">

                            <div
                                class="d-flex align-items-center justify-content-center bg-success rounded-circle mr-3"
                                style="width:42px;height:42px;"
                            >

                                <span class="text-white font-weight-bold">
                                    3
                                </span>

                            </div>

                            <div>

                                <div class="font-weight-bold text-gray-800">
                                    BAST Internal
                                </div>

                                <div class="small text-muted">
                                    Tahap akhir SPJ
                                </div>

                            </div>

                        </div>


                        <div class="d-flex align-items-end mb-2">

                            <div class="h2 mb-0 font-weight-bold text-success">
                                <?= number_format($total_spj_internal); ?>
                            </div>

                            <div class="small text-muted ml-2 mb-1">
                                dokumen
                            </div>

                        </div>


                        <div class="progress mb-2" style="height:6px;">

                            <div
                                class="progress-bar bg-success"
                                role="progressbar"
                                style="width:<?= $persen_internal; ?>%;"
                            ></div>

                        </div>


                        <div class="small text-muted">
                            <?= $persen_internal; ?>% dari kebutuhan
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- =========================================================
         RINGKASAN PROSES
    ========================================================== -->

    <div class="row">


        <!-- STATUS DOKUMEN -->

        <div class="col-lg-8 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-header py-3">

                    <h6 class="m-0 font-weight-bold text-gray-800">
                        Ringkasan Dokumen
                    </h6>

                </div>


                <div class="card-body">


                    <!-- KEBUTUHAN -->

                    <div class="d-flex align-items-center mb-4">

                        <div
                            class="d-flex align-items-center justify-content-center bg-primary rounded-circle mr-3"
                            style="width:40px;height:40px;"
                        >

                            <i class="fas fa-file-alt text-white"></i>

                        </div>


                        <div class="flex-grow-1">

                            <div class="d-flex justify-content-between mb-1">

                                <span class="font-weight-bold">
                                    Kebutuhan
                                </span>

                                <span class="font-weight-bold">
                                    <?= number_format($total_spj_kebutuhan); ?>
                                </span>

                            </div>


                            <div class="progress" style="height:6px;">

                                <div
                                    class="progress-bar bg-primary"
                                    style="width:100%;"
                                ></div>

                            </div>

                        </div>

                    </div>



                    <!-- PEMERIKSAAN -->

                    <div class="d-flex align-items-center mb-4">

                        <div
                            class="d-flex align-items-center justify-content-center bg-warning rounded-circle mr-3"
                            style="width:40px;height:40px;"
                        >

                            <i class="fas fa-clipboard-check text-white"></i>

                        </div>


                        <div class="flex-grow-1">

                            <div class="d-flex justify-content-between mb-1">

                                <span class="font-weight-bold">
                                    BAST Pemeriksaan
                                </span>

                                <span class="font-weight-bold">
                                    <?= number_format($total_spj_pemeriksaan); ?>
                                </span>

                            </div>


                            <div class="progress" style="height:6px;">

                                <div
                                    class="progress-bar bg-warning"
                                    style="width:<?= $persen_pemeriksaan; ?>%;"
                                ></div>

                            </div>

                        </div>

                    </div>



                    <!-- INTERNAL -->

                    <div class="d-flex align-items-center">

                        <div
                            class="d-flex align-items-center justify-content-center bg-success rounded-circle mr-3"
                            style="width:40px;height:40px;"
                        >

                            <i class="fas fa-file-signature text-white"></i>

                        </div>


                        <div class="flex-grow-1">

                            <div class="d-flex justify-content-between mb-1">

                                <span class="font-weight-bold">
                                    BAST Internal
                                </span>

                                <span class="font-weight-bold">
                                    <?= number_format($total_spj_internal); ?>
                                </span>

                            </div>


                            <div class="progress" style="height:6px;">

                                <div
                                    class="progress-bar bg-success"
                                    style="width:<?= $persen_internal; ?>%;"
                                ></div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <!-- INFORMASI -->

        <div class="col-lg-4 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-header py-3">

                    <h6 class="m-0 font-weight-bold text-gray-800">
                        Informasi Sistem
                    </h6>

                </div>


                <div class="card-body">


                    <div class="text-center mb-4">

                        <div
                            class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle"
                            style="width:64px;height:64px;"
                        >

                            <i class="fas fa-box-open fa-2x text-primary"></i>

                        </div>

                    </div>


                    <div class="text-center">

                        <div class="font-weight-bold text-gray-800 mb-1">
                            BispVentory
                        </div>

                        <div class="small text-muted">
                            Sistem pengelolaan kebutuhan dan dokumen SPJ
                        </div>

                    </div>


                    <hr>


                    <div class="small">

                        <div class="d-flex justify-content-between mb-2">

                            <span class="text-muted">
                                Total kebutuhan
                            </span>

                            <strong>
                                <?= number_format($total_spj_kebutuhan); ?>
                            </strong>

                        </div>


                        <div class="d-flex justify-content-between mb-2">

                            <span class="text-muted">
                                Detail barang
                            </span>

                            <strong>
                                <?= number_format($total_barang); ?>
                            </strong>

                        </div>


                        <div class="d-flex justify-content-between">

                            <span class="text-muted">
                                BAST selesai
                            </span>

                            <strong class="text-success">
                                <?= number_format($total_spj_internal); ?>
                            </strong>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- =========================================================
         FOOTER INFO
    ========================================================== -->

    <div class="text-center text-muted small pb-3">

        <i class="fas fa-info-circle mr-1"></i>

        Dashboard menampilkan ringkasan data proses SPJ yang tersedia pada sistem.

    </div>


</div>