<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container-fluid">

    <!-- =================================================
         HEADER
    ================================================== -->

    <div class="d-flex align-items-center justify-content-between mb-4">

        <div>

            <h1 class="h3 mb-1 text-gray-800">
                <?= html_escape($title) ?>
            </h1>

            <div class="text-muted small">
                Perbarui data pengajuan kebutuhan
            </div>

        </div>


        <a href="<?= base_url('spj/input_kebutuhan') ?>"
           class="btn btn-secondary">

            <i class="fas fa-arrow-left mr-1"></i>
            Kembali

        </a>

    </div>


    <!-- =================================================
         ALERT
    ================================================== -->

    <?php if ($this->session->flashdata('error')): ?>

        <div class="alert alert-danger">

            <i class="fas fa-exclamation-circle mr-1"></i>

            <?= $this->session->flashdata('error') ?>

        </div>

    <?php endif; ?>


    <form method="post"
          action="<?= base_url(
              'spj/update_kebutuhan/' .
              $kebutuhan->id_kebutuhan
          ) ?>">


        <!-- =================================================
             DATA SURAT
        ================================================== -->

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
                                Nomor Surat
                            </label>

                            <input type="text"
                                   name="nomor_surat"
                                   class="form-control"
                                   value="<?= html_escape(
                                       $kebutuhan->nomor_surat
                                   ) ?>"
                                   required>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label>
                                Tanggal
                            </label>

                            <input type="date"
                                   name="tanggal"
                                   class="form-control"
                                   value="<?= html_escape(
                                       $kebutuhan->tanggal
                                   ) ?>"
                                   required>

                        </div>

                    </div>


                    <div class="col-md-12">

                        <div class="form-group">

                            <label>
                                Perihal
                            </label>

                            <input type="text"
                                   name="perihal"
                                   class="form-control"
                                   value="<?= html_escape(
                                       $kebutuhan->perihal
                                   ) ?>"
                                   required>

                        </div>

                    </div>


                    <div class="col-md-12">

                        <div class="form-group">

                            <label>
                                Kegiatan
                            </label>

                            <input type="text"
                                   name="kegiatan"
                                   class="form-control"
                                   value="<?= html_escape(
                                       $kebutuhan->kegiatan
                                   ) ?>"
                                   placeholder="Contoh: Kegiatan Kesiswaan">

                        </div>

                    </div>


                    <div class="col-md-12">

                        <div class="form-group mb-0">

                            <label>
                                Keterangan
                            </label>

                            <textarea name="keterangan"
                                      class="form-control"
                                      rows="3"><?= html_escape(
                                          $kebutuhan->keterangan
                                      ) ?></textarea>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- =================================================
             RINCIAN
        ================================================== -->

        <div class="card shadow mb-4">

            <div class="card-header d-flex align-items-center justify-content-between">

                <strong class="text-primary">

                    <i class="fas fa-list mr-1"></i>

                    Rincian Kebutuhan

                </strong>


                <button type="button"
                        id="btnTambahBaris"
                        class="btn btn-primary btn-sm">

                    <i class="fas fa-plus mr-1"></i>

                    Tambah Barang

                </button>

            </div>


            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered"
                           id="tabelKebutuhan">

                        <thead class="thead-light">

                            <tr>

                                <th width="4%">
                                    No
                                </th>

                                <th width="25%">
                                    Kategori / Kodering
                                </th>

                                <th>
                                    Nama Barang/Jasa
                                </th>

                                <th width="10%">
                                    Jumlah
                                </th>

                                <th width="12%">
                                    Satuan
                                </th>

                                <th width="20%">
                                    Keterangan
                                </th>

                                <th width="5%">
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php
                            $no = 1;

                            foreach ($detail as $row):
                            ?>

                                <tr class="baris-kebutuhan">

                                    <td class="nomor text-center">
                                        <?= $no ?>
                                    </td>


                                    <td>

                                        <select name="id_kategori[]"
                                                class="form-control kategori-select"
                                                required>

                                            <option value="">
                                                -- Pilih Kategori --
                                            </option>

                                            <?php foreach ($kategori as $k): ?>

                                                <option
                                                    value="<?= $k->id_kategori ?>"
                                                    <?= (
                                                        $k->id_kategori ==
                                                        $row->id_kategori
                                                    )
                                                        ? 'selected'
                                                        : ''
                                                    ?>>

                                                    <?= html_escape(
                                                        $k->kodering
                                                    ) ?>

                                                    -
                                                    <?= html_escape(
                                                        $k->nama_kategori
                                                    ) ?>

                                                </option>

                                            <?php endforeach; ?>

                                        </select>


                                        <small class="kodering-preview text-primary font-weight-bold">

                                            Kodering:
                                            <?= html_escape(
                                                $row->kodering
                                            ) ?>

                                        </small>

                                    </td>


                                    <td>

                                        <input type="text"
                                               name="nama_barang[]"
                                               class="form-control"
                                               value="<?= html_escape(
                                                   $row->nama_barang
                                               ) ?>"
                                               required>

                                    </td>


                                    <td>

                                        <input type="number"
                                               name="jumlah[]"
                                               class="form-control"
                                               min="0.01"
                                               step="0.01"
                                               value="<?= html_escape(
                                                   $row->jumlah
                                               ) ?>"
                                               required>

                                    </td>


                                    <td>

                                        <input type="text"
                                               name="satuan[]"
                                               class="form-control"
                                               value="<?= html_escape(
                                                   $row->satuan
                                               ) ?>"
                                               placeholder="Pcs"
                                               required>

                                    </td>


                                    <td>

                                        <input type="text"
                                               name="keterangan_detail[]"
                                               class="form-control"
                                               value="<?= html_escape(
                                                   $row->keterangan
                                               ) ?>"
                                               placeholder="Opsional">

                                    </td>


                                    <td class="text-center">

                                        <button type="button"
                                                class="btn btn-danger btn-sm btn-hapus"
                                                title="Hapus Barang">

                                            <i class="fas fa-times"></i>

                                        </button>

                                    </td>

                                </tr>

                            <?php
                                $no++;
                            endforeach;
                            ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <!-- =================================================
             SUBMIT
        ================================================== -->

        <div class="text-right mb-4">

            <a href="<?= base_url('spj/input_kebutuhan') ?>"
               class="btn btn-secondary">

                Batal

            </a>


            <button type="submit"
                    class="btn btn-primary">

                <i class="fas fa-save mr-1"></i>

                Simpan Perubahan

            </button>

        </div>


    </form>

