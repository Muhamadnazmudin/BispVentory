<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/*
|--------------------------------------------------------------------------
| STATISTIK
|--------------------------------------------------------------------------
*/

$total_kebutuhan = !empty($kebutuhan)
    ? count($kebutuhan)
    : 0;

$total_lengkap = 0;
$total_belum = 0;


/*
|--------------------------------------------------------------------------
| HITUNG KELENGKAPAN
|--------------------------------------------------------------------------
*/

if (!empty($kebutuhan)) {

    foreach ($kebutuhan as $row) {

        $id_kebutuhan =
            (int) $row->id_kebutuhan;


        /*
        |--------------------------------------------------------------------------
        | BAST PEMERIKSAAN
        |--------------------------------------------------------------------------
        */

        $bast_pemeriksaan =
            $this->Spj_model
                ->get_bast_pemeriksaan_by_kebutuhan(
                    $id_kebutuhan
                );


        $ada_pemeriksaan =
            !empty($bast_pemeriksaan);


        /*
        |--------------------------------------------------------------------------
        | BAST INTERNAL
        |--------------------------------------------------------------------------
        */

        $ada_internal =
            !empty(
                $row->nomor_bast_internal
            );


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        if (
            $ada_pemeriksaan &&
            $ada_internal
        ) {

            $total_lengkap++;

        }
        else {

            $total_belum++;

        }

    }

}

?>


