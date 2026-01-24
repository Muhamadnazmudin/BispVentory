<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
<?= $this->session->flashdata('success') ?>
</div>
<?php endif; ?>

<a href="<?= base_url('barang/tambah') ?>" class="btn btn-primary mb-3">
<i class="fas fa-plus"></i> Tambah Barang
</a>

<div class="card shadow mb-4">
<div class="card-body">
<table class="table table-bordered">
<thead>
<tr>
<th>Kode</th>
<th>Nama Barang</th>
<th>merk</th>
<th>Satuan</th>
<th>Harga</th>
<th>Kategori</th>
<th width="15%">Aksi</th>
</tr>
</thead>
<tbody>
<?php foreach($barang as $b): ?>
<tr>
<td><?= $b->kode_barang ?></td>
<td><?= $b->nama_barang ?></td>
<td><?= $b->merk ?></td>
<td><?= $b->satuan ?></td>
<td><?= rupiah($b->harga) ?></td>
<td><?= $b->nama_kategori ?></td>
<td>
<a href="<?= base_url('barang/edit/'.$b->id_barang) ?>" class="btn btn-warning btn-sm">
<i class="fas fa-edit"></i>
</a>
<a href="<?= base_url('barang/hapus/'.$b->id_barang) ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Hapus data ini?')">
<i class="fas fa-trash"></i>
</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>

</div>
