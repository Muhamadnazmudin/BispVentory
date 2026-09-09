<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container-fluid">

    <div class="d-flex align-items-center justify-content-between mb-4">

        <div>

            <h1 class="h3 mb-1 text-gray-800">
                Download SPJ Full
            </h1>

            <div class="small text-muted">
                Download seluruh dokumen SPJ sekaligus dalam satu file ZIP.
            </div>

        </div>

    </div>


    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <strong class="text-primary">

                <i class="fas fa-file-archive mr-2"></i>

                Daftar SPJ

            </strong>

        </div>


        <div class="card-body p-0">

            <?php if (empty($kebutuhan)): ?>

                <div class="text-center text-muted py-5">

                    <i class="fas fa-folder-open fa-2x mb-3"></i>

                    <div>
                        Belum ada data Input Kebutuhan.
                    </div>

                </div>

            <?php else: ?>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover mb-0">

                        <thead class="thead-light">

                            <tr>

                                <th width="5%" class="text-center">
                                    No
                                </th>

                                <th>
                                    Nomor Surat
                                </th>

                                <th width="13%">
                                    Tanggal
                                </th>

                                <th>
                                    Perihal
                                </th>

                                <th>
                                    CV / Penyedia
                                </th>

                                <th width="25%">
                                    Kelengkapan
                                </th>

                                <th width="12%" class="text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                        <?php $no = 1; ?>


                        <?php foreach ($kebutuhan as $row): ?>


                            <?php

                            $id_kebutuhan =
                                (int) $row->id_kebutuhan;


                            /*
                            |--------------------------------------------------
                            | BAST PEMERIKSAAN
                            |--------------------------------------------------
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
                            |--------------------------------------------------
                            | BAST INTERNAL
                            |--------------------------------------------------
                            */

                            $ada_internal =
                                !empty(
                                    $row->nomor_bast_internal
                                );


                            /*
                            |--------------------------------------------------
                            | LENGKAP
                            |--------------------------------------------------
                            */

                            $lengkap =
                                (
                                    $ada_pemeriksaan &&
                                    $ada_internal
                                );

                            ?>


                            <tr>


                                <td class="text-center">
                                    <?= $no++ ?>
                                </td>


                                <td>

                                    <strong>

                                        <?= html_escape(
                                            !empty(
                                                $row->nomor_surat
                                            )
                                                ? $row->nomor_surat
                                                : '-'
                                        ) ?>

                                    </strong>

                                </td>


                                <td>

                                    <?php if (!empty($row->tanggal)): ?>

                                        <?= date(
                                            'd-m-Y',
                                            strtotime(
                                                $row->tanggal
                                            )
                                        ) ?>

                                    <?php else: ?>

                                        -

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <?= html_escape(
                                        !empty(
                                            $row->perihal
                                        )
                                            ? $row->perihal
                                            : '-'
                                    ) ?>

                                </td>


                                <td>

                                    <?= html_escape(
                                        !empty(
                                            $row->nama_penyedia
                                        )
                                            ? $row->nama_penyedia
                                            : '-'
                                    ) ?>

                                </td>


                                <td>


                                    <!-- INPUT KEBUTUHAN -->

                                    <span class="badge badge-success mr-1 mb-1">

                                        <i class="fas fa-check mr-1"></i>

                                        Input Kebutuhan

                                    </span>


                                    <!-- BAST PEMERIKSAAN -->

                                    <?php if ($ada_pemeriksaan): ?>

                                        <span class="badge badge-success mr-1 mb-1">

                                            <i class="fas fa-check mr-1"></i>

                                            BAST Pemeriksaan

                                        </span>

                                    <?php else: ?>

                                        <span class="badge badge-danger mr-1 mb-1">

                                            <i class="fas fa-times mr-1"></i>

                                            BAST Pemeriksaan

                                        </span>

                                    <?php endif; ?>


                                    <!-- BAST INTERNAL -->

                                    <?php if ($ada_internal): ?>

                                        <span class="badge badge-success mr-1 mb-1">

                                            <i class="fas fa-check mr-1"></i>

                                            BAST Internal

                                        </span>

                                    <?php else: ?>

                                        <span class="badge badge-danger mr-1 mb-1">

                                            <i class="fas fa-times mr-1"></i>

                                            BAST Internal

                                        </span>

                                    <?php endif; ?>


                                </td>


                                <td class="text-center">


                                    <?php if ($lengkap): ?>

                                        <a
                                            href="<?= site_url(
                                                'spj/download_spj_full_file/' .
                                                $id_kebutuhan
                                            ) ?>"
                                            class="btn btn-primary btn-sm"
                                        >

                                            <i class="fas fa-download mr-1"></i>

                                            Download

                                        </a>

                                    <?php else: ?>

                                        <button
                                            type="button"
                                            class="btn btn-secondary btn-sm"
                                            disabled
                                        >

                                            <i class="fas fa-lock mr-1"></i>

                                            Belum Lengkap

                                        </button>

                                    <?php endif; ?>


                                </td>


                            </tr>


                        <?php endforeach; ?>


                        </tbody>

                    </table>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>