<div class="container-fluid">


    <!-- =========================================================
         HEADER
    ========================================================== -->

    <div class="d-flex align-items-center mb-4">

        <div class="spj-header-icon bg-primary mr-3">

            <i class="fas fa-file-archive text-white"></i>

        </div>

        <div>

            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
                Download SPJ Full
            </h1>

            <div class="small text-muted">
                Download seluruh dokumen SPJ sekaligus dalam satu file ZIP.
            </div>

        </div>

    </div>



    <!-- =========================================================
         FLASH MESSAGE
    ========================================================== -->

    <?php if ($this->session->flashdata('success')): ?>

        <div class="alert alert-success border-left-success shadow-sm">

            <i class="fas fa-check-circle mr-1"></i>

            <?= html_escape(
                $this->session->flashdata('success')
            ) ?>

        </div>

    <?php endif; ?>


    <?php if ($this->session->flashdata('error')): ?>

        <div class="alert alert-danger border-left-danger shadow-sm">

            <i class="fas fa-exclamation-circle mr-1"></i>

            <?= html_escape(
                $this->session->flashdata('error')
            ) ?>

        </div>

    <?php endif; ?>



    <!-- =========================================================
         STATISTIK
    ========================================================== -->

    <div class="row mb-2">


        <!-- TOTAL -->

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="card stat-card stat-primary shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="stat-label text-primary">
                                Total SPJ
                            </div>

                            <div class="stat-number">
                                <?= number_format(
                                    $total_kebutuhan
                                ) ?>
                            </div>

                            <div class="stat-desc">
                                Pengajuan kebutuhan
                            </div>

                        </div>

                        <div class="stat-icon stat-icon-primary">

                            <i class="fas fa-file-alt"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <!-- LENGKAP -->

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="card stat-card stat-success shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="stat-label text-success">
                                Siap Download
                            </div>

                            <div class="stat-number">
                                <?= number_format(
                                    $total_lengkap
                                ) ?>
                            </div>

                            <div class="stat-desc">
                                Dokumen SPJ lengkap
                            </div>

                        </div>

                        <div class="stat-icon stat-icon-success">

                            <i class="fas fa-check-circle"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <!-- BELUM LENGKAP -->

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="card stat-card stat-warning shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="stat-label text-warning">
                                Belum Lengkap
                            </div>

                            <div class="stat-number">
                                <?= number_format(
                                    $total_belum
                                ) ?>
                            </div>

                            <div class="stat-desc">
                                Masih menunggu dokumen
                            </div>

                        </div>

                        <div class="stat-icon stat-icon-warning">

                            <i class="fas fa-clock"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- =========================================================
         CARD DAFTAR
    ========================================================== -->

    <div class="card shadow-sm mb-4">


        <!-- =====================================================
             HEADER
        ====================================================== -->

        <div class="card-header bg-white py-3">

            <div class="d-flex align-items-center justify-content-between">

                <div>

                    <h6 class="mb-1 font-weight-bold text-gray-800">

                        <i class="fas fa-file-archive text-primary mr-1"></i>

                        Daftar SPJ

                    </h6>

                    <div class="small text-muted">
                        Download seluruh dokumen SPJ dalam satu file ZIP.
                    </div>

                </div>


                <span class="badge badge-light border px-3 py-2">

                    <span id="jumlahHasil">
                        <?= number_format(
                            $total_kebutuhan
                        ) ?>
                    </span>

                    data

                </span>

            </div>

        </div>



        <!-- =====================================================
             BODY
        ====================================================== -->

        <div class="card-body">


            <!-- =================================================
                 INFO
            ================================================== -->

            <div class="download-info mb-4">

                <div class="download-info-icon">

                    <i class="fas fa-file-archive"></i>

                </div>

                <div>

                    <div class="font-weight-bold text-gray-700">

                        Download SPJ Full

                    </div>

                    <div class="small text-muted">

                        Tombol download hanya tersedia apabila
                        BAST Pemeriksaan dan BAST Internal sudah lengkap.

                    </div>

                </div>

            </div>



            <!-- =================================================
                 FILTER
            ================================================== -->

            <div class="filter-panel mb-4">

                <div class="row align-items-start">


                    <!-- PENCARIAN -->

                    <div class="col-lg-6 col-md-7 mb-3 mb-lg-0">

                        <label
                            for="filterPencarian"
                            class="filter-label"
                        >
                            Pencarian
                        </label>

                        <div class="input-group">

                            <div class="input-group-prepend">

                                <span class="input-group-text">

                                    <i class="fas fa-search"></i>

                                </span>

                            </div>

                            <input
                                type="text"
                                id="filterPencarian"
                                class="form-control"
                                placeholder="Nomor surat / invoice / nomor pesanan..."
                                autocomplete="off"
                            >

                        </div>

                        <div class="filter-help">

                            Pencarian berdasarkan nomor surat,
                            invoice, dan nomor pesanan.

                        </div>

                    </div>



                    <!-- BULAN -->

                    <div class="col-lg-3 col-md-3 mb-3 mb-lg-0">

                        <label
                            for="filterBulan"
                            class="filter-label"
                        >
                            Bulan Kebutuhan
                        </label>

                        <select
                            id="filterBulan"
                            class="form-control"
                        >

                            <option value="">
                                Semua Bulan
                            </option>

                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>

                        </select>

                    </div>



                    <!-- RESET -->

                    <div class="col-lg-2 col-md-2">

                        <label class="filter-label invisible">
                            Reset
                        </label>

                        <button
                            type="button"
                            id="resetFilter"
                            class="btn btn-secondary btn-block"
                        >

                            <i class="fas fa-sync-alt mr-1"></i>

                            Reset

                        </button>

                    </div>

                </div>

            </div>



            <!-- =================================================
                 INFO FILTER
            ================================================== -->

            <div
                id="infoFilter"
                class="filter-result-info mb-3"
                style="display:none;"
            >

                <i class="fas fa-filter mr-1"></i>

                Menampilkan
                <strong id="jumlahFilter">
                    0
                </strong>
                dari
                <strong>
                    <?= number_format(
                        $total_kebutuhan
                    ) ?>
                </strong>
                data.

            </div>



            <?php if (!empty($kebutuhan)): ?>


                <!-- =================================================
                     TABLE
                ================================================== -->

                <div class="table-container">

                    <div class="table-responsive">

                        <table
                            class="table table-hover mb-0 table-download-spj"
                            id="tabelDownloadSpj"
                        >

                            <thead>

                                <tr>

                                    <th
                                        width="55"
                                        class="text-center"
                                    >
                                        No
                                    </th>

                                    <th width="17%">
                                        Nomor Surat
                                    </th>

                                    <th width="11%">
                                        Tanggal
                                    </th>

                                    <th width="19%">
                                        Perihal
                                    </th>

                                    <th width="17%">
                                        Penyedia
                                    </th>

                                    <th width="24%">
                                        Kelengkapan
                                    </th>

                                    <th
                                        width="120"
                                        class="text-center"
                                    >
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            <tbody>


                            <?php

                            $no = 1;

                            foreach ($kebutuhan as $row):


                                $id_kebutuhan =
                                    (int) $row->id_kebutuhan;


                                /*
                                |--------------------------------------------------------------------------
                                | BAST PEMERIKSAAN
                                |--------------------------------------------------------------------------
                                */

                                $bast_pemeriksaan =
                                    $this->Spj_model
                                        ->get_bast_pemeriksaan_by_kebutuhan(
                                            $id_kebutuhan
                                        );


                                $ada_pemeriksaan =
                                    !empty(
                                        $bast_pemeriksaan
                                    );


                                /*
                                |--------------------------------------------------------------------------
                                | BAST INTERNAL
                                |--------------------------------------------------------------------------
                                */

                                $ada_internal =
                                    !empty(
                                        $row->nomor_bast_internal
                                    );


                                /*
                                |--------------------------------------------------------------------------
                                | LENGKAP
                                |--------------------------------------------------------------------------
                                */

                                $lengkap =
                                    (
                                        $ada_pemeriksaan &&
                                        $ada_internal
                                    );


                                /*
                                |--------------------------------------------------------------------------
                                | TANGGAL
                                |--------------------------------------------------------------------------
                                */

                                $tanggal =
                                    !empty($row->tanggal)
                                        ? trim(
                                            $row->tanggal
                                        )
                                        : '';


                                $bulan_data =
                                    $tanggal
                                        ? date(
                                            'm',
                                            strtotime($tanggal)
                                        )
                                        : '';


                                /*
                                |--------------------------------------------------------------------------
                                | SEARCH
                                |--------------------------------------------------------------------------
                                */

                                $data_search =
                                    strtolower(
                                        trim(
                                            ($row->nomor_surat ?? '') .
                                            ' ' .
                                            ($row->nomor_invoice ?? '') .
                                            ' ' .
                                            ($row->nomor_pesanan ?? '')
                                        )
                                    );

                            ?>


                                <tr
                                    class="data-download-spj"
                                    data-search="<?= html_escape(
                                        $data_search
                                    ) ?>"
                                    data-bulan="<?= html_escape(
                                        $bulan_data
                                    ) ?>"
                                >


                                    <!-- =================================
                                         NO
                                    ================================== -->

                                    <td class="text-center align-middle">

                                        <span class="nomor-urut">
                                            <?= $no++ ?>
                                        </span>

                                    </td>



                                    <!-- =================================
                                         NOMOR SURAT
                                    ================================== -->

                                    <td class="align-middle">

                                        <?php if (
                                            !empty(
                                                $row->nomor_surat
                                            )
                                        ): ?>

                                            <div class="main-data">

                                                <?= html_escape(
                                                    $row->nomor_surat
                                                ) ?>

                                            </div>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                -
                                            </span>

                                        <?php endif; ?>

                                    </td>



                                    <!-- =================================
                                         TANGGAL
                                    ================================== -->

                                    <td class="align-middle">

                                        <?php if ($tanggal): ?>

                                            <div class="date-data">

                                                <i class="far fa-calendar-alt mr-1"></i>

                                                <?= date(
                                                    'd-m-Y',
                                                    strtotime($tanggal)
                                                ) ?>

                                            </div>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                -
                                            </span>

                                        <?php endif; ?>

                                    </td>



                                    <!-- =================================
                                         PERIHAL
                                    ================================== -->

                                    <td class="align-middle">

                                        <?php if (
                                            !empty(
                                                $row->perihal
                                            )
                                        ): ?>

                                            <div
                                                class="main-data text-truncate"
                                                style="max-width:250px;"
                                                title="<?= html_escape(
                                                    $row->perihal
                                                ) ?>"
                                            >

                                                <?= html_escape(
                                                    $row->perihal
                                                ) ?>

                                            </div>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                -
                                            </span>

                                        <?php endif; ?>

                                    </td>



                                    <!-- =================================
                                         PENYEDIA
                                    ================================== -->

                                    <td class="align-middle">

                                        <?php if (
                                            !empty(
                                                $row->nama_penyedia
                                            )
                                        ): ?>

                                            <div
                                                class="main-data text-truncate"
                                                style="max-width:220px;"
                                                title="<?= html_escape(
                                                    $row->nama_penyedia
                                                ) ?>"
                                            >

                                                <?= html_escape(
                                                    $row->nama_penyedia
                                                ) ?>

                                            </div>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                -
                                            </span>

                                        <?php endif; ?>

                                    </td>



                                    <!-- =================================
                                         KELENGKAPAN
                                    ================================== -->

                                    <td class="align-middle">

                                        <div class="completeness-list">


                                            <!-- INPUT KEBUTUHAN -->

                                            <span class="completion-item complete">

                                                <i class="fas fa-check"></i>

                                                Input Kebutuhan

                                            </span>



                                            <!-- BAST PEMERIKSAAN -->

                                            <?php if (
                                                $ada_pemeriksaan
                                            ): ?>

                                                <span class="completion-item complete">

                                                    <i class="fas fa-check"></i>

                                                    BAST Pemeriksaan

                                                </span>

                                            <?php else: ?>

                                                <span class="completion-item incomplete">

                                                    <i class="fas fa-times"></i>

                                                    BAST Pemeriksaan

                                                </span>

                                            <?php endif; ?>



                                            <!-- BAST INTERNAL -->

                                            <?php if (
                                                $ada_internal
                                            ): ?>

                                                <span class="completion-item complete">

                                                    <i class="fas fa-check"></i>

                                                    BAST Internal

                                                </span>

                                            <?php else: ?>

                                                <span class="completion-item incomplete">

                                                    <i class="fas fa-times"></i>

                                                    BAST Internal

                                                </span>

                                            <?php endif; ?>


                                        </div>

                                    </td>



                                    <!-- =================================
                                         AKSI
                                    ================================== -->

                                    <td class="text-center align-middle">

                                        <?php if ($lengkap): ?>

                                            <a
                                                href="<?= site_url(
                                                    'spj/download_spj_full_file/' .
                                                    $id_kebutuhan
                                                ) ?>"
                                                class="btn btn-primary btn-sm btn-download"
                                                title="Download SPJ Full"
                                            >

                                                <i class="fas fa-download mr-1"></i>

                                                Download

                                            </a>

                                        <?php else: ?>

                                            <button
                                                type="button"
                                                class="btn btn-secondary btn-sm btn-download"
                                                disabled
                                                title="Dokumen belum lengkap"
                                            >

                                                <i class="fas fa-lock mr-1"></i>

                                                Belum Lengkap

                                            </button>

                                        <?php endif; ?>

                                    </td>


                                </tr>


                            <?php endforeach; ?>


                            <!-- =================================================
                                 DATA TIDAK DITEMUKAN
                            ================================================== -->

                            <tr
                                id="dataTidakDitemukan"
                                style="display:none;"
                            >

                                <td
                                    colspan="7"
                                    class="text-center py-5"
                                >

                                    <div class="empty-icon">

                                        <i class="fas fa-search"></i>

                                    </div>

                                    <div class="font-weight-bold text-gray-700 mt-3">

                                        Data tidak ditemukan

                                    </div>

                                    <div class="small text-muted mt-1">

                                        Coba ubah kata pencarian atau filter bulan.

                                    </div>

                                </td>

                            </tr>


                            </tbody>

                        </table>

                    </div>

                </div>



                <!-- =================================================
                     PAGINATION
                ================================================== -->

                <div
                    id="paginationWrapper"
                    class="pagination-wrapper"
                    style="display:none;"
                >

                    <div class="pagination-info">

                        Menampilkan

                        <strong id="paginationStart">
                            0
                        </strong>

                        -

                        <strong id="paginationEnd">
                            0
                        </strong>

                        dari

                        <strong id="paginationTotal">
                            0
                        </strong>

                        data

                    </div>


                    <nav aria-label="Pagination Download SPJ">

                        <ul
                            id="pagination"
                            class="pagination pagination-sm mb-0"
                        >
                        </ul>

                    </nav>

                </div>


            <?php else: ?>


                <!-- =================================================
                     EMPTY STATE
                ================================================== -->

                <div class="empty-state text-center">

                    <div class="empty-icon">

                        <i class="fas fa-folder-open"></i>

                    </div>

                    <h6 class="font-weight-bold text-gray-800 mt-3 mb-1">

                        Belum ada data Input Kebutuhan

                    </h6>

                    <div class="small text-muted">

                        Data kebutuhan akan muncul di sini
                        untuk proses download SPJ Full.

                    </div>

                </div>


            <?php endif; ?>


        </div>

    </div>



    <!-- =========================================================
         INFO ALUR
    ========================================================== -->

    <div class="card border-left-info shadow-sm mb-4">

        <div class="card-body py-3">

            <div class="d-flex align-items-center">

                <i class="fas fa-info-circle text-info mr-3 fa-lg"></i>

                <div class="small text-muted">

                    <strong class="text-gray-700">
                        Kelengkapan SPJ:
                    </strong>

                    Input Kebutuhan

                    <i class="fas fa-chevron-right mx-2"></i>

                    BAST Pemeriksaan

                    <i class="fas fa-chevron-right mx-2"></i>

                    BAST Internal

                    <i class="fas fa-chevron-right mx-2"></i>

                    Download SPJ Full.

                </div>

            </div>

        </div>

    </div>


