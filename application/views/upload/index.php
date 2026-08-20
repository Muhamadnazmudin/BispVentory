<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/* =========================================================
   HELPER
========================================================= */

if (!function_exists('upload_view_icon')) {

    function upload_view_icon($ext)
    {
        $ext = strtolower(trim($ext));

        switch ($ext) {

            case 'pdf':
                return array('pdf', 'fa-file-pdf');

            case 'xls':
            case 'xlsx':
                return array('excel', 'fa-file-excel');

            case 'doc':
            case 'docx':
                return array('word', 'fa-file-word');

            case 'ppt':
            case 'pptx':
                return array('powerpoint', 'fa-file-powerpoint');

            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
            case 'webp':
                return array('image', 'fa-file-image');

            case 'zip':
            case 'rar':
                return array('archive', 'fa-file-archive');

            default:
                return array('default', 'fa-file');
        }
    }
}


if (!function_exists('upload_view_size')) {

    function upload_view_size($bytes)
    {
        $bytes = (int) $bytes;

        if ($bytes <= 0) {
            return '0 KB';
        }

        if ($bytes >= 1048576) {

            return number_format(
                $bytes / 1048576,
                2,
                ',',
                '.'
            ) . ' MB';
        }

        return number_format(
            $bytes / 1024,
            1,
            ',',
            '.'
        ) . ' KB';
    }
}


if (!function_exists('upload_view_can_preview')) {

    function upload_view_can_preview($ext)
    {
        return in_array(
            strtolower(trim($ext)),
            array(
                'pdf',
                'jpg',
                'jpeg',
                'png',
                'gif',
                'webp',
                'xls',
                'xlsx',
                'doc',
                'docx'
            ),
            true
        );
    }
}


/* =========================================================
   ROLE
========================================================= */

$role_id   = (int) $this->session->userdata('role_id');
$role      = strtolower(trim((string) $this->session->userdata('role')));
$role_name = strtolower(trim((string) $this->session->userdata('role_name')));

$isAdmin =
    $role_id === 1 ||
    $role === 'admin' ||
    $role === 'administrator' ||
    $role_name === 'admin' ||
    $role_name === 'administrator';


/* =========================================================
   FLASH MESSAGE
========================================================= */

$flash_success = $this->session->flashdata('success');
$flash_error   = $this->session->flashdata('error');


/* =========================================================
   STATISTIK
========================================================= */

$total_point = is_array($points)
    ? count($points)
    : 0;

$total_file = 0;
$total_bosp = 0;
$total_bopd = 0;


foreach ($points as $point) {

    $groups = array(
        'files_2025_bosp',
        'files_2025_bopd',
        'files_2026_bosp',
        'files_2026_bopd'
    );

    foreach ($groups as $group) {

        if (
            isset($point->{$group}) &&
            is_array($point->{$group})
        ) {

            $jumlah = count($point->{$group});

            $total_file += $jumlah;

            if (strpos($group, '_bosp') !== false) {
                $total_bosp += $jumlah;
            }

            if (strpos($group, '_bopd') !== false) {
                $total_bopd += $jumlah;
            }
        }
    }
}

?>


<style>

/* =========================================================
   PAGE
========================================================= */

.upload-page {
    padding-bottom: 70px;
}

.upload-heading {
    margin-bottom: 20px;
}

.upload-heading h1 {
    margin: 0;
    font-size: 1.35rem;
    font-weight: 800;
    color: #263238;
}

.upload-heading p {
    margin: 5px 0 0;
    color: #858796;
    font-size: .75rem;
}


/* =========================================================
   ALERT
========================================================= */

.upload-alert {
    display: flex;
    align-items: flex-start;
    gap: 12px;

    margin-bottom: 18px;
    padding: 13px 16px;

    border-radius: 12px;

    font-size: .75rem;
}

.upload-alert i {
    margin-top: 2px;
    font-size: 1rem;
}

.upload-alert.success {
    background: #eaf8f0;
    border: 1px solid #bce3cc;
    color: #146c43;
}

.upload-alert.error {
    background: #fff0f0;
    border: 1px solid #f3c2c2;
    color: #b42318;
}

.upload-alert strong {
    display: block;
    margin-bottom: 2px;
}


/* =========================================================
   STATISTIC
========================================================= */

.upload-stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 20px;
}

.upload-stat {
    display: flex;
    align-items: center;

    padding: 16px;

    background: #fff;
    border: 1px solid #edf0f5;
    border-radius: 15px;

    box-shadow: 0 4px 18px rgba(0,0,0,.04);
}

.upload-stat-icon {
    width: 43px;
    height: 43px;

    flex: 0 0 43px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-right: 12px;

    border-radius: 12px;

    background: #eef2ff;
    color: #4e73df;
}

