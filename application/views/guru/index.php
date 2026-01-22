<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
    <?= $this->session->flashdata('success') ?>
</div>
<?php endif; ?>

<a href="<?= base_url('guru/tambah') ?>" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Tambah Guru
</a>

<div class="card shadow">
<div class="card-body">

<table class="table table-bordered table-striped">
<thead class="thead-light">
<tr>
    <th width="5%">No</th>
    <th>Nama Guru</th>
    <th>NIP</th>
    <th>Jabatan</th>
    <th width="15%">Aksi</th>
</tr>
</thead>
<tbody>

<?php if(empty($guru)): ?>
<tr>
    <td colspan="5" class="text-center text-muted">
        Belum ada data guru
    </td>
</tr>
<?php else: ?>

<?php $no=1; foreach($guru as $g): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $g->nama_guru ?></td>
    <td><?= $g->nip ?: '-' ?></td>
    <td><?= $g->jabatan ?: '-' ?></td>
    <td>
        <a href="<?= base_url('guru/edit/'.$g->id_guru) ?>"
           class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i>
        </a>
        <a href="<?= base_url('guru/hapus/'.$g->id_guru) ?>"
           class="btn btn-danger btn-sm"
           onclick="return confirm('Hapus data guru ini?')">
            <i class="fas fa-trash"></i>
        </a>
    </td>
</tr>
<?php endforeach; ?>

<?php endif; ?>

</tbody>
</table>

</div>
</div>

</div>