</div>



<!-- =============================================================
     STYLE
============================================================== -->

<style>


/*
|--------------------------------------------------------------------------
| HEADER
|--------------------------------------------------------------------------
*/

.spj-header-icon {

    width: 44px;
    height: 44px;

    min-width: 44px;

    border-radius: 12px;

    display: flex;

    align-items: center;
    justify-content: center;

    box-shadow:
        0 3px 8px rgba(0,0,0,.08);

}


/*
|--------------------------------------------------------------------------
| STAT CARD
|--------------------------------------------------------------------------
*/

.stat-card {

    border-left-width: 4px;

    transition:
        transform .15s ease,
        box-shadow .15s ease;

}


.stat-card:hover {

    transform: translateY(-2px);

    box-shadow:
        0 .35rem .9rem rgba(0,0,0,.08) !important;

}


.stat-primary {

    border-left-color: #4e73df;

}


.stat-success {

    border-left-color: #1cc88a;

}


.stat-warning {

    border-left-color: #f6c23e;

}


.stat-label {

    font-size: 10px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .04em;

}


.stat-number {

    font-size: 24px;

    font-weight: 700;

    line-height: 1.2;

    color: #3a3b45;

}


.stat-desc {

    font-size: 12px;

    color: #858796;

    margin-top: 4px;

}