</div>


<script>

$(document).ready(function () {


    /* =====================================================
       TAMBAH BARIS
    ===================================================== */

    $('#btnTambahBaris').on('click', function () {

        var baris =
            $('.baris-kebutuhan:first').clone();

        baris.find('input').val('');

        baris.find('select').val('');

        baris.find('.kodering-preview').text('');

        $('#tabelKebutuhan tbody').append(baris);

        updateNomor();

    });


    /* =====================================================
       HAPUS BARIS
    ===================================================== */

    $(document).on(
        'click',
        '.btn-hapus',
        function () {

            if (
                $('.baris-kebutuhan').length <= 1
            ) {

                alert(
                    'Minimal satu barang harus tersedia.'
                );

                return;
            }


            $(this)
                .closest('.baris-kebutuhan')
                .remove();


            updateNomor();

        }
    );


    /* =====================================================
       NOMOR
    ===================================================== */

    function updateNomor()
    {
        $('.baris-kebutuhan').each(
            function (index) {

                $(this)
                    .find('.nomor')
                    .text(index + 1);

            }
        );
    }


    /* =====================================================
       KODERING
    ===================================================== */

    $(document).on(
        'change',
        '.kategori-select',
        function () {

            var text =
                $(this)
                    .find('option:selected')
                    .text()
                    .trim();


            var preview =
                $(this)
                    .closest('td')
                    .find('.kodering-preview');


            if (!$(this).val()) {

                preview.text('');

                return;
            }


            var kodering =
                text.split(' - ')[0];


            preview.text(
                'Kodering: ' + kodering
            );

        }
    );

});

</script>