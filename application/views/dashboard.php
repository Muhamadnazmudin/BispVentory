<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<!-- =========================
     ROW CARD STATISTIK
========================== -->
<div class="row">

<?php
$cards = [
    ['Kategori Barang', $kategori, 'primary', 'tags'],
    ['Data Barang', $barang, 'success', 'box'],
    ['Ruangan', $ruangan, 'info', 'building'],
    ['Guru', $guru, 'warning', 'chalkboard-teacher'],
    ['Siswa', $siswa, 'primary', 'user-graduate'],
    ['Total Permohonan', $permohonan_total, 'info', 'file-alt'],
    ['Disetujui', $permohonan_setujui, 'success', 'check-circle'],
    ['Ditolak', $permohonan_tolak, 'danger', 'times-circle'],
    ['Pending', $permohonan_pending, 'warning', 'hourglass-half'],
];
?>

<?php foreach($cards as $c): ?>
<div class="col-xl-3 col-md-6 mb-4">
<div class="card border-left-<?= $c[2] ?> shadow h-100 py-2">
<div class="card-body">
<div class="row no-gutters align-items-center">
<div class="col mr-2">
<div class="text-xs font-weight-bold text-<?= $c[2] ?> text-uppercase mb-1">
<?= $c[0] ?>
</div>
<div class="h5 mb-0 font-weight-bold text-gray-800">
<?= $c[1] ?>
</div>
</div>
<div class="col-auto">
<i class="fas fa-<?= $c[3] ?> fa-2x text-gray-300"></i>
</div>
</div>
</div>
</div>
</div>
<?php endforeach; ?>

</div>
<?php if($jumlah_stok_menipis > 0): ?>
<div class="row">
<div class="col-xl-12">

<div class="card border-left-danger shadow mb-4">
<div class="card-body">

<div class="d-flex align-items-center mb-3">
<i class="fas fa-exclamation-triangle fa-2x text-danger mr-3"></i>
<div>
<h5 class="mb-0 text-danger font-weight-bold">
⚠️ Peringatan Stok Menipis
</h5>
<small class="text-muted">
<?= $jumlah_stok_menipis ?> barang dengan stok ≤ <?= $batas_stok ?>
</small>
</div>
</div>

<div class="table-responsive">
<table class="table table-sm table-bordered">
<thead class="thead-light">
<tr>
<th>Barang</th>
<th>Merk</th>
<th>Stok</th>
<th>Satuan</th>
</tr>
</thead>
<tbody>

<?php foreach($stok_menipis as $s): ?>
<tr class="<?= $s->stok==0?'table-danger':'' ?>">
<td><?= $s->nama_barang ?></td>
<td><?= $s->merk ?></td>
<td class="font-weight-bold text-danger">
<?= $s->stok ?>
</td>
<td><?= $s->satuan ?></td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
</div>

</div>
</div>

</div>
</div>
<?php endif; ?>

<!-- =========================
     GRAFIK PENGELUARAN
========================== -->
<div class="row">
<div class="col-xl-12">

<div class="card shadow mb-4">

<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
<h6 class="m-0 font-weight-bold text-primary">
Grafik Pengeluaran Barang Tahun <?= $tahun ?>
</h6>

<form method="get" class="form-inline">
<select name="tahun" class="form-control form-control-sm"
        onchange="this.form.submit()">
<?php foreach($tahun_list as $t): ?>
<option value="<?= $t->tahun ?>"
    <?= $tahun==$t->tahun?'selected':'' ?>>
    <?= $t->tahun ?>
</option>
<?php endforeach; ?>
</select>
</form>
</div>

<div class="card-body">

<!-- HEIGHT WAJIB -->
<div class="chart-area" style="height:360px">
    <canvas id="pengeluaranChart"></canvas>
</div>

</div>
</div>

</div>
</div>

</div>

<!-- =========================
     CHART JS
========================== -->
<script src="<?= base_url('assets/sbadmin2/vendor/chart.js/Chart.min.js') ?>"></script>

<script>
const dataPengeluaran = <?= json_encode($grafik_pengeluaran) ?>;
console.log('Grafik:', dataPengeluaran);

const ctx = document.getElementById('pengeluaranChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            'Jan','Feb','Mar','Apr','Mei','Jun',
            'Jul','Agu','Sep','Okt','Nov','Des'
        ],
        datasets: [{
            label: 'Jumlah Pengeluaran',
            data: dataPengeluaran,
            backgroundColor: 'rgba(78,115,223,0.7)',
            borderColor: 'rgba(78,115,223,1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: { precision: 0 }
            }
        },
        plugins: {
            legend: { display: false }
        }
    }
});
</script>
