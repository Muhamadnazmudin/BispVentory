<style>

/* =========================================================
   BISPVENTORY SIDEBAR
========================================================= */

.sidebar {
    width: 224px !important;

    position: fixed;
    top: 0;
    left: 0;

    height: 100vh;

    overflow-y: auto;
    overflow-x: hidden;

    z-index: 1030;

    scrollbar-width: thin;
}

.sidebar::-webkit-scrollbar {
    width: 5px;
}

.sidebar::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,.18);
    border-radius: 10px;
}

.sidebar::-webkit-scrollbar-track {
    background: transparent;
}


/* =========================================================
   CONTENT
========================================================= */

@media (min-width: 768px) {

    #content-wrapper {
        margin-left: 224px;
    }

    body.sidebar-toggled #content-wrapper {
        margin-left: 6.5rem;
    }

}


/* =========================================================
   BRAND
========================================================= */

.sidebar-brand {
    min-height: 76px;

    padding: 12px 15px !important;

    border-bottom: 1px solid rgba(255,255,255,.08);

    transition: .2s ease;
}

.sidebar-brand:hover {
    background: rgba(255,255,255,.04);
}

.sidebar-brand-icon {
    width: 43px;
    height: 43px;

    flex: 0 0 43px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-right: 9px !important;

    border-radius: 12px;

    background: rgba(255,255,255,.12);
}

.sidebar-brand-icon img {
    width: 34px !important;
    height: 34px !important;

    object-fit: contain;
}

.sidebar-brand-text {
    min-width: 0;

    color: #fff !important;

    line-height: 1.15;
}

.sidebar-brand-title {
    font-size: 13px;

    font-weight: 800;

    letter-spacing: .2px;
}

.sidebar-brand-version {
    margin-top: 3px;

    color: rgba(255,255,255,.65);

    font-size: 10px;

    font-weight: 600;
}


/* =========================================================
   DIVIDER
========================================================= */

.sidebar-divider {
    margin: 9px 15px;

    border-top-color: rgba(255,255,255,.10) !important;
}


/* =========================================================
   SIDEBAR HEADING
========================================================= */

.sidebar-heading {
    padding: 10px 17px 6px !important;

    color: rgba(255,255,255,.48) !important;

    font-size: 9px !important;

    font-weight: 800 !important;

    letter-spacing: 1px;

    text-transform: uppercase;
}


/* =========================================================
   NAV ITEM
========================================================= */

.sidebar .nav-item {
    margin: 2px 9px;
}

.sidebar .nav-link {
    min-height: 41px;

    display: flex !important;

    align-items: center;

    padding: 9px 11px !important;

    border-radius: 10px;

    color: rgba(255,255,255,.78) !important;

    font-size: 12px;

    font-weight: 600;

    transition:
        background .15s ease,
        color .15s ease,
        transform .15s ease;
}

.sidebar .nav-link i {
    width: 22px;

    margin-right: 8px;

    color: rgba(255,255,255,.58);

    font-size: 13px;

    text-align: center;

    transition: .15s ease;
}

.sidebar .nav-link span {
    flex: 1;
}


/* =========================================================
   HOVER
========================================================= */

.sidebar .nav-link:hover {
    color: #fff !important;

    background: rgba(255,255,255,.09);

    transform: translateX(1px);
}

.sidebar .nav-link:hover i {
    color: #fff;
}


/* =========================================================
   ACTIVE
========================================================= */

.sidebar .nav-item.active > .nav-link {
    color: #fff !important;

    background: rgba(255,255,255,.14);

    box-shadow:
        inset 3px 0 0 rgba(255,255,255,.9);
}

.sidebar .nav-item.active > .nav-link i {
    color: #fff;
}


/* =========================================================
   COLLAPSE ARROW
========================================================= */

.sidebar .nav-link[data-toggle="collapse"]::after {
    margin-left: auto;

    font-size: 9px;

    opacity: .55;
}

.sidebar .nav-link[data-toggle="collapse"][aria-expanded="true"] {
    color: #fff !important;

    background: rgba(255,255,255,.08);
}

.sidebar .nav-link[data-toggle="collapse"][aria-expanded="true"] i {
    color: #fff;
}


/* =========================================================
   SUBMENU
========================================================= */

