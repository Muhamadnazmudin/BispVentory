<?php
$bulan_awal  = $_GET['bulan_awal'] ?? 1;
$bulan_akhir = $_GET['bulan_akhir'] ?? 12;
?>

<style>
/* ===== BASE ===== */
.rekap-table{
    font-size:13px;
    white-space:nowrap;
}

/* ===== HEADER ===== */
.rekap-head-1 th{
    background:#0d6efd;
    color:#fff;
    text-align:center;
    vertical-align:middle;
}

.rekap-head-2 th{
    background:#e9f2ff;
    color:#0d6efd;
    text-align:center;
    font-weight:600;
}

/* ===== BODY COLORS ===== */
.saldo-awal{ background:#f8f9fa; font-weight:600; }
.masuk{ background:#e7f5ec; }
.keluar{ background:#fdeaea; }
.saldo{ background:#fff3cd; font-weight:600; }
.total{ background:#e2e3e5; font-weight:700; }

/* ===== ZEBRA & HOVER ===== */
.rekap-table tbody tr:nth-child(even){ background:#fcfcfc; }
.rekap-table tbody tr:hover{ background:#f1f5ff; }

/* ===== STICKY COLUMN ===== */
.sticky-kode{
    position:sticky;
    left:0;
    background:#fff;
    z-index:3;
}
.sticky-uraian{
    position:sticky;
    left:120px;
    background:#fff;
    z-index:3;
}

/* HEADER sticky sync */
.rekap-head-1 .sticky-kode,
.rekap-head-2 .sticky-kode{
    background:#0d6efd;
    z-index:4;
}
.rekap-head-1 .sticky-uraian,
.rekap-head-2 .sticky-uraian{
    background:#0d6efd;
    z-index:4;
}

/* DARK MODE FIX */
body.dark-mode .masuk,
body.dark-mode .keluar,
body.dark-mode .saldo,
body.dark-mode .saldo-awal,
body.dark-mode .total{
    color:#212529 !important;
}
/* ===== DARK MODE FIX (STICKY COLUMN TEXT) ===== */
body.dark-mode .rekap-table td.sticky-kode,
body.dark-mode .rekap-table td.sticky-uraian {
    color: #212529 !important;   /* hitam jelas */
    background: #ffffff !important; /* putih solid */
    opacity: 1 !important;
}

/* biar hover tetap enak */
body.dark-mode .rekap-table tbody tr:hover td.sticky-kode,
body.dark-mode .rekap-table tbody tr:hover td.sticky-uraian {
    background: #f1f5ff !important;
}

</style>

<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800">
    <?= $title ?> Tahun <?= $tahun ?>
</h1>

<!-- ================= FILTER ================= -->
<form method="get" class="row g-2 mb-3 align-items-end">
    <input type="hidden" name="tahun" value="<?= $tahun ?>">

    <div class="col-md-3">
        <label>Bulan Awal</label>
        <select name="bulan_awal" class="form-control">
            <?php for($b=1;$b<=12;$b++): ?>
                <option value="<?= $b ?>" <?= $b==$bulan_awal?'selected':'' ?>>
                    <?= bulan_id($b) ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>

    <div class="col-md-3">
        <label>Bulan Akhir</label>
        <select name="bulan_akhir" class="form-control">
            <?php for($b=1;$b<=12;$b++): ?>
                <option value="<?= $b ?>" <?= $b==$bulan_akhir?'selected':'' ?>>
                    <?= bulan_id($b) ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>
                
    <div class="col-md-3">
        <button class="btn btn-primary">Tampilkan</button>
    </div>
</form>

<div class="mb-3 d-flex gap-2">
    <a href="<?= base_url('laporan/export_excel?tahun='.$tahun) ?>" class="btn btn-success btn-sm">
        Export Excel
    </a>
    <a href="<?= base_url('laporan/export_pdf?tahun='.$tahun) ?>" class="btn btn-danger btn-sm">
        Export PDF
    </a>
</div>
<div class="col-md-4">
    <label>Filter Uraian</label>
    <input type="text" id="filterUraian"
           class="form-control"
           placeholder="Ketik nama uraian…">
</div>
<div class="card shadow">
<div class="card-body table-responsive">

<table class="table table-bordered table-sm rekap-table">
<thead>
<tr class="rekap-head-1">
    <th rowspan="2" class="sticky-kode">Kodering</th>
    <th rowspan="2" class="sticky-uraian">Uraian</th>
    <th rowspan="2">Saldo Awal</th>

    <?php for($b=$bulan_awal;$b<=$bulan_akhir;$b++): ?>
        <th colspan="3"><?= strtoupper(bulan_id($b)) ?></th>
    <?php endfor; ?>

    <th colspan="3">TOTAL</th>
</tr>

<tr class="rekap-head-2">
    <?php for($b=$bulan_awal;$b<=$bulan_akhir;$b++): ?>
        <th>Masuk</th>
        <th>Keluar</th>
        <th>Saldo</th>
    <?php endfor; ?>
    <th>Masuk</th>
    <th>Keluar</th>
    <th>Saldo</th>
</tr>
</thead>

<tbody>
<?php foreach($rekap as $r): ?>
<?php
$totalMasuk=0; $totalKeluar=0; $saldoAkhir=0;
?>
<tr>
    <td class="sticky-kode"><?= $r['kode'] ?></td>
    <td class="sticky-uraian uraian-cell">
    <?= $r['uraian'] ?>
</td>
    <td class="text-right saldo-awal"><?= rupiah($r['saldo_awal']) ?></td>

    <?php for($b=$bulan_awal;$b<=$bulan_akhir;$b++):
        $masuk=$r['bulan'][$b]['masuk']??0;
        $keluar=$r['bulan'][$b]['keluar']??0;
        $saldo=$r['bulan'][$b]['saldo']??0;
        $totalMasuk+=$masuk;
        $totalKeluar+=$keluar;
        $saldoAkhir=$saldo;
    ?>
        <td class="text-right masuk"><?= rupiah($masuk) ?></td>
        <td class="text-right keluar"><?= rupiah($keluar) ?></td>
        <td class="text-right saldo"><?= rupiah($saldo) ?></td>
    <?php endfor; ?>

    <td class="text-right masuk total"><?= rupiah($totalMasuk) ?></td>
    <td class="text-right keluar total"><?= rupiah($totalKeluar) ?></td>
    <td class="text-right saldo total"><?= rupiah($saldoAkhir) ?></td>
</tr>
<?php endforeach; ?>
<script>
document.getElementById('filterUraian').addEventListener('keyup', function () {
    const keyword = this.value.toLowerCase();
    const rows = document.querySelectorAll('.rekap-table tbody tr');

    rows.forEach(row => {
        const uraian = row.querySelector('.uraian-cell')?.innerText.toLowerCase() || '';
        row.style.display = uraian.includes(keyword) ? '' : 'none';
    });
});
</script>

</tbody>
</table>

</div>
</div>
</div>
