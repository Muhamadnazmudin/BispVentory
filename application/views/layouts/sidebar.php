<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/*
|--------------------------------------------------------------------------
| URL SEGMENT
|--------------------------------------------------------------------------
*/

$segment1 = $this->uri->segment(1);
$segment2 = $this->uri->segment(2);


/*
|--------------------------------------------------------------------------
| ROLE
|--------------------------------------------------------------------------
*/

$role = strtolower(
    trim(
        (string) $this->session->userdata('role')
    )
);

$is_admin = ($role === 'admin');

$is_operator = ($role === 'operator');


/*
|--------------------------------------------------------------------------
| ACTIVE MENU
|--------------------------------------------------------------------------
*/

$is_master_page = in_array(
    $segment1,
    array(
        'kategori',
        'barang',
        'barang_ruangan'
    ),
    true
);


$is_user_page = in_array(
    $segment1,
    array(
        'admin',
        'user',
        'guru',
        'siswa'
    ),
    true
);


$is_spj_page = (
    $segment1 === 'spj'
);


$is_laporan_page = (
    $segment1 === 'laporan'
);


$is_upload_page = (
    $segment1 === 'upload'
);

?>


<!-- =========================================================
     SB ADMIN 2 SIDEBAR
========================================================= -->

<ul
    class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
    id="accordionSidebar"