.upload-stat-value {
    color: #263238;
    font-size: 1.1rem;
    font-weight: 800;
    line-height: 1.1;
}

.upload-stat-label {
    margin-top: 4px;
    color: #8a93a2;
    font-size: .62rem;
    font-weight: 700;
}


/* =========================================================
   TOOLBAR
========================================================= */

.upload-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;

    padding: 14px;
    margin-bottom: 20px;

    background: #fff;
    border: 1px solid #edf0f5;
    border-radius: 14px;

    box-shadow: 0 4px 18px rgba(0,0,0,.04);
}

.upload-search {
    position: relative;
    flex: 1;
    max-width: 520px;
}

.upload-search i {
    position: absolute;

    left: 14px;
    top: 50%;

    transform: translateY(-50%);

    color: #9aa3b2;
}

.upload-search input {
    width: 100%;
    height: 40px;

    padding: 0 15px 0 38px;

    border: 1px solid #e1e5ec;
    border-radius: 9px;

    background: #f9fafc;

    font-size: .76rem;
    outline: none;
}

.upload-search input:focus {
    background: #fff;
    border-color: #4e73df;
    box-shadow: 0 0 0 3px rgba(78,115,223,.1);
}

.upload-toolbar-right {
    display: flex;
    align-items: center;
    gap: 8px;
}

.upload-toolbar-right select {
    height: 40px;
    min-width: 100px;

    border: 1px solid #e1e5ec;
    border-radius: 9px;

    font-size: .75rem;
}

.btn-add-point {
    height: 40px;

    display: inline-flex;
    align-items: center;

    padding: 0 14px;

    border: 0;
    border-radius: 9px;

    background: #4e73df;
    color: #fff;

    font-size: .72rem;
    font-weight: 700;

    text-decoration: none;
}

.btn-add-point:hover {
    background: #3d5fc4;
    color: #fff;
    text-decoration: none;
}


/* =========================================================
   POINT CARD
========================================================= */

.point-card {
    overflow: hidden;

    margin-bottom: 18px;

    background: #fff;

    border: 1px solid #edf0f5;
    border-radius: 18px;

    box-shadow: 0 4px 20px rgba(0,0,0,.045);
}

.point-header {
    display: flex;
    align-items: center;

    gap: 15px;

    min-height: 105px;

    padding: 20px 24px;

    background: #fff;
}

.point-number {
    width: 56px;
    height: 56px;

    flex: 0 0 56px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 16px;

    background: #eef2ff;
    color: #4e73df;

    font-size: .95rem;
    font-weight: 800;
}

.point-info {
    flex: 1;
    min-width: 0;
}

.point-title {
    margin: 0;

    color: #202936;

    font-size: .94rem;
    font-weight: 800;
    line-height: 1.5;
}

.point-description {
    margin-top: 5px;

    color: #8a93a2;

    font-size: .68rem;
    line-height: 1.5;
}

.point-actions {
    display: flex;
    align-items: center;
    gap: 6px;
}

.point-btn {
    width: 37px;
    height: 37px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 1px solid #e0e5ed;
    border-radius: 10px;

    background: #fff;
    color: #6f7785;

    font-size: .73rem;

    cursor: pointer;
    text-decoration: none;
}

.point-btn:hover {
    background: #eef2ff;
    border-color: #cbd5ff;
    color: #4e73df;
    text-decoration: none;
}

.point-btn.danger:hover {
    background: #fff0f0;
    border-color: #f5c2c0;
    color: #e74a3b;
}

.point-toggle i {
    transition: transform .2s ease;
}

.point-card.collapsed .point-toggle i {
    transform: rotate(-90deg);
}

.point-body {
    padding: 0 24px 24px;
    border-top: 1px solid #f0f2f6;
}

.point-card.collapsed .point-body {
    display: none;
}


/* =========================================================
   YEAR
========================================================= */

.year-section {
    padding-top: 20px;
}

.year-section + .year-section {
    margin-top: 8px;
    border-top: 1px dashed #e4e7ed;
}

.year-header {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
}

.year-icon {
    width: 35px;
    height: 35px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-right: 9px;

    border-radius: 10px;

    background: #eef2ff;
    color: #4e73df;
}

.year-title {
    color: #343a40;
    font-size: .82rem;
    font-weight: 800;
}


/* =========================================================
   FUND
========================================================= */

.fund-grid {
    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 13px;
}

.fund-card {
    overflow: hidden;

    border: 1px solid #e1e6ef;
    border-radius: 13px;

    background: #fafbfe;
}

.fund-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 10px;

    padding: 12px 13px;

    background: #f7f9fc;
    border-bottom: 1px solid #e5e8ee;
}

.fund-name {
    display: flex;
    align-items: center;
    gap: 8px;

    color: #263238;

    font-size: .75rem;
    font-weight: 800;
}

