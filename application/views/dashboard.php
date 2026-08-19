<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| DASHBOARD BISPVENTORY
|--------------------------------------------------------------------------
*/

$total_permohonan = (int) $permohonan_total;
$total_disetujui  = (int) $permohonan_setujui;
$total_ditolak    = (int) $permohonan_tolak;
$total_pending    = (int) $permohonan_pending;

$persen_disetujui = $total_permohonan > 0
    ? round(($total_disetujui / $total_permohonan) * 100)
    : 0;

$persen_ditolak = $total_permohonan > 0
    ? round(($total_ditolak / $total_permohonan) * 100)
    : 0;

$persen_pending = $total_permohonan > 0
    ? round(($total_pending / $total_permohonan) * 100)
    : 0;
?>

<style>

/* =========================================================
   DASHBOARD
========================================================= */

.dashboard-page {
    padding-bottom: 40px;
}


/* =========================================================
   HEADER
========================================================= */

.dashboard-header {
    position: relative;

    padding: 25px 28px;

    margin-bottom: 25px;

    border-radius: 16px;

    background:
        linear-gradient(
            135deg,
            #4e73df 0%,
            #224abe 100%
        );

    color: #fff;

    overflow: hidden;

    box-shadow:
        0 8px 24px rgba(78,115,223,.18);
}

.dashboard-header::after {
    content: "";

    position: absolute;

    width: 180px;
    height: 180px;

    right: -50px;
    top: -70px;

    border-radius: 50%;

    background: rgba(255,255,255,.08);
}

.dashboard-header::before {
    content: "";

    position: absolute;

    width: 100px;
    height: 100px;

    right: 100px;
    bottom: -65px;

    border-radius: 50%;

    background: rgba(255,255,255,.06);
}

.dashboard-header-content {
    position: relative;

    z-index: 2;
}

.dashboard-title {
    margin: 0;

    font-size: 1.55rem;

    font-weight: 700;
}

.dashboard-subtitle {
    margin: 5px 0 0;

    font-size: .9rem;

    opacity: .86;
}


/* =========================================================
   SECTION TITLE
========================================================= */

.dashboard-section {
    margin-top: 30px;
    margin-bottom: 15px;
}

.dashboard-section-title {
    display: flex;

    align-items: center;

    margin: 0;

    color: #343a40;

    font-size: 1rem;

    font-weight: 700;
}

.dashboard-section-title i {
    width: 34px;
    height: 34px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    margin-right: 10px;

    border-radius: 9px;

    background: #eef2ff;

    color: #4e73df;

    font-size: .85rem;
}

.dashboard-section-desc {
    margin: 5px 0 0 44px;

    color: #858796;

    font-size: .78rem;
}


/* =========================================================
   STAT CARD
========================================================= */

.stat-card {
    position: relative;

    min-height: 108px;

    border: 0;

    border-radius: 14px;

    background: #fff;

    overflow: hidden;

    transition:
        transform .2s ease,
        box-shadow .2s ease;

    box-shadow:
        0 3px 14px rgba(0,0,0,.06);
}

.stat-card:hover {
    transform: translateY(-3px);

    box-shadow:
        0 8px 22px rgba(0,0,0,.10);
}

.stat-card .card-body {
    padding: 18px 20px;
}

.stat-label {
    margin-bottom: 7px;

    color: #858796;

    font-size: .68rem;

    font-weight: 700;

    letter-spacing: .5px;

    text-transform: uppercase;
}

.stat-value {
    color: #343a40;

    font-size: 1.45rem;

    line-height: 1;

    font-weight: 700;
}

.stat-icon {
    position: absolute;

    right: 18px;
    top: 50%;

    transform: translateY(-50%);

    width: 48px;
    height: 48px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 12px;

    font-size: 1.25rem;

    opacity: .95;
}


/* STAT COLOR */

.stat-primary {
    border-left: 4px solid #4e73df;
}

.stat-primary .stat-icon {
    background: #eef2ff;
    color: #4e73df;
}

