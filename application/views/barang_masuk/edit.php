<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<div class="card shadow">
<div class="card-body">

<form method="post">

<div class="row">
<div class="col-md-6">

<div class="form-group">
<label>Tanggal</label>
<input type="date" name="tanggal" class="form-control"
value="<?= $row->tanggal ?>" required>
</div>

<div class="form-group">
<label>Nama Barang</label>
<select name="barang_id" class="form-control" required>
<?php foreach($barang as $b): ?>
<option value="<?= $b->id ?>" 
<?= $b->id==$row->barang_id?'selected':'' ?>>
<?= $b->nama_barang ?>
</option>
<?php endforeach; ?>
</select>
</div>

<div class="form-group">
<label>Merk</label>
<input type="text" name="merk" class="form-control"
value="<?= $row->merk ?>">
</div>

<div class="form-group">
<label>Jumlah</label>
<input type="number" name="jumlah" class="form-control"
value="<?= $row->jumlah ?>" min="1" required>
</div>

</div>

<div class="col-md-6">

<div class="form-group">
<label>Satuan</label>
<input type="text" name="satuan" class="form-control"
value="<?= $row->satuan ?>">
</div>

<div class="form-group">
<label>Perolehan</label>
<select name="perolehan" class="form-control">
<option <?= $row->perolehan=='Pembelian'?'selected':'' ?>>Pembelian</option>
<option <?= $row->perolehan=='Hibah'?'selected':'' ?>>Hibah</option>
<option <?= $row->perolehan=='Bantuan'?'selected':'' ?>>Bantuan</option>
</select>
</div>

<div class="form-group">
<label>Toko / Sumber</label>
<input type="text" name="toko" class="form-control"
value="<?= $row->toko ?>">
</div>

</div>
</div>

<hr>

<button class="btn btn-primary">
<i class="fas fa-save"></i> Update
</button>
<a href="<?= base_url('barang_masuk') ?>" class="btn btn-secondary">
Kembali
</a>

</form>

</div>
</div>

</div>