.sidebar .collapse {
    margin: 2px 5px 7px;
}

.sidebar .collapse-inner {
    padding: 7px !important;

    border-radius: 11px !important;

    background: rgba(255,255,255,.96) !important;

    box-shadow:
        0 5px 18px rgba(0,0,0,.12);
}

.sidebar .collapse-header {
    padding: 5px 10px 7px;

    color: #9a9cac;

    font-size: 8px;

    font-weight: 800;

    letter-spacing: .6px;

    text-transform: uppercase;
}

.sidebar .collapse-divider {
    height: 1px;

    margin: 6px 8px;

    background: #edf0f5;
}

.sidebar .collapse-item {
    display: flex;
    align-items: center;

    min-height: 36px;

    padding: 8px 10px;

    border-radius: 8px;

    color: #5a5c69 !important;

    font-size: 11px;

    font-weight: 600;

    transition: .15s ease;
}

.sidebar .collapse-item i {
    width: 18px;

    margin-right: 7px;

    color: #9aa0ad;

    font-size: 10px;

    text-align: center;
}

.sidebar .collapse-item:hover {
    color: #4e73df !important;

    background: #f1f5ff;

    text-decoration: none;

    transform: translateX(1px);
}

.sidebar .collapse-item:hover i {
    color: #4e73df;
}

.sidebar .collapse-item.active {
    color: #4e73df !important;

    background: #eaf0ff;

    font-weight: 800;
}

.sidebar .collapse-item.active i {
    color: #4e73df;
}


/* =========================================================
   SPECIAL UPLOAD MENU
========================================================= */

.sidebar .collapse-item.upload-menu {
    color: #4e73df !important;

    background: #f3f6ff;

    margin-top: 2px;
}

.sidebar .collapse-item.upload-menu i {
    color: #4e73df;
}

.sidebar .collapse-item.upload-menu:hover,
.sidebar .collapse-item.upload-menu.active {
    color: #fff !important;

    background: #4e73df;
}

.sidebar .collapse-item.upload-menu:hover i,
.sidebar .collapse-item.upload-menu.active i {
    color: #fff;
}


/* =========================================================
   TOGGLER
========================================================= */

.sidebar-toggle-wrapper {
    padding: 8px 0 15px;
}

.sidebar-toggle-button {
    width: 32px;
    height: 32px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    border: 0;

    color: rgba(255,255,255,.65);

    background: rgba(255,255,255,.08);

    transition: .15s ease;
}

.sidebar-toggle-button:hover {
    color: #fff;

    background: rgba(255,255,255,.15);
}


/* =========================================================
   SIDEBAR COLLAPSED
========================================================= */

.sidebar.toggled {
    width: 6.5rem !important;
}

.sidebar.toggled .sidebar-brand {
    justify-content: center;

    padding-left: 8px !important;
    padding-right: 8px !important;
}

.sidebar.toggled .sidebar-brand-icon {
    margin-right: 0 !important;
}

.sidebar.toggled .sidebar-brand-text {
    display: none;
}

.sidebar.toggled .sidebar-heading {
    text-align: center;

    padding-left: 5px !important;
    padding-right: 5px !important;
}

.sidebar.toggled .nav-item {
    margin-left: 10px;
    margin-right: 10px;
}

.sidebar.toggled .nav-link {
    justify-content: center;

    padding-left: 8px !important;
    padding-right: 8px !important;
}

.sidebar.toggled .nav-link i {
    margin-right: 0;

    width: auto;
}

.sidebar.toggled .nav-link span {
    display: none;
}

.sidebar.toggled .nav-link[data-toggle="collapse"]::after {
    display: none;
}


/* =========================================================
   DARK MODE
========================================================= */

body.dark-mode .sidebar .collapse-inner {
    background: #1f2937 !important;
}

body.dark-mode .sidebar .collapse-item {
    color: #d1d5db !important;
}

body.dark-mode .sidebar .collapse-item:hover {
    color: #fff !important;

    background: #374151;
}

body.dark-mode .sidebar .collapse-item.active {
    color: #fff !important;

    background: #3b5fc0;
}

body.dark-mode .sidebar .collapse-divider {
    background: #374151;
}

body.dark-mode .sidebar .collapse-header {
    color: #9ca3af;
}

