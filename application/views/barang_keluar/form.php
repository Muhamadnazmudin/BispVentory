<div class="container-fluid pb-5">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>

<div class="card shadow">
<div class="card-body">

<form method="post">

    <div class="form-group">
        <label>Tanggal</label>
        <input type="date" name="tanggal" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Barang</label>
        <select name="id_barang" class="form-control" required>
            <option value="">- Pilih Barang -</option>
            <?php foreach($barang as $b): ?>
                <option value="<?= $b->id_barang ?>">
                    <?= $b->nama_barang ?> (<?= $b->merk ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Jumlah Keluar</label>
        <input type="number" name="jumlah" class="form-control" min="1" required>
    </div>

    <div class="form-group">
        <label>Pemohon</label>
        <select name="pemohon" id="pemohon" class="form-control" required>
            <option value="">- Pilih -</option>
            <option value="guru">Guru</option>
            <option value="siswa">Siswa</option>
        </select>
    </div>

    <div class="form-group" id="guru-box" style="display:none;">
        <label>Guru</label>
        <select name="id_guru" class="form-control">
            <option value="">- Pilih Guru -</option>
            <?php foreach($guru as $g): ?>
                <option value="<?= $g->id_guru ?>"><?= $g->nama_guru ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group" id="siswa-box" style="display:none;">
        <label>Siswa</label>
        <select name="id_siswa" class="form-control">
            <option value="">- Pilih Siswa -</option>
            <?php foreach($siswa as $s): ?>
                <option value="<?= $s->id_siswa ?>"><?= $s->nama_siswa ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control"></textarea>
    </div>

    <button class="btn btn-danger">
        <i class="fas fa-arrow-up"></i> Keluarkan Barang
    </button>

</form>

</div>
</div>

</div>

<script>
const pemohon = document.getElementById('pemohon');
const guruBox = document.getElementById('guru-box');
const siswaBox = document.getElementById('siswa-box');

pemohon.addEventListener('change', function(){
    guruBox.style.display  = this.value === 'guru'  ? 'block' : 'none';
    siswaBox.style.display = this.value === 'siswa' ? 'block' : 'none';
});
</script>
