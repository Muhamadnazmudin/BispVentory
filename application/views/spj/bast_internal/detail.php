<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container-fluid">

    <!-- =========================================================
         HEADER
    ========================================================== -->

    <div class="d-flex align-items-center justify-content-between mb-4">

        <div>

            <h1 class="h3 mb-1 text-gray-800">
                Detail BAST Internal
            </h1>

            <div class="text-muted small">
                Detail Berita Acara Serah Terima Internal
            </div>

        </div>


        <div>

            <a href="<?= base_url('spj/bast_internal') ?>"
               class="btn btn-secondary">

                <i class="fas fa-arrow-left mr-1"></i>

                Kembali

            </a>

        </div>

    </div>


    <!-- =========================================================
         INFORMASI BAST
    ========================================================== -->

    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">

                <i class="fas fa-file-signature mr-1"></i>

                Informasi BAST Internal

            </h6>

        </div>


        <div class="card-body">

            <div class="row">

                <!-- NOMOR SURAT -->

                <div class="col-md-6 mb-3">

                    <label class="small text-muted mb-1">
                        Nomor Surat Kebutuhan
                    </label>

                    <div class="font-weight-bold">

                        <?= !empty($kebutuhan->nomor_surat)
                            ? html_escape($kebutuhan->nomor_surat)
                            : '-'
                        ?>

                    </div>

                </div>


                <!-- NOMOR BAST -->

                <div class="col-md-6 mb-3">

                    <label class="small text-muted mb-1">
                        Nomor BAST Internal
                    </label>

                    <?php if (!empty($kebutuhan->nomor_bast_internal)): ?>

                        <div class="font-weight-bold text-success">

                            <i class="fas fa-check-circle mr-1"></i>

                            <?= html_escape(
                                $kebutuhan->nomor_bast_internal
                            ) ?>

                        </div>

                    <?php else: ?>

                        <div class="text-muted">

                            <i class="fas fa-minus-circle mr-1"></i>

                            Belum diinput

                        </div>

                    <?php endif; ?>

                </div>


                <!-- PERIHAL -->

                <div class="col-md-6 mb-3">

                    <label class="small text-muted mb-1">
                        Perihal
                    </label>

                    <div class="font-weight-bold">

                        <?= !empty($kebutuhan->perihal)
                            ? html_escape($kebutuhan->perihal)
                            : '-'
                        ?>

                    </div>

                </div>


                <!-- KEGIATAN -->

                <div class="col-md-6 mb-3">

                    <label class="small text-muted mb-1">
                        Kegiatan
                    </label>

                    <div class="font-weight-bold">

                        <?= !empty($kebutuhan->kegiatan)
                            ? html_escape($kebutuhan->kegiatan)
                            : '-'
                        ?>

                    </div>

                </div>


                <!-- TANGGAL KEBUTUHAN -->

                <div class="col-md-6 mb-3">

                    <label class="small text-muted mb-1">
                        Tanggal Kebutuhan
                    </label>

                    <div>

                        <?php if (!empty($kebutuhan->tanggal)): ?>

                            <i class="fas fa-calendar-alt mr-1"></i>

                            <?= date(
                                'd-m-Y',
                                strtotime($kebutuhan->tanggal)
                            ) ?>

                        <?php else: ?>

                            -

                        <?php endif; ?>

                    </div>

                </div>


                <!-- TANGGAL BAST -->

                <div class="col-md-6 mb-3">

                    <label class="small text-muted mb-1">
                        Tanggal BAST Internal
                    </label>

                    <?php if (!empty($kebutuhan->tanggal_bast_internal)): ?>

                        <div class="font-weight-bold text-success">

                            <i class="fas fa-calendar-check mr-1"></i>

                            <?= date(
                                'd-m-Y',
                                strtotime(
                                    $kebutuhan->tanggal_bast_internal
                                )
                            ) ?>

                        </div>

                    <?php else: ?>

                        <div class="text-muted">

                            <i class="fas fa-minus-circle mr-1"></i>

                            Belum diinput

                        </div>

                    <?php endif; ?>

                </div>


                <!-- KETERANGAN -->

                <?php if (!empty($kebutuhan->keterangan)): ?>

                    <div class="col-12 mb-2">

                        <label class="small text-muted mb-1">
                            Keterangan
                        </label>

                        <div class="border rounded p-3 bg-light">

                            <?= nl2br(
                                html_escape($kebutuhan->keterangan)
                            ) ?>

                        </div>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>


    <!-- =========================================================
         DAFTAR BARANG
    ========================================================== -->

    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <div class="d-flex align-items-center justify-content-between">

                <h6 class="m-0 font-weight-bold text-primary">

                    <i class="fas fa-boxes mr-1"></i>

                    Daftar Barang / Jasa

                </h6>


                <span class="badge badge-info">

                    <?= !empty($detail)
                        ? count($detail)
                        : 0
                    ?>

                    Item

                </span>

            </div>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="thead-light">

                        <tr>

                            <th width="5%" class="text-center">
                                No
                            </th>

                            <th width="15%">
                                Kodering
                            </th>

                            <th>
                                Nama Barang / Jasa
                            </th>

                            <th width="10%" class="text-center">
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

                        <?php if (!empty($detail)): ?>

                            <?php $no = 1; ?>

                            <?php foreach ($detail as $item): ?>

                                <tr>

                                    <!-- NO -->

                                    <td class="text-center">

                                        <?= $no++ ?>

                                    </td>


                                    <!-- KODERING -->

                                    <td>

                                        <span class="badge badge-secondary">

                                            <?= !empty($item->kodering)
                                                ? html_escape($item->kodering)
                                                : '-'
                                            ?>

                                        </span>

                                    </td>


                                    <!-- NAMA BARANG -->

                                    <td>

                                        <?= !empty($item->nama_barang)
                                            ? html_escape($item->nama_barang)
                                            : '-'
                                        ?>

                                    </td>


                                    <!-- JUMLAH -->

                                    <td class="text-center">

                                        <?= rtrim(
                                            rtrim(
                                                number_format(
                                                    (float) $item->jumlah,
                                                    2,
                                                    ',',
                                                    '.'
                                                ),
                                                '0'
                                            ),
                                            ','
                                        ) ?>

                                    </td>


                                    <!-- SATUAN -->

                                    <td>

                                        <?= !empty($item->satuan)
                                            ? html_escape($item->satuan)
                                            : '-'
                                        ?>

                                    </td>


                                    <!-- KETERANGAN -->

                                    <td>

                                        <?= !empty($item->keterangan)
                                            ? html_escape($item->keterangan)
                                            : '-'
                                        ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td colspan="6"
                                    class="text-center text-muted py-5">

                                    <i class="fas fa-box-open fa-2x mb-3"></i>

                                    <div class="font-weight-bold">
                                        Belum ada barang / jasa.
                                    </div>

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- =========================================================
         ACTION
    ========================================================== -->

    <div class="d-flex justify-content-end mb-4">

        <a href="<?= base_url(
            'spj/edit_bast_internal/' .
            $kebutuhan->id_kebutuhan
        ) ?>"
           class="btn btn-warning mr-2">

            <i class="fas fa-edit mr-1"></i>

            Edit BAST

        </a>


        <a href="<?= base_url(
            'spj/cetak_bast_internal/' .
            $kebutuhan->id_kebutuhan
        ) ?>"
           class="btn btn-danger"
           target="_blank">

            <i class="fas fa-file-pdf mr-1"></i>

            Cetak BAST

        </a>

    </div>

</div>