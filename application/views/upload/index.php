<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>

/* =========================================================
   UPLOAD PAGE
========================================================= */

.upload-page {
    padding-bottom: 50px;
}


/* =========================================================
   HEADER
========================================================= */

.upload-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 20px;

    margin-bottom: 25px;
}

.upload-title-wrap {
    min-width: 0;
}

.upload-title {
    margin: 0;

    color: #343a40;

    font-size: 1.35rem;

    font-weight: 700;
}

.upload-subtitle {
    margin: 5px 0 0;

    color: #858796;

    font-size: .78rem;
}


/* =========================================================
   STATISTIK
========================================================= */

.upload-stats {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    gap: 14px;

    margin-bottom: 25px;
}

.upload-stat {
    display: flex;

    align-items: center;

    padding: 15px 17px;

    border-radius: 12px;

    background: #fff;

    box-shadow:
        0 3px 14px rgba(0,0,0,.05);
}

.upload-stat-icon {
    width: 42px;
    height: 42px;

    display: flex;

    align-items: center;
    justify-content: center;

    margin-right: 12px;

    border-radius: 10px;

    background: #eef2ff;

    color: #4e73df;
}

.upload-stat-value {
    color: #343a40;

    font-size: 1.1rem;

    font-weight: 700;

    line-height: 1;
}

.upload-stat-label {
    margin-top: 4px;

    color: #858796;

    font-size: .68rem;
}


/* =========================================================
   TOOLBAR
========================================================= */

.upload-toolbar {
    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    padding: 15px 17px;

    margin-bottom: 25px;

    border-radius: 12px;

    background: #fff;

    box-shadow:
        0 3px 14px rgba(0,0,0,.05);
}

.upload-search {
    position: relative;

    flex: 1;

    max-width: 500px;
}

.upload-search i {
    position: absolute;

    left: 14px;

    top: 50%;

    transform: translateY(-50%);

    color: #9aa3b2;

    font-size: .8rem;
}

.upload-search input {
    width: 100%;

    height: 40px;

    padding-left: 38px;

    border: 1px solid #e0e4eb;

    border-radius: 9px;

    background: #f9fafc;

    font-size: .78rem;

    outline: none;
}

.upload-search input:focus {
    background: #fff;

    border-color: #4e73df;

    box-shadow:
        0 0 0 3px rgba(78,115,223,.10);
}

.upload-filter {
    display: flex;

    align-items: center;

    gap: 8px;
}

.upload-filter select {
    height: 40px;

    min-width: 110px;

    border: 1px solid #e0e4eb;

    border-radius: 9px;

    font-size: .78rem;
}


/* =========================================================
   POINT CARD
========================================================= */

.point-card {
    margin-bottom: 20px;

    border: 0;

    border-radius: 16px;

    background: #fff;

    overflow: hidden;

    box-shadow:
        0 4px 18px rgba(0,0,0,.055);
}

.point-header {
    display: flex;

    align-items: flex-start;

    gap: 15px;

    padding: 19px 20px;

    border-bottom: 1px solid #edf0f5;
}

.point-number {
    width: 44px;
    height: 44px;

    flex: 0 0 44px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 12px;

    background: #eef2ff;

    color: #4e73df;

    font-size: .9rem;

    font-weight: 800;
}

.point-content {
    min-width: 0;

    flex: 1;
}

.point-name {
    margin: 0;

    color: #263238;

    font-size: .92rem;

    line-height: 1.5;

    font-weight: 700;
}

.point-description {
    margin-top: 5px;

    color: #858796;

    font-size: .73rem;

    line-height: 1.5;
}

.point-actions {
    display: flex;

    align-items: center;

    gap: 7px;
}

.point-edit {
    width: 34px;
    height: 34px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 8px;

    color: #858796;

    background: #f7f8fb;

    font-size: .75rem;
}

.point-edit:hover {
    color: #4e73df;

    background: #eef2ff;
}


/* =========================================================
   YEAR GRID
========================================================= */

.year-grid {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 15px;

    padding: 16px 20px 20px;
}


/* =========================================================
   YEAR CARD
========================================================= */

