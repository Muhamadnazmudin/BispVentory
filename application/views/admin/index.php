<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
    <?= $this->session->flashdata('success') ?>
</div>
<?php endif; ?>

<a href="<?= base_url('admin/tambah') ?>"
   class="btn btn-primary mb-3">
   <i class="fas fa-plus"></i> Tambah Admin
</a>

<table class="table table-bordered table-striped">
<thead>
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Username</th>
    <th>Role</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php $no=1; foreach($admin as $a): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $a->nama ?></td>
    <td><?= $a->username ?></td>
    <td><?= $a->role ?></td>
    <td>
        <a href="<?= base_url('admin/edit/'.$a->id_user) ?>"
           class="btn btn-warning btn-sm">Edit</a>
        <a href="<?= base_url('admin/hapus/'.$a->id_user) ?>"
           class="btn btn-danger btn-sm"
           onclick="return confirm('Yakin hapus admin?')">
           Hapus
        </a>
    </td>
</tr>
<?php endforeach ?>
</tbody>
</table>

</div>