.fund-badge {
    padding: 4px 9px;

    border-radius: 20px;

    background: #eaf0ff;
    color: #4e73df;

    font-size: .6rem;
    font-weight: 800;
}

.fund-badge.bopd {
    background: #e8f7ef;
    color: #198754;
}

.btn-upload {
    display: inline-flex;
    align-items: center;
    gap: 5px;

    padding: 7px 11px;

    border: 0;
    border-radius: 8px;

    background: #4e73df;
    color: #fff;

    font-size: .62rem;
    font-weight: 700;

    cursor: pointer;
}

.btn-upload:hover {
    background: #3d5fc4;
    color: #fff;
}

.btn-upload.bopd {
    background: #198754;
}

.btn-upload.bopd:hover {
    background: #157347;
}


/* =========================================================
   FILE
========================================================= */

.file-list {
    padding: 12px;
}

.file-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;

    padding: 10px;

    background: #fff;
    border: 1px solid #e1e5ec;
    border-radius: 10px;
}

.file-item + .file-item {
    margin-top: 8px;
}

.file-icon {
    width: 40px;
    height: 40px;

    flex: 0 0 40px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;
}

.file-icon.pdf {
    background: #fff0f0;
    color: #dc3545;
}

.file-icon.excel {
    background: #eaf8f0;
    color: #198754;
}

.file-icon.word {
    background: #edf4ff;
    color: #0d6efd;
}

.file-icon.powerpoint {
    background: #fff2eb;
    color: #e85d04;
}

.file-icon.image {
    background: #fff8e7;
    color: #d89b00;
}

.file-icon.archive {
    background: #f1efff;
    color: #6f42c1;
}

.file-icon.default {
    background: #f1f3f5;
    color: #6c757d;
}

.file-info {
    flex: 1;
    min-width: 0;
}

.file-name {
    overflow: hidden;

    text-overflow: ellipsis;
    white-space: nowrap;

    color: #263238;

    font-size: .72rem;
    font-weight: 800;
}

.file-meta {
    display: flex;
    flex-wrap: wrap;
    align-items: center;

    gap: 5px;

    margin-top: 3px;

    color: #9aa3b2;

    font-size: .6rem;
}

.file-description {
    display: flex;
    align-items: flex-start;
    gap: 6px;

    margin-top: 8px;
    padding: 7px 9px;

    border-radius: 8px;

    background: #f5f8ff;

    color: #667085;

    font-size: .63rem;
    line-height: 1.5;
}

.file-description i {
    margin-top: 2px;
    color: #4e73df;
}

.file-actions {
    display: flex;
    gap: 4px;
}

.file-action {
    width: 31px;
    height: 31px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 8px;

    background: #fff;

    font-size: .7rem;
    text-decoration: none;
}

.file-action.view {
    border: 1px solid #36b9cc;
    color: #36b9cc;
}

.file-action.view:hover {
    background: #36b9cc;
    color: #fff;
}

.file-action.download {
    border: 1px solid #4e73df;
    color: #4e73df;
}

.file-action.download:hover {
    background: #4e73df;
    color: #fff;
}

.file-action.delete {
    border: 1px solid #e74a3b;
    color: #e74a3b;
}

.file-action.delete:hover {
    background: #e74a3b;
    color: #fff;
}


/* =========================================================
   EMPTY
========================================================= */

.empty-file {
    padding: 22px 10px;

    text-align: center;

    color: #a0a7b4;

    font-size: .64rem;
}

.empty-file i {
    display: block;

    margin-bottom: 6px;

    color: #c8ced9;

    font-size: 1.25rem;
}


/* =========================================================
   MODAL
========================================================= */

.upload-modal .modal-content {
    overflow: hidden;

    border: 0;
    border-radius: 16px;
}

.upload-modal .modal-header {
    padding: 16px 20px;
    border-bottom: 1px solid #edf0f5;
}

.upload-modal .modal-title {
    color: #263238;
    font-size: .9rem;
    font-weight: 800;
}

.upload-modal .modal-body {
    padding: 20px;
}

.upload-modal label {
    color: #5a5c69;
    font-size: .7rem;
    font-weight: 700;
}

.upload-modal .form-control {
    border-radius: 9px;
    font-size: .75rem;
}

.upload-context {
    display: flex;
    align-items: center;
    gap: 8px;

    margin-bottom: 16px;
    padding: 11px 12px;

    border-radius: 10px;

    background: #f5f8ff;
    border: 1px solid #dfe7ff;
}

.upload-context-badge {
    padding: 5px 9px;

    border-radius: 20px;

    background: #4e73df;

    color: #fff;

    font-size: .6rem;
    font-weight: 800;
}

.upload-context-badge.bopd {
    background: #198754;
}

.upload-context-text {
    color: #344054;
    font-size: .68rem;
    font-weight: 700;
}

