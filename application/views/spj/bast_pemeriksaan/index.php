<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/*
|--------------------------------------------------------------------------
| MAP BAST
|--------------------------------------------------------------------------
*/

$bast_map = array();

if (!empty($bast)) {

    foreach ($bast as $item) {

        $bast_map[(int) $item->id_kebutuhan] = $item;

    }

}


/*
|--------------------------------------------------------------------------
| STATISTIK
|--------------------------------------------------------------------------
*/

$total_kebutuhan = !empty($kebutuhan)
    ? count($kebutuhan)
    : 0;

$total_bast = count($bast_map);

$total_belum = max(
    0,
    $total_kebutuhan - $total_bast
);

?>


<div class="container-fluid">


    <!-- =========================================================
         HEADER
    ========================================================== -->

    <div class="d-flex align-items-center mb-4">

        <div class="spj-header-icon bg-primary mr-3">

            <i class="fas fa-clipboard-check text-white"></i>

        </div>

        <div>

            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
                BAST Pemeriksaan
            </h1>

            <div class="small text-muted">
                Pemeriksaan barang berdasarkan kebutuhan SPJ.
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
                                Total Kebutuhan
                            </div>

                            <div class="stat-number">
                                <?= number_format($total_kebutuhan) ?>
                            </div>

                            <div class="stat-desc">
                                Pengajuan kebutuhan SPJ
                            </div>

                        </div>

                        <div class="stat-icon stat-icon-primary">

                            <i class="fas fa-file-alt"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <!-- SUDAH -->

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="card stat-card stat-success shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="stat-label text-success">
                                Sudah Dibuat
                            </div>

                            <div class="stat-number">
                                <?= number_format($total_bast) ?>
                            </div>

                            <div class="stat-desc">
                                BAST pemeriksaan
                            </div>

                        </div>

                        <div class="stat-icon stat-icon-success">

                            <i class="fas fa-check-circle"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <!-- BELUM -->

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="card stat-card stat-warning shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="stat-label text-warning">
                                Belum Dibuat
                            </div>

                            <div class="stat-number">
                                <?= number_format($total_belum) ?>
                            </div>

                            <div class="stat-desc">
                                Menunggu pemeriksaan
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
         DAFTAR BAST
    ========================================================== -->

    <div class="card shadow-sm mb-4">


        <!-- =====================================================
             HEADER CARD
        ====================================================== -->

        <div class="card-header bg-white py-3">

            <div class="d-flex align-items-center justify-content-between">

                <div>

                    <h6 class="mb-1 font-weight-bold text-gray-800">

                        <i class="fas fa-clipboard-list text-primary mr-1"></i>

                        Daftar BAST Pemeriksaan

                    </h6>

                    <div class="small text-muted">
                        Kelola pemeriksaan untuk setiap kebutuhan SPJ.
                    </div>

                </div>


                <span class="badge badge-light border px-3 py-2">

                    <span id="jumlahHasil">
                        <?= number_format($total_kebutuhan) ?>
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

                            Cari berdasarkan nomor surat,
                            invoice, atau nomor pesanan.

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
                <strong id="jumlahFilter">0</strong>
                dari
                <strong>
                    <?= number_format($total_kebutuhan) ?>
                </strong>
                data.

            </div>



            <!-- =================================================
                 TABLE
            ================================================== -->

            <?php if (!empty($kebutuhan)): ?>

                <div class="table-container">

                    <div class="table-responsive">

                        <table
                            class="table table-hover mb-0 table-bast"
                            id="tabelBastPemeriksaan"
                        >

                            <thead>

                                <tr>

                                    <th
                                        width="55"
                                        class="text-center"
                                    >
                                        No
                                    </th>

                                    <th width="20%">
                                        Dokumen BAST
                                    </th>

                                    <th width="14%">
                                        Nomor Surat
                                    </th>

                                    <th width="13%">
                                        Invoice
                                    </th>

                                    <th width="13%">
                                        Nomor Pesanan
                                    </th>

                                    <th>
                                        Penyedia
                                    </th>

                                    <th width="13%">
                                        Tanggal Pemeriksaan
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
                                | BAST
                                |--------------------------------------------------------------------------
                                */

                                $bastRow =
                                    isset(
                                        $bast_map[$id_kebutuhan]
                                    )
                                        ? $bast_map[$id_kebutuhan]
                                        : null;


                                /*
                                |--------------------------------------------------------------------------
                                | DATA BAST
                                |--------------------------------------------------------------------------
                                */

                                $nomor_bast =
                                    $bastRow &&
                                    !empty($bastRow->nomor_bast)
                                        ? trim(
                                            $bastRow->nomor_bast
                                        )
                                        : '';


                                $nomor_keputusan =
                                    $bastRow &&
                                    !empty($bastRow->nomor_keputusan)
                                        ? trim(
                                            $bastRow->nomor_keputusan
                                        )
                                        : '';


                                $tanggal_pemeriksaan =
                                    $bastRow &&
                                    !empty(
                                        $bastRow->tanggal_pemeriksaan
                                    )
                                        ? trim(
                                            $bastRow->tanggal_pemeriksaan
                                        )
                                        : '';


                                /*
                                |--------------------------------------------------------------------------
                                | TANGGAL KEBUTUHAN
                                |--------------------------------------------------------------------------
                                */

                                $tanggal_kebutuhan =
                                    !empty($row->tanggal)
                                        ? trim($row->tanggal)
                                        : '';


                                $bulan_kebutuhan =
                                    $tanggal_kebutuhan
                                        ? date(
                                            'm',
                                            strtotime(
                                                $tanggal_kebutuhan
                                            )
                                        )
                                        : '';


                                /*
                                |--------------------------------------------------------------------------
                                | SEARCH
                                |--------------------------------------------------------------------------
                                */

                                $data_search = strtolower(
                                    trim(
                                        ($row->nomor_surat ?? '') . ' ' .
                                        ($row->nomor_invoice ?? '') . ' ' .
                                        ($row->nomor_pesanan ?? '')
                                    )
                                );

                            ?>


                                <tr
                                    class="data-bast"
                                    data-search="<?= html_escape(
                                        $data_search
                                    ) ?>"
                                    data-bulan="<?= html_escape(
                                        $bulan_kebutuhan
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
                                         DOKUMEN
                                    ================================== -->

                                    <td class="align-middle">

                                        <?php if ($bastRow): ?>

                                            <div class="document-cell">

                                                <div class="status-icon success">

                                                    <i class="fas fa-check"></i>

                                                </div>

                                                <div>

                                                    <div class="document-title">

                                                        <?= html_escape(
                                                            $nomor_bast
                                                                ?: 'BAST Pemeriksaan'
                                                        ) ?>

                                                    </div>


                                                    <?php if ($nomor_keputusan): ?>

                                                        <div class="document-meta">

                                                            <i class="fas fa-gavel mr-1"></i>

                                                            <?= html_escape(
                                                                $nomor_keputusan
                                                            ) ?>

                                                        </div>

                                                    <?php endif; ?>


                                                    <span class="badge badge-success status-badge">

                                                        Sudah dibuat

                                                    </span>

                                                </div>

                                            </div>

                                        <?php else: ?>

                                            <div class="document-cell">

                                                <div class="status-icon warning">

                                                    <i class="fas fa-clock"></i>

                                                </div>

                                                <div>

                                                    <div class="document-title text-muted">

                                                        Belum dibuat

                                                    </div>

                                                    <div class="document-meta">

                                                        Menunggu pemeriksaan

                                                    </div>

                                                </div>

                                            </div>

                                        <?php endif; ?>

                                    </td>



                                    <!-- =================================
                                         NOMOR SURAT
                                    ================================== -->

                                    <td class="align-middle">

                                        <?php if (!empty($row->nomor_surat)): ?>

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
                                         INVOICE
                                    ================================== -->

                                    <td class="align-middle">

                                        <?php if (!empty($row->nomor_invoice)): ?>

                                            <div class="secondary-data">

                                                <i class="fas fa-file-invoice mr-1"></i>

                                                <?= html_escape(
                                                    $row->nomor_invoice
                                                ) ?>

                                            </div>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                -
                                            </span>

                                        <?php endif; ?>

                                    </td>



                                    <!-- =================================
                                         PESANAN
                                    ================================== -->

                                    <td class="align-middle">

                                        <?php if (!empty($row->nomor_pesanan)): ?>

                                            <div class="secondary-data">

                                                <i class="fas fa-shopping-cart mr-1"></i>

                                                <?= html_escape(
                                                    $row->nomor_pesanan
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

                                        <div class="main-data">

                                            <?= html_escape(
                                                $row->nama_penyedia ?: '-'
                                            ) ?>

                                        </div>


                                        <?php if (!empty($row->perihal)): ?>

                                            <div
                                                class="secondary-data text-truncate"
                                                style="max-width:220px;"
                                                title="<?= html_escape(
                                                    $row->perihal
                                                ) ?>"
                                            >

                                                <?= html_escape(
                                                    $row->perihal
                                                ) ?>

                                            </div>

                                        <?php endif; ?>

                                    </td>



                                    <!-- =================================
                                         TANGGAL
                                    ================================== -->

                                    <td class="align-middle">

                                        <?php if ($tanggal_pemeriksaan): ?>

                                            <div class="date-data">

                                                <i class="far fa-calendar-alt mr-1"></i>

                                                <?= date(
                                                    'd-m-Y',
                                                    strtotime(
                                                        $tanggal_pemeriksaan
                                                    )
                                                ) ?>

                                            </div>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                -
                                            </span>

                                        <?php endif; ?>

                                    </td>



                                    <!-- =================================
                                         AKSI
                                    ================================== -->

                                    <td class="text-center align-middle">

                                        <?php if ($bastRow): ?>

                                            <div class="action-buttons">


                                                <!-- CETAK -->

                                                <a
                                                    href="<?= site_url(
                                                        'spj/cetak_bast_pemeriksaan/' .
                                                        $bastRow->id_bast_pemeriksaan
                                                    ) ?>"
                                                    target="_blank"
                                                    class="btn btn-success btn-action"
                                                    title="Cetak BAST"
                                                >

                                                    <i class="fas fa-print"></i>

                                                </a>


                                                <!-- EDIT -->

                                                <a
                                                    href="<?= site_url(
                                                        'spj/edit_bast_pemeriksaan/' .
                                                        $bastRow->id_bast_pemeriksaan
                                                    ) ?>"
                                                    class="btn btn-warning btn-action"
                                                    title="Edit BAST"
                                                >

                                                    <i class="fas fa-edit"></i>

                                                </a>


                                                <!-- HAPUS -->

                                                <a
                                                    href="<?= site_url(
                                                        'spj/hapus_bast_pemeriksaan/' .
                                                        $bastRow->id_bast_pemeriksaan
                                                    ) ?>"
                                                    class="btn btn-danger btn-action"
                                                    title="Hapus BAST"
                                                    onclick="
                                                        return confirm(
                                                            'Hapus BAST Pemeriksaan ini?'
                                                        );
                                                    "
                                                >

                                                    <i class="fas fa-trash"></i>

                                                </a>

                                            </div>

                                        <?php else: ?>

                                            <a
                                                href="<?= site_url(
                                                    'spj/tambah_bast_pemeriksaan/' .
                                                    $id_kebutuhan
                                                ) ?>"
                                                class="btn btn-primary btn-sm btn-create"
                                            >

                                                <i class="fas fa-plus mr-1"></i>

                                                Buat BAST

                                            </a>

                                        <?php endif; ?>

                                    </td>


                                </tr>


                            <?php endforeach; ?>


                            <!-- =================================================
                                 DATA FILTER KOSONG
                            ================================================== -->

                            <tr
                                id="dataTidakDitemukan"
                                style="display:none;"
                            >

                                <td
                                    colspan="8"
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
                        <strong id="paginationStart">0</strong>
                        -
                        <strong id="paginationEnd">0</strong>
                        dari
                        <strong id="paginationTotal">0</strong>
                        data

                    </div>


                    <nav>

                        <ul
                            id="pagination"
                            class="pagination pagination-sm mb-0"
                        >
                        </ul>

                    </nav>

                </div>


            <?php else: ?>


                <!-- =================================================
                     EMPTY
                ================================================== -->

                <div class="empty-state text-center">

                    <div class="empty-icon">

                        <i class="fas fa-clipboard-list"></i>

                    </div>

                    <h6 class="font-weight-bold text-gray-800 mt-3 mb-1">

                        Belum ada data kebutuhan

                    </h6>

                    <div class="small text-muted">

                        Data kebutuhan akan muncul di sini untuk diproses
                        menjadi BAST Pemeriksaan.

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
                        Alur SPJ:
                    </strong>

                    Kebutuhan

                    <i class="fas fa-chevron-right mx-2"></i>

                    BAST Pemeriksaan

                    <i class="fas fa-chevron-right mx-2"></i>

                    BAST Internal.

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

    box-shadow: 0 3px 8px rgba(0, 0, 0, .08);

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

    line-height: 1.4;

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


