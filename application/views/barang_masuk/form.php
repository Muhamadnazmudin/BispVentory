<style>
body.dark-mode .card-body input[readonly] {
    color: #212529 !important;
    background-color: #e9ecef !important;
}
    </style>
<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<div class="card shadow">
<div class="card-body">

<form method="post">

<div class="form-group">
<label>Tanggal</label>
<input type="date" name="tanggal" class="form-control"
value="<?= isset($row)?$row->tanggal:'' ?>" required>
</div>

<div class="form-group">
<label>Barang</label>
<select name="id_barang" class="form-control" required id="barangSelect">
<option value="">- Pilih Barang -</option>
<?php foreach($barang as $b): ?>
<option value="<?= $b->id_barang ?>"
    data-satuan="<?= $b->satuan ?>"
    data-merk="<?= $b->merk ?>"
    data-harga="<?= $b->harga ?>"
    <?= isset($row) && $row->id_barang==$b->id_barang?'selected':'' ?>>
    <?= $b->nama_barang ?> (<?= $b->merk ?>)
</option>
<?php endforeach; ?>
</select>
</div>

<div class="form-group">
<label>Satuan</label>
<input type="text" name="satuan" class="form-control" readonly>
</div>

<div class="form-group">
<label>Merk</label>
<input type="text" name="merk" class="form-control" readonly>
</div>
<div class="form-group">
<label>Harga</label>
<input type="text" name="harga_view" class="form-control" readonly>
<input type="hidden" name="harga">
</div>

<div class="form-group">
<label>Jumlah</label>
<input type="number" name="jumlah" class="form-control" min="1" required
value="<?= isset($row)?$row->jumlah:'' ?>">
</div>

<div class="form-group">
<label>Toko <small class="text-muted">(Opsional)</small></label>
<input type="text" name="toko" class="form-control"
value="<?= isset($row)?$row->toko:'' ?>">
</div>

<div class="form-group">
<label>Perolehan</label>
<select name="perolehan" class="form-control">
<option value="BOSP" <?= isset($row)&&$row->perolehan=='BOSP'?'selected':'' ?>>BOSP</option>
<option value="BOPD" <?= isset($row)&&$row->perolehan=='BOPD'?'selected':'' ?>>BOPD</option>
</select>
</div>

<div class="mt-4">
<button type="submit" class="btn btn-success">
<i class="fas fa-save"></i> Simpan
</button>
<a href="<?= base_url('barang_masuk') ?>" class="btn btn-secondary">
Kembali
</a>
</div>

</form>

</div>
</div>

</div>

<script>
const barangSelect = document.getElementById('barangSelect');
const satuanInput  = document.querySelector('[name="satuan"]');
const merkInput    = document.querySelector('[name="merk"]');
const hargaView    = document.querySelector('[name="harga_view"]');
const hargaReal    = document.querySelector('[name="harga"]');

function formatRupiah(angka){
    return new Intl.NumberFormat('id-ID').format(angka);
}

function setBarangInfo() {
    const opt = barangSelect.options[barangSelect.selectedIndex];
    if (!opt) return;

    satuanInput.value = opt.getAttribute('data-satuan') || '';
    merkInput.value   = opt.getAttribute('data-merk') || '';

    const harga = opt.getAttribute('data-harga') || 0;
    hargaView.value = harga ? formatRupiah(harga) : '';
    hargaReal.value = harga;
}

// ganti barang
barangSelect.addEventListener('change', setBarangInfo);

// saat edit / reload
window.addEventListener('DOMContentLoaded', setBarangInfo);
</script>

