<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
<?= $this->session->flashdata('success') ?>
</div>
<?php endif; ?>

<div class="d-flex flex-wrap align-items-center mb-3">

    <!-- Tambah -->
    <a href="<?= base_url('kategori/tambah') ?>"
       class="btn btn-primary mr-2 mb-2">
        <i class="fas fa-plus"></i> Tambah Kategori
    </a>

    <!-- Import -->
    <form action="<?= base_url('kategori/import_excel') ?>"
          method="post"
          enctype="multipart/form-data"
          class="d-flex align-items-center mr-2 mb-2">

        <input type="file"
               name="file"
               accept=".xls,.xlsx"
               class="form-control form-control-sm mr-2"
               style="width: 220px;"
               required>

        <button class="btn btn-success btn-sm">
            <i class="fas fa-file-excel"></i> Import
        </button>
    </form>

    <!-- Download Template -->
    <a href="<?= base_url('kategori/download_template') ?>"
       class="btn btn-success btn-sm mb-2">
        <i class="fas fa-download"></i> Template Excel
    </a>

</div>

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