.upload-help {
    margin-top: 5px;

    color: #9299a7;

    font-size: .61rem;
    line-height: 1.5;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1100px) {

    .upload-stat-grid {
        grid-template-columns: repeat(2, 1fr);
    }

}

@media (max-width: 767px) {

    .upload-toolbar {
        display: block;
    }

    .upload-search {
        max-width: none;
        margin-bottom: 10px;
    }

    .upload-toolbar-right {
        justify-content: flex-end;
    }

    .fund-grid {
        grid-template-columns: 1fr;
    }

    .point-header {
        padding: 17px;
    }

    .point-body {
        padding: 0 17px 18px;
    }

}

@media (max-width: 576px) {

    .upload-stat-grid {
        grid-template-columns: 1fr;
    }

    .point-header {
        gap: 9px;
    }

    .point-number {
        width: 44px;
        height: 44px;
        flex-basis: 44px;
    }

    .point-title {
        font-size: .78rem;
    }

    .point-actions {
        gap: 3px;
    }

    .point-btn {
        width: 31px;
        height: 31px;
    }

    .file-item {
        flex-wrap: wrap;
    }

    .file-actions {
        margin-left: 50px;
    }

}

</style>


<div class="container-fluid upload-page">


    <!-- =====================================================
         HEADER
    ====================================================== -->

    <div class="upload-heading">

        <h1>
            <i class="fas fa-folder-open text-primary mr-2"></i>
            <?= html_escape($title) ?>
        </h1>

        <p>
            Kelola dokumen Inspektorat berdasarkan point,
            tahun, dan sumber dana BOSP/BOPD.
        </p>

    </div>


    <!-- =====================================================
         FLASH SUCCESS
    ====================================================== -->

    <?php if (!empty($flash_success)): ?>

        <div class="upload-alert success">

            <i class="fas fa-check-circle"></i>

            <div>

                <strong>Berhasil</strong>

                <?= html_escape($flash_success) ?>

            </div>

        </div>

    <?php endif; ?>


    <!-- =====================================================
         FLASH ERROR
    ====================================================== -->

    <?php if (!empty($flash_error)): ?>

        <div class="upload-alert error">

            <i class="fas fa-exclamation-triangle"></i>

            <div>

                <strong>Upload Gagal</strong>

                <?= html_escape($flash_error) ?>

            </div>

        </div>

    <?php endif; ?>


    <!-- =====================================================
         STATISTIK
    ====================================================== -->

    <div class="upload-stat-grid">

        <div class="upload-stat">

            <div class="upload-stat-icon">
                <i class="fas fa-list-ol"></i>
            </div>

            <div>

                <div class="upload-stat-value">
                    <?= number_format($total_point) ?>
                </div>

                <div class="upload-stat-label">
                    TOTAL POINT
                </div>

            </div>

        </div>


        <div class="upload-stat">

            <div class="upload-stat-icon">
                <i class="fas fa-file-alt"></i>
            </div>

            <div>

                <div class="upload-stat-value">
                    <?= number_format($total_file) ?>
                </div>

                <div class="upload-stat-label">
                    TOTAL BERKAS
                </div>

            </div>

        </div>


        <div class="upload-stat">

            <div class="upload-stat-icon">
                <i class="fas fa-wallet"></i>
            </div>

            <div>

                <div class="upload-stat-value">
                    <?= number_format($total_bosp) ?>
                </div>

                <div class="upload-stat-label">
                    BERKAS BOSP
                </div>

            </div>

        </div>


        <div class="upload-stat">

            <div class="upload-stat-icon">
                <i class="fas fa-landmark"></i>
            </div>

            <div>

                <div class="upload-stat-value">
                    <?= number_format($total_bopd) ?>
                </div>

                <div class="upload-stat-label">
                    BERKAS BOPD
                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         TOOLBAR
    ====================================================== -->

    <div class="upload-toolbar">

        <form
            method="get"
            action="<?= site_url('upload') ?>"
            class="upload-search"
        >

            <i class="fas fa-search"></i>

            <input
                type="text"
                name="q"
                value="<?= html_escape($keyword) ?>"
                placeholder="Cari point dokumen..."
                autocomplete="off"
            >

        </form>


        <div class="upload-toolbar-right">

            <span
                class="text-muted"
                style="font-size:.7rem;"
            >
                Tahun
            </span>


            <form
                method="get"
                action="<?= site_url('upload') ?>"
            >

                <input
                    type="hidden"
                    name="q"
                    value="<?= html_escape($keyword) ?>"
                >

                <select
                    name="tahun"
                    class="form-control"
                    onchange="this.form.submit()"
                >

                    <option
                        value="2025"
                        <?= ((int)$tahun === 2025)
                            ? 'selected'
                            : '' ?>
                    >
                        2025
                    </option>

                    <option
                        value="2026"
                        <?= ((int)$tahun === 2026)
                            ? 'selected'
                            : '' ?>
                    >
                        2026
                    </option>

                </select>

            </form>


          <?php if ($isAdmin): ?>

    <a
        href="<?= site_url('upload/download_all') ?>"
        class="btn-add-point"
        style="background:#198754;"
        onclick="
            return confirm(
                'Download seluruh berkas Inspektorat dalam satu ZIP?'
            );
        "
    >
        <i class="fas fa-file-archive mr-1"></i>
        Download Semua
    </a>


    <a
        href="<?= site_url('upload/tambah_point') ?>"
        class="btn-add-point"
    >
        <i class="fas fa-plus mr-1"></i>
        Tambah Point
    </a>

