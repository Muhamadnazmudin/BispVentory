<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<div class="card shadow">
<div class="card-body">

<form method="post">

<div class="form-group">
<label>Kode Barang</label>

<!-- tampil ke user -->
<input type="text"
       class="form-control"
       value="<?= isset($row) ? $row->kode_barang : $kode_barang ?>"
       readonly>

<!-- dikirim ke server -->
<input type="hidden"
       name="kode_barang"
       value="<?= isset($row) ? $row->kode_barang : $kode_barang ?>">
</div>


<div class="form-group">
<label>Nama Barang</label>
<input type="text" name="nama_barang" class="form-control"
value="<?= isset($row)?$row->nama_barang:'' ?>" required>
</div>

<div class="form-group">
<label>Kategori</label>
<select name="id_kategori" class="form-control" required>
<option value="">- Pilih -</option>
<?php foreach($kategori as $k): ?>
<option value="<?= $k->id_kategori ?>"
<?= isset($row) && $row->id_kategori==$k->id_kategori?'selected':'' ?>>
<?= $k->nama_kategori ?>
</option>
<?php endforeach; ?>
</select>
</div>
<div class="form-group">
    <label>Merk</label>
    <input type="text" name="merk" class="form-control"
           value="<?= isset($row)?$row->merk:'' ?>" required>
</div>

<div class="form-group">
<label>Satuan</label>
<input type="text" name="satuan" class="form-control"
value="<?= isset($row)?$row->satuan:'' ?>">
</div>
<div class="form-group">
    <label>Harga</label>
    <input type="number"
           name="harga"
           class="form-control"
           value="<?= isset($row)?$row->harga:'' ?>"
           min="0"
           step="0.01"
           placeholder="Contoh: 150000"
           required>
</div>

<div class="form-group">
<label>Keterangan</label>
<textarea name="keterangan" class="form-control"><?= isset($row)?$row->keterangan:'' ?></textarea>
</div>

<button class="btn btn-success">
<i class="fas fa-save"></i> Simpan
</button>
<a href="<?= base_url('barang') ?>" class="btn btn-secondary">Kembali</a>

</form>

</div>
</div>

</div>
