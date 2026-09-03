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


        <div class="d-flex align-items-center">

            <!-- DOWNLOAD TEMPLATE -->

            <a href="<?= base_url('spj/download_template_kebutuhan') ?>"
               class="btn btn-success mr-2">

                <i class="fas fa-file-excel mr-1"></i>
                Download Template

            </a>


            <!-- IMPORT EXCEL -->

            <a href="<?= base_url('spj/import_kebutuhan') ?>"
               class="btn btn-warning mr-2">

                <i class="fas fa-upload mr-1"></i>
                Import Excel

            </a>


            <!-- EXPORT EXCEL -->

            <!-- <a href="<?= base_url('spj/export_kebutuhan') ?>"
               class="btn btn-info mr-2">

                <i class="fas fa-download mr-1"></i>
                Export Excel

            </a> -->


            <!-- INPUT MANUAL -->

            <a href="<?= base_url('spj/tambah_kebutuhan') ?>"
               class="btn btn-primary">

                <i class="fas fa-plus mr-1"></i>
                Input Kebutuhan

            </a>

        </div>

    </div>


    <!-- =========================================================
         FLASH MESSAGE
    ========================================================== -->

    <?php if ($this->session->flashdata('success')): ?>

        <div class="alert alert-success">

            <i class="fas fa-check-circle mr-1"></i>

            <?= $this->session->flashdata('success') ?>

        </div>

    <?php endif; ?>


    <?php if ($this->session->flashdata('error')): ?>

        <div class="alert alert-danger">

            <i class="fas fa-exclamation-circle mr-1"></i>

            <?= $this->session->flashdata('error') ?>

        </div>

    <?php endif; ?>


    <!-- =========================================================
         CARD DAFTAR KEBUTUHAN
    ========================================================== -->

    <div class="card shadow mb-4">

        <!-- =====================================================
             CARD HEADER
        ====================================================== -->

        <div class="card-header py-3">

            <div class="d-flex align-items-center justify-content-between">

                <h6 class="m-0 font-weight-bold text-primary">

                    <i class="fas fa-clipboard-list mr-1"></i>

                    Daftar Kebutuhan

                </h6>


                <span class="text-muted small">

                    <span id="jumlahHasil">
                        <?= !empty($kebutuhan) ? count($kebutuhan) : 0 ?>
                    </span>

                    pengajuan

                </span>

            </div>

        </div>


        <div class="card-body">

            <!-- =================================================
                 FILTER
            ================================================== -->

            <div class="row mb-4">

                <!-- PENCARIAN NOMOR SURAT -->

                <div class="col-md-5 mb-2">

                    <label class="small font-weight-bold text-gray-700 mb-1">
                        Cari Nomor Surat
                    </label>

                    <div class="input-group">

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

                    <label class="small font-weight-bold text-gray-700 mb-1">
                        Filter Bulan
                    </label>

                    <select id="filterBulan"
                            class="form-control">

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
                            class="btn btn-secondary btn-block">

                        <i class="fas fa-sync-alt mr-1"></i>
                        Reset

                    </button>

                </div>

            </div>


            <!-- =================================================
                 TABLE
            ================================================== -->

            <div class="table-responsive">

                <table class="table table-bordered table-hover"
                       id="tabelKebutuhan">

                    <thead class="thead-light">

                        <tr>

                            <th width="5%" class="text-center">
                                No
                            </th>

                            <th>
                                Nomor Surat
                            </th>

                            <th>
                                Perihal
                            </th>

                            <th width="12%">
                                Tanggal
                            </th>

                            <th width="10%" class="text-center">
                                Item
                            </th>

                            <th width="18%" class="text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php if (!empty($kebutuhan)): ?>

                            <?php foreach ($kebutuhan as $row): ?>

                                <?php
                                $tanggal_data = !empty($row->tanggal)
                                    ? date('Y-m-d', strtotime($row->tanggal))
                                    : '';

                                $bulan_data = !empty($row->tanggal)
                                    ? date('m', strtotime($row->tanggal))
                                    : '';
                                ?>

                                <tr class="barisKebutuhan"
                                    data-nomor="<?= html_escape(strtolower($row->nomor_surat)) ?>"
                                    data-bulan="<?= html_escape($bulan_data) ?>">

                                    <!-- NO -->

                                    <td class="text-center nomorUrut">
                                        -
                                    </td>


                                    <!-- NOMOR SURAT -->

                                    <td>

                                        <span class="font-weight-bold">

                                            <?= html_escape(
                                                $row->nomor_surat
                                            ) ?>

                                        </span>

                                    </td>


                                    <!-- PERIHAL -->

                                    <td>

                                        <?= html_escape(
                                            $row->perihal
                                        ) ?>

                                    </td>


                                    <!-- TANGGAL -->

                                    <td>

                                        <?php if (!empty($tanggal_data)): ?>

                                            <?= date(
                                                'd-m-Y',
                                                strtotime($tanggal_data)
                                            ) ?>

                                        <?php else: ?>

                                            -

                                        <?php endif; ?>

                                    </td>


                                    <!-- JUMLAH ITEM -->

                                    <td class="text-center">

                                        <span class="badge badge-info">

                                            <?= (int) $row->jumlah_item ?>

                                        </span>

                                    </td>


                                    <!-- AKSI -->

                                    <td class="text-center">

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


                            <!-- DATA TIDAK DITEMUKAN -->

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

                            <!-- DATA KOSONG -->

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

    const inputNomor = document.getElementById('filterNomorSurat');
    const selectBulan = document.getElementById('filterBulan');
    const tombolReset = document.getElementById('resetFilter');

    const baris = document.querySelectorAll('.barisKebutuhan');
    const dataTidakDitemukan =
        document.getElementById('dataTidakDitemukan');

    const jumlahHasil =
        document.getElementById('jumlahHasil');


    function filterData() {

        const keyword =
            inputNomor.value
                .toLowerCase()
                .trim();

        const bulan =
            selectBulan.value;

        let jumlah = 0;


        baris.forEach(function (row) {

            const nomor =
                row.getAttribute('data-nomor') || '';

            const bulanData =
                row.getAttribute('data-bulan') || '';


            const cocokNomor =
                nomor.indexOf(keyword) !== -1;

            const cocokBulan =
                bulan === '' ||
                bulanData === bulan;


            if (cocokNomor && cocokBulan) {

                row.style.display = '';

                jumlah++;

            } else {

                row.style.display = 'none';

            }

        });


        /*
         * UPDATE NOMOR URUT
         */

        let nomorUrut = 1;

        baris.forEach(function (row) {

            if (row.style.display !== 'none') {

                const cell =
                    row.querySelector('.nomorUrut');

                if (cell) {
                    cell.textContent = nomorUrut++;
                }

            }

        });


        /*
         * UPDATE JUMLAH
         */

        if (jumlahHasil) {
            jumlahHasil.textContent = jumlah;
        }


        /*
         * DATA TIDAK DITEMUKAN
         */

        if (dataTidakDitemukan) {

            dataTidakDitemukan.style.display =
                jumlah === 0 ? '' : 'none';

        }

    }


    /*
     * PENCARIAN NOMOR SURAT
     */

    if (inputNomor) {

        inputNomor.addEventListener(
            'input',
            filterData
        );

    }


    /*
     * FILTER BULAN
     */

    if (selectBulan) {

        selectBulan.addEventListener(
            'change',
            filterData
        );

    }


    /*
     * RESET FILTER
     */

    if (tombolReset) {

        tombolReset.addEventListener(
            'click',
            function () {

                inputNomor.value = '';
                selectBulan.value = '';

                filterData();

            }
        );

    }


    /*
     * INISIALISASI
     */

    filterData();

});

</script>