<?php endif; ?>

        </div>

    </div>


    <!-- =====================================================
         POINT LIST
    ====================================================== -->

    <?php if (!empty($points)): ?>


        <?php foreach ($points as $point): ?>

            <?php

            $point_id = (int) $point->id;

            $files = array(

                2025 => array(

                    'BOSP' =>
                        isset($point->files_2025_bosp)
                            ? $point->files_2025_bosp
                            : array(),

                    'BOPD' =>
                        isset($point->files_2025_bopd)
                            ? $point->files_2025_bopd
                            : array()

                ),

                2026 => array(

                    'BOSP' =>
                        isset($point->files_2026_bosp)
                            ? $point->files_2026_bosp
                            : array(),

                    'BOPD' =>
                        isset($point->files_2026_bopd)
                            ? $point->files_2026_bopd
                            : array()

                )

            );

            ?>


            <!-- =================================================
                 POINT CARD
            ================================================== -->

           <div
    class="point-card collapsed"
    id="point-<?= $point_id ?>"
    data-point="<?= $point_id ?>"
>


                <div class="point-header">

                    <div class="point-number">

                        <?= str_pad(
                            (int)$point->nomor,
                            2,
                            '0',
                            STR_PAD_LEFT
                        ) ?>

                    </div>


                    <div class="point-info">

                        <h2 class="point-title">

                            <?= html_escape(
                                $point->nama_point
                            ) ?>

                        </h2>


                        <?php if (
                            isset($point->keterangan) &&
                            trim($point->keterangan) !== ''
                        ): ?>

                            <div class="point-description">

                                <?= nl2br(
                                    html_escape(
                                        $point->keterangan
                                    )
                                ) ?>

                            </div>

                        <?php endif; ?>

                    </div>


                    <div class="point-actions">


                        <button
                            type="button"
                            class="point-btn point-toggle"
                            title="Perkecil / Perbesar"
                            aria-expanded="true"
                        >

                            <i class="fas fa-chevron-down"></i>

                        </button>


                        <?php if ($isAdmin): ?>

                            <a
                                href="<?= site_url(
                                    'upload/edit_point/' . $point_id
                                ) ?>"
                                class="point-btn"
                                title="Edit Point"
                            >

                                <i class="fas fa-edit"></i>

                            </a>


                            <a
                                href="<?= site_url(
                                    'upload/delete_point/' . $point_id
                                ) ?>"
                                class="point-btn danger"
                                title="Hapus Point"
                                onclick="
                                    return confirm(
                                        'Hapus point beserta seluruh berkas di dalamnya?'
                                    );
                                "
                            >

                                <i class="fas fa-trash"></i>

                            </a>

                        <?php endif; ?>

                    </div>

                </div>


                <div class="point-body">


                    <?php foreach ($files as $year => $funds): ?>


                        <div class="year-section">


                            <div class="year-header">

                                <div class="year-icon">

                                    <i class="fas fa-calendar-alt"></i>

                                </div>

                                <div class="year-title">
                                    Tahun <?= $year ?>
                                </div>

                            </div>


                            <div class="fund-grid">


                                <?php foreach ($funds as $fund => $file_list): ?>

                                    <?php

                                    $isBopd =
                                        ($fund === 'BOPD');

                                    $badge_class =
                                        $isBopd
                                            ? 'bopd'
                                            : '';

                                    ?>


                                    <div class="fund-card">


                                        <div class="fund-header">


                                            <div class="fund-name">

                                                <span
                                                    class="fund-badge <?= $badge_class ?>"
                                                >
                                                    <?= $fund ?>
                                                </span>

                                                <span>
                                                    <?= $year ?>
                                                </span>

                                            </div>


                                            <!--
                                                PENTING:
                                                sumber dana langsung disimpan
                                                di data attribute.
                                            -->

                                            <button
                                                type="button"
                                                class="btn-upload <?= $badge_class ?>"
                                                data-toggle="modal"
                                                data-target="#uploadModal<?= $point_id ?>"
                                                data-point="<?= $point_id ?>"
                                                data-point-name="<?= html_escape(
                                                    $point->nomor .
                                                    '. ' .
                                                    $point->nama_point
                                                ) ?>"
                                                data-tahun="<?= $year ?>"
                                                data-sumber-dana="<?= $fund ?>"
                                            >

                                                <i class="fas fa-cloud-upload-alt"></i>

                                                Upload

                                            </button>

                                        </div>


                                        <div class="file-list">


                                            <?php if (!empty($file_list)): ?>


                                                <?php foreach ($file_list as $file): ?>

                                                    <?php

                                                    $ext =
                                                        strtolower(
                                                            trim(
                                                                $file->ekstensi
                                                            )
                                                        );

                                                    $icon =
                                                        upload_view_icon(
                                                            $ext
                                                        );

                                                    $can_preview =
                                                        upload_view_can_preview(
                                                            $ext
                                                        );

                                                    $size =
                                                        upload_view_size(
                                                            isset(
                                                                $file->ukuran_file
                                                            )
                                                                ? $file->ukuran_file
                                                                : 0
                                                        );

                                                    ?>


                                                    <div class="file-item">


                                                        <div
                                                            class="file-icon <?= $icon[0] ?>"
                                                        >

                                                            <i
                                                                class="fas <?= $icon[1] ?>"
                                                            ></i>

                                                        </div>


                                                        <div class="file-info">


                                                            <div
                                                                class="file-name"
                                                                title="<?= html_escape(
                                                                    $file->nama_file_asli
                                                                ) ?>"
                                                            >

                                                                <?= html_escape(
                                                                    $file->nama_file_asli
                                                                ) ?>

                                                            </div>


                                                            <div class="file-meta">

                                                                <span>
                                                                    <?= $size ?>
                                                                </span>

                                                                <span>•</span>

                                                                <span>

                                                                    <?= date(
                                                                        'd/m/Y H:i',
                                                                        strtotime(
                                                                            $file->uploaded_at
                                                                        )
                                                                    ) ?>

                                                                </span>

                                                            </div>


                                                            <?php if (
                                                                isset($file->keterangan) &&
                                                                trim($file->keterangan) !== ''
                                                            ): ?>

                                                                <div class="file-description">

                                                                    <i class="fas fa-info-circle"></i>

                                                                    <span>

                                                                        <?= nl2br(
                                                                            html_escape(
                                                                                $file->keterangan
                                                                            )
                                                                        ) ?>

                                                                    </span>

                                                                </div>

                                                            <?php endif; ?>


                                                        </div>


                                                        <div class="file-actions">


                                                            <?php if ($can_preview): ?>

                                                                <a
                                                                    href="<?= site_url(
                                                                        'upload/preview/' .
                                                                        (int)$file->id
                                                                    ) ?>"
                                                                    target="_blank"
                                                                    class="file-action view"
                                                                    title="Lihat"
                                                                >

                                                                    <i class="fas fa-eye"></i>

                                                                </a>

                                                            <?php endif; ?>


                                                            <a
                                                                href="<?= site_url(
                                                                    'upload/download/' .
                                                                    (int)$file->id
                                                                ) ?>"
                                                                class="file-action download"
                                                                title="Download"
                                                            >

                                                                <i class="fas fa-download"></i>

                                                            </a>


                                                            <a
                                                                href="<?= site_url(
                                                                    'upload/delete_file/' .
                                                                    (int)$file->id
                                                                ) ?>"
                                                                class="file-action delete"
                                                                title="Hapus"
                                                                onclick="
                                                                    return confirm(
                                                                        'Yakin ingin menghapus berkas ini?'
                                                                    );
                                                                "
                                                            >

                                                                <i class="fas fa-trash"></i>

                                                            </a>


                                                        </div>


                                                    </div>


                                                <?php endforeach; ?>


                                            <?php else: ?>


                                                <div class="empty-file">

                                                    <i class="fas fa-folder-open"></i>

                                                    Belum ada berkas <?= $fund ?>.

                                                </div>

                                            <?php endif; ?>


                                        </div>


                                    </div>


                                <?php endforeach; ?>


                            </div>


                        </div>


                    <?php endforeach; ?>


                </div>


            </div>


            <!-- =================================================
                 MODAL
            ================================================== -->

            <div
                class="modal fade upload-modal"
                id="uploadModal<?= $point_id ?>"
                tabindex="-1"
                role="dialog"
                aria-hidden="true"
            >

                <div
                    class="modal-dialog modal-dialog-centered"
                    role="document"
                >

                    <div class="modal-content">


                        <div class="modal-header">

                            <h5 class="modal-title">

                                <i class="fas fa-cloud-upload-alt text-primary mr-2"></i>

                                Upload Berkas

                            </h5>

                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                            >
                                <span>&times;</span>
                            </button>

                        </div>


                        <form
                            method="post"
                            action="<?= site_url(
                                'upload/upload_file/' .
                                $point_id
                            ) ?>"
                            enctype="multipart/form-data"
                        >


                            <div class="modal-body">


                                <!-- KONTEKS UPLOAD -->

                                <div class="upload-context">

                                    <span
                                        class="upload-context-badge"
                                        id="upload_badge_<?= $point_id ?>"
                                    >
                                        -
                                    </span>

                                    <span
                                        class="upload-context-text"
                                        id="upload_context_<?= $point_id ?>"
                                    >
                                        Pilih sumber dana
                                    </span>

                                </div>


                                <div class="form-group">

                                    <label>
                                        Point
                                    </label>

                                    <input
                                        type="text"
                                        id="upload_point_<?= $point_id ?>"
                                        class="form-control"
                                        readonly
                                    >

                                </div>


                                <div class="row">


                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Tahun
                                            </label>

                                            <input
                                                type="text"
                                                id="upload_tahun_<?= $point_id ?>"
                                                class="form-control"
                                                readonly
                                            >

                                            <input
                                                type="hidden"
                                                name="tahun"
                                                id="upload_tahun_hidden_<?= $point_id ?>"
                                            >

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Sumber Dana
                                            </label>

                                            <input
                                                type="text"
                                                id="upload_sumber_<?= $point_id ?>"
                                                class="form-control"
                                                readonly
                                            >

                                            <input
                                                type="hidden"
                                                name="sumber_dana"
                                                id="upload_sumber_hidden_<?= $point_id ?>"
                                            >

                                        </div>

                                    </div>


                                </div>


                                <div class="form-group">

                                    <label>
                                        Berkas
                                    </label>

                                    <input
                                        type="file"
                                        name="berkas"
                                        class="form-control"
                                        required
                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.webp,.zip,.rar"
                                    >

                                    <div class="upload-help">

                                        PDF, Word, Excel, PowerPoint,
                                        gambar, ZIP/RAR.
                                        Maksimal 200 MB.

                                    </div>

                                </div>


                                <div class="form-group">

                                    <label>
                                        Keterangan
                                    </label>

                                    <textarea
                                        name="keterangan"
                                        class="form-control"
                                        rows="4"
                                        placeholder="Contoh: BKU Semester II 2025, dokumen asli, hasil scan, dan sebagainya."
                                    ></textarea>

                                </div>


                            </div>


                            <div class="modal-footer">

                                <button
                                    type="button"
                                    class="btn btn-light btn-sm"
                                    data-dismiss="modal"
                                >
                                    Batal
                                </button>


                                <button
                                    type="submit"
                                    class="btn btn-primary btn-sm"
                                >

                                    <i class="fas fa-upload mr-1"></i>

                                    Upload Berkas

                                </button>

                            </div>


                        </form>


                    </div>

                </div>

            </div>


        <?php endforeach; ?>


    <?php else: ?>


        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>

                <h5 class="text-gray-700">
                    Belum ada point dokumen.
                </h5>


                <?php if ($isAdmin): ?>

                    <a
                        href="<?= site_url('upload/tambah_point') ?>"
                        class="btn btn-primary btn-sm mt-2"
                    >

                        <i class="fas fa-plus mr-1"></i>

                        Tambah Point

                    </a>

                <?php endif; ?>

            </div>

        </div>

    <?php endif; ?>


