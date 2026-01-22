<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
    <?= $this->session->flashdata('success') ?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger">
    <?= $this->session->flashdata('error') ?>
</div>
<?php endif; ?>

<div class="card shadow mb-4">
<div class="card-body">

<table class="table table-bordered table-striped">
<thead class="thead-light">
<tr>
    <th width="5%">No</th>
    <th>Tanggal</th>
    <th>Nama Barang</th>
    <th>Merk</th>
    <th>Jumlah</th>
    <th>Pemohon</th>
    <th>Nama Pemohon</th>
    <th>Keterangan</th>
    <th width="12%">Aksi</th>
</tr>
</thead>
<tbody>

<?php if(empty($list)): ?>
<tr>
    <td colspan="9" class="text-center text-muted">
        Belum ada data barang keluar
    </td>
</tr>
<?php else: ?>

<?php $no=1; foreach($list as $r): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= date('d-m-Y', strtotime($r->tanggal)) ?></td>
    <td><?= $r->nama_barang ?></td>
    <td><?= $r->merk ?></td>
    <td class="text-right font-weight-bold"><?= $r->jumlah ?></td>
    <td class="text-capitalize"><?= $r->pemohon ?></td>
    <td>
        <?= $r->pemohon == 'guru' ? $r->nama_guru : ($r->pemohon == 'siswa' ? $r->nama_siswa : '-') ?>
    </td>
    <td><?= $r->keterangan ?: '-' ?></td>
    <td class="text-center">

        <a href="<?= base_url('barang_keluar/edit/'.$r->id_keluar) ?>"
           class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i>
        </a>

        <a href="<?= base_url('barang_keluar/hapus/'.$r->id_keluar) ?>"
           class="btn btn-danger btn-sm"
           onclick="return confirm('Batalkan pengeluaran barang ini? Stok akan dikembalikan.')">
            <i class="fas fa-times"></i>
        </a>

    </td>
</tr>
<?php endforeach; ?>

<?php endif; ?>

</tbody>
</table>

</div>
</div>

</div>