body.dark-mode .sidebar .collapse-item.upload-menu {
    color: #c7d7ff !important;

    background: #25345d;
}

body.dark-mode .sidebar .collapse-item.upload-menu:hover,
body.dark-mode .sidebar .collapse-item.upload-menu.active {
    color: #fff !important;

    background: #4e73df;
}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 767.98px) {

    .sidebar {
        position: fixed;

        height: 100vh;
    }

    #content-wrapper {
        margin-left: 0;
    }

    body.sidebar-toggled #content-wrapper {
        margin-left: 0;
    }

}

</style>


<?php

$segment1 = $this->uri->segment(1);
$segment2 = $this->uri->segment(2);

/*
|--------------------------------------------------------------------------
| ROLE USER
|--------------------------------------------------------------------------
| BispVentory menggunakan role berbentuk teks:
| admin
| operator
| jurusan
|--------------------------------------------------------------------------
*/

$role = strtolower(
    trim(
        (string) $this->session->userdata('role')
    )
);

$is_admin    = ($role === 'admin');
$is_operator = ($role === 'operator');

$is_upload_page = ($segment1 === 'upload');

$is_master_page = in_array(
    $segment1,
    array(
        'kategori',
        'barang',
        'barang_ruangan'
    )
);

$is_user_page = in_array(
    $segment1,
    array(
        'admin',
        'user',
        'guru',
        'siswa'
    )
);

$is_laporan_page = ($segment1 === 'laporan');

?>


