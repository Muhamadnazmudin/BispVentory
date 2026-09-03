<div class="container-fluid">

    <!-- =========================================================
         HEADER
    ========================================================== -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>
            <h1 class="h3 mb-1 text-gray-800">
                Input Kebutuhan
            </h1>

            <div class="text-muted small">
                Pengajuan kebutuhan barang/jasa sekolah
            </div>
        </div>

        <div class="d-flex align-items-center flex-wrap">

            <!-- DOWNLOAD TEMPLATE -->

            <a href="<?= base_url('spj/download_template_kebutuhan') ?>"
               class="btn btn-success btn-sm mr-2 mb-1">

                <i class="fas fa-file-excel mr-1"></i>
                Download Template

            </a>


            <!-- IMPORT EXCEL -->

            <a href="<?= base_url('spj/import_kebutuhan') ?>"
               class="btn btn-warning btn-sm mr-2 mb-1">

                <i class="fas fa-upload mr-1"></i>
                Import Excel

            </a>


            <!-- INPUT MANUAL -->

            <a href="<?= base_url('spj/tambah_kebutuhan') ?>"
               class="btn btn-primary btn-sm mb-1">

                <i class="fas fa-plus mr-1"></i>
                Input Kebutuhan

            </a>

        </div>

    </div>


    <!-- =========================================================
         FLASH MESSAGE
    ========================================================== -->

    <?php if ($this->session->flashdata('success')): ?>

        <div class="alert alert-success alert-dismissible fade show">

            <i class="fas fa-check-circle mr-1"></i>

            <?= $this->session->flashdata('success') ?>

            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close">

                <span aria-hidden="true">&times;</span>

            </button>

        </div>

    <?php endif; ?>


    <?php if ($this->session->flashdata('error')): ?>

        <div class="alert alert-danger alert-dismissible fade show">

            <i class="fas fa-exclamation-circle mr-1"></i>

            <?= $this->session->flashdata('error') ?>

            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close">

                <span aria-hidden="true">&times;</span>

            </button>

        </div>

    <?php endif; ?>


    <!-- =========================================================
         CARD DAFTAR KEBUTUHAN
    ========================================================== -->

    <div class="card shadow-sm mb-4">

        <!-- =====================================================
             CARD HEADER
        ====================================================== -->

        <div class="card-header py-3">

            <div class="d-flex align-items-center justify-content-between">

                <div>

                    <h6 class="m-0 font-weight-bold text-primary">

                        <i class="fas fa-clipboard-list mr-1"></i>
                        Daftar Kebutuhan

                    </h6>

                </div>


                <div class="text-muted small">

                    <span id="jumlahHasil" class="font-weight-bold">
                        <?= !empty($kebutuhan) ? count($kebutuhan) : 0 ?>
                    </span>

                    pengajuan

                </div>

            </div>

        </div>


        <div class="card-body">

            <!-- =================================================
                 FILTER
            ================================================== -->

            <div class="row mb-4">

                <!-- CARI NOMOR SURAT -->

                <div class="col-md-5 mb-2">

                    <label for="filterNomorSurat"
                           class="small font-weight-bold text-gray-700">

                        Cari Nomor Surat

                    </label>

                    <div class="input-group input-group-sm">

                        <div class="input-group-prepend">

                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>

                        </div>

                        <input type="text"
                               id="filterNomorSurat"
                               class="form-control"
                               placeholder="Ketik nomor surat...">

                    </div>

                </div>


                <!-- FILTER BULAN -->

                <div class="col-md-3 mb-2">

                    <label for="filterBulan"
                           class="small font-weight-bold text-gray-700">

                        Filter Bulan

                    </label>

                    <select id="filterBulan"
                            class="form-control form-control-sm">

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

                <div class="col-md-2 mb-2 d-flex align-items-end">

                    <button type="button"
                            id="resetFilter"
                            class="btn btn-secondary btn-sm btn-block">

                        <i class="fas fa-sync-alt mr-1"></i>
                        Reset

                    </button>

                </div>

            </div>


            <!-- =================================================
                 TABLE
            ================================================== -->

            <div class="table-responsive">

                <table class="table table-bordered table-hover mb-0"
                       id="tabelKebutuhan">

                    <thead class="thead-light">

                        <tr>

                            <th width="5%"
                                class="text-center align-middle">
                                No
                            </th>

                            <th width="27%"
                                class="align-middle">
                                Nomor Surat
                            </th>

                            <th class="align-middle">
                                Perihal
                            </th>

                            <th width="12%"
                                class="align-middle">
                                Tanggal
                            </th>

                            <th width="9%"
                                class="text-center align-middle">
                                Item
                            </th>

                            <th width="18%"
                                class="text-center align-middle">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php if (!empty($kebutuhan)): ?>

                            <?php foreach ($kebutuhan as $row): ?>

                                <?php

                                $tanggal_data = !empty($row->tanggal)
                                    ? date(
                                        'Y-m-d',
                                        strtotime($row->tanggal)
                                    )
                                    : '';

                                $bulan_data = !empty($row->tanggal)
                                    ? date(
                                        'm',
                                        strtotime($row->tanggal)
                                    )
                                    : '';

                                ?>

                                <tr class="barisKebutuhan"
    data-nomor="<?= html_escape($row->nomor_surat) ?>"
    data-invoice="<?= html_escape($row->nomor_invoice ?? '') ?>"
    data-pesanan="<?= html_escape($row->nomor_pesanan ?? '') ?>"
    data-penyedia="<?= html_escape($row->nama_penyedia ?? '') ?>"
    data-bulan="<?= date('m', strtotime($row->tanggal)) ?>">

                                    <!-- =================================================
                                         NO
                                    ================================================== -->

                                    <td class="text-center align-middle nomorUrut">
                                        -
                                    </td>


                                    <!-- =================================================
                                         NOMOR SURAT + INFORMASI TAMBAHAN
                                    ================================================== -->

                                    <td class="align-middle">

                                        <div class="font-weight-bold text-gray-800">

                                            <?= html_escape(
                                                $row->nomor_surat
                                            ) ?>

                                        </div>


                                        <!-- NOMOR INVOICE -->

                                        <?php if (!empty($row->nomor_invoice)): ?>

                                            <div class="small text-muted mt-1">

                                                <i class="fas fa-file-invoice mr-1"></i>

                                                Invoice:
                                                <?= html_escape(
                                                    $row->nomor_invoice
                                                ) ?>

                                            </div>

                                        <?php endif; ?>


                                        <!-- NOMOR PESANAN -->

                                        <?php if (!empty($row->nomor_pesanan)): ?>

                                            <div class="small text-muted">

                                                <i class="fas fa-shopping-cart mr-1"></i>

                                                Pesanan:
                                                <?= html_escape(
                                                    $row->nomor_pesanan
                                                ) ?>

                                            </div>

                                        <?php endif; ?>


                                        <!-- PENYEDIA -->

                                        <?php if (!empty($row->nama_penyedia)): ?>

                                            <div class="small text-muted">

                                                <i class="fas fa-building mr-1"></i>

                                                <?= html_escape(
                                                    $row->nama_penyedia
                                                ) ?>

                                            </div>

                                        <?php endif; ?>

                                    </td>


                                    <!-- =================================================
                                         PERIHAL
                                    ================================================== -->

                                    <td class="align-middle">

                                        <?= html_escape(
                                            $row->perihal
                                        ) ?>

                                    </td>


                                    <!-- =================================================
                                         TANGGAL
                                    ================================================== -->

                                    <td class="align-middle">

                                        <?php if (!empty($tanggal_data)): ?>

                                            <span class="text-nowrap">

                                                <i class="far fa-calendar-alt mr-1 text-muted"></i>

                                                <?= date(
                                                    'd-m-Y',
                                                    strtotime($tanggal_data)
                                                ) ?>

                                            </span>

                                        <?php else: ?>

                                            -

                                        <?php endif; ?>

                                    </td>


                                    <!-- =================================================
                                         JUMLAH ITEM
                                    ================================================== -->

                                    <td class="text-center align-middle">

                                        <span class="badge badge-info px-2 py-1">

                                            <?= (int) $row->jumlah_item ?>

                                        </span>

                                    </td>


                                    <!-- =================================================
                                         AKSI
                                    ================================================== -->

                                    <td class="text-center align-middle">

                                        <div class="d-flex justify-content-center">

                                            <!-- DETAIL -->

                                            <a href="<?= base_url(
                                                'spj/detail_kebutuhan/' .
                                                $row->id_kebutuhan
                                            ) ?>"
                                               class="btn btn-info btn-sm mr-1"
                                               title="Lihat Detail">

                                                <i class="fas fa-eye"></i>

                                            </a>


                                            <!-- EDIT -->

                                            <a href="<?= base_url(
                                                'spj/edit_kebutuhan/' .
                                                $row->id_kebutuhan
                                            ) ?>"
                                               class="btn btn-warning btn-sm mr-1"
                                               title="Edit Kebutuhan">

                                                <i class="fas fa-edit"></i>

                                            </a>


                                            <!-- PDF -->

                                            <a href="<?= base_url(
                                                'spj/cetak_kebutuhan/' .
                                                $row->id_kebutuhan
                                            ) ?>"
                                               class="btn btn-danger btn-sm mr-1"
                                               target="_blank"
                                               title="Cetak PDF">

                                                <i class="fas fa-file-pdf"></i>

                                            </a>


                                            <!-- HAPUS -->

                                            <a href="<?= base_url(
                                                'spj/hapus_kebutuhan/' .
                                                $row->id_kebutuhan
                                            ) ?>"
                                               class="btn btn-danger btn-sm"
                                               title="Hapus"
                                               onclick="return confirm(
                                                   'Yakin ingin menghapus data kebutuhan ini?'
                                               )">

                                                <i class="fas fa-trash"></i>

                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            <?php endforeach; ?>


                            <!-- =================================================
                                 TIDAK DITEMUKAN
                            ================================================== -->

                            <tr id="dataTidakDitemukan"
                                style="display:none;">

                                <td colspan="6"
                                    class="text-center text-muted py-5">

                                    <i class="fas fa-search fa-2x mb-3"></i>

                                    <div class="font-weight-bold">
                                        Data tidak ditemukan.
                                    </div>

                                    <div class="small mt-1">
                                        Coba ubah nomor surat atau filter bulan.
                                    </div>

                                </td>

                            </tr>


                        <?php else: ?>

                            <!-- =================================================
                                 DATA KOSONG
                            ================================================== -->

                            <tr>

                                <td colspan="6"
                                    class="text-center text-muted py-5">

                                    <i class="fas fa-folder-open fa-2x mb-3"></i>

                                    <div class="font-weight-bold">
                                        Belum ada data kebutuhan.
                                    </div>

                                    <div class="small mt-1">
                                        Silakan input manual atau gunakan
                                        template Excel.
                                    </div>

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<!-- =============================================================
     FILTER SCRIPT