.stat-icon {

    width: 44px;
    height: 44px;

    border-radius: 11px;

    display: flex;

    align-items: center;
    justify-content: center;

    font-size: 18px;

}


.stat-icon-primary {

    background: #e8efff;

    color: #4e73df;

}


.stat-icon-success {

    background: #e8f7ef;

    color: #1cc88a;

}


.stat-icon-warning {

    background: #fff5df;

    color: #f6c23e;

}


/*
|--------------------------------------------------------------------------
| DOWNLOAD INFO
|--------------------------------------------------------------------------
*/

.download-info {

    display: flex;

    align-items: center;

    padding: 12px 14px;

    background: #f8f9fc;

    border: 1px solid #eaecf4;

    border-radius: 8px;

}


.download-info-icon {

    width: 36px;
    height: 36px;

    min-width: 36px;

    border-radius: 9px;

    background: #e8efff;

    color: #4e73df;

    display: flex;

    align-items: center;
    justify-content: center;

    margin-right: 10px;

}


/*
|--------------------------------------------------------------------------
| FILTER
|--------------------------------------------------------------------------
*/

.filter-panel {

    background: #f8f9fc;

    border: 1px solid #eaecf4;

    border-radius: 10px;

    padding: 18px;

}


.filter-label {

    display: block;

    font-size: 12px;

    font-weight: 700;

    color: #5a5c69;

    margin-bottom: 6px;

}


