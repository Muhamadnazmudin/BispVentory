<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container-fluid">

    <!-- =====================================================
         HEADER
    ====================================================== -->

    <div class="d-flex align-items-center justify-content-between mb-4">

        <div>

            <h1 class="h3 mb-1 text-gray-800">
                <?= html_escape($title) ?>
            </h1>

            <div class="text-muted small">
                Lengkapi nomor dan tanggal BAST Internal
            </div>

        </div>


        <a href="<?= base_url('spj/bast_internal') ?>"
           class="btn btn-secondary">

            <i class="fas fa-arrow-left mr-1"></i>

            Kembali

        </a>

    </div>


    <!-- =====================================================
         FLASH MESSAGE
    ====================================================== -->

    <?php if ($this->session->flashdata('error')): ?>

        <div class="alert alert-danger">

            <i class="fas fa-exclamation-circle mr-1"></i>

            <?= $this->session->flashdata('error') ?>

        </div>

    <?php endif; ?>


    <!-- =====================================================
         DATA PENGAJUAN
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

                <div class="col-md-6">

                    <div class="form-group">

                        <label>
                            Nomor Surat Kebutuhan
                        </label>

                        <input type="text"
                               class="form-control"
                               value="<?= html_escape($kebutuhan->nomor_surat) ?>"
                               readonly>

                    </div>

                </div>


                <div class="col-md-6">

                    <div class="form-group">

                        <label>
                            Tanggal Pengajuan
                        </label>

                        <input type="text"
                               class="form-control"
                               value="<?= date('d-m-Y', strtotime($kebutuhan->tanggal)) ?>"
                               readonly>

                    </div>

                </div>


                <div class="col-md-12">

                    <div class="form-group mb-0">

                        <label>
                            Perihal
                        </label>

                        <input type="text"
                               class="form-control"
                               value="<?= html_escape($kebutuhan->perihal) ?>"
                               readonly>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         DATA BAST
    ====================================================== -->

    <form method="post"
          action="<?= base_url('spj/edit_bast_internal/' . $kebutuhan->id_kebutuhan) ?>">

        <div class="card shadow mb-4">

            <div class="card-header">

                <strong class="text-primary">

                    <i class="fas fa-file-signature mr-1"></i>

                    Data BAST Internal

                </strong>

            </div>


            <div class="card-body">

                <div class="row">

                    <div class="col-md-7">

                        <div class="form-group">

                            <label>
                                Nomor BAST
                            </label>

                            <input type="text"
                                   name="nomor_bast_internal"
                                   class="form-control"
                                   value="<?= !empty($kebutuhan->nomor_bast_internal)
                                       ? html_escape($kebutuhan->nomor_bast_internal)
                                       : '' ?>"
                                   placeholder="Contoh: 001/BAST-Sarpras.09/2026"
                                   required>

                            <small class="form-text text-muted">
                                Nomor BAST diisi secara manual.
                            </small>

                        </div>

                    </div>


                    <div class="col-md-5">

                        <div class="form-group">

                            <label>
                                Tanggal BAST
                            </label>

                            <input type="date"
                                   name="tanggal_bast_internal"
                                   class="form-control"
                                   value="<?= !empty($kebutuhan->tanggal_bast_internal)
                                       ? html_escape($kebutuhan->tanggal_bast_internal)
                                       : date('Y-m-d') ?>"
                                   required>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- =================================================
             BUTTON
        ================================================== -->

        <div class="text-right mb-4">

            <a href="<?= base_url('spj/bast_internal') ?>"
               class="btn btn-secondary">

                Batal

            </a>

            <button type="submit"
                    class="btn btn-primary">

                <i class="fas fa-save mr-1"></i>

                Simpan BAST

            </button>

        </div>

    </form>

</div>