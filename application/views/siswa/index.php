<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
    <?= $this->session->flashdata('success') ?>
</div>
<?php endif; ?>

<a href="<?= base_url('siswa/tambah') ?>" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Tambah Siswa
</a>

<table class="table table-bordered table-striped">
<thead>
<tr>
    <th>No</th>
    <th>Nama Siswa</th>
    <th>NISN</th>
    <th>Kelas</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php $no=1; foreach($siswa as $s): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $s->nama_siswa ?></td>
    <td><?= $s->nisn ?></td>
    <td><?= $s->kelas ?></td>
    <td>
        <a href="<?= base_url('siswa/edit/'.$s->id_siswa) ?>" 
           class="btn btn-warning btn-sm">
           Edit
        </a>
        <a href="<?= base_url('siswa/hapus/'.$s->id_siswa) ?>"
           class="btn btn-danger btn-sm"
           onclick="return confirm('Yakin hapus data?')">
           Hapus
        </a>
    </td>
</tr>
<?php endforeach ?>
</tbody>
</table>

</div>
