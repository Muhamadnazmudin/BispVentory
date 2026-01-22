<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<div class="card shadow">
<div class="card-body">

<form method="post">

<!-- =========================
     HEADER
========================= -->
<div class="row mb-3">
<div class="col-md-3">
<label>Tanggal</label>
<input type="date" name="tanggal" class="form-control" required>
</div>

<div class="col-md-3">
<label>Pemohon</label>
<select name="pemohon" id="pemohon" class="form-control" required>
<option value="">- Pilih -</option>
<option value="guru">Guru</option>
<option value="siswa">Siswa</option>
</select>
</div>

<div class="col-md-3" id="wrapGuru" style="display:none;">
<label>Guru</label>
<select name="id_guru" class="form-control">
<option value="">- Pilih Guru -</option>
<?php foreach($guru as $g): ?>
<option value="<?= $g->id_guru ?>"><?= $g->nama_guru ?></option>
<?php endforeach; ?>
</select>
</div>

<div class="col-md-3" id="wrapSiswa" style="display:none;">
<label>Siswa</label>
<select name="id_siswa" class="form-control">
<option value="">- Pilih Siswa -</option>
<?php foreach($siswa as $s): ?>
<option value="<?= $s->id_siswa ?>"><?= $s->nama_siswa ?></option>
<?php endforeach; ?>
</select>
</div>
</div>

<!-- =========================
     DETAIL BARANG
========================= -->
<div class="table-responsive">
<table class="table table-bordered" id="tableItem">
<thead class="thead-light">
<tr>
<th>Barang</th>
<th width="20%">Stok</th>
<th width="20%">Jumlah</th>
<th width="5%"></th>
</tr>
</thead>
<tbody>
<tr>
<td>
<select name="id_barang[]" class="form-control barangSelect" required>
<option value="">- Pilih Barang -</option>
<?php foreach($barang as $b): ?>
<option value="<?= $b->id_barang ?>"
    data-stok="<?= $b->stok ?>">
    <?= $b->nama_barang ?> 
(<span class="font-weight-bold text-primary"><?= $b->merk ?></span>)

</option>
<?php endforeach; ?>
</select>
</td>
<td>
<input type="text" class="form-control stokView" readonly placeholder="0">
</td>
<td>
<input type="number" name="jumlah[]" class="form-control jumlahInput"
min="1" required>
</td>
<td class="text-center">
<button type="button" class="btn btn-sm btn-primary" onclick="addRow()">
<i class="fas fa-plus"></i>
</button>
</td>
</tr>
</tbody>
</table>
</div>

<!-- =========================
     KETERANGAN
========================= -->
<div class="form-group">
<label>Keterangan</label>
<textarea name="keterangan" class="form-control" rows="3"></textarea>
</div>

<!-- =========================
     ACTION
========================= -->
<div class="mt-4">
<button class="btn btn-success">
<i class="fas fa-save"></i> Simpan Permohonan
</button>
<a href="<?= base_url('permohonan') ?>" class="btn btn-secondary">
Kembali
</a>
</div>

</form>

</div>
</div>

</div>

<!-- =========================
     SCRIPT
========================= -->
<script>
// pemohon
document.getElementById('pemohon').addEventListener('change',function(){
    document.getElementById('wrapGuru').style.display  = this.value=='guru'?'block':'none';
    document.getElementById('wrapSiswa').style.display = this.value=='siswa'?'block':'none';
});

// update stok per row
function bindRow(row){
    const select = row.querySelector('.barangSelect');
    const stok   = row.querySelector('.stokView');
    const jumlah = row.querySelector('.jumlahInput');

    select.addEventListener('change',function(){
        const s = this.options[this.selectedIndex].getAttribute('data-stok') || 0;
        stok.value = s;
        jumlah.max = s;
    });

    jumlah.addEventListener('input',function(){
        if(parseInt(this.value) > parseInt(this.max)){
            alert('Jumlah melebihi stok tersedia');
            this.value = this.max;
        }
    });
}

// tambah baris
function addRow(){
    const tbody = document.querySelector('#tableItem tbody');
    const row   = tbody.rows[0].cloneNode(true);

    row.querySelector('.barangSelect').value = '';
    row.querySelector('.stokView').value = '';
    row.querySelector('.jumlahInput').value = '';

    row.querySelector('td:last-child').innerHTML = `
        <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">
            <i class="fas fa-trash"></i>
        </button>`;

    tbody.appendChild(row);
    bindRow(row);
}

// bind awal
document.querySelectorAll('#tableItem tbody tr').forEach(bindRow);
</script>