.stat-success {
    border-left: 4px solid #1cc88a;
}

.stat-success .stat-icon {
    background: #e8faf3;
    color: #1cc88a;
}

.stat-info {
    border-left: 4px solid #36b9cc;
}

.stat-info .stat-icon {
    background: #eaf9fb;
    color: #36b9cc;
}

.stat-warning {
    border-left: 4px solid #f6c23e;
}

.stat-warning .stat-icon {
    background: #fff8e6;
    color: #d9a514;
}

.stat-danger {
    border-left: 4px solid #e74a3b;
}

.stat-danger .stat-icon {
    background: #fff0ef;
    color: #e74a3b;
}


/* =========================================================
   PERMOHONAN SUMMARY
========================================================= */

.request-summary {
    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    padding: 20px 22px;

    border-radius: 14px;

    background: #fff;

    box-shadow:
        0 3px 14px rgba(0,0,0,.06);
}

.request-summary-title {
    margin: 0 0 4px;

    color: #343a40;

    font-size: .9rem;

    font-weight: 700;
}

.request-summary-total {
    margin: 0;

    color: #4e73df;

    font-size: 1.5rem;

    font-weight: 700;
}

.request-summary-info {
    color: #858796;

    font-size: .75rem;
}

.request-progress {
    width: 55%;

    max-width: 450px;
}

.request-progress-bar {
    height: 9px;

    display: flex;

    overflow: hidden;

    border-radius: 20px;

    background: #eaecf4;
}

.progress-approved {
    background: #1cc88a;
}

.progress-pending {
    background: #f6c23e;
}

.progress-rejected {
    background: #e74a3b;
}

.progress-legend {
    display: flex;

    flex-wrap: wrap;

    gap: 15px;

    margin-top: 10px;

    color: #858796;

    font-size: .72rem;
}

.progress-legend span {
    display: inline-flex;

    align-items: center;

    gap: 5px;
}

.legend-dot {
    width: 8px;
    height: 8px;

    display: inline-block;

    border-radius: 50%;
}


/* =========================================================
   STOCK WARNING
========================================================= */

.stock-alert {
    border: 0;

    border-left: 4px solid #e74a3b;

    border-radius: 14px;

    box-shadow:
        0 3px 14px rgba(0,0,0,.06);
}

.stock-alert .card-body {
    padding: 20px;
}

.stock-alert-header {
    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 15px;
}

.stock-alert-title {
    display: flex;

    align-items: center;
}

.stock-alert-icon {
    width: 42px;
    height: 42px;

    display: flex;

    align-items: center;
    justify-content: center;

    margin-right: 12px;

    border-radius: 10px;

    background: #fff0ef;

    color: #e74a3b;
}

.stock-alert-title h5 {
    margin: 0;

    color: #343a40;

    font-size: .95rem;

    font-weight: 700;
}

.stock-alert-title small {
    color: #858796;

    font-size: .72rem;
}

.stock-count {
    padding: 6px 11px;

    border-radius: 20px;

    background: #fff0ef;

    color: #e74a3b;

    font-size: .7rem;

    font-weight: 700;
}


/* STOCK TABLE */

.stock-table {
    margin: 0;
}

.stock-table thead th {
    border-top: 0;

    background: #f8f9fc;

    color: #858796;

    font-size: .68rem;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .3px;
}

.stock-table tbody td {
    vertical-align: middle;

    font-size: .78rem;
}

.stock-zero {
    background: #fff1f1 !important;
}

.stock-number {
    font-weight: 700;
}


/* =========================================================
   CHART CARD
========================================================= */

.chart-card {
    border: 0;

    border-radius: 14px;

    box-shadow:
        0 3px 14px rgba(0,0,0,.06);
}

.chart-header {
    padding: 17px 20px;

    border-bottom: 1px solid #eaecf4;

    background: #fff;

    border-radius: 14px 14px 0 0;
}

.chart-title {
    display: flex;

    align-items: center;

    margin: 0;

    color: #343a40;

    font-size: .92rem;

    font-weight: 700;
}