.filter-panel .form-control,
.filter-panel .input-group-text,
.filter-panel .btn {

    height: 46px;

}


.filter-panel .input-group-text {

    width: 48px;

    justify-content: center;

    background: #fff;

    color: #858796;

}


.filter-panel .form-control {

    font-size: 14px;

}


.filter-help {

    font-size: 11px;

    color: #858796;

    margin-top: 5px;

}


.filter-result-info {

    font-size: 12px;

    color: #858796;

}


/*
|--------------------------------------------------------------------------
| TABLE
|--------------------------------------------------------------------------
*/

.table-container {

    border: 1px solid #eaecf4;

    border-radius: 8px;

    overflow: hidden;

}


.table-download-spj {

    font-size: 13px;

}


.table-download-spj thead th {

    background: #f8f9fc;

    color: #5a5c69;

    font-size: 10px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .035em;

    border-top: 0;

    border-bottom: 1px solid #e3e6f0;

    padding: 13px 12px;

    vertical-align: middle;

    white-space: nowrap;

}


.table-download-spj tbody td {

    padding: 13px 12px;

    border-color: #eaecf4;

    vertical-align: middle;

}


.table-download-spj tbody tr {

    transition:
        background-color .15s ease;

}


.table-download-spj tbody tr:hover {

    background-color: #fafbfe;

}


