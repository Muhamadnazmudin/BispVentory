<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800">Stok Barang</h1>

<div class="card shadow">
<div class="card-body">

<table class="table table-bordered table-striped">
<thead>
<tr>
    <th>No</th>
    <th>Nama Barang</th>
    <th>Merk</th>
    <th>Stok</th>
    <th>Satuan</th>
    <th>Kategori</th>
</tr>
</thead>
<tbody>

<?php $no=1; foreach($stock as $s): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $s->nama_barang ?></td>
    <td><?= $s->merk ?></td>
    <td class="font-weight-bold text-right"><?= $s->total_stok ?></td>
    <td><?= $s->satuan ?></td>
    <td><?= $s->nama_kategori ?></td>
</tr>
<?php endforeach; ?>

</tbody>
</table>


</div>
</div>

</div>
