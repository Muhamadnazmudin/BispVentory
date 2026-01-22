<div class="container-fluid">
<h1 class="h3 mb-4"><?= $title ?></h1>

<table class="table table-bordered table-striped">
<tr>
<th>No</th><th>Tanggal</th><th>Barang</th><th>Merk</th>
<th>Jumlah</th><th>Pemohon</th><th>Keterangan</th>
</tr>
<?php $no=1; foreach($list as $r): ?>
<tr>
<td><?= $no++ ?></td>
<td><?= date('d-m-Y',strtotime($r->tanggal)) ?></td>
<td><?= $r->nama_barang ?></td>
<td><?= $r->merk ?></td>
<td><?= $r->jumlah ?></td>
<td><?= ucfirst($r->pemohon) ?></td>
<td><?= $r->keterangan ?></td>
</tr>
<?php endforeach; ?>
</table>
</div>