/*
|--------------------------------------------------------------------------
| DATA
|--------------------------------------------------------------------------
*/

.main-data {

    font-weight: 700;

    color: #3a3b45;

}


.date-data {

    font-size: 12px;

    font-weight: 600;

    color: #6e707e;

    white-space: nowrap;

}


/*
|--------------------------------------------------------------------------
| KELENGKAPAN
|--------------------------------------------------------------------------
*/

.completeness-list {

    display: flex;

    flex-wrap: wrap;

    gap: 5px;

}


.completion-item {

    display: inline-flex;

    align-items: center;

    border-radius: 6px;

    padding: 4px 7px;

    font-size: 10px;

    font-weight: 600;

    white-space: nowrap;

}


.completion-item i {

    margin-right: 4px;

    font-size: 9px;

}


.completion-item.complete {

    background: #e8f7ef;

    color: #198754;

}


.completion-item.incomplete {

    background: #fdecec;

    color: #dc3545;

}


/*
|--------------------------------------------------------------------------
| DOWNLOAD BUTTON
|--------------------------------------------------------------------------
*/

.btn-download {

    white-space: nowrap;

    min-width: 100px;

}


/*
|--------------------------------------------------------------------------
| PAGINATION
|--------------------------------------------------------------------------
*/

.pagination-wrapper {

    display: flex;

    align-items: center;

    justify-content: space-between;

    border-top: 1px solid #eaecf4;

    padding-top: 15px;

    margin-top: 15px;

}


.pagination-info {

    font-size: 12px;

    color: #858796;

}


.pagination .page-link {

    min-width: 34px;

    height: 34px;

    padding: 0 8px;

    display: flex;

    align-items: center;
    justify-content: center;

    font-size: 12px;

    font-weight: 600;

    color: #5a5c69;

    border-color: #e3e6f0;

    background: #fff;

}


/*
|--------------------------------------------------------------------------
| EMPTY
|--------------------------------------------------------------------------
*/

.empty-icon {

    width: 64px;
    height: 64px;

    margin-left: auto;
    margin-right: auto;

    border-radius: 50%;

    background: #f8f9fc;

    color: #b7b9cc;

    display: flex;

    align-items: center;
    justify-content: center;

    font-size: 24px;

}


.empty-state {

    padding: 50px 20px;

}


/*
|--------------------------------------------------------------------------
| MOBILE
|--------------------------------------------------------------------------
*/

@media (max-width: 767.98px) {


    .spj-header-icon {

        width: 40px;
        height: 40px;

        min-width: 40px;

    }


    .spj-header-icon + div h1 {

        font-size: 1.35rem;

    }


    .filter-panel {

        padding: 14px;

    }


    .download-info {

        align-items: flex-start;

    }


    .table-container .table-responsive {

        overflow-x: auto;

        -webkit-overflow-scrolling: touch;

    }


    .table-download-spj {

        min-width: 1050px;

    }


    .table-download-spj th,
    .table-download-spj td {

        white-space: nowrap;

    }


    .completeness-list {

        flex-wrap: nowrap;

    }


    .pagination-wrapper {

        display: block;

        text-align: center;

    }


    .pagination-info {

        margin-bottom: 12px;

    }


    .pagination {

        justify-content: center;

    }

}

</style>



<!-- =============================================================
     FILTER + PAGINATION SCRIPT
