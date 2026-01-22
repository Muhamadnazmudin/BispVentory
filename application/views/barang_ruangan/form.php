<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<div class="card shadow">
<div class="card-body">

<form method="post">

<div class="form-group">
<label>Barang</label>
<select name="id_barang" class="form-control" required>
<option value="">- Pilih -</option>
<?php foreach($barang as $b): ?>
<option value="<?= $b->id_barang ?>"
<?= isset($row)&&$row->id_barang==$b->id_barang?'selected':'' ?>>
<?= $b->nama_barang ?>
</option>
<?php endforeach; ?>
</select>
</div>

<div class="form-group">
<label>Ruangan</label>
<select name="id_ruangan" class="form-control" required>
<option value="">- Pilih -</option>
<?php foreach($ruangan as $r): ?>
<option value="<?= $r->id_ruangan ?>"
<?= isset($row)&&$row->id_ruangan==$r->id_ruangan?'selected':'' ?>>
<?= $r->nama_ruangan ?>
</option>
<?php endforeach; ?>
</select>
</div>

<div class="form-group">
<label>Jumlah</label>
<input type="number" name="jumlah" class="form-control"
value="<?= isset($row)?$row->jumlah:'' ?>" required>
</div>

<div class="form-group">
<label>Keterangan</label>
<textarea name="keterangan" class="form-control"><?= isset($row)?$row->keterangan:'' ?></textarea>
</div>

<button class="btn btn-success">
<i class="fas fa-save"></i> Simpan
</button>
<a href="<?= base_url('barang_ruangan') ?>" class="btn btn-secondary">
Kembali
</a>

</form>

</div>
</div>

</div>
