<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/*
|--------------------------------------------------------------------------
| MODE FORM
|--------------------------------------------------------------------------
|
| Jika $bast tersedia dan memiliki ID:
|   = EDIT
|
| Jika tidak:
|   = TAMBAH
|
*/

$is_edit =
    isset($bast) &&
    !empty($bast->id_bast_pemeriksaan);


/*
|--------------------------------------------------------------------------
| JUDUL
|--------------------------------------------------------------------------
*/

$judul =
    $is_edit
        ? 'Edit BAST Pemeriksaan'
        : 'Tambah BAST Pemeriksaan';


/*
|--------------------------------------------------------------------------
| NOMOR BAST
|--------------------------------------------------------------------------
*/

$nomor_bast =
    $is_edit &&
    isset($bast->nomor_bast)
        ? $bast->nomor_bast
        : '';


/*
|--------------------------------------------------------------------------
| NOMOR KEPUTUSAN
|--------------------------------------------------------------------------
|
| Nomor ini berlaku sama untuk seluruh BA Pemeriksaan.
|
*/

$nomor_keputusan =
    '110/PK.02.01/SMKN1 Clms';


/*
|--------------------------------------------------------------------------
| ACTION FORM
|--------------------------------------------------------------------------
*/

if ($is_edit) {

    $form_action =
        site_url(
            'spj/edit_bast_pemeriksaan/' .
            $bast->id_bast_pemeriksaan
        );

} else {

    $form_action =
        site_url(
            'spj/tambah_bast_pemeriksaan/' .
            $kebutuhan->id_kebutuhan
        );
}

?>

<div class="container-fluid">


<!-- =========================================================
     HEADER
========================================================== -->

<div class="d-flex align-items-center justify-content-between mb-4">

    <div>

        <h1 class="h3 mb-1 text-gray-800">

            <?= html_escape($judul) ?>

        </h1>


        <div class="small text-muted">

            Data diambil otomatis dari Input Kebutuhan.

        </div>

    </div>


    <a
        href="<?= site_url('spj/bast_pemeriksaan') ?>"
        class="btn btn-secondary btn-sm"
    >

        <i class="fas fa-arrow-left mr-1"></i>

        Kembali

    </a>

</div>


<!-- =========================================================
     ERROR
========================================================== -->

<?php if ($this->session->flashdata('error')): ?>

    <div class="alert alert-danger">

        <?= html_escape(
            $this->session->flashdata('error')
        ) ?>

    </div>

<?php endif; ?>


<!-- =========================================================
     SUCCESS
========================================================== -->

<?php if ($this->session->flashdata('success')): ?>

    <div class="alert alert-success">

        <?= html_escape(
            $this->session->flashdata('success')
        ) ?>

    </div>

<?php endif; ?>


<!-- =========================================================
     FORM
========================================================== -->

<form
    method="post"
    action="<?= $form_action ?>"
