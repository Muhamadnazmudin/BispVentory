<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container-fluid">

    <div class="d-flex align-items-center justify-content-between mb-4">

        <div>

            <h1 class="h3 mb-1 text-gray-800">
                BAST Pemeriksaan
            </h1>

            <div class="small text-muted">
                Pemeriksaan barang berdasarkan kebutuhan yang telah dibuat.
            </div>

        </div>

    </div>


    <?php if ($this->session->flashdata('success')): ?>

        <div class="alert alert-success">

            <i class="fas fa-check-circle mr-1"></i>

            <?= html_escape(
                $this->session->flashdata('success')
            ) ?>

        </div>

    <?php endif; ?>


    <?php if ($this->session->flashdata('error')): ?>

        <div class="alert alert-danger">

            <i class="fas fa-exclamation-circle mr-1"></i>

            <?= html_escape(
                $this->session->flashdata('error')
            ) ?>

        </div>

    <?php endif; ?>


    <div class="card shadow mb-4">

        <div class="card-header">

            <strong class="text-primary">

                <i class="fas fa-clipboard-check mr-1"></i>

                Daftar BAST Pemeriksaan

            </strong>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="thead-light">

                        <tr>

                            <th width="5%">
                                No
                            </th>

                            <th>
                                Nomor BAST
                            </th>

                            <th>
                                Nomor Surat
                            </th>

                            <th>
                                Invoice
                            </th>

                            <th>
                                Nomor Pesanan
                            </th>

                            <th>
                                Penyedia
                            </th>

                            <th>
                                Tanggal Pemeriksaan
                            </th>

                            <th width="18%">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php if (!empty($kebutuhan)): ?>

                        <?php

                        $no = 1;

                        foreach ($kebutuhan as $row):

                            $bastRow = null;

                            foreach ($bast as $b) {

                                if (
                                    (int)$b->id_kebutuhan ===
                                    (int)$row->id_kebutuhan
                                ) {

                                    $bastRow = $b;

                                    break;
                                }
                            }

                        ?>

                            <tr>

                                <td>
                                    <?= $no++ ?>
                                </td>


                                <td>

                                    <?php if ($bastRow): ?>

                                        <strong>
                                            <?= html_escape(
                                                $bastRow->nomor_bast
                                            ) ?>
                                        </strong>

                                        <div class="small text-muted">

                                            Keputusan:
                                            <?= html_escape(
                                                $bastRow->nomor_keputusan
                                            ) ?>

                                        </div>

                                    <?php else: ?>

                                        <span class="badge badge-warning">
                                            Belum dibuat
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <td>
                                    <?= html_escape(
                                        $row->nomor_surat
                                    ) ?>
                                </td>


                                <td>
                                    <?= html_escape(
                                        $row->nomor_invoice ?? '-'
                                    ) ?>
                                </td>


                                <td>
                                    <?= html_escape(
                                        $row->nomor_pesanan ?? '-'
                                    ) ?>
                                </td>


                                <td>
                                    <?= html_escape(
                                        $row->nama_penyedia ?? '-'
                                    ) ?>
                                </td>


                                <td>

                                    <?= date(
                                        'd-m-Y',
                                        strtotime(
                                            $bastRow
                                                ? $bastRow->tanggal_pemeriksaan
                                                : $row->tanggal
                                        )
                                    ) ?>

                                </td>


                                <td>

                                    <?php if ($bastRow): ?>

                                        <a
                                            href="<?= site_url(
                                                'spj/cetak_bast_pemeriksaan/' .
                                                $bastRow->id_bast_pemeriksaan
                                            ) ?>"
                                            target="_blank"
                                            class="btn btn-success btn-sm"
                                            title="Cetak"
                                        >

                                            <i class="fas fa-print"></i>

                                        </a>


                                        <a
                                            href="<?= site_url(
                                                'spj/edit_bast_pemeriksaan/' .
                                                $bastRow->id_bast_pemeriksaan
                                            ) ?>"
                                            class="btn btn-warning btn-sm"
                                            title="Edit"
                                        >

                                            <i class="fas fa-edit"></i>

                                        </a>


                                        <a
                                            href="<?= site_url(
                                                'spj/hapus_bast_pemeriksaan/' .
                                                $bastRow->id_bast_pemeriksaan
                                            ) ?>"
                                            class="btn btn-danger btn-sm"
                                            title="Hapus"
                                            onclick="
                                                return confirm(
                                                    'Hapus BAST Pemeriksaan ini?'
                                                );
                                            "
                                        >

                                            <i class="fas fa-trash"></i>

                                        </a>

                                    <?php else: ?>

                                        <a
                                            href="<?= site_url(
                                                'spj/tambah_bast_pemeriksaan/' .
                                                $row->id_kebutuhan
                                            ) ?>"
                                            class="btn btn-primary btn-sm"
                                        >

                                            <i class="fas fa-plus mr-1"></i>

                                            Buat BAST

                                        </a>

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td
                                colspan="8"
                                class="text-center text-muted py-4"
                            >

                                Belum ada data kebutuhan.

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>