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

</div>
</div>

</div>