>


    <!-- =====================================================
         DATA BAST
    ====================================================== -->

    <div class="card shadow mb-4">


        <div class="card-header">

            <strong class="text-primary">

                <i class="fas fa-file-signature mr-1"></i>

                Data BAST Pemeriksaan

            </strong>

        </div>


        <div class="card-body">

            <div class="row">


                <!-- =================================================
                     NOMOR BAST
                ================================================== -->

                <div class="col-md-6">

                    <div class="form-group">

                        <label class="font-weight-bold">

                            Nomor BAST

                            <span class="text-danger">
                                *
                            </span>

                        </label>


                        <input
                            type="text"
                            name="nomor_bast"
                            class="form-control"
                            placeholder="Contoh: 001/BA-Pemeriksaan/VII/2026"
                            value="<?= html_escape(
                                $nomor_bast
                            ) ?>"
                            autocomplete="off"
                            required
                        >

                    </div>

                </div>


                <!-- =================================================
                     NOMOR KEPUTUSAN
                ================================================== -->

                <div class="col-md-6">

                    <div class="form-group">

                        <label class="font-weight-bold">

                            Nomor Keputusan

                        </label>


                        <input
                            type="text"
                            name="nomor_keputusan"
                            class="form-control"
                            value="<?= html_escape(
                                $nomor_keputusan
                            ) ?>"
                            readonly
                        >


                        <small class="form-text text-muted">

                            Nomor keputusan berlaku sama untuk seluruh
                            Berita Acara Pemeriksaan.

                        </small>

                    </div>

                </div>


            </div>

        </div>

    </div>


    <!-- =========================================================
         SUMBER KEBUTUHAN
    ========================================================== -->

    <div class="card shadow mb-4">


        <div class="card-header">

            <strong class="text-primary">

                <i class="fas fa-database mr-1"></i>

                Data Kebutuhan

            </strong>

        </div>


        <div class="card-body">

            <div class="row">


                <!-- =================================================
                     NOMOR SURAT
                ================================================== -->

                <div class="col-md-6">

                    <label class="font-weight-bold">

                        Nomor Surat

                    </label>


                    <input
                        type="text"
                        class="form-control mb-3"
                        value="<?= html_escape(
                            $kebutuhan->nomor_surat ?? ''
                        ) ?>"
                        readonly
                    >

                </div>


                <!-- =================================================
                     TANGGAL PEMERIKSAAN
                ================================================== -->

                <div class="col-md-6">

                    <label class="font-weight-bold">

                        Tanggal Pemeriksaan

                    </label>


                    <input
                        type="text"
                        class="form-control mb-3"
                        value="<?= !empty(
                            $kebutuhan->tanggal
                        )
                            ? date(
                                'd-m-Y',
                                strtotime(
                                    $kebutuhan->tanggal
                                )
                            )
                            : ''
                        ?>"
                        readonly
                    >

                </div>


                <!-- =================================================
                     NOMOR INVOICE
                ================================================== -->

                <div class="col-md-4">

                    <label class="font-weight-bold">

                        Nomor Invoice

                    </label>


                    <input
                        type="text"
                        class="form-control"
                        value="<?= html_escape(
                            $kebutuhan->nomor_invoice ?? ''
                        ) ?>"
                        readonly
                    >

                </div>


                <!-- =================================================
                     NOMOR PESANAN
                ================================================== -->

                <div class="col-md-4">

                    <label class="font-weight-bold">

                        Nomor Pesanan

                    </label>


                    <input
                        type="text"
                        class="form-control"
                        value="<?= html_escape(
                            $kebutuhan->nomor_pesanan ?? ''
                        ) ?>"
                        readonly
                    >

                </div>


                <!-- =================================================
                     PENYEDIA
                ================================================== -->

                <div class="col-md-4">

                    <label class="font-weight-bold">

                        CV/Penyedia

                    </label>


                    <input
                        type="text"
                        class="form-control"
                        value="<?= html_escape(
                            $kebutuhan->nama_penyedia ?? ''
                        ) ?>"
                        readonly
                    >

                </div>


            </div>

        </div>

    </div>


    <!-- =========================================================
         RINCIAN BARANG
    ========================================================== -->

    <div class="card shadow mb-4">


        <div class="card-header">

            <strong class="text-primary">

                <i class="fas fa-boxes mr-1"></i>

                Rincian Barang/Jasa

            </strong>

        </div>


        <div class="card-body">

            <div class="table-responsive">


                <table class="table table-bordered">


                    <thead class="thead-light">

                        <tr>

                            <th width="5%">
                                No
                            </th>

                            <th width="15%">
                                Kodering
                            </th>

                            <th>
                                Nama Barang/Jasa
                            </th>

                            <th width="12%">
                                Unit
                            </th>

                            <th width="12%">
                                Satuan
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php $no = 1; ?>


                    <?php if (!empty($detail)): ?>


                        <?php foreach ($detail as $row): ?>

                            <tr>


                                <td>

                                    <?= $no++ ?>.

                                </td>


                                <td>

                                    <?= html_escape(
                                        $row->kodering ?? ''
                                    ) ?>

                                </td>


                                <td>

                                    <?= html_escape(
                                        $row->nama_barang ?? ''
                                    ) ?>

                                </td>


                                <td>

                                    <?= rtrim(
                                        rtrim(
                                            number_format(
                                                (float) (
                                                    $row->jumlah ?? 0
                                                ),
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

                                    <?= html_escape(
                                        $row->satuan ?? ''
                                    ) ?>

                                </td>


                            </tr>

                        <?php endforeach; ?>


                    <?php else: ?>


                        <tr>

                            <td
                                colspan="5"
                                class="text-center text-muted"
                            >

                                Tidak ada rincian barang/jasa.

                            </td>

                        </tr>


                    <?php endif; ?>


                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- =========================================================
         TOMBOL
    ========================================================== -->

    <div class="text-right mb-4">


        <a
            href="<?= site_url('spj/bast_pemeriksaan') ?>"
            class="btn btn-secondary"
        >

            Batal

        </a>


        <button
            type="submit"
            class="btn btn-primary"
        >

            <i class="fas fa-save mr-1"></i>


            <?= $is_edit
                ? 'Simpan Perubahan'
                : 'Simpan BAST Pemeriksaan'
            ?>


        </button>


    </div>


</form>


</div>