.chart-title i {
    margin-right: 8px;

    color: #4e73df;
}

.chart-description {
    margin: 4px 0 0;

    color: #858796;

    font-size: .72rem;
}

.year-select {
    min-width: 100px;

    border-radius: 8px;

    border-color: #d9dce3;

    font-size: .78rem;
}

.chart-body {
    padding: 20px;
}

.chart-container {
    position: relative;

    height: 350px;
}


/* =========================================================
   QUICK INFO
========================================================= */

.info-card {
    height: 100%;

    padding: 20px;

    border-radius: 14px;

    background: #fff;

    box-shadow:
        0 3px 14px rgba(0,0,0,.06);
}

.info-item {
    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 11px 0;

    border-bottom: 1px solid #eaecf4;
}

.info-item:last-child {
    border-bottom: 0;
}

.info-item-label {
    color: #858796;

    font-size: .75rem;
}

.info-item-value {
    color: #343a40;

    font-size: .82rem;

    font-weight: 700;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 767px) {

    .dashboard-header {
        padding: 20px;
    }

    .dashboard-title {
        font-size: 1.25rem;
    }

    .stat-value {
        font-size: 1.25rem;
    }

    .stat-icon {
        width: 40px;
        height: 40px;

        right: 14px;

        font-size: 1rem;
    }

    .request-summary {
        display: block;
    }

    .request-progress {
        width: 100%;

        max-width: none;

        margin-top: 18px;
    }

    .stock-alert-header {
        align-items: flex-start;
    }

    .chart-container {
        height: 280px;
    }

}

</style>


<div class="container-fluid dashboard-page">


<!-- =========================================================
     HEADER
========================================================= -->

<div class="dashboard-header">

    <div class="dashboard-header-content">

        <h1 class="dashboard-title">
            <i class="fas fa-boxes mr-2"></i>
            <?= html_escape($title) ?>
        </h1>

        <p class="dashboard-subtitle">
            Ringkasan inventaris, permohonan barang, dan pengeluaran
            BispVentory.
        </p>

    </div>

</div>


<!-- =========================================================
     STATISTIK INVENTARIS
========================================================= -->

<div class="dashboard-section">

    <h4 class="dashboard-section-title">
        <i class="fas fa-chart-pie"></i>
        Ringkasan Inventaris
    </h4>

    <p class="dashboard-section-desc">
        Informasi utama data inventaris sekolah.
    </p>

</div>


<div class="row">

<?php
$inventory_cards = array(

    array(
        'Kategori Barang',
        $kategori,
        'primary',
        'tags'
    ),

    array(
        'Data Barang',
        $barang,
        'success',
        'box'
    ),

    array(
        'Ruangan',
        $ruangan,
        'info',
        'building'
    ),

    array(
        'Guru',
        $guru,
        'warning',
        'chalkboard-teacher'
    ),

    array(
        'Siswa',
        $siswa,
        'primary',
        'user-graduate'
    )

);
?>


<?php foreach ($inventory_cards as $card): ?>

<div class="col-xl col-lg-4 col-md-6 mb-4">

    <div class="card stat-card stat-<?= $card[2] ?> h-100">

        <div class="card-body">

            <div class="stat-label">
                <?= html_escape($card[0]) ?>
            </div>

            <div class="stat-value">
                <?= number_format((int) $card[1]) ?>
            </div>

            <div class="stat-icon">
                <i class="fas fa-<?= $card[3] ?>"></i>
            </div>

        </div>

    </div>

</div>

<?php endforeach; ?>

</div>


<!-- =========================================================
     PERMOHONAN
========================================================= -->

<div class="dashboard-section">

    <h4 class="dashboard-section-title">

        <i class="fas fa-file-signature"></i>

        Permohonan Barang

    </h4>

    <p class="dashboard-section-desc">

        Status seluruh permohonan barang yang tercatat dalam sistem.

    </p>

</div>


<div class="row">


<!-- TOTAL -->

