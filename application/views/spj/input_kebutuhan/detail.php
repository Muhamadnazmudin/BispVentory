<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/*
 * =========================================================
 * HELPER TANGGAL
 * =========================================================
 */

function format_tanggal_detail($tanggal)
{
    if (
        empty($tanggal) ||
        $tanggal === '0000-00-00'
    ) {
        return '-';
    }


    $timestamp = strtotime($tanggal);


    if ($timestamp === false) {
        return '-';
    }


    return date('d-m-Y', $timestamp);
}

?>

<div class="container-fluid">

    <!-- =====================================================
         HEADER
    ====================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="h3 mb-1 text-gray-800">
                Detail Kebutuhan
            </h1>

            <div class="text-muted small">
                <?= html_escape($kebutuhan->nomor_surat ?? '-') ?>
            </div>

        </div>


        <a href="<?= base_url('spj/input_kebutuhan') ?>"
           class="btn btn-secondary">

            <i class="fas fa-arrow-left mr-1"></i>
            Kembali

        </a>

    </div>


    <!-- =====================================================
         INFORMASI PENGAJUAN
    ====================================================== -->

    <div class="card shadow mb-4">

        <div class="card-header">

            <strong class="text-primary">

                <i class="fas fa-file-alt mr-1"></i>
                Data Pengajuan

            </strong>

        </div>


        <div class="card-body">

            <div class="row">


                <!-- =================================================
                     NOMOR SURAT
                ================================================== -->

                <div class="col-md-6">

                    <div class="detail-item">

                        <div class="detail-label">
                            Nomor Surat
                        </div>

                        <div class="detail-value">
                            <?= !empty($kebutuhan->nomor_surat)
                                ? html_escape($kebutuhan->nomor_surat)
                                : '-' ?>
                        </div>

                    </div>

                </div>


                <!-- =================================================
                     TANGGAL KEBUTUHAN
                ================================================== -->

                <div class="col-md-6">

                    <div class="detail-item">

                        <div class="detail-label">
                            Tanggal Kebutuhan
                        </div>

                        <div class="detail-value">

                            <?= format_tanggal_detail(
                                $kebutuhan->tanggal ?? null
                            ) ?>

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     NOMOR INVOICE
                ================================================== -->

                <div class="col-md-6">

                    <div class="detail-item">

                        <div class="detail-label">
                            Nomor Invoice
                        </div>

                        <div class="detail-value">

                            <?= !empty($kebutuhan->nomor_invoice)
                                ? html_escape($kebutuhan->nomor_invoice)
                                : '-' ?>

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     TANGGAL INVOICE
                ================================================== -->

                <div class="col-md-6">

                    <div class="detail-item">

                        <div class="detail-label">
                            Tanggal Invoice
                        </div>

                        <div class="detail-value">

                            <?= format_tanggal_detail(
                                $kebutuhan->tanggal_invoice ?? null
                            ) ?>

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     NOMOR PESANAN
                ================================================== -->

                <div class="col-md-6">

                    <div class="detail-item">

                        <div class="detail-label">
                            Nomor Pesanan
                        </div>

                        <div class="detail-value">

                            <?= !empty($kebutuhan->nomor_pesanan)
                                ? html_escape($kebutuhan->nomor_pesanan)
                                : '-' ?>

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     TANGGAL PESANAN
                ================================================== -->

                <div class="col-md-6">

                    <div class="detail-item">

                        <div class="detail-label">
                            Tanggal Pesanan
                        </div>

                        <div class="detail-value">

                            <?= format_tanggal_detail(
                                $kebutuhan->tanggal_pesanan ?? null
                            ) ?>

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     NAMA PENYEDIA
                ================================================== -->

                <div class="col-md-12">

                    <div class="detail-item">

                        <div class="detail-label">
                            Nama CV/Penyedia
                        </div>

                        <div class="detail-value">

                            <?= !empty($kebutuhan->nama_penyedia)
                                ? html_escape($kebutuhan->nama_penyedia)
                                : '-' ?>

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     PERIHAL
                ================================================== -->

                <div class="col-md-12">

                    <div class="detail-item">

                        <div class="detail-label">
                            Perihal
                        </div>

                        <div class="detail-value">

                            <?= !empty($kebutuhan->perihal)
                                ? html_escape($kebutuhan->perihal)
                                : '-' ?>

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     KEGIATAN
                ================================================== -->

                <div class="col-md-12">

                    <div class="detail-item">

                        <div class="detail-label">
                            Kegiatan
                        </div>

                        <div class="detail-value">

                            <?= !empty($kebutuhan->kegiatan)
                                ? html_escape($kebutuhan->kegiatan)
                                : '-' ?>

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     KETERANGAN
                ================================================== -->

                <div class="col-md-12">

                    <div class="detail-item mb-0">

                        <div class="detail-label">
                            Keterangan
                        </div>

                        <div class="detail-value">

                            <?php if (!empty($kebutuhan->keterangan)): ?>

                                <?= nl2br(
                                    html_escape(
                                        $kebutuhan->keterangan
                                    )
                                ) ?>

                            <?php else: ?>

                                -

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         RINCIAN KEBUTUHAN
    ====================================================== -->

    <div class="card shadow mb-4">

        <div class="card-header d-flex align-items-center justify-content-between">

            <strong class="text-primary">

                <i class="fas fa-list mr-1"></i>
                Rincian Kebutuhan

            </strong>


            <?php if (!empty($detail)): ?>

                <span class="badge badge-primary">

                    <?= count($detail) ?> item

                </span>

            <?php endif; ?>

        </div>


        <div class="card-body">

            <?php if (!empty($detail)): ?>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead class="thead-light">

                            <tr>

                                <th width="5%"
                                    class="text-center">
                                    No
                                </th>

                                <th width="18%">
                                    Kodering
                                </th>

                                <th>
                                    Nama Barang/Jasa
                                </th>

                                <th width="10%"
                                    class="text-right">
                                    Jumlah
                                </th>

                                <th width="12%">
                                    Satuan
                                </th>

                                <th width="20%">
                                    Keterangan
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php $no = 1; ?>


                            <?php foreach ($detail as $row): ?>

                                <tr>

                                    <td class="text-center">

                                        <?= $no++ ?>

                                    </td>


                                    <td>

                                        <div class="font-weight-bold">

                                            <?= !empty($row->kodering)
                                                ? html_escape($row->kodering)
                                                : '-' ?>

                                        </div>

                                    </td>


                                    <td>

                                        <?= !empty($row->nama_barang)
                                            ? html_escape($row->nama_barang)
                                            : '-' ?>

                                    </td>


                                    <td class="text-right">

                                        <?= rtrim(
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
                                        ) ?>

                                    </td>


                                    <td>

                                        <?= !empty($row->satuan)
                                            ? html_escape($row->satuan)
                                            : '-' ?>

                                    </td>


                                    <td>

                                        <?= !empty($row->keterangan)
                                            ? html_escape($row->keterangan)
                                            : '-' ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php else: ?>

                <div class="text-center text-muted py-4">

                    <i class="fas fa-inbox fa-2x mb-2"></i>

                    <div>
                        Belum ada rincian kebutuhan.
                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>


    <!-- =====================================================
         TOMBOL AKSI
    ====================================================== -->

    <div class="d-flex justify-content-end mb-4">

        <a href="<?= base_url(
            'spj/edit_kebutuhan/' .
            $kebutuhan->id_kebutuhan
        ) ?>"
           class="btn btn-warning mr-2">

            <i class="fas fa-edit mr-1"></i>
            Edit Kebutuhan

        </a>


        <!--
        =====================================================
        NANTI TOMBOL PDF DI SINI
        =====================================================

        <a href="<?= base_url(
            'spj/bast_internal/' .
            $kebutuhan->id_kebutuhan
        ) ?>"
           class="btn btn-primary mr-2">

            <i class="fas fa-file-pdf mr-1"></i>
            BAST Internal

        </a>


        <a href="<?= base_url(
            'spj/bast_pemeriksaan/' .
            $kebutuhan->id_kebutuhan
        ) ?>"
           class="btn btn-success">

            <i class="fas fa-file-pdf mr-1"></i>
            BAST Pemeriksaan

        </a>
        -->

    </div>

</div>


<!-- =========================================================
     STYLE
========================================================= -->

<style>

.detail-item {
    margin-bottom: 18px;
}

.detail-label {
    font-size: 12px;
    font-weight: 700;
    color: #858796;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: .3px;
}

.detail-value {
    font-size: 14px;
    font-weight: 600;
    color: #3a3b45;
    word-break: break-word;
}

.table th {
    vertical-align: middle;
}

.table td {
    vertical-align: middle;
}

@media (max-width: 767.98px) {

    .detail-item {
        margin-bottom: 15px;
    }

    .detail-value {
        font-size: 13px;
    }

}

</style>