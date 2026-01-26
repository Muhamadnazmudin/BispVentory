<?php
$bulan_awal  = $bulan_awal  ?? 1;
$bulan_akhir = $bulan_akhir ?? 12;
$tahun       = $tahun       ?? date('Y');

$bulanList = [
    1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
    5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
    9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
];

$namaBulan = [
    1=>'JANUARI',2=>'FEBRUARI',3=>'MARET',4=>'APRIL',
    5=>'MEI',6=>'JUNI',7=>'JULI',8=>'AGUSTUS',
    9=>'SEPTEMBER',10=>'OKTOBER',11=>'NOVEMBER',12=>'DESEMBER'
];
?>

<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<!-- ================= FILTER ================= -->
<form method="get" class="form-inline mb-4">

    <label class="mr-2">Dari Bulan</label>
    <select name="bulan_awal" class="form-control mr-3">
        <?php foreach ($bulanList as $k=>$v): ?>
            <option value="<?= $k ?>" <?= ($bulan_awal==$k?'selected':'') ?>>
                <?= $v ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label class="mr-2">Sampai Bulan</label>
    <select name="bulan_akhir" class="form-control mr-3">
        <?php foreach ($bulanList as $k=>$v): ?>
            <option value="<?= $k ?>" <?= ($bulan_akhir==$k?'selected':'') ?>>
                <?= $v ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label class="mr-2">Tahun</label>
    <select name="tahun" class="form-control mr-3">
        <?php for($t=date('Y');$t>=2020;$t--): ?>
            <option value="<?= $t ?>" <?= ($tahun==$t?'selected':'') ?>>
                <?= $t ?>
            </option>
        <?php endfor; ?>
    </select>

    <button class="btn btn-primary">
        <i class="fa fa-search"></i> Tampilkan
    </button>
</form>
<div class="mb-3">
    <a href="<?= base_url('laporan/mutasi_excel?bulan_awal='.$bulan_awal.'&bulan_akhir='.$bulan_akhir.'&tahun='.$tahun) ?>"
       class="btn btn-success btn-sm">
        <i class="fa fa-file-excel"></i> Download Excel
    </a>

    <a href="<?= base_url('laporan/mutasi_pdf?bulan_awal='.$bulan_awal.'&bulan_akhir='.$bulan_akhir.'&tahun='.$tahun) ?>"
       target="_blank"
       class="btn btn-danger btn-sm">
        <i class="fa fa-file-pdf"></i> Download PDF
    </a>
</div>

<!-- ================= LOOP PER BULAN ================= -->
<?php for ($bulan = $bulan_awal; $bulan <= $bulan_akhir; $bulan++): ?>

<h5 class="text-center font-weight-bold mb-2">
    MUTASI <?= $namaBulan[$bulan] ?> <?= $tahun ?>
</h5>

<div class="table-wrapper mb-5">
<table class="table table-bordered table-sm mutasi-table">
<thead>

<tr class="text-center header-mutasi">
    <th rowspan="2">No</th>
    <th rowspan="2">Kode Rekening</th>
    <th rowspan="2">Nama Barang</th>
    <th rowspan="2">Merk</th>

    <th colspan="4">PENAMBAHAN</th>
    <th colspan="4">PENGURANGAN</th>
    <th colspan="4">SALDO AKHIR</th>
</tr>

<tr class="text-center header-mutasi">
    <?php for($i=0;$i<3;$i++): ?>
        <th>Vol</th>
        <th>Satuan</th>
        <th>Harga</th>
        <th>Jumlah</th>
    <?php endfor; ?>
</tr>

</thead>

<tbody>
<?php
$no = 1;
$list = $data_bulan[$bulan] ?? [];
foreach ($list as $r):
    $saldo_vol   = $r->masuk_vol - $r->keluar_vol;
    $saldo_total = $saldo_vol * $r->harga;
?>
<tr>
    <td class="text-center"><?= $no++ ?></td>
    <td><?= $r->kodering ?></td>
    <td><?= $r->nama_barang ?></td>
    <td><?= $r->merk ?></td>

    <!-- PENAMBAHAN -->
    <td class="text-center"><?= $r->masuk_vol ?></td>
    <td class="text-center"><?= $r->satuan ?></td>
    <td class="text-right"><?= number_format($r->harga,0,',','.') ?></td>
    <td class="text-right"><?= number_format($r->masuk_total,0,',','.') ?></td>

    <!-- PENGURANGAN -->
    <td class="text-center"><?= $r->keluar_vol ?></td>
    <td class="text-center"><?= $r->satuan ?></td>
    <td class="text-right"><?= number_format($r->harga,0,',','.') ?></td>
    <td class="text-right"><?= number_format($r->keluar_total,0,',','.') ?></td>

    <!-- SALDO AKHIR -->
    <td class="text-center"><?= $saldo_vol ?></td>
    <td class="text-center"><?= $r->satuan ?></td>
    <td class="text-right"><?= number_format($r->harga,0,',','.') ?></td>
    <td class="text-right"><?= number_format($saldo_total,0,',','.') ?></td>
</tr>
<?php endforeach; ?>

<?php if (empty($list)): ?>
<tr>
    <td colspan="16" class="text-center text-muted">
        Tidak ada transaksi bulan <?= $namaBulan[$bulan] ?>
    </td>
</tr>
<?php endif; ?>

</tbody>
</table>
</div>

<?php endfor; ?>

</div>

<!-- ================= CSS ================= -->
<style>
.table-wrapper{
    width:100%;
    overflow-x:auto;
    white-space:nowrap;
}

.mutasi-table th,
.mutasi-table td{
    min-width:110px;
    vertical-align:middle;
}

.mutasi-table th:nth-child(2),
.mutasi-table td:nth-child(2){
    min-width:180px;
}

.header-mutasi th{
    background:#20c997;
    color:#fff;
}
</style>