<div class="col-xl-3 col-md-6 mb-4">

    <div class="card stat-card stat-info h-100">

        <div class="card-body">

            <div class="stat-label">
                Total Permohonan
            </div>

            <div class="stat-value">
                <?= number_format($total_permohonan) ?>
            </div>

            <div class="stat-icon">
                <i class="fas fa-file-alt"></i>
            </div>

        </div>

    </div>

</div>


<!-- DISETUJUI -->

<div class="col-xl-3 col-md-6 mb-4">

    <div class="card stat-card stat-success h-100">

        <div class="card-body">

            <div class="stat-label">
                Disetujui
            </div>

            <div class="stat-value">
                <?= number_format($total_disetujui) ?>
            </div>

            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>

        </div>

    </div>

</div>


<!-- PENDING -->

<div class="col-xl-3 col-md-6 mb-4">

    <div class="card stat-card stat-warning h-100">

        <div class="card-body">

            <div class="stat-label">
                Pending
            </div>

            <div class="stat-value">
                <?= number_format($total_pending) ?>
            </div>

            <div class="stat-icon">
                <i class="fas fa-hourglass-half"></i>
            </div>

        </div>

    </div>

</div>


<!-- DITOLAK -->

<div class="col-xl-3 col-md-6 mb-4">

    <div class="card stat-card stat-danger h-100">

        <div class="card-body">

            <div class="stat-label">
                Ditolak
            </div>

            <div class="stat-value">
                <?= number_format($total_ditolak) ?>
            </div>

            <div class="stat-icon">
                <i class="fas fa-times-circle"></i>
            </div>

        </div>

    </div>

</div>


</div>


<!-- =========================================================
     PROGRESS PERMOHONAN
========================================================= -->

<div class="request-summary mb-4">

    <div>

        <div class="request-summary-title">
            Distribusi Status Permohonan
        </div>

        <div class="request-summary-total">
            <?= number_format($total_permohonan) ?>
            <span class="request-summary-info">
                total permohonan
            </span>
        </div>

    </div>


    <div class="request-progress">

        <div class="request-progress-bar">

            <div
                class="progress-approved"
                style="width: <?= $persen_disetujui ?>%">
            </div>

            <div
                class="progress-pending"
                style="width: <?= $persen_pending ?>%">
            </div>

            <div
                class="progress-rejected"
                style="width: <?= $persen_ditolak ?>%">
            </div>

        </div>


        <div class="progress-legend">

            <span>
                <i
                    class="legend-dot"
                    style="background:#1cc88a">
                </i>

                Disetujui <?= $persen_disetujui ?>%
            </span>


            <span>
                <i
                    class="legend-dot"
                    style="background:#f6c23e">
                </i>

                Pending <?= $persen_pending ?>%
            </span>


            <span>
                <i
                    class="legend-dot"
                    style="background:#e74a3b">
                </i>

                Ditolak <?= $persen_ditolak ?>%
            </span>

        </div>

    </div>

</div>


<!-- =========================================================
     STOK MENIPIS
========================================================= -->

<?php if ((int) $jumlah_stok_menipis > 0): ?>

<div class="dashboard-section">

    <h4 class="dashboard-section-title">

        <i class="fas fa-exclamation-triangle"></i>

        Perhatian

    </h4>

</div>


