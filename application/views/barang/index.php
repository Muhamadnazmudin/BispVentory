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

<button class="btn btn-success mb-3" data-toggle="modal" data-target="#modalImport">
    <i class="fas fa-file-excel"></i> Import Excel
</button>

<a href="<?= base_url('barang/download_template') ?>" class="btn btn-secondary mb-3">
    <i class="fas fa-download"></i> Download Template
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
<!-- Modal Import Excel -->
<div class="modal fade" id="modalImport" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('barang/import_excel') ?>" method="post" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Import Data Barang</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>File Excel</label>
            <input type="file" name="file" class="form-control" accept=".xls,.xlsx" required>
            <small class="text-muted">
              Gunakan template resmi agar format sesuai
            </small>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">
            <i class="fas fa-upload"></i> Import
          </button>
        </div>
      </div>
    </form>
  </div>
</div>


