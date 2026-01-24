<div class="container-fluid pb-5">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
<div class="mb-3">
    <a href="<?= base_url('siswa/download_template') ?>" 
       class="btn btn-success">
       <i class="fas fa-download"></i> Download Template
    </a>
</div>

<form action="<?= base_url('siswa/import_excel') ?>"
      method="post" enctype="multipart/form-data"
      class="mb-4">

    <div class="form-row">
        <div class="col-md-4">
            <input type="file" name="file_excel"
                   class="form-control"
                   accept=".xls,.xlsx" required>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">
                <i class="fas fa-file-excel"></i> Import
            </button>
        </div>
    </div>

    <small class="text-muted">
        Format: nama_siswa | nisn | kelas
    </small>
</form>

<div class="card shadow">
<div class="card-body">

<form method="post">

    <div class="form-group">
        <label>Nama Siswa</label>
        <input type="text" name="nama_siswa"
               class="form-control"
               value="<?= isset($row)?$row->nama_siswa:'' ?>" required>
    </div>

    <div class="form-group">
        <label>NISN</label>
        <input type="text" name="nisn"
               class="form-control"
               value="<?= isset($row)?$row->nisn:'' ?>" required>
    </div>

    <div class="form-group">
        <label>Kelas</label>
        <input type="text" name="kelas"
               class="form-control"
               value="<?= isset($row)?$row->kelas:'' ?>" required>
    </div>

    <button class="btn btn-success">
        <i class="fas fa-save"></i> Simpan
    </button>
    <a href="<?= base_url('siswa') ?>" class="btn btn-secondary">
        Kembali
    </a>

</form>

</div>
</div>

</div>