<div class="card stock-alert mb-4">

    <div class="card-body">

        <div class="stock-alert-header">

            <div class="stock-alert-title">

                <div class="stock-alert-icon">

                    <i class="fas fa-exclamation-triangle"></i>

                </div>

                <div>

                    <h5>
                        Stok Barang Menipis
                    </h5>

                    <small>
                        Barang dengan stok sama dengan atau di bawah
                        <?= (int) $batas_stok ?>.
                    </small>

                </div>

            </div>


            <div class="stock-count">

                <?= (int) $jumlah_stok_menipis ?>
                Barang

            </div>

        </div>


        <div class="table-responsive">

            <table class="table table-sm table-hover stock-table">

                <thead>

                    <tr>

                        <th>
                            Barang
                        </th>

                        <th>
                            Merk
                        </th>

                        <th class="text-center">
                            Stok
                        </th>

                        <th>
                            Satuan
                        </th>

                    </tr>

                </thead>


                <tbody>

                <?php foreach ($stok_menipis as $stock): ?>

                    <tr
                        class="<?= ((int) $stock->stok === 0)
                            ? 'stock-zero'
                            : '' ?>">

                        <td class="font-weight-bold">

                            <?= html_escape(
                                $stock->nama_barang
                            ) ?>

                        </td>

                        <td>

                            <?= html_escape(
                                $stock->merk
                            ) ?>

                        </td>

                        <td class="text-center">

                            <span
                                class="stock-number text-danger">

                                <?= number_format(
                                    (int) $stock->stok
                                ) ?>

                            </span>

                        </td>

                        <td>

                            <?= html_escape(
                                $stock->satuan
                            ) ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php endif; ?>


<!-- =========================================================
     GRAFIK
========================================================= -->

<div class="dashboard-section">

    <h4 class="dashboard-section-title">

        <i class="fas fa-chart-bar"></i>

        Pengeluaran Barang

    </h4>

    <p class="dashboard-section-desc">

        Grafik jumlah pengeluaran barang berdasarkan bulan.

    </p>

</div>


<div class="card chart-card mb-4">


    <div class="chart-header">

        <div class="d-flex align-items-center justify-content-between flex-wrap">

            <div>

                <h6 class="chart-title">

                    <i class="fas fa-chart-column"></i>

                    Pengeluaran Tahun <?= (int) $tahun ?>

                </h6>

                <p class="chart-description">

                    Pilih tahun untuk melihat data pengeluaran.

                </p>

            </div>


            <form
                method="get"
                class="mt-2 mt-md-0">

                <select
                    name="tahun"
                    class="form-control form-control-sm year-select"
                    onchange="this.form.submit()">

                    <?php foreach ($tahun_list as $t): ?>

                        <option
                            value="<?= (int) $t->tahun ?>"
                            <?= ((int) $tahun === (int) $t->tahun)
                                ? 'selected'
                                : '' ?>>

                            <?= (int) $t->tahun ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </form>

        </div>

    </div>


    <div class="chart-body">

        <div class="chart-container">

            <canvas id="pengeluaranChart"></canvas>

        </div>

    </div>

</div>


</div>


<!-- =========================================================
     CHART JS
========================================================= -->

<script src="<?= base_url(
    'assets/sbadmin2/vendor/chart.js/Chart.min.js'
) ?>"></script>


<script>

(function () {

    const dataPengeluaran =
        <?= json_encode(
            array_values($grafik_pengeluaran)
        ) ?>;

    const canvas =
        document.getElementById(
            'pengeluaranChart'
        );


    if (!canvas) {
        return;
    }


    new Chart(
        canvas,
        {

            type: 'bar',

            data: {

                labels: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'Mei',
                    'Jun',
                    'Jul',
                    'Agu',
                    'Sep',
                    'Okt',
                    'Nov',
                    'Des'
                ],

                datasets: [

                    {

                        label:
                            'Jumlah Pengeluaran',

                        data:
                            dataPengeluaran,

                        backgroundColor:
                            'rgba(78,115,223,.75)',

                        borderColor:
                            'rgba(78,115,223,1)',

                        borderWidth: 1,

                        borderRadius: 5,

                        maxBarThickness: 38

                    }

                ]

            },


            options: {

                responsive: true,

                maintainAspectRatio: false,

                animation: {

                    duration: 700

                },

                scales: {

                    x: {

                        grid: {

                            display: false

                        }

                    },

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

                    },

                    tooltip: {

                        callbacks: {

                            label: function (context) {

                                const value =
                                    context.raw || 0;

                                return ' ' +
                                    value.toLocaleString(
                                        'id-ID'
                                    ) +
                                    ' barang';

                            }

                        }

                    }

                }

            }

        }
    );

})();

</script>