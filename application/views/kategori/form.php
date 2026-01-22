<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<div class="card shadow">
<div class="card-body">

<form method="post">

<div class="form-group">
<label>Nama Kategori</label>
<input type="text" name="nama_kategori" class="form-control"
value="<?= isset($row)?$row->nama_kategori:'' ?>" required>
</div>

<div class="form-group">
<label>Keterangan</label>
<textarea name="keterangan" class="form-control"><?= isset($row)?$row->keterangan:'' ?></textarea>
</div>

<button class="btn btn-success">
<i class="fas fa-save"></i> Simpan
</button>
<a href="<?= base_url('kategori') ?>" class="btn btn-secondary">
Kembali
</a>

</form>

</div>
</div>

</div>
