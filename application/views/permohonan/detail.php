<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<a href="<?= base_url('permohonan') ?>" class="btn btn-secondary mb-3">
    <i class="fas fa-arrow-left"></i> Kembali
</a>

<div class="card shadow mb-4">
<div class="card-body">

<!-- HEADER PERMOHONAN -->
<table class="table table-borderless">
<tr>
    <th width="20%">Tanggal</th>
    <td>: <?= date('d-m-Y', strtotime($permohonan->tanggal)) ?></td>
</tr>
<tr>
    <th>Pemohon</th>
    <td>:
        <?php if($permohonan->pemohon == 'guru'): ?>
            <?= $permohonan->nama_guru ?>
        <?php elseif($permohonan->pemohon == 'siswa'): ?>
            <?= $permohonan->nama_siswa ?>
        <?php else: ?>
            -
        <?php endif; ?>
    </td>
</tr>
<tr>
    <th>Status</th>
    <td>:
        <span class="badge badge-<?= 
            $permohonan->status == 'pending' ? 'warning' :
            ($permohonan->status == 'disetujui' ? 'success' : 'danger')
        ?>">
            <?= strtoupper($permohonan->status) ?>
        </span>
    </td>
</tr>
</table>

<hr>

<!-- DETAIL BARANG -->
<h5>Daftar Barang Dimohon</h5>

<table class="table table-bordered mt-3">
<thead class="thead-light">
<tr>
    <th width="5%">No</th>
    <th>Nama Barang</th>
    <th>Merk</th>
    <th>Jumlah</th>
    <th>Satuan</th>
</tr>
</thead>
<tbody>

<?php if(empty($detail)): ?>
<tr>
    <td colspan="5" class="text-center text-muted">
        Tidak ada detail barang
    </td>
</tr>
<?php else: ?>

<?php $no=1; foreach($detail as $d): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $d->nama_barang ?></td>
    <td><?= $d->merk ?></td>
    <td class="text-right"><?= $d->jumlah ?></td>
    <td><?= $d->satuan ?></td>
</tr>
<?php endforeach; ?>

<?php endif; ?>

</tbody>
</table>

<!-- AKSI APPROVAL -->
<hr>

<!-- TOMBOL PDF SELALU ADA -->
<a href="<?= base_url('permohonan/pdf/'.$permohonan->id_permohonan) ?>"
   class="btn btn-primary mb-2" target="_blank">
    <i class="fas fa-eye"></i> Preview PDF
</a>

<a href="<?= base_url('permohonan/download_pdf/'.$permohonan->id_permohonan) ?>"
   class="btn btn-success mb-2">
    <i class="fas fa-download"></i> Download PDF
</a>


<!-- TOMBOL APPROVAL HANYA SAAT PENDING -->
<?php if($permohonan->status == 'pending'): ?>

<form method="post"
      action="<?= base_url('permohonan/approve/'.$permohonan->id_permohonan) ?>"
      class="d-inline">
    <button class="btn btn-success"
            onclick="return confirm('Setujui permohonan ini?')">
        <i class="fas fa-check"></i> Setujui
    </button>
</form>

<form method="post"
      action="<?= base_url('permohonan/tolak/'.$permohonan->id_permohonan) ?>"
      class="d-inline">
    <button class="btn btn-danger"
            onclick="return confirm('Tolak permohonan ini?')">
        <i class="fas fa-times"></i> Tolak
    </button>
</form>

<?php endif; ?>


</div>
</div>

</div>