</div>


<script>

document.addEventListener('DOMContentLoaded', function () {


    /* =====================================================
   TOGGLE POINT
===================================================== */

document.querySelectorAll('.point-toggle').forEach(function (button) {

    button.addEventListener('click', function (event) {

        event.preventDefault();
        event.stopPropagation();

        var card = button.closest('.point-card');

        if (!card) {
            return;
        }

        var collapsed =
            card.classList.toggle('collapsed');

        button.setAttribute(
            'aria-expanded',
            collapsed ? 'false' : 'true'
        );

    });

});

/* =====================================================
   BUKA POINT TERAKHIR SETELAH REDIRECT
===================================================== */

var hash = window.location.hash;

if (hash && hash.indexOf('#point-') === 0) {

    var activePoint = document.querySelector(hash);

    if (activePoint) {

        /*
         * Buka point
         */
        activePoint.classList.remove('collapsed');


        /*
         * Update tombol panah
         */
        var toggleButton =
            activePoint.querySelector('.point-toggle');

        if (toggleButton) {

            toggleButton.setAttribute(
                'aria-expanded',
                'true'
            );

        }


        /*
         * Scroll perlahan ke point tersebut
         */
        setTimeout(function () {

            activePoint.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        }, 150);

    }

}


    /* =====================================================
       UPLOAD BUTTON
       
       PENTING:
       data-sumber-dana dibaca dengan:
       getAttribute('data-sumber-dana')
    ===================================================== */

    document.querySelectorAll('.btn-upload').forEach(function (button) {

        button.addEventListener('click', function () {


            var pointId =
                button.getAttribute('data-point');


            var pointName =
                button.getAttribute('data-point-name');


            var tahun =
                button.getAttribute('data-tahun');


            var sumberDana =
                button.getAttribute('data-sumber-dana');


            /*
             * Normalisasi
             */

            tahun =
                tahun
                    ? tahun.trim()
                    : '';


            sumberDana =
                sumberDana
                    ? sumberDana.trim().toUpperCase()
                    : '';


            console.log(
                '[UPLOAD]',
                {
                    point: pointId,
                    tahun: tahun,
                    sumber_dana: sumberDana
                }
            );


            /* =================================================
               ELEMENT
            ================================================= */

            var pointInput =
                document.getElementById(
                    'upload_point_' + pointId
                );


            var tahunInput =
                document.getElementById(
                    'upload_tahun_' + pointId
                );


            var tahunHidden =
                document.getElementById(
                    'upload_tahun_hidden_' + pointId
                );


            var sumberInput =
                document.getElementById(
                    'upload_sumber_' + pointId
                );


            var sumberHidden =
                document.getElementById(
                    'upload_sumber_hidden_' + pointId
                );


            var badge =
                document.getElementById(
                    'upload_badge_' + pointId
                );


            var context =
                document.getElementById(
                    'upload_context_' + pointId
                );


            /* =================================================
               VALIDASI CLIENT
            ================================================= */

            if (
                tahun !== '2025' &&
                tahun !== '2026'
            ) {

                alert(
                    'Tahun upload tidak valid.'
                );

                return;
            }


            if (
                sumberDana !== 'BOSP' &&
                sumberDana !== 'BOPD'
            ) {

                alert(
                    'Sumber dana tidak valid: ' +
                    sumberDana
                );

                console.error(
                    'Sumber dana tidak valid',
                    sumberDana
                );

                return;
            }


            /* =================================================
               SET VALUE
            ================================================= */

            if (pointInput) {
                pointInput.value =
                    pointName || '';
            }


            if (tahunInput) {
                tahunInput.value =
                    tahun;
            }


            if (tahunHidden) {
                tahunHidden.value =
                    tahun;
            }


            if (sumberInput) {
                sumberInput.value =
                    sumberDana;
            }


            if (sumberHidden) {
                sumberHidden.value =
                    sumberDana;
            }


            /* =================================================
               CONTEXT
            ================================================= */

            if (badge) {

                badge.textContent =
                    sumberDana;

                badge.classList.toggle(
                    'bopd',
                    sumberDana === 'BOPD'
                );
            }


            if (context) {

                context.textContent =
                    'Upload dokumen ' +
                    sumberDana +
                    ' Tahun ' +
                    tahun;
            }


            /*
             * DEBUG
             */

            console.log(
                '[UPLOAD FORM SET]',
                {
                    tahun:
                        tahunHidden
                            ? tahunHidden.value
                            : null,

                    sumber_dana:
                        sumberHidden
                            ? sumberHidden.value
                            : null
                }
            );

        });

    });


    /* =====================================================
       FORM SUBMIT DEBUG
    ===================================================== */

    document.querySelectorAll(
        '.upload-modal form'
    ).forEach(function (form) {

        form.addEventListener(
            'submit',
            function () {

                var tahun =
                    form.querySelector(
                        'input[name="tahun"]'
                    );

                var sumber =
                    form.querySelector(
                        'input[name="sumber_dana"]'
                    );


                console.log(
                    '[SUBMIT UPLOAD]',
                    {
                        tahun:
                            tahun
                                ? tahun.value
                                : null,

                        sumber_dana:
                            sumber
                                ? sumber.value
                                : null
                    }
                );


                /*
                 * Jangan izinkan submit kalau
                 * sumber dana kosong.
                 */

                if (
                    !sumber ||
                    (
                        sumber.value !== 'BOSP' &&
                        sumber.value !== 'BOPD'
                    )
                ) {

                    alert(
                        'Sumber dana belum valid. ' +
                        'Silakan tutup modal dan klik tombol BOSP/BOPD lagi.'
                    );

                    return false;
                }

            }
        );

    });


    /* =====================================================
       RESET MODAL
    ===================================================== */

    document.querySelectorAll(
        '.upload-modal'
    ).forEach(function (modal) {

        /*
         * Bootstrap event tetap dipakai
         * kalau Bootstrap tersedia.
         */

        if (
            typeof window.jQuery !== 'undefined'
        ) {

            window.jQuery(modal).on(
                'hidden.bs.modal',
                function () {

                    var form =
                        modal.querySelector('form');

                    if (form) {
                        form.reset();
                    }

                }
            );

        }

    });

});

</script>