<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
    id="accordionSidebar">


    <!-- =====================================================
         BRAND
    ====================================================== -->

    <a class="sidebar-brand d-flex align-items-center"
       href="<?= base_url('dashboard') ?>">

        <div class="sidebar-brand-icon">

            <img src="<?= base_url('assets/img/logobispar.png') ?>"
                 alt="Logo BispVentory">

        </div>

        <div class="sidebar-brand-text">

            <div class="sidebar-brand-title">
                BispVentory
            </div>

            <div class="sidebar-brand-version">
                Sistem Inventaris
            </div>

        </div>

    </a>


    <hr class="sidebar-divider my-0">


    <!-- =====================================================
         DASHBOARD
    ====================================================== -->

    <li class="nav-item <?= $segment1 === 'dashboard' ? 'active' : '' ?>">

        <a class="nav-link"
           href="<?= base_url('dashboard') ?>">

            <i class="fas fa-fw fa-tachometer-alt"></i>

            <span>Dashboard</span>

        </a>

    </li>


    <hr class="sidebar-divider">


    <!-- =====================================================
         DATA
    ====================================================== -->

    <div class="sidebar-heading">
        Data
    </div>


    <!-- =====================================================
         DATA MASTER
    ====================================================== -->

    <li class="nav-item <?= $is_master_page ? 'active' : '' ?>">

        <a class="nav-link <?= !$is_master_page ? 'collapsed' : '' ?>"
           href="#"
           data-toggle="collapse"
           data-target="#dataMaster"
           aria-expanded="<?= $is_master_page ? 'true' : 'false' ?>">

            <i class="fas fa-fw fa-cubes"></i>

            <span>Data Master</span>

        </a>


        <div id="dataMaster"
             class="collapse <?= $is_master_page ? 'show' : '' ?>">

            <div class="collapse-inner rounded">


                <h6 class="collapse-header">
                    Inventaris
                </h6>


                <!-- KATEGORI -->

                <a class="collapse-item <?= $segment1 === 'kategori' ? 'active' : '' ?>"
                   href="<?= base_url('kategori') ?>">

                    <i class="fas fa-tags"></i>

                    Kategori Barang

                </a>


                <!-- BARANG -->

                <a class="collapse-item <?= $segment1 === 'barang' ? 'active' : '' ?>"
                   href="<?= base_url('barang') ?>">

                    <i class="fas fa-box"></i>

                    Data Barang

                </a>


                <!-- BARANG RUANGAN -->

                <a class="collapse-item <?= $segment1 === 'barang_ruangan' ? 'active' : '' ?>"
                   href="<?= base_url('barang_ruangan') ?>">

                    <i class="fas fa-building"></i>

                    Barang Ruangan

                </a>


            </div>

        </div>

    </li>


    <!-- =====================================================
         DATA USER
    ====================================================== -->

    <li class="nav-item <?= $is_user_page ? 'active' : '' ?>">

        <a class="nav-link <?= !$is_user_page ? 'collapsed' : '' ?>"
           href="#"
           data-toggle="collapse"
           data-target="#dataUser"
           aria-expanded="<?= $is_user_page ? 'true' : 'false' ?>">

            <i class="fas fa-fw fa-users"></i>

            <span>Data User</span>

        </a>


        <div id="dataUser"
             class="collapse <?= $is_user_page ? 'show' : '' ?>">

            <div class="collapse-inner rounded">


                <h6 class="collapse-header">
                    Pengguna Sistem
                </h6>


                <!-- ADMIN -->

                <a class="collapse-item <?= $segment1 === 'admin' ? 'active' : '' ?>"
                   href="<?= base_url('admin') ?>">

                    <i class="fas fa-user-shield"></i>

                    Admin

                </a>


                <!-- GURU -->

                <a class="collapse-item <?= $segment1 === 'guru' ? 'active' : '' ?>"
                   href="<?= base_url('guru') ?>">

                    <i class="fas fa-chalkboard-teacher"></i>

                    Guru

                </a>


                <!-- SISWA -->

                <a class="collapse-item <?= $segment1 === 'siswa' ? 'active' : '' ?>"
                   href="<?= base_url('siswa') ?>">

                    <i class="fas fa-user-graduate"></i>

                    Siswa

                </a>


            </div>

        </div>

    </li>


    <!-- =====================================================
         ADMINISTRASI DOKUMEN
    ====================================================== -->

    <?php if ($is_admin || $is_operator): ?>

        <div class="sidebar-heading mt-2">
            Administrasi
        </div>


        <li class="nav-item <?= $is_upload_page ? 'active' : '' ?>">

            <a class="nav-link"
               href="<?= base_url('upload') ?>">

                <i class="fas fa-fw fa-cloud-upload-alt"></i>

                <span>Upload Berkas</span>

            </a>

        </li>

    <?php endif; ?>


    <hr class="sidebar-divider">


    <!-- =====================================================
         TRANSAKSI
    ====================================================== -->

    <div class="sidebar-heading">
        Transaksi
    </div>


    <!-- BARANG MASUK -->

    <li class="nav-item <?= $segment1 === 'barang_masuk' ? 'active' : '' ?>">

        <a class="nav-link"
           href="<?= base_url('barang_masuk') ?>">

            <i class="fas fa-fw fa-arrow-down"></i>

            <span>Barang Masuk</span>

        </a>

    </li>


    <!-- STOK -->

    <li class="nav-item <?= $segment1 === 'stock' ? 'active' : '' ?>">

        <a class="nav-link"
           href="<?= base_url('stock') ?>">

            <i class="fas fa-fw fa-boxes"></i>

            <span>Stok Barang</span>

        </a>

    </li>


    <!-- PERMOHONAN -->

    <li class="nav-item <?= $segment1 === 'permohonan' ? 'active' : '' ?>">

        <a class="nav-link"
           href="<?= base_url('permohonan') ?>">

            <i class="fas fa-fw fa-file-signature"></i>

            <span>Permohonan Barang</span>

        </a>

    </li>


    <!-- BARANG KELUAR -->

    <li class="nav-item <?= $segment1 === 'barang_keluar' ? 'active' : '' ?>">

        <a class="nav-link"
           href="<?= base_url('barang_keluar') ?>">

            <i class="fas fa-fw fa-arrow-up"></i>

            <span>Barang Keluar</span>

        </a>

    </li>


    <!-- PEMINJAMAN -->

    <li class="nav-item <?= $segment1 === 'peminjaman' ? 'active' : '' ?>">

        <a class="nav-link"
           href="<?= base_url('peminjaman') ?>">

            <i class="fas fa-fw fa-handshake"></i>

            <span>Peminjaman</span>

        </a>

    </li>


    <!-- BARANG RUSAK -->

    <li class="nav-item <?= $segment1 === 'barang_rusak' ? 'active' : '' ?>">

        <a class="nav-link"
           href="<?= base_url('barang_rusak') ?>">

            <i class="fas fa-fw fa-tools"></i>

            <span>Barang Rusak</span>

        </a>

    </li>


    <!-- BARANG RUSAK RUANGAN -->

    <li class="nav-item <?= $segment1 === 'barang_rusak_ruangan' ? 'active' : '' ?>">

        <a class="nav-link"
           href="<?= base_url('barang_rusak_ruangan') ?>">

            <i class="fas fa-fw fa-exclamation-triangle"></i>

            <span>Barang Rusak Ruangan</span>

        </a>

    </li>


    <hr class="sidebar-divider">


    <!-- =====================================================
         LAPORAN
    ====================================================== -->

    <div class="sidebar-heading">
        Laporan
    </div>


    <li class="nav-item <?= $is_laporan_page ? 'active' : '' ?>">

        <a class="nav-link <?= !$is_laporan_page ? 'collapsed' : '' ?>"
           href="#"
           data-toggle="collapse"
           data-target="#menuLaporan"
           aria-expanded="<?= $is_laporan_page ? 'true' : 'false' ?>">

            <i class="fas fa-fw fa-file-alt"></i>

            <span>Laporan</span>

        </a>


        <div id="menuLaporan"
             class="collapse <?= $is_laporan_page ? 'show' : '' ?>">

            <div class="collapse-inner rounded">


                <h6 class="collapse-header">
                    Laporan Inventaris
                </h6>


                <!-- BARANG MASUK -->

                <a class="collapse-item <?= $segment2 === 'masuk' ? 'active' : '' ?>"
                   href="<?= base_url('laporan/masuk') ?>">

                    <i class="fas fa-arrow-down"></i>

                    Barang Masuk

                </a>


                <!-- BARANG KELUAR -->

                <a class="collapse-item <?= $segment2 === 'keluar' ? 'active' : '' ?>"
                   href="<?= base_url('laporan/keluar') ?>">

                    <i class="fas fa-arrow-up"></i>

                    Barang Keluar

                </a>


                <!-- STOK -->

                <a class="collapse-item <?= $segment2 === 'stok' ? 'active' : '' ?>"
                   href="<?= base_url('laporan/stok') ?>">

                    <i class="fas fa-boxes"></i>

                    Sisa Stok

                </a>


                <!-- KARTU PERSEDIAAN -->

                <a class="collapse-item <?= $segment2 === 'buku_besar' ? 'active' : '' ?>"
                   href="<?= base_url('laporan/buku_besar') ?>">

                    <i class="fas fa-book"></i>

                    Kartu Persediaan

                </a>


                <!-- MUTASI -->

                <a class="collapse-item <?= $segment2 === 'mutasi' ? 'active' : '' ?>"
                   href="<?= base_url('laporan/mutasi') ?>">

                    <i class="fas fa-exchange-alt"></i>

                    Laporan Mutasi

                </a>


                <!-- REKAP KENDALI -->

                <a class="collapse-item <?= $segment2 === 'rekap_kendali' ? 'active' : '' ?>"
                   href="<?= base_url('laporan/rekap_kendali') ?>">

                    <i class="fas fa-clipboard-list"></i>

                    Rekap Kendali

                </a>


            </div>

        </div>

    </li>


    <hr class="sidebar-divider d-none d-md-block">


    <!-- =====================================================
         TOGGLE
    ====================================================== -->

    <div class="sidebar-toggle-wrapper text-center d-none d-md-block">

        <button class="sidebar-toggle-button rounded-circle border-0"
                id="sidebarToggle"
                type="button"
                title="Perkecil / Perbesar Sidebar">

            <i class="fas fa-angle-left"></i>

        </button>

    </div>


</ul>


<script>

$(document).ready(function () {

    /*
    |--------------------------------------------------------------------------
    | Ubah icon toggle saat sidebar mengecil
    |--------------------------------------------------------------------------
    */

    $('#sidebarToggle').on('click', function () {

        setTimeout(function () {

            var sidebar =
                $('#accordionSidebar');

            var icon =
                $('#sidebarToggle i');

            if (sidebar.hasClass('toggled')) {

                icon
                    .removeClass('fa-angle-left')
                    .addClass('fa-angle-right');

            } else {

                icon
                    .removeClass('fa-angle-right')
                    .addClass('fa-angle-left');

            }

        }, 100);

    });

});

</script>