.year-card {
    border: 1px solid #e4e8f0;

    border-radius: 13px;

    background: #fafbfe;

    overflow: hidden;
}

.year-header {
    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 10px;

    padding: 13px 15px;

    border-bottom: 1px solid #e5e8ef;

    background: #f8f9fc;
}

.year-title {
    display: flex;

    align-items: center;

    color: #343a40;

    font-size: .8rem;

    font-weight: 700;
}

.year-icon {
    width: 34px;
    height: 34px;

    display: flex;

    align-items: center;
    justify-content: center;

    margin-right: 9px;

    border-radius: 9px;

    background: #e9efff;

    color: #4e73df;

    font-size: .75rem;
}

.year-count {
    padding: 5px 9px;

    border-radius: 20px;

    background: #eef2ff;

    color: #4e73df;

    font-size: .65rem;

    font-weight: 700;
}


/* =========================================================
   UPLOAD BUTTON
========================================================= */

.btn-upload {
    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding: 8px 12px;

    border: 0;

    border-radius: 9px;

    background: #4e73df;

    color: #fff;

    font-size: .7rem;

    font-weight: 700;

    text-decoration: none;

    cursor: pointer;
}

.btn-upload:hover {
    color: #fff;

    background: #3d5fc4;

    text-decoration: none;
}


/* =========================================================
   FILE LIST
========================================================= */

.file-list {
    padding: 14px;
}


/* =========================================================
   FILE ITEM
========================================================= */

.file-item {
    display: flex;

    align-items: flex-start;

    gap: 12px;

    padding: 12px;

    border: 1px solid #e1e5ec;

    border-radius: 11px;

    background: #fff;

    transition:
        border-color .15s ease,
        box-shadow .15s ease;
}

.file-item:hover {
    border-color: #cbd5ee;

    box-shadow:
        0 3px 12px rgba(0,0,0,.045);
}

.file-item + .file-item {
    margin-top: 9px;
}


/* =========================================================
   FILE ICON
========================================================= */

