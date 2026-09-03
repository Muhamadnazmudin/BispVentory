<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container-fluid">

    <!-- =========================================================
         HEADER
    ========================================================== -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>

            <h1 class="h3 mb-1 text-gray-800">
                Import Kebutuhan
            </h1>

            <div class="text-muted small">
                Import pengajuan kebutuhan melalui file Excel
            </div>

        </div>


        <a href="<?= base_url('spj/input_kebutuhan') ?>"
           class="btn btn-secondary">

            <i class="fas fa-arrow-left mr-1"></i>
            Kembali

        </a>

    </div>


    <!-- =========================================================
         FLASH MESSAGE
    ========================================================== -->

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


    <!-- =========================================================
         CARD IMPORT
    ========================================================== -->

    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">

                <i class="fas fa-file-import mr-1"></i>

                Import File Excel

            </h6>

        </div>


        <div class="card-body">

            <div class="alert alert-info">

                <i class="fas fa-info-circle mr-1"></i>

                Gunakan template Excel yang disediakan sistem agar
                format data sesuai dengan database.

            </div>


            <form method="post"
                  action="<?= base_url('spj/import_kebutuhan') ?>"
                  enctype="multipart/form-data">


                <div class="form-group">

                    <label class="font-weight-bold">
                        File Excel
                    </label>

                    <div class="custom-file">

                        <input type="file"
                               name="file_excel"
                               class="custom-file-input"
                               id="file_excel"
                               accept=".xlsx,.xls"
                               required>

                        <label class="custom-file-label"
                               for="file_excel">

                            Pilih file Excel...

                        </label>

                    </div>

                    <small class="form-text text-muted">

                        Format yang diperbolehkan:
                        <strong>.xlsx</strong> atau
                        <strong>.xls</strong>

                    </small>

                </div>


                <div class="mt-4">

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fas fa-upload mr-1"></i>

                        Import Sekarang

                    </button>


                    <a href="<?= base_url(
                        'spj/download_template_kebutuhan'
                    ) ?>"
                       class="btn btn-success ml-1">

                        <i class="fas fa-file-excel mr-1"></i>

                        Download Template

                    </a>

                </div>

            </form>

        </div>

    </div>


    <!-- =========================================================
         PETUNJUK
    ========================================================== -->

    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">

                <i class="fas fa-question-circle mr-1"></i>

                Petunjuk Pengisian

            </h6>

        </div>


        <div class="card-body">

            <ol class="mb-0">

                <li class="mb-2">
                    Download template Excel terlebih dahulu.
                </li>

                <li class="mb-2">
                    Isi nomor surat, tanggal, perihal,
                    kegiatan dan keterangan.
                </li>

                <li class="mb-2">
                    Pilih <strong>Kodering</strong> dari dropdown
                    yang tersedia.
                </li>

                <li class="mb-2">
                    Isi daftar nama barang/jasa, jumlah,
                    satuan dan keterangan.
                </li>

                <li class="mb-2">
                    Simpan file Excel.
                </li>

                <li>
                    Upload file tersebut melalui halaman ini.
                </li>

            </ol>

        </div>

    </div>

</div>


<script>

document.getElementById('file_excel')
    .addEventListener('change', function (event) {

        var fileName = event.target.files.length
            ? event.target.files[0].name
            : 'Pilih file Excel...';

        event.target
            .nextElementSibling
            .innerText = fileName;

    });

</script>