============================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const inputNomor =
        document.getElementById('filterNomorSurat');

    const selectBulan =
        document.getElementById('filterBulan');

    const tombolReset =
        document.getElementById('resetFilter');

    const baris =
        document.querySelectorAll('.barisKebutuhan');

    const dataTidakDitemukan =
        document.getElementById('dataTidakDitemukan');

    const jumlahHasil =
        document.getElementById('jumlahHasil');


    /*
    |--------------------------------------------------------------------------
    | FILTER DATA
    |--------------------------------------------------------------------------
    */

    function filterData() {

    const keyword =
        inputNomor
            ? inputNomor.value
                .toLowerCase()
                .trim()
            : '';

    const bulan =
        selectBulan
            ? selectBulan.value
            : '';

    let jumlah = 0;


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN / SEMBUNYIKAN BARIS
        |--------------------------------------------------------------------------
        */

        baris.forEach(function (row) {

    const nomor =
        (
            row.getAttribute('data-nomor') || ''
        ).toLowerCase();

    const invoice =
        (
            row.getAttribute('data-invoice') || ''
        ).toLowerCase();

    const pesanan =
        (
            row.getAttribute('data-pesanan') || ''
        ).toLowerCase();

    const penyedia =
        (
            row.getAttribute('data-penyedia') || ''
        ).toLowerCase();

    const bulanData =
        row.getAttribute(
            'data-bulan'
        ) || '';


    const cocokNomor =
        keyword === '' ||
        nomor.indexOf(keyword) !== -1 ||
        invoice.indexOf(keyword) !== -1 ||
        pesanan.indexOf(keyword) !== -1 ||
        penyedia.indexOf(keyword) !== -1;


    const cocokBulan =
        bulan === '' ||
        bulanData === bulan;


    if (
        cocokNomor &&
        cocokBulan
    ) {

        row.style.display = '';

        jumlah++;

    } else {

        row.style.display = 'none';

    }

});


        /*
        |--------------------------------------------------------------------------
        | NOMOR URUT DINAMIS
        |--------------------------------------------------------------------------
        */

        let nomorUrut = 1;


        baris.forEach(function (row) {

            if (
                row.style.display !== 'none'
            ) {

                const cell =
                    row.querySelector(
                        '.nomorUrut'
                    );


                if (cell) {

                    cell.textContent =
                        nomorUrut++;

                }

            }

        });


        /*
        |--------------------------------------------------------------------------
        | JUMLAH HASIL
        |--------------------------------------------------------------------------
        */

        if (jumlahHasil) {

            jumlahHasil.textContent =
                jumlah;

        }


        /*
        |--------------------------------------------------------------------------
        | DATA TIDAK DITEMUKAN
        |--------------------------------------------------------------------------
        */

        if (dataTidakDitemukan) {

            dataTidakDitemukan.style.display =
                jumlah === 0
                    ? ''
                    : 'none';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | PENCARIAN
    |--------------------------------------------------------------------------
    */

    if (inputNomor) {

        inputNomor.addEventListener(
            'input',
            filterData
        );

    }


    /*
    |--------------------------------------------------------------------------
    | FILTER BULAN
    |--------------------------------------------------------------------------
    */

    if (selectBulan) {

        selectBulan.addEventListener(
            'change',
            filterData
        );

    }


    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    if (tombolReset) {

        tombolReset.addEventListener(
            'click',
            function () {

                if (inputNomor) {
                    inputNomor.value = '';
                }

                if (selectBulan) {
                    selectBulan.value = '';
                }

                filterData();

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | INIT
    |--------------------------------------------------------------------------
    */

    filterData();

});

</script>