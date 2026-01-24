<div class="container-fluid pb-5">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<div class="card shadow">
<div class="card-body">

<form method="post">

    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama"
               class="form-control"
               value="<?= isset($row)?$row->nama:'' ?>" required>
    </div>

    <div class="form-group">
        <label>Username</label>
        <input type="text" name="username"
               class="form-control"
               value="<?= isset($row)?$row->username:'' ?>" required>
    </div>

    <div class="form-group">
        <label>Password <?= isset($row)?'(Kosongkan jika tidak diubah)':'' ?></label>
        <input type="password" name="password"
               class="form-control">
    </div>

    <button class="btn btn-success">
        <i class="fas fa-save"></i> Simpan
    </button>
    <a href="<?= base_url('admin') ?>" class="btn btn-secondary">
        Kembali
    </a>

</form>

</div>
</div>

</div>
