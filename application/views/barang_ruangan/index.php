<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
<?= $this->session->flashdata('success') ?>
</div>
<?php endif; ?>

<a href="<?= base_url('barang_ruangan/tambah') ?>" class="btn btn-primary mb-3">
<i class="fas fa-plus"></i> Tambah
</a>

<div class="card shadow">
<div class="card-body">
<table class="table table-bordered">
<thead>
<tr>
<th>No</th>
<th>Barang</th>
<th>Ruangan</th>
<th>Jumlah</th>
<th width="15%">Aksi</th>
</tr>
</thead>
<tbody>
<?php $no=1; foreach($list as $r): ?>
<tr>
<td><?= $no++ ?></td>
<td><?= $r->nama_barang ?></td>
<td><?= $r->nama_ruangan ?></td>
<td><?= $r->jumlah ?></td>
<td>
<a href="<?= base_url('barang_ruangan/edit/'.$r->id_barang_ruangan) ?>"
   class="btn btn-warning btn-sm">
<i class="fas fa-edit"></i>
</a>
<a href="<?= base_url('barang_ruangan/hapus/'.$r->id_barang_ruangan) ?>"
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