.table-bast {

    font-size: 13px;

}


.table-bast thead th {

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


.table-bast tbody td {

    padding: 13px 12px;

    border-color: #eaecf4;

}


.table-bast tbody tr {

    transition: background-color .15s ease;

}


.table-bast tbody tr:hover {

    background-color: #fafbfe;

}


/*
|--------------------------------------------------------------------------
| DOKUMEN
|--------------------------------------------------------------------------
*/

.document-cell {

    display: flex;

    align-items: flex-start;

}


.status-icon {

    width: 34px;
    height: 34px;

    min-width: 34px;

    border-radius: 9px;

    display: flex;

    align-items: center;
    justify-content: center;

    margin-right: 9px;

    font-size: 14px;

}


.status-icon.success {

    background: #20c997;

    color: #fff;

}


.status-icon.warning {

    background: #fff3cd;

    color: #d39e00;

}


.document-title {

    font-weight: 700;

    color: #3a3b45;

    line-height: 1.4;

}


.document-meta {

    font-size: 11px;

    color: #858796;

    margin-top: 3px;

}


.status-badge {

    font-size: 9px;

    font-weight: 600;

    padding: 4px 6px;

    margin-top: 5px;

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


.secondary-data {

    font-size: 11px;

    font-weight: 600;

    color: #6e707e;

    word-break: break-word;

}


.date-data {

    font-size: 12px;

    font-weight: 600;

    color: #6e707e;

    white-space: nowrap;

}


/*
|--------------------------------------------------------------------------
| ACTION
|--------------------------------------------------------------------------
*/

.action-buttons {

    display: inline-flex;

    align-items: center;

    justify-content: center;

}


.btn-action {

    width: 32px;
    height: 32px;

    padding: 0;

    margin: 0 2px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

}


.btn-create {

    white-space: nowrap;

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


.pagination {

    margin-bottom: 0;

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

}


.pagination .page-item.active .page-link {

    z-index: 1;

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


    /*
     * Filter
     */

    .filter-panel {

        padding: 14px;

    }


    /*
     * Table scroll hanya di dalam container
     */

    .table-container .table-responsive {

        overflow-x: auto;

        -webkit-overflow-scrolling: touch;

    }


    .table-bast {

        min-width: 980px;

    }


    .table-bast th,
    .table-bast td {

        white-space: nowrap;

    }


    /*
     * Pagination
     */

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


    /*
     * Info alur
     */

    .card .fa-chevron-right {

        margin-left: 4px !important;

        margin-right: 4px !important;

    }

}

</style>



<!-- =============================================================
     FILTER + PAGINATION
============================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {


    /*
    |--------------------------------------------------------------------------
    | ELEMENT
    |--------------------------------------------------------------------------
    */

    const input =
        document.getElementById('filterPencarian');

    const bulan =
        document.getElementById('filterBulan');

    const reset =
        document.getElementById('resetFilter');

    const jumlahHasil =
        document.getElementById('jumlahHasil');

    const infoFilter =
        document.getElementById('infoFilter');

    const jumlahFilter =
        document.getElementById('jumlahFilter');

    const emptyRow =
        document.getElementById('dataTidakDitemukan');

    const paginationWrapper =
        document.getElementById('paginationWrapper');

    const pagination =
        document.getElementById('pagination');

    const paginationStart =
        document.getElementById('paginationStart');

    const paginationEnd =
        document.getElementById('paginationEnd');

    const paginationTotal =
        document.getElementById('paginationTotal');


    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */

    const rows =
        Array.from(
            document.querySelectorAll('.data-bast')
        );


    /*
    |--------------------------------------------------------------------------
    | KONFIGURASI
    |--------------------------------------------------------------------------
    */

    const perPage = 20;

    let currentPage = 1;

    let filteredRows = [];


    /*
    |--------------------------------------------------------------------------
    | FILTER
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


        filteredRows = rows.filter(function (row)
        {

            const search =
                row.dataset.search || '';


            const month =
                row.dataset.bulan || '';


            const matchSearch =
                keyword === '' ||
                search.includes(keyword);


            const matchMonth =
                selectedMonth === '' ||
                month === selectedMonth;


            return (
                matchSearch &&
                matchMonth
            );

        });


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
        | SEMBUNYIKAN SEMUA
        |--------------------------------------------------------------------------
        */

        rows.forEach(function (row)
        {

            row.style.display = 'none';

        });


        /*
        |--------------------------------------------------------------------------
        | EMPTY
        |--------------------------------------------------------------------------
        */

        if (emptyRow) {

            emptyRow.style.display =
                total === 0
                    ? ''
                    : 'none';

        }


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
        | TIDAK ADA DATA
        |--------------------------------------------------------------------------
        */

        if (total === 0) {

            if (paginationWrapper) {

                paginationWrapper.style.display =
                    'none';

            }

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL HALAMAN
        |--------------------------------------------------------------------------
        */

        const totalPages =
            Math.ceil(
                total / perPage
            );


        /*
        |--------------------------------------------------------------------------
        | JAGA HALAMAN
        |--------------------------------------------------------------------------
        */

        if (
            currentPage >
            totalPages
        ) {

            currentPage =
                totalPages;

        }


        /*
        |--------------------------------------------------------------------------
        | RANGE DATA
        |--------------------------------------------------------------------------
        */

        const startIndex =
            (currentPage - 1)
            * perPage;


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
        | PAGINATION INFO
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

    function renderPagination(totalPages)
    {

        if (
            !pagination ||
            !paginationWrapper
        ) {

            return;

        }


        pagination.innerHTML = '';


        /*
        |--------------------------------------------------------------------------
        | SATU HALAMAN
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
            createButton(
                '‹',
                currentPage - 1,
                currentPage === 1
            )
        );


        /*
        |--------------------------------------------------------------------------
        | NOMOR HALAMAN
        |--------------------------------------------------------------------------
        */

        for (
            let i = 1;
            i <= totalPages;
            i++
        ) {

            pagination.appendChild(
                createButton(
                    i,
                    i,
                    false,
                    i === currentPage
                )
            );

        }


        /*
        |--------------------------------------------------------------------------
        | NEXT
        |--------------------------------------------------------------------------
        */

        pagination.appendChild(
            createButton(
                '›',
                currentPage + 1,
                currentPage === totalPages
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CREATE BUTTON
    |--------------------------------------------------------------------------
    */

    function createButton(
        label,
        page,
        disabled,
        active
    )
    {

        const li =
            document.createElement('li');


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
            document.createElement('button');


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
                'tabelBastPemeriksaan'
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

                    input.value = '';

                }


                if (bulan) {

                    bulan.value = '';

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