.file-icon {
    width: 45px;
    height: 45px;

    flex: 0 0 45px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 11px;

    font-size: 1.05rem;
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

.file-icon.image {
    background: #fff8e7;
    color: #d89b00;
}

.file-icon.powerpoint {
    background: #fff2eb;
    color: #e85d04;
}

.file-icon.archive {
    background: #f1efff;
    color: #6f42c1;
}

.file-icon.default {
    background: #f1f3f5;
    color: #6c757d;
}


/* =========================================================
   FILE INFO
========================================================= */

.file-info {
    min-width: 0;

    flex: 1;
}

.file-name {
    max-width: 100%;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

    color: #263238;

    font-size: .79rem;

    font-weight: 700;

    line-height: 1.4;
}

.file-meta {
    display: flex;

    align-items: center;

    flex-wrap: wrap;

    gap: 6px;

    margin-top: 3px;

    color: #9aa3b2;

    font-size: .65rem;
}

.meta-dot {
    color: #c5cad3;
}


/* =========================================================
   KETERANGAN FILE
========================================================= */

.file-description {
    display: flex;

    align-items: flex-start;

    gap: 7px;

    margin-top: 9px;

    padding: 8px 10px;

    border-radius: 8px;

    background: #f5f8ff;

    color: #667085;

    font-size: .68rem;

    line-height: 1.55;
}

.file-description i {
    flex: 0 0 auto;

    margin-top: 2px;

    color: #4e73df;

    font-size: .68rem;
}

.file-description span {
    min-width: 0;

    word-break: break-word;
}


/* =========================================================
   FILE ACTION
========================================================= */

.file-actions {
    display: flex;

    align-items: center;

    gap: 5px;

    flex: 0 0 auto;
}

.file-action {
    width: 35px;
    height: 35px;

    display: flex;

    align-items: center;
    justify-content: center;

    border: 1px solid transparent;

    border-radius: 8px;

    background: #fff;

    font-size: .8rem;

    cursor: pointer;

    transition:
        background .15s ease,
        color .15s ease,
        border-color .15s ease;
}

.file-action.view {
    border-color: #36b9cc;

    color: #36b9cc;
}

.file-action.view:hover {
    background: #36b9cc;

    color: #fff;
}

.file-action.download {
    border-color: #4e73df;

    color: #4e73df;
}

.file-action.download:hover {
    background: #4e73df;

    color: #fff;
}

.file-action.delete {
    border-color: #e74a3b;

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
    padding: 25px 15px;

    text-align: center;

    color: #a0a7b4;

    font-size: .7rem;
}

.empty-file i {
    display: block;

    margin-bottom: 7px;

    color: #c9ced8;

    font-size: 1.4rem;
}


/* =========================================================
   MODAL UPLOAD
========================================================= */

.upload-modal .modal-content {
    border: 0;

    border-radius: 16px;

    overflow: hidden;
}

.upload-modal .modal-header {
    padding: 17px 20px;

    border-bottom: 1px solid #edf0f5;

    background: #fff;
}

.upload-modal .modal-title {
    color: #343a40;

    font-size: .95rem;

    font-weight: 700;
}

.upload-modal .modal-body {
    padding: 20px;
}

.upload-modal label {
    color: #5a5c69;

    font-size: .73rem;

    font-weight: 700;
}

.upload-modal .form-control {
    border-radius: 9px;

    border-color: #dfe3eb;

    font-size: .78rem;
}

.upload-modal .form-control:focus {
    border-color: #4e73df;

    box-shadow:
        0 0 0 3px rgba(78,115,223,.10);
}

.upload-help {
    margin-top: 5px;

    color: #9299a7;

    font-size: .65rem;

    line-height: 1.5;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 991px) {

    .year-grid {
        grid-template-columns: 1fr;
    }

}

@media (max-width: 767px) {

    .upload-stats {
        grid-template-columns: 1fr;
    }

    .upload-toolbar {
        display: block;
    }

    .upload-search {
        max-width: none;

        margin-bottom: 10px;
    }

    .upload-filter {
        justify-content: space-between;
    }

    .point-header {
        padding: 15px;
    }

    .point-actions {
        flex: 0 0 auto;
    }

    .year-grid {
        padding: 12px;
    }

}

@media (max-width: 576px) {

    .upload-header {
        display: block;
    }

    .upload-title {
        font-size: 1.15rem;
    }

    .point-header {
        gap: 10px;
    }

    .point-number {
        width: 38px;
        height: 38px;

        flex-basis: 38px;

        border-radius: 10px;

        font-size: .75rem;
    }

    .point-name {
        font-size: .8rem;
    }

    .point-actions {
        gap: 4px;
    }

    .point-edit {
        width: 30px;
        height: 30px;
    }

    .file-item {
        gap: 9px;

        padding: 10px;
    }

    .file-icon {
        width: 38px;
        height: 38px;

        flex-basis: 38px;

        font-size: .9rem;
    }

    .file-name {
        font-size: .72rem;
    }

    .file-actions {
        gap: 3px;
    }

    .file-action {
        width: 31px;
        height: 31px;

        font-size: .7rem;
    }

    .file-description {
        font-size: .62rem;
    }

}

</style>


<div class="container-fluid upload-page">


    <!-- =====================================================
         HEADER
    ====================================================== -->

    <div class="upload-header">

        <div class="upload-title-wrap">

            <h1 class="upload-title">

                <i class="fas fa-folder-open text-primary mr-2"></i>

                <?= html_escape($title) ?>

            </h1>

            <p class="upload-subtitle">

                Kelola dokumen permintaan Inspektorat berdasarkan
                point dan tahun dokumen.

            </p>

        </div>

    </div>


    <!-- =====================================================
         STATISTIK
    ====================================================== -->

    <?php

    $total_point = is_array($points)
        ? count($points)
        : 0;

    $total_file_2025 = 0;
    $total_file_2026 = 0;

    foreach ($points as $p) {

        if (
            isset($p->files_2025) &&
            is_array($p->files_2025)
        ) {
            $total_file_2025 +=
                count($p->files_2025);
        }

        if (
            isset($p->files_2026) &&
            is_array($p->files_2026)
        ) {
            $total_file_2026 +=
                count($p->files_2026);
        }
    }

    $total_file =
        $total_file_2025 +
        $total_file_2026;

    ?>


    <div class="upload-stats">


        <div class="upload-stat">

            <div class="upload-stat-icon">

                <i class="fas fa-list-ol"></i>

            </div>

            <div>

                <div class="upload-stat-value">

                    <?= number_format($total_point) ?>

                </div>

                <div class="upload-stat-label">

                    Total Point

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

                    Total Berkas

                </div>

            </div>

        </div>


        <div class="upload-stat">

            <div class="upload-stat-icon">

                <i class="fas fa-calendar-alt"></i>

            </div>

            <div>

                <div class="upload-stat-value">

                    <?= number_format(
                        $total_file_2025
                    ) ?>

                    <small style="font-size:.65rem;color:#858796;">
                        / <?= number_format(
                            $total_file_2026
                        ) ?>
                    </small>

                </div>

                <div class="upload-stat-label">

                    Berkas 2025 / 2026

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


        <div class="upload-filter">

            <span
                class="text-muted"
                style="font-size:.72rem;"
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
                    class="form-control form-control-sm"
                    onchange="this.form.submit()"
                >

                    <option
                        value="2025"
                        <?= ((int) $tahun === 2025)
                            ? 'selected'
                            : '' ?>
                    >
                        2025
                    </option>

                    <option
                        value="2026"
                        <?= ((int) $tahun === 2026)
                            ? 'selected'
                            : '' ?>
                    >
                        2026
                    </option>

                </select>

            </form>


            <?php if (
                $this->session->userdata('role_id') == 1
            ): ?>

                <a
                    href="<?= site_url('upload/tambah_point') ?>"
                    class="btn btn-primary btn-sm"
                    style="border-radius:9px;"
                >

                    <i class="fas fa-plus mr-1"></i>

                    Point

                </a>

            <?php endif; ?>


        </div>

    </div>


    <!-- =====================================================
         POINT
    ====================================================== -->

    <?php if (!empty($points)): ?>


        <?php foreach ($points as $point): ?>


            <?php

            $files_2025 =
                isset($point->files_2025)
                    ? $point->files_2025
                    : array();

            $files_2026 =
                isset($point->files_2026)
                    ? $point->files_2026
                    : array();

            ?>


            <div class="point-card">


                <!-- =================================================
                     POINT HEADER
                ================================================== -->

                <div class="point-header">


                    <div class="point-number">

                        <?= str_pad(
                            (int) $point->nomor,
                            2,
                            '0',
                            STR_PAD_LEFT
                        ) ?>

                    </div>


                    <div class="point-content">


                        <h2 class="point-name">

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


                    <?php if (
                        $this->session->userdata('role_id') == 1
                    ): ?>

                        <div class="point-actions">

                            <a
                                href="<?= site_url(
                                    'upload/edit_point/' .
                                    (int) $point->id
                                ) ?>"
                                class="point-edit"
                                title="Edit point"
                            >

                                <i class="fas fa-edit"></i>

                            </a>


                            <a
                                href="<?= site_url(
                                    'upload/delete_point/' .
                                    (int) $point->id
                                ) ?>"
                                class="point-edit text-danger"
                                title="Hapus point"
                                onclick="
                                    return confirm(
                                        'Hapus point beserta seluruh berkas di dalamnya?'
                                    );
                                "
                            >

                                <i class="fas fa-trash"></i>

                            </a>

                        </div>

                    <?php endif; ?>


                </div>



                <!-- =================================================
                     YEAR
                ================================================== -->

                <div class="year-grid">


                    <!-- =================================================
                         2025
                    ================================================== -->

                    <div class="year-card">


                        <div class="year-header">


                            <div class="year-title">

                                <div class="year-icon">

                                    <i class="fas fa-calendar-alt"></i>

                                </div>

                                Tahun 2025

                            </div>


                            <div class="d-flex align-items-center gap-1">


                                <span class="year-count">

                                    <?= count($files_2025) ?>
                                    berkas

                                </span>


                                <button
                                    type="button"
                                    class="btn-upload"
                                    data-toggle="modal"
                                    data-target="#uploadModal<?= (int) $point->id ?>2025"
                                >

                                    <i class="fas fa-cloud-upload-alt"></i>

                                    Upload

                                </button>


                            </div>


                        </div>


                        <div class="file-list">


                            <?php if (!empty($files_2025)): ?>


                                <?php foreach ($files_2025 as $file): ?>


                                    <?php

                                    $ext =
                                        strtolower(
                                            trim(
                                                $file->ekstensi
                                            )
                                        );


                                    /*
                                     * Icon
                                     */

                                    $icon_class =
                                        'default';

                                    $icon =
                                        'fa-file';


                                    if (
                                        in_array(
                                            $ext,
                                            array(
                                                'pdf'
                                            ),
                                            true
                                        )
                                    ) {

                                        $icon_class =
                                            'pdf';

                                        $icon =
                                            'fa-file-pdf';

                                    } elseif (
                                        in_array(
                                            $ext,
                                            array(
                                                'xls',
                                                'xlsx'
                                            ),
                                            true
                                        )
                                    ) {

                                        $icon_class =
                                            'excel';

                                        $icon =
                                            'fa-file-excel';

                                    } elseif (
                                        in_array(
                                            $ext,
                                            array(
                                                'doc',
                                                'docx'
                                            ),
                                            true
                                        )
                                    ) {

                                        $icon_class =
                                            'word';

                                        $icon =
                                            'fa-file-word';

                                    } elseif (
                                        in_array(
                                            $ext,
                                            array(
                                                'jpg',
                                                'jpeg',
                                                'png',
                                                'gif',
                                                'webp'
                                            ),
                                            true
                                        )
                                    ) {

                                        $icon_class =
                                            'image';

                                        $icon =
                                            'fa-file-image';

                                    } elseif (
                                        in_array(
                                            $ext,
                                            array(
                                                'ppt',
                                                'pptx'
                                            ),
                                            true
                                        )
                                    ) {

                                        $icon_class =
                                            'powerpoint';

                                        $icon =
                                            'fa-file-powerpoint';

                                    } elseif (
                                        in_array(
                                            $ext,
                                            array(
                                                'zip',
                                                'rar'
                                            ),
                                            true
                                        )
                                    ) {

                                        $icon_class =
                                            'archive';

                                        $icon =
                                            'fa-file-archive';

                                    }


                                    /*
                                     * Preview support
                                     */

                                    $previewable =
                                        in_array(
                                            $ext,
                                            array(
                                                'pdf',
                                                'jpg',
                                                'jpeg',
                                                'png',
                                                'gif',
                                                'webp',
                                                'xls',
                                                'xlsx',
                                                'docx'
                                            ),
                                            true
                                        );


                                    /*
                                     * Ukuran
                                     */

                                    $size =
                                        isset(
                                            $file->ukuran_file
                                        )
                                            ? (int)
                                                $file->ukuran_file
                                            : 0;


                                    if ($size >= 1048576) {

                                        $size_text =
                                            number_format(
                                                $size / 1048576,
                                                2
                                            ) . ' MB';

                                    } else {

                                        $size_text =
                                            number_format(
                                                $size / 1024,
                                                1
                                            ) . ' KB';

                                    }

                                    ?>


                                    <div class="file-item">


                                        <!-- ICON -->

                                        <div
                                            class="file-icon <?= $icon_class ?>"
                                        >

                                            <i
                                                class="fas <?= $icon ?>"
                                            ></i>

                                        </div>


                                        <!-- INFO -->

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
                                                    <?= $size_text ?>
                                                </span>

                                                <span class="meta-dot">
                                                    •
                                                </span>

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
                                                isset(
                                                    $file->keterangan
                                                ) &&
                                                trim(
                                                    $file->keterangan
                                                ) !== ''
                                            ): ?>

                                                <div
                                                    class="file-description"
                                                >

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


                                        <!-- ACTION -->

                                        <div class="file-actions">


                                            <?php if ($previewable): ?>

                                                <a
                                                    href="<?= site_url(
                                                        'upload/preview/' .
                                                        (int) $file->id
                                                    ) ?>"
                                                    target="_blank"
                                                    class="file-action view"
                                                    title="Lihat berkas"
                                                >

                                                    <i class="fas fa-eye"></i>

                                                </a>

                                            <?php endif; ?>


                                            <a
                                                href="<?= site_url(
                                                    'upload/download/' .
                                                    (int) $file->id
                                                ) ?>"
                                                class="file-action download"
                                                title="Download"
                                            >

                                                <i class="fas fa-download"></i>

                                            </a>


                                            <a
                                                href="<?= site_url(
                                                    'upload/delete_file/' .
                                                    (int) $file->id
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

                                    Belum ada berkas untuk tahun 2025.

                                </div>


                            <?php endif; ?>


                        </div>


                    </div>



                    <!-- =================================================
                         2026
                    ================================================== -->

                    <div class="year-card">


                        <div class="year-header">


                            <div class="year-title">

                                <div class="year-icon">

                                    <i class="fas fa-calendar-alt"></i>

                                </div>

                                Tahun 2026

                            </div>


                            <div class="d-flex align-items-center">


                                <span class="year-count mr-1">

                                    <?= count($files_2026) ?>
                                    berkas

                                </span>


                                <button
                                    type="button"
                                    class="btn-upload"
                                    data-toggle="modal"
                                    data-target="#uploadModal<?= (int) $point->id ?>2026"
                                >

                                    <i class="fas fa-cloud-upload-alt"></i>

                                    Upload

                                </button>


                            </div>


                        </div>


                        <div class="file-list">


                            <?php if (!empty($files_2026)): ?>


                                <?php foreach ($files_2026 as $file): ?>


                                    <?php

                                    $ext =
                                        strtolower(
                                            trim(
                                                $file->ekstensi
                                            )
                                        );


                                    $icon_class =
                                        'default';

                                    $icon =
                                        'fa-file';


                                    if (
                                        $ext === 'pdf'
                                    ) {

                                        $icon_class =
                                            'pdf';

                                        $icon =
                                            'fa-file-pdf';

                                    } elseif (
                                        in_array(
                                            $ext,
                                            array(
                                                'xls',
                                                'xlsx'
                                            ),
                                            true
                                        )
                                    ) {

                                        $icon_class =
                                            'excel';

                                        $icon =
                                            'fa-file-excel';

                                    } elseif (
                                        in_array(
                                            $ext,
                                            array(
                                                'doc',
                                                'docx'
                                            ),
                                            true
                                        )
                                    ) {

                                        $icon_class =
                                            'word';

                                        $icon =
                                            'fa-file-word';

                                    } elseif (
                                        in_array(
                                            $ext,
                                            array(
                                                'jpg',
                                                'jpeg',
                                                'png',
                                                'gif',
                                                'webp'
                                            ),
                                            true
                                        )
                                    ) {

                                        $icon_class =
                                            'image';

                                        $icon =
                                            'fa-file-image';

                                    } elseif (
                                        in_array(
                                            $ext,
                                            array(
                                                'ppt',
                                                'pptx'
                                            ),
                                            true
                                        )
                                    ) {

                                        $icon_class =
                                            'powerpoint';

                                        $icon =
                                            'fa-file-powerpoint';

                                    } elseif (
                                        in_array(
                                            $ext,
                                            array(
                                                'zip',
                                                'rar'
                                            ),
                                            true
                                        )
                                    ) {

                                        $icon_class =
                                            'archive';

                                        $icon =
                                            'fa-file-archive';

                                    }


                                    $previewable =
                                        in_array(
                                            $ext,
                                            array(
                                                'pdf',
                                                'jpg',
                                                'jpeg',
                                                'png',
                                                'gif',
                                                'webp',
                                                'xls',
                                                'xlsx',
                                                'docx'
                                            ),
                                            true
                                        );


                                    $size =
                                        isset(
                                            $file->ukuran_file
                                        )
                                            ? (int)
                                                $file->ukuran_file
                                            : 0;


                                    if ($size >= 1048576) {

                                        $size_text =
                                            number_format(
                                                $size / 1048576,
                                                2
                                            ) . ' MB';

                                    } else {

                                        $size_text =
                                            number_format(
                                                $size / 1024,
                                                1
                                            ) . ' KB';

                                    }

                                    ?>


                                    <div class="file-item">


                                        <div
                                            class="file-icon <?= $icon_class ?>"
                                        >

                                            <i
                                                class="fas <?= $icon ?>"
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
                                                    <?= $size_text ?>
                                                </span>

                                                <span class="meta-dot">
                                                    •
                                                </span>

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
                                                isset(
                                                    $file->keterangan
                                                ) &&
                                                trim(
                                                    $file->keterangan
                                                ) !== ''
                                            ): ?>

                                                <div
                                                    class="file-description"
                                                >

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


                                            <?php if ($previewable): ?>

                                                <a
                                                    href="<?= site_url(
                                                        'upload/preview/' .
                                                        (int) $file->id
                                                    ) ?>"
                                                    target="_blank"
                                                    class="file-action view"
                                                    title="Lihat berkas"
                                                >

                                                    <i class="fas fa-eye"></i>

                                                </a>

                                            <?php endif; ?>


                                            <a
                                                href="<?= site_url(
                                                    'upload/download/' .
                                                    (int) $file->id
                                                ) ?>"
                                                class="file-action download"
                                                title="Download"
                                            >

                                                <i class="fas fa-download"></i>

                                            </a>


                                            <a
                                                href="<?= site_url(
                                                    'upload/delete_file/' .
                                                    (int) $file->id
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

                                    Belum ada berkas untuk tahun 2026.

                                </div>


                            <?php endif; ?>


                        </div>


                    </div>


                </div>


            </div>


            <!-- =====================================================
                 MODAL UPLOAD 2025
            ====================================================== -->

            <div
                class="modal fade upload-modal"
                id="uploadModal<?= (int) $point->id ?>2025"
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
                                (int) $point->id
                            ) ?>"
                            enctype="multipart/form-data"
                        >


                            <div class="modal-body">


                                <div class="form-group">

                                    <label>
                                        Point
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        value="<?= html_escape(
                                            $point->nomor .
                                            '. ' .
                                            $point->nama_point
                                        ) ?>"
                                        readonly
                                    >

                                </div>


                                <div class="form-group">

                                    <label>
                                        Tahun
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        value="2025"
                                        readonly
                                    >

                                    <input
                                        type="hidden"
                                        name="tahun"
                                        value="2025"
                                    >

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
                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.zip,.rar"
                                    >

                                    <div class="upload-help">

                                        PDF, Word, Excel, PowerPoint,
                                        gambar, ZIP/RAR.
                                        Maksimal 50 MB.

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
                                        placeholder="Contoh: BKU Semester II 2025, dokumen asli, PDF hasil scan, dan sebagainya."
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



            <!-- =====================================================
                 MODAL UPLOAD 2026
            ====================================================== -->

            <div
                class="modal fade upload-modal"
                id="uploadModal<?= (int) $point->id ?>2026"
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
                                (int) $point->id
                            ) ?>"
                            enctype="multipart/form-data"
                        >


                            <div class="modal-body">


                                <div class="form-group">

                                    <label>
                                        Point
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        value="<?= html_escape(
                                            $point->nomor .
                                            '. ' .
                                            $point->nama_point
                                        ) ?>"
                                        readonly
                                    >

                                </div>


                                <div class="form-group">

                                    <label>
                                        Tahun
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        value="2026"
                                        readonly
                                    >

                                    <input
                                        type="hidden"
                                        name="tahun"
                                        value="2026"
                                    >

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
                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.zip,.rar"
                                    >

                                    <div class="upload-help">

                                        PDF, Word, Excel, PowerPoint,
                                        gambar, ZIP/RAR.
                                        Maksimal 50 MB.

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
                                        placeholder="Contoh: BKU Semester I 2026, dokumen asli, PDF hasil scan, dan sebagainya."
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


        <!-- =====================================================
             EMPTY SEARCH
        ====================================================== -->

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <i
                    class="fas fa-search fa-3x text-gray-300 mb-3"
                ></i>

                <h5 class="text-gray-700">

                    Point dokumen tidak ditemukan.

                </h5>

                <p class="text-muted small mb-0">

                    Coba gunakan kata kunci pencarian yang berbeda.

                </p>

            </div>

        </div>


    <?php endif; ?>


</div>