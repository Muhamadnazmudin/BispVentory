<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<div class="card shadow mb-4">
<div class="card-body">

<form method="get" class="form-inline mb-3">

<select name="id_barang" class="form-control mr-2" required>
<option value="">- Pilih Barang -</option>
<?php foreach($barang as $b): ?>
<option value="<?= $b->id_barang ?>"
<?= $id_barang==$b->id_barang?'selected':'' ?>>
<?= $b->nama_barang ?> (<?= $b->merk ?>)
</option>
<?php endforeach; ?>
</select>

<input type="date" name="awal" class="form-control mr-2"
value="<?= $awal ?>" required>

<input type="date" name="akhir" class="form-control mr-2"
value="<?= $akhir ?>" required>

<button class="btn btn-primary">
<i class="fas fa-search"></i> Tampilkan
</button>

</form>

<?php if($saldo_awal !== null): ?>

<table class="table table-bordered table-striped">
<thead class="thead-light">
<tr>
<th width="15%">Tanggal</th>
<th>Uraian</th>
<th width="10%">Masuk</th>
<th width="10%">Keluar</th>
<th width="10%">Sisa</th>
</tr>
</thead>
<tbody>

<?php
$saldo = $saldo_awal;
?>

<tr class="font-weight-bold">
<td>-</td>
<td>SALDO AWAL</td>
<td class="text-center">-</td>
<td class="text-center">-</td>
<td class="text-right"><?= $saldo ?></td>
</tr>

<?php foreach($list as $r): ?>
<?php
$saldo = $saldo + $r->masuk - $r->keluar;
?>
<tr>
<td><?= date('d-m-Y',strtotime($r->tanggal)) ?></td>
<td><?= $r->uraian ?></td>
<td class="text-right"><?= $r->masuk ?: '-' ?></td>
<td class="text-right"><?= $r->keluar ?: '-' ?></td>
<td class="text-right font-weight-bold"><?= $saldo ?></td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

<?php else: ?>
<div class="alert alert-info">
Silakan pilih barang dan periode untuk menampilkan kartu persediaan.
</div>
<?php endif; ?>

</div>
</div>

</div>
