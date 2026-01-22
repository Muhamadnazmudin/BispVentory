<div class="container-fluid">
<h1 class="h3 mb-4"><?= $title ?></h1>

<table class="table table-bordered">
<tr>
<th>No</th><th>Barang</th><th>Merk</th><th>Satuan</th><th>Sisa Stok</th>
</tr>
<?php $no=1; foreach($list as $r): ?>
<tr>
<td><?= $no++ ?></td>
<td><?= $r->nama_barang ?></td>
<td><?= $r->merk ?></td>
<td><?= $r->satuan ?></td>
<td class="font-weight-bold"><?= $r->stok ?></td>
</tr>
<?php endforeach; ?>
</table>
</div>
