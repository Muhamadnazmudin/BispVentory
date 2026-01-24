<div class="container-fluid pb-5">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<div class="card shadow">
<div class="card-body">

<form method="post">

    <div class="form-group">
        <label>Nama Guru</label>
        <input type="text" name="nama_guru" class="form-control"
               value="<?= isset($row)?$row->nama_guru:'' ?>" required>
    </div>

    <div class="form-group">
        <label>NIP</label>
        <input type="text" name="nip" class="form-control"
               value="<?= isset($row)?$row->nip:'' ?>">
    </div>

    <div class="form-group">
        <label>Jabatan</label>
        <input type="text" name="jabatan" class="form-control"
               value="<?= isset($row)?$row->jabatan:'' ?>">
    </div>

    <button class="btn btn-success">
        <i class="fas fa-save"></i> Simpan
    </button>
    <a href="<?= base_url('guru') ?>" class="btn btn-secondary">
        Kembali
    </a>

</form>
<hr>

<h5 class="mt-4">Import Data Guru (Excel)</h5>

<form action="<?= base_url('guru/import_excel') ?>" 
      method="post" enctype="multipart/form-data">

    <div class="form-group">
        <input type="file" name="file_excel"
               class="form-control"
               accept=".xls,.xlsx" required>
        <small class="text-muted">
            Format: nama_guru | nip | jabatan (baris pertama header)
        </small>
        <a href="<?= base_url('guru/download_template') ?>"
   class="btn btn-success mb-3">
   <i class="fas fa-download"></i> Download Template Excel
</a>

    </div>

    <button class="btn btn-primary">
        <i class="fas fa-file-excel"></i> Import Excel
    </button>
</form>

</div>
</div>

</div>
