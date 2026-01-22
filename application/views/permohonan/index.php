<div class="container-fluid">

<h1 class="h3 mb-4"><?= $title ?></h1>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show">
<?= $this->session->flashdata('success') ?>
<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger alert-dismissible fade show">
<?= $this->session->flashdata('error') ?>
<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<?php endif; ?>

<a href="<?= base_url('permohonan/tambah') ?>" class="btn btn-primary mb-3">
<i class="fas fa-plus"></i> Ajukan Permohonan
</a>

<div class="card shadow">
<div class="card-body table-responsive">

<table class="table table-bordered table-hover">
<thead class="thead-dark">
<tr>
<th width="5%">No</th>
<th>Tanggal</th>
<th>Pemohon</th>
<th>Status</th>
<th width="30%">Aksi</th>
</tr>
</thead>

<tbody>
<?php if(!empty($list)): ?>
<?php $no=1; foreach($list as $p): ?>
<tr>
<td><?= $no++ ?></td>
<td><?= date('d-m-Y', strtotime($p->tanggal)) ?></td>
<td><?= $p->pemohon=='guru' ? $p->nama_guru : $p->nama_siswa ?></td>
<td>
<span class="badge badge-<?= 
$p->status=='pending' ? 'warning' : 
($p->status=='disetujui' ? 'success' : 'danger') ?>">
<?= strtoupper($p->status) ?>
</span>
</td>
<td>

<!-- DETAIL -->
<a href="<?= base_url('permohonan/detail/'.$p->id_permohonan) ?>"
   class="btn btn-info btn-sm">
<i class="fas fa-eye"></i> Detail
</a>

<?php if($p->status=='pending'): ?>

<!-- APPROVE -->
<a href="<?= base_url('permohonan/approve/'.$p->id_permohonan) ?>"
   class="btn btn-success btn-sm"
   onclick="return confirm('Setujui permohonan ini? Stok akan berkurang!')">
<i class="fas fa-check"></i> Approve
</a>

<!-- TOLAK -->
<a href="<?= base_url('permohonan/tolak/'.$p->id_permohonan) ?>"
   class="btn btn-warning btn-sm"
   onclick="return confirm('Tolak permohonan ini?')">
<i class="fas fa-times"></i> Tolak
</a>

<!-- DELETE -->
<a href="<?= base_url('permohonan/delete/'.$p->id_permohonan) ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Yakin hapus permohonan ini?')">
<i class="fas fa-trash"></i> Hapus
</a>

<?php else: ?>

<!-- PDF -->
<a href="<?= base_url('permohonan/pdf/'.$p->id_permohonan) ?>"
   target="_blank"
   class="btn btn-secondary btn-sm">
<i class="fas fa-file-pdf"></i> PDF
</a>

<?php endif; ?>

</td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
<td colspan="5" class="text-center text-muted">
Belum ada data permohonan
</td>
</tr>
<?php endif; ?>
</tbody>
</table>

</div>
</div>

</div>
