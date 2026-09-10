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
| TANGGAL PEMERIKSAAN
|--------------------------------------------------------------------------
|
| EDIT:
|   Ambil dari data BAST.
|
| TAMBAH:
|   Default hari ini, tetapi tetap bisa diubah manual.
|
*/

$tanggal_pemeriksaan =
    $is_edit &&
    !empty($bast->tanggal_pemeriksaan)
        ? $bast->tanggal_pemeriksaan
        : date('Y-m-d');


/*
|--------------------------------------------------------------------------
| NOMOR KEPUTUSAN
|--------------------------------------------------------------------------
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
                Isi tanggal pemeriksaan sesuai tanggal pelaksanaan pemeriksaan.
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

            <i class="fas fa-exclamation-circle mr-1"></i>

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

            <i class="fas fa-check-circle mr-1"></i>

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
        id="formBastPemeriksaan"
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


                    <!-- =================================================
                         TANGGAL PEMERIKSAAN
                    ================================================== -->

                    <div class="col-md-6">

                        <div class="form-group">

                            <label class="font-weight-bold">

                                Tanggal Pemeriksaan

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <input
                                type="date"
                                name="tanggal_pemeriksaan"
                                class="form-control"
                                value="<?= html_escape(
                                    $tanggal_pemeriksaan
                                ) ?>"
                                required
                            >


                            <small class="form-text text-muted">

                                Tentukan tanggal saat pemeriksaan
                                barang/jasa dilaksanakan.

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

                        <div class="form-group">

                            <label class="font-weight-bold">
                                Nomor Surat
                            </label>


                            <input
                                type="text"
                                class="form-control"
                                value="<?= html_escape(
                                    $kebutuhan->nomor_surat ?? ''
                                ) ?>"
                                readonly
                            >

                        </div>

                    </div>


                    <!-- =================================================
                         TANGGAL KEBUTUHAN
                    ================================================== -->

                    <div class="col-md-6">

                        <div class="form-group">

                            <label class="font-weight-bold">
                                Tanggal Kebutuhan
                            </label>


                            <input
                                type="text"
                                class="form-control"
                                value="<?= !empty(
                                    $kebutuhan->tanggal
                                )
                                    ? date(
                                        'd-m-Y',
                                        strtotime(
                                            $kebutuhan->tanggal
                                        )
                                    )
                                    : '-'
                                ?>"
                                readonly
                            >


                            <small class="form-text text-muted">

                                Tanggal ini berasal dari Input Kebutuhan
                                dan hanya sebagai informasi referensi.

                            </small>

                        </div>

                    </div>


                    <!-- =================================================
                         NOMOR INVOICE
                    ================================================== -->

                    <div class="col-md-4">

                        <div class="form-group">

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

                    </div>


                    <!-- =================================================
                         NOMOR PESANAN
                    ================================================== -->

                    <div class="col-md-4">

                        <div class="form-group">

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

                    </div>


                    <!-- =================================================
                         CV / PENYEDIA
                    ================================================== -->

                    <div class="col-md-4">

                        <div class="form-group">

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


                    <table class="table table-bordered table-hover">


                        <thead class="thead-light">

                            <tr>

                                <th
                                    width="5%"
                                    class="text-center"
                                >
                                    No
                                </th>

                                <th width="15%">
                                    Kodering
                                </th>

                                <th>
                                    Nama Barang/Jasa
                                </th>

                                <th
                                    width="12%"
                                    class="text-right"
                                >
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


                                    <td class="text-center">

                                        <?= $no++ ?>

                                    </td>


                                    <td>

                                        <?= !empty(
                                            $row->kodering
                                        )
                                            ? html_escape(
                                                $row->kodering
                                            )
                                            : '-'
                                        ?>

                                    </td>


                                    <td>

                                        <?= !empty(
                                            $row->nama_barang
                                        )
                                            ? html_escape(
                                                $row->nama_barang
                                            )
                                            : '-'
                                        ?>

                                    </td>


                                    <td class="text-right">

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

                                        <?= !empty(
                                            $row->satuan
                                        )
                                            ? html_escape(
                                                $row->satuan
                                            )
                                            : '-'
                                        ?>

                                    </td>


                                </tr>

                            <?php endforeach; ?>


                        <?php else: ?>


                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center text-muted py-4"
                                >

                                    <i class="fas fa-inbox fa-2x mb-2"></i>

                                    <div>
                                        Tidak ada rincian barang/jasa.
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
             TOMBOL
        ========================================================== -->

        <div class="d-flex justify-content-end mb-4">


            <a
                href="<?= site_url('spj/bast_pemeriksaan') ?>"
                class="btn btn-secondary mr-2"
            >

                <i class="fas fa-times mr-1"></i>

                Batal

            </a>


            <button
                type="submit"
                class="btn btn-primary"
                id="btnSimpan"
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


<!-- =========================================================
     STYLE
========================================================= -->

<style>

.table th {
    vertical-align: middle;
    font-size: 12px;
    font-weight: 700;
}

.table td {
    vertical-align: middle;
}

.form-control[readonly] {
    background-color: #f8f9fc;
}

@media (max-width: 767.98px) {

    .card-body {
        padding: 15px;
    }

}

</style>


<!-- =========================================================
     SCRIPT
========================================================= -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const form =
        document.getElementById('formBastPemeriksaan');

    const btnSimpan =
        document.getElementById('btnSimpan');


    if (!form || !btnSimpan) {
        return;
    }


    form.addEventListener('submit', function (event) {

        const tanggal =
            form.querySelector(
                '[name="tanggal_pemeriksaan"]'
            );


        if (
            !tanggal ||
            !tanggal.value
        ) {

            event.preventDefault();

            alert(
                'Tanggal pemeriksaan wajib diisi.'
            );


            if (tanggal) {
                tanggal.focus();
            }


            return;

        }


        btnSimpan.disabled = true;


        btnSimpan.innerHTML =
            '<i class="fas fa-spinner fa-spin mr-1"></i>' +
            ' Menyimpan...';

    });

});

</script>