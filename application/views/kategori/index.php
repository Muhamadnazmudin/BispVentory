<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
<?= $this->session->flashdata('success') ?>
</div>
<?php endif; ?>

<a href="<?= base_url('kategori/tambah') ?>" class="btn btn-primary mb-3">
<i class="fas fa-plus"></i> Tambah Kategori
</a>

<div class="card shadow mb-4">
<div class="card-body">
<table class="table table-bordered">
<thead>
<tr>
<th width="5%">No</th>
<th>Nama Kategori</th>
<th>Keterangan</th>
<th width="15%">Aksi</th>
</tr>
</thead>
<tbody>
<?php $no=1; foreach($kategori as $k): ?>
<tr>
<td><?= $no++ ?></td>
<td><?= $k->nama_kategori ?></td>
<td><?= $k->keterangan ?></td>
<td>
<a href="<?= base_url('kategori/edit/'.$k->id_kategori) ?>" class="btn btn-warning btn-sm">
<i class="fas fa-edit"></i>
</a>
<a href="<?= base_url('kategori/hapus/'.$k->id_kategori) ?>"
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