============================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {


    /*
    |--------------------------------------------------------------------------
    | ELEMENT
    |--------------------------------------------------------------------------
    */

    const input =
        document.getElementById(
            'filterPencarian'
        );


    const bulan =
        document.getElementById(
            'filterBulan'
        );


    const reset =
        document.getElementById(
            'resetFilter'
        );


    const jumlahHasil =
        document.getElementById(
            'jumlahHasil'
        );


    const infoFilter =
        document.getElementById(
            'infoFilter'
        );


    const jumlahFilter =
        document.getElementById(
            'jumlahFilter'
        );


    const emptyRow =
        document.getElementById(
            'dataTidakDitemukan'
        );


    const paginationWrapper =
        document.getElementById(
            'paginationWrapper'
        );


    const pagination =
        document.getElementById(
            'pagination'
        );


    const paginationStart =
        document.getElementById(
            'paginationStart'
        );


    const paginationEnd =
        document.getElementById(
            'paginationEnd'
        );


    const paginationTotal =
        document.getElementById(
            'paginationTotal'
        );


    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */

    const rows =
        Array.from(
            document.querySelectorAll(
                '.data-download-spj'
            )
        );


    /*
    |--------------------------------------------------------------------------
    | CONFIG
    |--------------------------------------------------------------------------
    */

    const perPage = 20;

    let currentPage = 1;

    let filteredRows = [];


    /*
    |--------------------------------------------------------------------------
    | APPLY FILTER
    |--------------------------------------------------------------------------
    */

    function applyFilter()
    {

        const keyword =
            input
                ? input.value
                    .toLowerCase()
                    .trim()
                : '';


        const selectedMonth =
            bulan
                ? bulan.value
                : '';


        filteredRows =
            rows.filter(
                function (row)
                {

                    const search =
                        row.dataset.search || '';


                    const month =
                        row.dataset.bulan || '';


                    const matchSearch =
                        keyword === '' ||
                        search.includes(
                            keyword
                        );


                    const matchMonth =
                        selectedMonth === '' ||
                        month === selectedMonth;


                    return (
                        matchSearch &&
                        matchMonth
                    );

                }
            );


        currentPage = 1;


        render();

    }


    /*
    |--------------------------------------------------------------------------
    | RENDER
    |--------------------------------------------------------------------------
    */

    function render()
    {

        const total =
            filteredRows.length;


        /*
        |--------------------------------------------------------------------------
        | SEMBUNYIKAN DATA
        |--------------------------------------------------------------------------
        */

        rows.forEach(
            function (row)
            {

                row.style.display =
                    'none';

            }
        );


        /*
        |--------------------------------------------------------------------------
        | JUMLAH
        |--------------------------------------------------------------------------
        */

        if (jumlahHasil) {

            jumlahHasil.textContent =
                total;

        }


        if (jumlahFilter) {

            jumlahFilter.textContent =
                total;

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER INFO
        |--------------------------------------------------------------------------
        */

        const filterAktif =
            (
                input &&
                input.value.trim() !== ''
            ) ||
            (
                bulan &&
                bulan.value !== ''
            );


        if (infoFilter) {

            infoFilter.style.display =
                filterAktif
                    ? ''
                    : 'none';

        }


        /*
        |--------------------------------------------------------------------------
        | DATA KOSONG
        |--------------------------------------------------------------------------
        */

        if (total === 0) {

            if (emptyRow) {

                emptyRow.style.display =
                    '';

            }


            if (paginationWrapper) {

                paginationWrapper.style.display =
                    'none';

            }

            return;

        }


        if (emptyRow) {

            emptyRow.style.display =
                'none';

        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL PAGE
        |--------------------------------------------------------------------------
        */

        const totalPages =
            Math.ceil(
                total / perPage
            );


        if (
            currentPage >
            totalPages
        ) {

            currentPage =
                totalPages;

        }


        /*
        |--------------------------------------------------------------------------
        | RANGE
        |--------------------------------------------------------------------------
        */

        const startIndex =
            (
                currentPage - 1
            ) * perPage;


        const endIndex =
            Math.min(
                startIndex + perPage,
                total
            );


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN DATA
        |--------------------------------------------------------------------------
        */

        for (
            let i = startIndex;
            i < endIndex;
            i++
        ) {

            const row =
                filteredRows[i];


            row.style.display =
                '';


            const nomor =
                row.querySelector(
                    '.nomor-urut'
                );


            if (nomor) {

                nomor.textContent =
                    i + 1;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | INFO
        |--------------------------------------------------------------------------
        */

        if (paginationStart) {

            paginationStart.textContent =
                startIndex + 1;

        }


        if (paginationEnd) {

            paginationEnd.textContent =
                endIndex;

        }


        if (paginationTotal) {

            paginationTotal.textContent =
                total;

        }


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        renderPagination(
            totalPages
        );

    }


    /*
    |--------------------------------------------------------------------------
    | RENDER PAGINATION
    |--------------------------------------------------------------------------
    */

    function renderPagination(
        totalPages
    )
    {

        if (
            !pagination ||
            !paginationWrapper
        ) {

            return;

        }


        pagination.innerHTML =
            '';


        /*
        |--------------------------------------------------------------------------
        | HANYA SATU HALAMAN
        |--------------------------------------------------------------------------
        */

        if (totalPages <= 1) {

            paginationWrapper.style.display =
                'none';

            return;

        }


        paginationWrapper.style.display =
            'flex';


        /*
        |--------------------------------------------------------------------------
        | PREVIOUS
        |--------------------------------------------------------------------------
        */

        pagination.appendChild(
            createPageButton(
                '‹',
                currentPage - 1,
                currentPage === 1
            )
        );


        /*
        |--------------------------------------------------------------------------
        | PAGE NUMBER
        |--------------------------------------------------------------------------
        */

        let startPage = 1;

        let endPage = totalPages;


        if (totalPages > 7) {

            if (currentPage <= 4) {

                startPage = 1;

                endPage = 7;

            }
            else if (
                currentPage >=
                totalPages - 3
            ) {

                startPage =
                    totalPages - 6;

                endPage =
                    totalPages;

            }
            else {

                startPage =
                    currentPage - 3;

                endPage =
                    currentPage + 3;

            }

        }


        for (
            let page = startPage;
            page <= endPage;
            page++
        ) {

            pagination.appendChild(
                createPageButton(
                    page,
                    page,
                    false,
                    page === currentPage
                )
            );

        }


        /*
        |--------------------------------------------------------------------------
        | NEXT
        |--------------------------------------------------------------------------
        */

        pagination.appendChild(
            createPageButton(
                '›',
                currentPage + 1,
                currentPage === totalPages
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CREATE PAGE BUTTON
    |--------------------------------------------------------------------------
    */

    function createPageButton(
        label,
        page,
        disabled,
        active
    )
    {

        const li =
            document.createElement(
                'li'
            );


        li.className =
            'page-item';


        if (disabled) {

            li.classList.add(
                'disabled'
            );

        }


        if (active) {

            li.classList.add(
                'active'
            );

        }


        const button =
            document.createElement(
                'button'
            );


        button.type =
            'button';


        button.className =
            'page-link';


        button.textContent =
            label;


        button.disabled =
            disabled;


        if (!disabled) {

            button.addEventListener(
                'click',
                function ()
                {

                    currentPage =
                        page;


                    render();


                    scrollToTable();

                }
            );

        }


        li.appendChild(
            button
        );


        return li;

    }


    /*
    |--------------------------------------------------------------------------
    | SCROLL KE TABEL
    |--------------------------------------------------------------------------
    */

    function scrollToTable()
    {

        const table =
            document.getElementById(
                'tabelDownloadSpj'
            );


        if (!table) {

            return;

        }


        const position =
            table.getBoundingClientRect().top +
            window.pageYOffset -
            120;


        window.scrollTo({

            top: position,

            behavior: 'smooth'

        });

    }


    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    if (input) {

        input.addEventListener(
            'input',
            applyFilter
        );

    }


    /*
    |--------------------------------------------------------------------------
    | BULAN
    |--------------------------------------------------------------------------
    */

    if (bulan) {

        bulan.addEventListener(
            'change',
            applyFilter
        );

    }


    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    if (reset) {

        reset.addEventListener(
            'click',
            function ()
            {

                if (input) {

                    input.value =
                        '';

                }


                if (bulan) {

                    bulan.value =
                        '';

                }


                applyFilter();

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | INITIAL
    |--------------------------------------------------------------------------
    */

    applyFilter();

});

</script>