>


    <!-- =====================================================
         BRAND
    ====================================================== -->

    <a
        class="sidebar-brand d-flex align-items-center justify-content-center"
        href="<?= base_url('dashboard') ?>"
    >

        <div class="sidebar-brand-icon">

            <img
                src="<?= base_url('assets/img/logobispar.png') ?>"
                alt="BispVentory"
                style="
                    width: 38px;
                    height: 38px;
                    object-fit: contain;
                "
            >

        </div>


        <div class="sidebar-brand-text mx-3">

            BispVentory

        </div>

    </a>


    <!-- =====================================================
         DIVIDER
    ====================================================== -->

    <hr class="sidebar-divider my-0">


    <!-- =====================================================
         DASHBOARD
    ====================================================== -->

    <li
        class="nav-item <?= $segment1 === 'dashboard' ? 'active' : '' ?>"
    >

        <a
            class="nav-link"
            href="<?= base_url('dashboard') ?>"
        >

            <i class="fas fa-fw fa-tachometer-alt"></i>

            <span>
                Dashboard
            </span>

        </a>

    </li>


    <!-- =====================================================
         DIVIDER
    ====================================================== -->

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

    <li
        class="nav-item <?= $is_master_page ? 'active' : '' ?>"
    >

        <a
            class="nav-link <?= $is_master_page ? '' : 'collapsed' ?>"
            href="#"
            data-toggle="collapse"
            data-target="#collapseDataMaster"
            aria-expanded="<?= $is_master_page ? 'true' : 'false' ?>"
            aria-controls="collapseDataMaster"
        >

            <i class="fas fa-fw fa-cubes"></i>

            <span>
                Data Master
            </span>

        </a>


        <div
            id="collapseDataMaster"
            class="collapse <?= $is_master_page ? 'show' : '' ?>"
            aria-labelledby="headingDataMaster"
            data-parent="#accordionSidebar"
        >

            <div class="bg-white py-2 collapse-inner rounded">

                <h6 class="collapse-header">
                    Inventaris
                </h6>


                <a
                    class="collapse-item <?= $segment1 === 'kategori' ? 'active' : '' ?>"
                    href="<?= base_url('kategori') ?>"
                >

                    Kategori Barang

                </a>


                <a
                    class="collapse-item <?= $segment1 === 'barang' ? 'active' : '' ?>"
                    href="<?= base_url('barang') ?>"
                >

                    Data Barang

                </a>


                <a
                    class="collapse-item <?= $segment1 === 'barang_ruangan' ? 'active' : '' ?>"
                    href="<?= base_url('barang_ruangan') ?>"
                >

                    Barang Ruangan

                </a>

            </div>

        </div>

    </li>


    <!-- =====================================================
         DATA USER
    ====================================================== -->

    <li
        class="nav-item <?= $is_user_page ? 'active' : '' ?>"
    >

        <a
            class="nav-link <?= $is_user_page ? '' : 'collapsed' ?>"
            href="#"
            data-toggle="collapse"
            data-target="#collapseDataUser"
            aria-expanded="<?= $is_user_page ? 'true' : 'false' ?>"
            aria-controls="collapseDataUser"
        >

            <i class="fas fa-fw fa-users"></i>

            <span>
                Data User
            </span>

        </a>


        <div
            id="collapseDataUser"
            class="collapse <?= $is_user_page ? 'show' : '' ?>"
            aria-labelledby="headingDataUser"
            data-parent="#accordionSidebar"
        >

            <div class="bg-white py-2 collapse-inner rounded">

                <h6 class="collapse-header">
                    Pengguna Sistem
                </h6>


                <a
                    class="collapse-item <?= $segment1 === 'admin' ? 'active' : '' ?>"
                    href="<?= base_url('admin') ?>"
                >

                    Admin

                </a>


                <a
                    class="collapse-item <?= $segment1 === 'guru' ? 'active' : '' ?>"
                    href="<?= base_url('guru') ?>"
                >

                    Guru

                </a>


                <a
                    class="collapse-item <?= $segment1 === 'siswa' ? 'active' : '' ?>"
                    href="<?= base_url('siswa') ?>"
                >

                    Siswa

                </a>

            </div>

        </div>

    </li>


    <?php if ($is_admin || $is_operator): ?>


        <!-- =================================================
             ADMINISTRASI
        ================================================== -->

        <div class="sidebar-heading">
            Administrasi
        </div>


        <li
            class="nav-item <?= $is_upload_page ? 'active' : '' ?>"
        >

            <a
                class="nav-link"
                href="<?= base_url('upload') ?>"
            >

                <i class="fas fa-fw fa-cloud-upload-alt"></i>

                <span>
                    Upload Berkas
                </span>

            </a>

        </li>


    <?php endif; ?>


    <!-- =====================================================
         DIVIDER
    ====================================================== -->

    <hr class="sidebar-divider">


    <!-- =====================================================
         SPJ
    ====================================================== -->

    <div class="sidebar-heading">
        SPJ
    </div>


    <li
        class="nav-item <?= $is_spj_page ? 'active' : '' ?>"
    >

        <a
            class="nav-link <?= $is_spj_page ? '' : 'collapsed' ?>"
            href="#"
            data-toggle="collapse"
            data-target="#collapseSPJ"
            aria-expanded="<?= $is_spj_page ? 'true' : 'false' ?>"
            aria-controls="collapseSPJ"
        >

            <i class="fas fa-fw fa-file-invoice"></i>

            <span>
                SPJ
            </span>

        </a>


        <div
            id="collapseSPJ"
            class="collapse <?= $is_spj_page ? 'show' : '' ?>"
            aria-labelledby="headingSPJ"
            data-parent="#accordionSidebar"
        >

            <div class="bg-white py-2 collapse-inner rounded">

                <h6 class="collapse-header">
                    SPJ
                </h6>


                <!-- INPUT KEBUTUHAN -->

                <a
                    class="collapse-item <?= $segment2 === 'input_kebutuhan' ? 'active' : '' ?>"
                    href="<?= base_url('spj/input_kebutuhan') ?>"
                >

                    Input Kebutuhan

                </a>


                <!-- BAST PEMERIKSAAN -->

                <a
                    class="collapse-item <?= $segment2 === 'bast_pemeriksaan' ? 'active' : '' ?>"
                    href="<?= base_url('spj/bast_pemeriksaan') ?>"
                >

                    BAST Pemeriksaan

                </a>


                <!-- BAST INTERNAL -->

                <a
                    class="collapse-item <?= $segment2 === 'bast_internal' ? 'active' : '' ?>"
                    href="<?= base_url('spj/bast_internal') ?>"
                >

                    BAST Internal

                </a>


                <!-- DOWNLOAD SPJ FULL -->

                <a
                    class="collapse-item <?= $segment2 === 'download_spj_full' ? 'active' : '' ?>"
                    href="<?= base_url('spj/download_spj_full') ?>"
                >

                    Download SPJ Full

                </a>

            </div>

        </div>

    </li>


    <!-- =====================================================
         DIVIDER
    ====================================================== -->

    <hr class="sidebar-divider">


    <!-- =====================================================
         LAPORAN
    ====================================================== -->

    <div class="sidebar-heading">
        Laporan
    </div>


    <li
        class="nav-item <?= $is_laporan_page ? 'active' : '' ?>"
    >

        <a
            class="nav-link <?= $is_laporan_page ? '' : 'collapsed' ?>"
            href="#"
            data-toggle="collapse"
            data-target="#collapseLaporan"
            aria-expanded="<?= $is_laporan_page ? 'true' : 'false' ?>"
            aria-controls="collapseLaporan"
        >

            <i class="fas fa-fw fa-file-alt"></i>

            <span>
                Laporan
            </span>

        </a>


        <div
            id="collapseLaporan"
            class="collapse <?= $is_laporan_page ? 'show' : '' ?>"
            aria-labelledby="headingLaporan"
            data-parent="#accordionSidebar"
        >

            <div class="bg-white py-2 collapse-inner rounded">

                <h6 class="collapse-header">
                    Laporan Inventaris
                </h6>


                <a
                    class="collapse-item <?= $segment2 === 'masuk' ? 'active' : '' ?>"
                    href="<?= base_url('laporan/masuk') ?>"
                >

                    Barang Masuk

                </a>


                <a
                    class="collapse-item <?= $segment2 === 'keluar' ? 'active' : '' ?>"
                    href="<?= base_url('laporan/keluar') ?>"
                >

                    Barang Keluar

                </a>


                <a
                    class="collapse-item <?= $segment2 === 'stok' ? 'active' : '' ?>"
                    href="<?= base_url('laporan/stok') ?>"
                >

                    Sisa Stok

                </a>


                <a
                    class="collapse-item <?= $segment2 === 'buku_besar' ? 'active' : '' ?>"
                    href="<?= base_url('laporan/buku_besar') ?>"
                >

                    Kartu Persediaan

                </a>


                <a
                    class="collapse-item <?= $segment2 === 'mutasi' ? 'active' : '' ?>"
                    href="<?= base_url('laporan/mutasi') ?>"
                >

                    Laporan Mutasi

                </a>


                <a
                    class="collapse-item <?= $segment2 === 'rekap_kendali' ? 'active' : '' ?>"
                    href="<?= base_url('laporan/rekap_kendali') ?>"
                >

                    Rekap Kendali

                </a>

            </div>

        </div>

    </li>


    <!-- =====================================================
         DIVIDER
    ====================================================== -->

    <hr class="sidebar-divider d-none d-md-block">


    <!-- =====================================================
         SIDEBAR TOGGLER
    ====================================================== -->

    <div class="text-center d-none d-md-inline">

        <button
            class="rounded-circle border-0"
            id="sidebarToggle"
        ></button>

    </div>


</ul>