<style>
    .sidebar-brand img {
    max-height: 80px;
    object-fit: contain;
}

    </style>
<?php
$segment1 = $this->uri->segment(1);
$segment2 = $this->uri->segment(2);
?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<a class="sidebar-brand d-flex align-items-center"
   href="<?= base_url('dashboard') ?>">

    <div class="sidebar-brand-icon mr-2">
        <img src="<?= base_url('assets/img/logobispar.png') ?>"
             alt="Logo BIS Inventory"
             style="width:40px; height:40px; object-fit:contain;">
    </div>

    <div class="sidebar-brand-text text-left">
        <div class="font-weight-bold" style="font-size:13px; line-height:1.2;">
            BispVentory
        </div>
        <div class="small text-center" style="font-size:13px;">
            73
        </div>
    </div>

</a>



<hr class="sidebar-divider my-0">

<!-- DASHBOARD -->
<li class="nav-item <?= $segment1=='dashboard'?'active':'' ?>">
    <a class="nav-link" href="<?= base_url('dashboard') ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
    </a>
</li>

<hr class="sidebar-divider">

<!-- HEADING -->
<div class="sidebar-heading">
    Data - Data
</div>

<!-- DATA MASTER -->
<li class="nav-item <?= in_array($segment1,['kategori','barang','barang_ruangan'])?'active':'' ?>">
    <a class="nav-link collapsed" href="#"
       data-toggle="collapse"
       data-target="#dataMaster"
       aria-expanded="<?= in_array($segment1,['kategori','barang','barang_ruangan'])?'true':'false' ?>">
        <i class="fas fa-fw fa-cogs"></i>
        <span>Data Master</span>
    </a>
    <div id="dataMaster"
         class="collapse <?= in_array($segment1,['kategori','barang','barang_ruangan'])?'show':'' ?>">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?= $segment1=='kategori'?'active':'' ?>"
               href="<?= base_url('kategori') ?>">Kategori Barang</a>
            <a class="collapse-item <?= $segment1=='barang'?'active':'' ?>"
               href="<?= base_url('barang') ?>">Data Barang</a>
            <a class="collapse-item <?= $segment1=='barang_ruangan'?'active':'' ?>"
               href="<?= base_url('barang_ruangan') ?>">Barang Ruangan</a>
        </div>
    </div>
</li>

<!-- DATA USER -->
<li class="nav-item <?= in_array($segment1,['user','guru','siswa'])?'active':'' ?>">
    <a class="nav-link collapsed" href="#"
       data-toggle="collapse"
       data-target="#dataUser"
       aria-expanded="<?= in_array($segment1,['user','guru','siswa'])?'true':'false' ?>">
        <i class="fas fa-fw fa-users"></i>
        <span>Data User</span>
    </a>
    <div id="dataUser"
         class="collapse <?= in_array($segment1,['user','guru','siswa'])?'show':'' ?>">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?= $segment2=='admin'?'active':'' ?>"
               href="<?= base_url('admin') ?>">Admin</a>
            <a class="collapse-item <?= $segment1=='guru'?'active':'' ?>"
               href="<?= base_url('guru') ?>">Guru</a>
            <a class="collapse-item <?= $segment1=='siswa'?'active':'' ?>"
               href="<?= base_url('siswa') ?>">Siswa</a>
        </div>
    </div>
</li>

<hr class="sidebar-divider">

<!-- TRANSAKSI -->
<div class="sidebar-heading">
    Transaksi
</div>

<li class="nav-item <?= $segment1=='barang_masuk'?'active':'' ?>">
    <a class="nav-link" href="<?= base_url('barang_masuk') ?>">
        <i class="fas fa-fw fa-arrow-down"></i>
        <span>Barang Masuk</span>
    </a>
</li>

<li class="nav-item <?= $segment1=='stock'?'active':'' ?>">
    <a class="nav-link" href="<?= base_url('stock') ?>">
        <i class="fas fa-fw fa-boxes"></i>
        <span>Stok Barang</span>
    </a>
</li>

<li class="nav-item <?= $segment1=='permohonan'?'active':'' ?>">
    <a class="nav-link" href="<?= base_url('permohonan') ?>">
        <i class="fas fa-fw fa-file-signature"></i>
        <span>Permohonan Barang</span>
    </a>
</li>

<li class="nav-item <?= $segment1=='barang_keluar'?'active':'' ?>">
    <a class="nav-link" href="<?= base_url('barang_keluar') ?>">
        <i class="fas fa-fw fa-arrow-up"></i>
        <span>Barang Keluar</span>
    </a>
</li>

<li class="nav-item <?= $segment1=='peminjaman'?'active':'' ?>">
    <a class="nav-link" href="<?= base_url('peminjaman') ?>">
        <i class="fas fa-fw fa-handshake"></i>
        <span>Peminjaman</span>
    </a>
</li>

<li class="nav-item <?= $segment1=='barang_rusak'?'active':'' ?>">
    <a class="nav-link" href="<?= base_url('barang_rusak') ?>">
        <i class="fas fa-fw fa-tools"></i>
        <span>Barang Rusak</span>
    </a>
</li>

<li class="nav-item <?= $segment1=='barang_rusak_ruangan'?'active':'' ?>">
    <a class="nav-link" href="<?= base_url('barang_rusak_ruangan') ?>">
        <i class="fas fa-fw fa-exclamation-triangle"></i>
        <span>Barang Rusak Ruangan</span>
    </a>
</li>

<hr class="sidebar-divider">

<!-- LAPORAN -->
<div class="sidebar-heading">
    Laporan
</div>

<li class="nav-item <?= $segment1=='laporan'?'active':'' ?>">
    <a class="nav-link collapsed" href="#"
       data-toggle="collapse"
       data-target="#laporan"
       aria-expanded="<?= $segment1=='laporan'?'true':'false' ?>">
        <i class="fas fa-fw fa-file-alt"></i>
        <span>Laporan</span>
    </a>
    <div id="laporan"
         class="collapse <?= $segment1=='laporan'?'show':'' ?>">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?= $segment2=='masuk'?'active':'' ?>"
               href="<?= base_url('laporan/masuk') ?>">Barang Masuk</a>
            <a class="collapse-item <?= $segment2=='keluar'?'active':'' ?>"
               href="<?= base_url('laporan/keluar') ?>">Barang Keluar</a>
            <a class="collapse-item <?= $segment2=='stok'?'active':'' ?>"
               href="<?= base_url('laporan/stok') ?>">Sisa Stok</a>
            <a class="collapse-item <?= $segment2=='buku_besar'?'active':'' ?>"
               href="<?= base_url('laporan/buku_besar') ?>">Kartu Persediaan</a>
        </div>
    </div>
</li>
<li class="nav-item <?= $segment1=='backup'?'active':'' ?>">
    <a class="nav-link" href="<?= base_url('backup') ?>">
        <i class="fas fa-fw fa-database"></i>
        <span>Backup & Restore</span>
    </a>
</li>

<hr class="sidebar-divider d-none d-md-block">

<!-- TOGGLER -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
