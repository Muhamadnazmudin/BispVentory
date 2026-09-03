<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| DATA DASHBOARD
|--------------------------------------------------------------------------
*/

$total_kategori = (int) ($kategori ?? 0);

/*
 * Data Barang sekarang berasal dari nama_barang
 * pada spj_kebutuhan_detail.
 */
$total_barang = (int) ($barang ?? 0);

$total_ruangan = 0;

$total_guru  = (int) ($guru ?? 0);
$total_siswa = (int) ($siswa ?? 0);

$total_spj_kebutuhan    = (int) ($spj_kebutuhan ?? 0);
$total_spj_pemeriksaan  = (int) ($spj_pemeriksaan ?? 0);
$total_spj_internal     = (int) ($spj_internal ?? 0);

$batas_stok = (int) ($batas_stok ?? 10);
$jumlah_stok_menipis = (int) ($jumlah_stok_menipis ?? 0);

$tahun = $tahun ?? date('Y');
$tahun_list = $tahun_list ?? array();
$grafik_pengeluaran = $grafik_pengeluaran ?? array();

$stok_menipis = $stok_menipis ?? array();
?>

<div class="container-fluid">

    <!-- =========================================================
         HEADER
    ========================================================== -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
                Dashboard
            </h1>

            <p class="mb-0 text-muted">
                Ringkasan inventaris dan proses SPJ BispVentory.
            </p>
        </div>

    </div>


    <!-- =========================================================
         DATA MASTER
    ========================================================== -->

    <div class="row">

        <!-- KATEGORI -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Kategori Barang
                            </div>

                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($total_kategori); ?>
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>
        </div>


        <!-- DATA BARANG -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Data Barang
                            </div>

                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($total_barang); ?>
                            </div>

                            <small class="text-muted">
                                Barang dari kebutuhan SPJ
                            </small>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>
        </div>


        <!-- RUANGAN -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Ruangan
                            </div>

                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                0
                            </div>

                            <small class="text-muted">
                                Belum digunakan
                            </small>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-door-open fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>
        </div>


        <!-- GURU -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Guru
                            </div>

                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($total_guru); ?>
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>


    <div class="row">

        <!-- SISWA -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Siswa
                            </div>

                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($total_siswa); ?>
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>


    <!-- =========================================================
         ALUR SPJ
    ========================================================== -->

    <div class="d-sm-flex align-items-center justify-content-between mb-3">

        <div>
            <h5 class="mb-0 font-weight-bold text-gray-800">
                Proses SPJ
            </h5>

            <small class="text-muted">
                Ringkasan dokumen berdasarkan alur SPJ
            </small>
        </div>

    </div>


    <div class="row">

        <!-- INPUT KEBUTUHAN -->
        <div class="col-xl-4 col-md-6 mb-4">

            <div class="card shadow h-100 border-left-primary">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Input Kebutuhan
                            </div>

                            <div class="h4 mb-1 font-weight-bold text-gray-800">
                                <?= number_format($total_spj_kebutuhan); ?>
                            </div>

                            <small class="text-muted">
                                Surat kebutuhan yang sudah diinput
                            </small>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- BAST PEMERIKSAAN -->
        <div class="col-xl-4 col-md-6 mb-4">

            <div class="card shadow h-100 border-left-warning">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                BAST Pemeriksaan
                            </div>

                            <div class="h4 mb-1 font-weight-bold text-gray-800">
                                <?= number_format($total_spj_pemeriksaan); ?>
                            </div>

                            <small class="text-muted">
                                Berita acara pemeriksaan
                            </small>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- BAST INTERNAL -->
        <div class="col-xl-4 col-md-6 mb-4">

            <div class="card shadow h-100 border-left-success">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                BAST Internal
                            </div>

                            <div class="h4 mb-1 font-weight-bold text-gray-800">
                                <?= number_format($total_spj_internal); ?>
                            </div>

                            <small class="text-muted">
                                Dokumen BAST Internal
                            </small>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-file-signature fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- =========================================================
         ALUR SPJ
    ========================================================== -->

    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">
                Alur Dokumen SPJ
            </h6>

        </div>

        <div class="card-body">

            <div class="row align-items-center text-center">

                <div class="col-md-4 mb-3 mb-md-0">

                    <div class="p-3 border rounded">

                        <div class="mb-2">
                            <i class="fas fa-file-alt fa-2x text-primary"></i>
                        </div>

                        <strong>
                            Input Kebutuhan
                        </strong>

                        <div class="small text-muted mt-1">
                            Surat dan detail kebutuhan
                        </div>

                    </div>

                </div>


                <div class="col-md-4 mb-3 mb-md-0">

                    <div class="p-3 border rounded">

                        <div class="mb-2">
                            <i class="fas fa-clipboard-check fa-2x text-warning"></i>
                        </div>

                        <strong>
                            BAST Pemeriksaan
                        </strong>

                        <div class="small text-muted mt-1">
                            Pemeriksaan barang
                        </div>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="p-3 border rounded">

                        <div class="mb-2">
                            <i class="fas fa-file-signature fa-2x text-success"></i>
                        </div>

                        <strong>
                            BAST Internal
                        </strong>

                        <div class="small text-muted mt-1">
                            Dokumen hasil akhir
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- =========================================================
         STOK MENIPIS
    ========================================================== -->

    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex justify-content-between align-items-center">

            <h6 class="m-0 font-weight-bold text-danger">
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Stok Menipis
            </h6>

            <span class="badge badge-danger">
                <?= number_format($jumlah_stok_menipis); ?> barang
            </span>

        </div>

        <div class="card-body">

            <?php if (!empty($stok_menipis)): ?>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover mb-0">

                        <thead class="thead-light">

                            <tr>
                                <th width="50">No</th>
                                <th>Nama Barang</th>
                                <th>Merk</th>
                                <th>Satuan</th>
                                <th width="120" class="text-center">Stok</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php $no = 1; ?>

                            <?php foreach ($stok_menipis as $row): ?>

                                <tr>

                                    <td>
                                        <?= $no++; ?>
                                    </td>

                                    <td>
                                        <?= html_escape($row->nama_barang); ?>
                                    </td>

                                    <td>
                                        <?= html_escape($row->merk ?: '-'); ?>
                                    </td>

                                    <td>
                                        <?= html_escape($row->satuan); ?>
                                    </td>

                                    <td class="text-center font-weight-bold text-danger">
                                        <?= number_format((float) $row->stok, 0, ',', '.'); ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php else: ?>

                <div class="text-center py-4 text-muted">

                    <i class="fas fa-check-circle fa-2x mb-2"></i>

                    <div>
                        Tidak ada stok yang menipis.
                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>


    <!-- =========================================================
         PENGELUARAN BARANG
    ========================================================== -->

    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex justify-content-between align-items-center">

            <h6 class="m-0 font-weight-bold text-primary">
                Pengeluaran Barang
            </h6>

            <form method="get" class="form-inline">

                <label class="mr-2 text-muted small">
                    Tahun
                </label>

                <select
                    name="tahun"
                    class="form-control form-control-sm"
                    onchange="this.form.submit()"
                >

                    <?php if (!empty($tahun_list)): ?>

                        <?php foreach ($tahun_list as $item): ?>

                            <option
                                value="<?= $item->tahun; ?>"
                                <?= ((string) $tahun === (string) $item->tahun)
                                    ? 'selected'
                                    : ''; ?>
                            >
                                <?= $item->tahun; ?>
                            </option>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <option value="<?= date('Y'); ?>">
                            <?= date('Y'); ?>
                        </option>

                    <?php endif; ?>

                </select>

            </form>

        </div>

        <div class="card-body">

            <div style="height: 320px;">
                <canvas id="chartPengeluaran"></canvas>
            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     CHART
========================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const canvas = document.getElementById('chartPengeluaran');

    if (!canvas) {
        return;
    }

    const ctx = canvas.getContext('2d');

    const dataPengeluaran = <?= json_encode(
        array_values($grafik_pengeluaran)
    ); ?>;

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            ],

            datasets: [{
                label: 'Jumlah Pengeluaran',
                data: dataPengeluaran,
                borderWidth: 1
            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            scales: {

                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }

            },

            plugins: {

                legend: {
                    display: false
                }

            }

        }

    });

});

</script>