<?php
$bulan_awal  = $bulan_awal  ?? 1;
$bulan_akhir = $bulan_akhir ?? 12;
$tahun       = $tahun       ?? date('Y');

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
        <?php
        $bulanList = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
        ];
        foreach ($bulanList as $k=>$v):
        ?>
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

    <button class="btn btn-primary mr-2">
        <i class="fa fa-search"></i> Tampilkan
    </button>

    <a href="<?= base_url('laporan/mutasi_excel?bulan_awal='.$bulan_awal.'&bulan_akhir='.$bulan_akhir.'&tahun='.$tahun) ?>"
       class="btn btn-success mr-2">
        <i class="fa fa-file-excel"></i> Excel
    </a>

    <a href="<?= base_url('laporan/mutasi_pdf?bulan_awal='.$bulan_awal.'&bulan_akhir='.$bulan_akhir.'&tahun='.$tahun) ?>"
       target="_blank"
       class="btn btn-danger">
        <i class="fa fa-file-pdf"></i> PDF
    </a>

</form>

<!-- ================= LOOP PER BULAN ================= -->
<?php
// SALDO BERJALAN PER BARANG (PAKAI ID_BARANG)
$saldo_barang = [];
?>

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
    <th rowspan="2">No Faktur</th>
    <th rowspan="2">No Kwitansi</th>
    <th rowspan="2">No BAST</th>

    <th colspan="4">PENAMBAHAN</th>
    <th colspan="4">PENGURANGAN</th>
    <th colspan="4">SALDO AKHIR</th>
</tr>

<tr class="text-center header-mutasi">
    <?php for ($i=0; $i<3; $i++): ?>
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

    // key saldo = id_barang (PALING BENAR)
    $key = $r->id_barang;

    if (!isset($saldo_barang[$key])) {
        $saldo_barang[$key] = 0; // saldo awal januari
    }

    $saldo_awal  = $saldo_barang[$key];
    $masuk       = (int)$r->masuk_vol;
    $keluar      = (int)$r->keluar_vol;
    $saldo_akhir = $saldo_awal + $masuk - $keluar;

    // simpan untuk bulan berikutnya
    $saldo_barang[$key] = $saldo_akhir;

    $masuk_total  = $masuk  * $r->harga;
    $keluar_total = $keluar * $r->harga;
    $saldo_total  = $saldo_akhir * $r->harga;
?>
<tr>
    <td class="text-center"><?= $no++ ?></td>
    <td><?= $r->kodering ?></td>
    <td><?= $r->nama_barang ?></td>
    <td><?= $r->merk ?></td>
    <td><?= $r->no_faktur ?? '-' ?></td>
    <td><?= $r->no_kwitansi ?? '-' ?></td>
    <td><?= $r->no_bast ?? '-' ?></td>

    <!-- PENAMBAHAN -->
    <td class="text-center bg-penambahan"><?= $masuk ?></td>
    <td class="text-center bg-penambahan"><?= $r->satuan ?></td>
    <td class="text-right  bg-penambahan"><?= number_format($r->harga,0,',','.') ?></td>
    <td class="text-right  bg-penambahan"><?= number_format($masuk_total,0,',','.') ?></td>

    <!-- PENGURANGAN -->
    <td class="text-center bg-pengurangan"><?= $keluar ?></td>
    <td class="text-center bg-pengurangan"><?= $r->satuan ?></td>
    <td class="text-right  bg-pengurangan"><?= number_format($r->harga,0,',','.') ?></td>
    <td class="text-right  bg-pengurangan"><?= number_format($keluar_total,0,',','.') ?></td>

    <!-- SALDO -->
    <td class="text-center bg-saldo"><?= $saldo_akhir ?></td>
    <td class="text-center bg-saldo"><?= $r->satuan ?></td>
    <td class="text-right  bg-saldo"><?= number_format($r->harga,0,',','.') ?></td>
    <td class="text-right  bg-saldo"><?= number_format($saldo_total,0,',','.') ?></td>
</tr>
<?php endforeach; ?>

<?php if (empty($list)): ?>
<tr>
    <td colspan="19" class="text-center text-muted">
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

/* HEADER */
.header-mutasi th{
    background:#20c997;
    color:#fff;
}

/* WARNA KOLOM */
.bg-penambahan{ background:#d4edda; }
.bg-pengurangan{ background:#f8d7da; }
.bg-saldo{ background:#ffe5b4; }

/* DARK MODE FIX */
body.dark-mode .bg-penambahan,
body.dark-mode .bg-pengurangan,
body.dark-mode .bg-saldo{
    color:#212529 !important;
}
</style>
