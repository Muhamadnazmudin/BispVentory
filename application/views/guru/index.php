<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
    <?= $this->session->flashdata('success') ?>
</div>
<?php endif; ?>
<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger">
    <?= $this->session->flashdata('error') ?>
</div>
<?php endif; ?>

<a href="<?= base_url('guru/tambah') ?>" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Tambah Guru
</a>

<button class="btn btn-success mb-3" data-toggle="modal" data-target="#importModal">
    <i class="fas fa-file-excel"></i> Import Excel
</button>

<a href="<?= base_url('guru/download_template') ?>" class="btn btn-outline-success mb-3">
    <i class="fas fa-download"></i> Template Excel
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
<!-- Modal Import Excel -->
<div class="modal fade" id="importModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Import Data Guru</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form action="<?= base_url('guru/import_excel') ?>" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label>File Excel</label>
            <input type="file" name="file_excel" class="form-control"
                   accept=".xls,.xlsx" required>
            <small class="text-muted">
              Format: nama_guru | nip | jabatan
            </small>
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-primary">
            <i class="fas fa-upload"></i> Import
          </button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Batal
          </button>
        </div>
      </form>

    </div>
  </div>
</div>
