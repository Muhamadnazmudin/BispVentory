<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show">
<?= $this->session->flashdata('success') ?>
<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<?php endif; ?>

<a href="<?= base_url('barang_masuk/tambah') ?>" class="btn btn-primary mb-3">
<i class="fas fa-plus"></i> Tambah Barang Masuk
</a>

<div class="card shadow">
<div class="card-body table-responsive">

<table class="table table-bordered table-hover">
<thead class="bg-primary text-white">
<tr>
<th width="5%">No</th>
<th>Tanggal</th>
<th>Nama Barang</th>
<th>Merk</th>
<th>Jumlah</th>
<th>Satuan</th>
<th>Perolehan</th>
<th>Toko</th>
<th width="12%">Aksi</th>
</tr>
</thead>
<tbody>
<?php if(!empty($list)): ?>
<?php $no=1; foreach($list as $r): ?>
<tr>
<td><?= $no++ ?></td>
<td><?= date('d-m-Y', strtotime($r->tanggal)) ?></td>
<td><?= $r->nama_barang ?></td>
<td><?= $r->merk ?></td>
<td><?= $r->jumlah ?></td>
<td><?= $r->satuan ?></td>
<td><?= $r->perolehan ?></td>
<td><?= $r->toko ?></td>
<td class="text-center">

<a href="<?= base_url('barang_masuk/edit/'.$r->id_masuk) ?>" 
   class="btn btn-warning btn-sm">
   <i class="fas fa-edit"></i>
</a>

<a href="<?= base_url('barang_masuk/delete/'.$r->id_masuk) ?>" 
   class="btn btn-danger btn-sm"
   onclick="return confirm('Yakin hapus data barang masuk?')">
   <i class="fas fa-trash"></i>
</a>

</td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
<td colspan="9" class="text-center text-muted">
Data belum tersedia
</td>
</tr>
<?php endif; ?>
</tbody>
</table>

</div>
</div>

</div>
