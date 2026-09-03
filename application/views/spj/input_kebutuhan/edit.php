<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$id_kebutuhan = (int) $kebutuhan->id_kebutuhan;

/*
 * =========================================================
 * KELOMPOKKAN DETAIL BERDASARKAN KODERING
 *
 * Karena database menyimpan setiap barang sebagai baris,
 * saat edit kita susun kembali menjadi:
 *
 * Kodering 1
 *   - Barang 1
 *   - Barang 2
 *
 * Kodering 2
 *   - Barang 1
 *   - Barang 2
 * =========================================================
 */

$kelompok_kodering = array();

if (!empty($detail)) {

    foreach ($detail as $row) {

        $key = (string) $row->id_kategori;

        if (!isset($kelompok_kodering[$key])) {

            $kelompok_kodering[$key] = array(
                'id_kategori' => $row->id_kategori,
                'kodering'    => $row->kodering,
                'barang'      => array()
            );

        }

        $kelompok_kodering[$key]['barang'][] = $row;
    }
}


/*
 * Jika tidak ada detail sama sekali,
 * buat satu kelompok kosong.
 */

if (empty($kelompok_kodering)) {

    $kelompok_kodering[] = array(
        'id_kategori' => '',
        'kodering'    => '',
        'barang'      => array(
            null
        )
    );

} else {

    /*
     * Ubah associative array menjadi index 0,1,2...
     * supaya cocok dengan name:
     *
     * id_kategori[0]
     * id_kategori[1]
     */

    $kelompok_kodering = array_values($kelompok_kodering);

}

?>

<div class="container-fluid">

    <!-- =====================================================
         HEADER
    ====================================================== -->

    <div class="d-flex align-items-center justify-content-between mb-4">

        <div>

            <h1 class="h3 mb-1 text-gray-800">
                <?= html_escape($title) ?>
            </h1>

            <div class="text-muted small">
                Perbarui data pengajuan kebutuhan
            </div>

        </div>


        <a href="<?= base_url('spj/input_kebutuhan') ?>"
           class="btn btn-secondary">

            <i class="fas fa-arrow-left mr-1"></i>
            Kembali

        </a>

    </div>


    <!-- =====================================================
         ALERT
    ====================================================== -->

    <?php if ($this->session->flashdata('error')): ?>

        <div class="alert alert-danger">

            <i class="fas fa-exclamation-circle mr-1"></i>

            <?= html_escape($this->session->flashdata('error')) ?>

        </div>

    <?php endif; ?>


    <!-- =====================================================
         FORM
    ====================================================== -->

    <form method="post"
          action="<?= base_url('spj/update_kebutuhan/' . $id_kebutuhan) ?>"
          id="formKebutuhan">


        <!-- =================================================
             DATA PENGAJUAN
        ================================================== -->

        <div class="card shadow mb-4">

            <div class="card-header">

                <strong class="text-primary">

                    <i class="fas fa-file-alt mr-1"></i>
                    Data Pengajuan

                </strong>

            </div>


            <div class="card-body">

                <div class="row">


                    <!-- NOMOR SURAT -->

                    <div class="col-md-6">

                        <div class="form-group">

                            <label class="font-weight-bold">
                                Nomor Surat
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="nomor_surat"
                                   class="form-control"
                                   value="<?= html_escape($kebutuhan->nomor_surat) ?>"
                                   autocomplete="off"
                                   required>

                        </div>

                    </div>


                    <!-- TANGGAL -->

                    <div class="col-md-6">

                        <div class="form-group">

                            <label class="font-weight-bold">
                                Tanggal
                                <span class="text-danger">*</span>
                            </label>

                            <input type="date"
                                   name="tanggal"
                                   class="form-control"
                                   value="<?= html_escape($kebutuhan->tanggal) ?>"
                                   required>

                        </div>

                    </div>


                    <!-- NOMOR INVOICE -->

                    <div class="col-md-6">

                        <div class="form-group">

                            <label class="font-weight-bold">
                                Nomor Invoice
                            </label>

                            <input type="text"
                                   name="nomor_invoice"
                                   class="form-control"
                                   value="<?= html_escape($kebutuhan->nomor_invoice ?? '') ?>"
                                   placeholder="Nomor invoice"
                                   autocomplete="off">

                        </div>

                    </div>


                    <!-- NOMOR PESANAN -->

                    <div class="col-md-6">

                        <div class="form-group">

                            <label class="font-weight-bold">
                                Nomor Pesanan
                            </label>

                            <input type="text"
                                   name="nomor_pesanan"
                                   class="form-control"
                                   value="<?= html_escape($kebutuhan->nomor_pesanan ?? '') ?>"
                                   placeholder="Nomor pesanan"
                                   autocomplete="off">

                        </div>

                    </div>


                    <!-- NAMA PENYEDIA -->

                    <div class="col-md-12">

                        <div class="form-group">

                            <label class="font-weight-bold">
                                Nama CV/Penyedia
                            </label>

                            <input type="text"
                                   name="nama_penyedia"
                                   class="form-control"
                                   value="<?= html_escape($kebutuhan->nama_penyedia ?? '') ?>"
                                   placeholder="Nama CV atau penyedia barang/jasa"
                                   autocomplete="off">

                        </div>

                    </div>


                    <!-- PERIHAL -->

                    <div class="col-md-12">

                        <div class="form-group">

                            <label class="font-weight-bold">
                                Perihal
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="perihal"
                                   class="form-control"
                                   value="<?= html_escape($kebutuhan->perihal) ?>"
                                   required>

                        </div>

                    </div>


                    <!-- KEGIATAN -->

                    <div class="col-md-12">

                        <div class="form-group">

                            <label class="font-weight-bold">
                                Kegiatan
                            </label>

                            <input type="text"
                                   name="kegiatan"
                                   class="form-control"
                                   value="<?= html_escape($kebutuhan->kegiatan ?? '') ?>"
                                   placeholder="Contoh: Kegiatan Kesiswaan">

                        </div>

                    </div>


                    <!-- KETERANGAN -->

                    <div class="col-md-12">

                        <div class="form-group mb-0">

                            <label class="font-weight-bold">
                                Keterangan
                            </label>

                            <textarea name="keterangan"
                                      class="form-control"
                                      rows="3"
                                      placeholder="Keterangan tambahan..."><?= html_escape($kebutuhan->keterangan ?? '') ?></textarea>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- =================================================
             RINCIAN KEBUTUHAN
        ================================================== -->

        <div class="card shadow mb-4">

            <div class="card-header d-flex align-items-center justify-content-between">

                <div>

                    <strong class="text-primary">

                        <i class="fas fa-list mr-1"></i>
                        Rincian Kebutuhan

                    </strong>

                    <div class="small text-muted mt-1">
                        Pilih kodering, kemudian tambahkan barang
                        di dalam kelompok tersebut.
                    </div>

                </div>


                <button type="button"
                        id="btnTambahKodering"
                        class="btn btn-primary btn-sm">

                    <i class="fas fa-plus mr-1"></i>
                    Tambah Kodering

                </button>

            </div>


            <div class="card-body">

                <div id="containerKodering">


                    <?php foreach ($kelompok_kodering as $indexKelompok => $kelompok): ?>

                        <!-- =================================================
                             KELOMPOK KODERING
                        ================================================== -->

                        <div class="kelompok-kodering"
                             data-index="<?= $indexKelompok ?>">


                            <!-- HEADER KODERING -->

                            <div class="kodering-header">

                                <div class="row align-items-end">

                                    <div class="col-md-9">

                                        <label class="font-weight-bold mb-1">

                                            Kodering
                                            <span class="text-danger">*</span>

                                        </label>


                                        <select name="id_kategori[<?= $indexKelompok ?>]"
                                                class="form-control kodering-select"
                                                required>

                                            <option value="">
                                                -- Pilih Kodering --
                                            </option>


                                            <?php foreach ($kategori as $k): ?>

                                                <option value="<?= (int) $k->id_kategori ?>"
                                                        data-kodering="<?= html_escape($k->kodering) ?>"
                                                    <?= (
                                                        (int) $k->id_kategori ===
                                                        (int) $kelompok['id_kategori']
                                                    )
                                                        ? 'selected'
                                                        : ''
                                                    ?>>

                                                    <?= html_escape($k->kodering) ?>
                                                    -
                                                    <?= html_escape($k->nama_kategori) ?>

                                                </option>

                                            <?php endforeach; ?>

                                        </select>


                                        <div class="kodering-info text-primary small font-weight-bold mt-1">

                                            <?php if (!empty($kelompok['kodering'])): ?>

                                                Kodering:
                                                <?= html_escape($kelompok['kodering']) ?>

                                            <?php endif; ?>

                                        </div>

                                    </div>


                                    <div class="col-md-3 text-right">

                                        <button type="button"
                                                class="btn btn-outline-danger btn-sm btn-hapus-kodering">

                                            <i class="fas fa-trash mr-1"></i>
                                            Hapus Kodering

                                        </button>

                                    </div>

                                </div>

                            </div>


                            <!-- TABEL BARANG -->

                            <div class="table-responsive mt-3">

                                <table class="table table-bordered table-hover tabel-barang mb-2">

                                    <thead class="thead-light">

                                        <tr>

                                            <th width="5%"
                                                class="text-center">
                                                No
                                            </th>

                                            <th>
                                                Nama Barang/Jasa
                                            </th>

                                            <th width="14%">
                                                Jumlah
                                            </th>

                                            <th width="15%">
                                                Satuan
                                            </th>

                                            <th width="25%">
                                                Keterangan
                                            </th>

                                            <th width="6%"
                                                class="text-center">
                                                Aksi
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                        <?php foreach ($kelompok['barang'] as $indexBarang => $barang): ?>

                                            <tr class="baris-barang">

                                                <td class="nomor-barang text-center">
                                                    <?= $indexBarang + 1 ?>
                                                </td>


                                                <td>

                                                    <input type="text"
                                                           name="nama_barang[<?= $indexKelompok ?>][]"
                                                           class="form-control nama-barang"
                                                           value="<?= $barang ? html_escape($barang->nama_barang) : '' ?>"
                                                           placeholder="Nama barang/jasa"
                                                           autocomplete="off"
                                                           required>

                                                </td>


                                                <td>

                                                    <input type="number"
                                                           name="jumlah[<?= $indexKelompok ?>][]"
                                                           class="form-control jumlah-barang"
                                                           value="<?= $barang ? html_escape($barang->jumlah) : '' ?>"
                                                           min="0.01"
                                                           step="0.01"
                                                           placeholder="0"
                                                           required>

                                                </td>


                                                <td>

                                                    <input type="text"
                                                           name="satuan[<?= $indexKelompok ?>][]"
                                                           class="form-control satuan-barang"
                                                           value="<?= $barang ? html_escape($barang->satuan) : '' ?>"
                                                           placeholder="Pcs"
                                                           autocomplete="off"
                                                           required>

                                                </td>


                                                <td>

                                                    <input type="text"
                                                           name="keterangan_detail[<?= $indexKelompok ?>][]"
                                                           class="form-control keterangan-barang"
                                                           value="<?= $barang ? html_escape($barang->keterangan ?? '') : '' ?>"
                                                           placeholder="Opsional"
                                                           autocomplete="off">

                                                </td>


                                                <td class="text-center">

                                                    <button type="button"
                                                            class="btn btn-outline-danger btn-sm btn-hapus-barang"
                                                            title="Hapus barang">

                                                        <i class="fas fa-times"></i>

                                                    </button>

                                                </td>

                                            </tr>

                                        <?php endforeach; ?>

                                    </tbody>

                                </table>

                            </div>


                            <!-- TAMBAH BARANG -->

                            <button type="button"
                                    class="btn btn-outline-primary btn-sm btn-tambah-barang">

                                <i class="fas fa-plus mr-1"></i>
                                Tambah Barang

                            </button>

                        </div>

                    <?php endforeach; ?>

                </div>

            </div>

        </div>


        <!-- =================================================
             SUBMIT
        ================================================== -->

        <div class="text-right mb-4">

            <a href="<?= base_url('spj/input_kebutuhan') ?>"
               class="btn btn-secondary mr-1">

                Batal

            </a>


            <button type="submit"
                    class="btn btn-primary"
                    id="btnSimpan">

                <i class="fas fa-save mr-1"></i>
                Simpan Perubahan

            </button>

        </div>


    </form>

</div>


<style>

.kelompok-kodering {

    border: 1px solid #e3e6f0;

    border-radius: 10px;

    padding: 16px;

    margin-bottom: 20px;

    background: #fff;

    box-shadow: 0 2px 8px rgba(0,0,0,.04);

}


.kodering-header {

    padding-bottom: 12px;

    border-bottom: 1px solid #eaecf4;

}


.tabel-barang {

    margin-bottom: 0 !important;

}


.tabel-barang th {

    font-size: 11px;

    font-weight: 700;

    vertical-align: middle;

}


.tabel-barang td {

    vertical-align: middle;

}


.tabel-barang .form-control {

    font-size: 12px;

}


.nomor-barang {

    font-weight: 700;

    color: #858796;

}


.kodering-info {

    min-height: 17px;

}


.btn-tambah-barang {

    border-radius: 7px;

}


@media (max-width: 767.98px) {

    .kelompok-kodering {

        padding: 12px;

    }


    .kodering-header .text-right {

        margin-top: 10px;

        text-align: left !important;

    }

}

</style>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const container =
        document.getElementById('containerKodering');

    const btnTambahKodering =
        document.getElementById('btnTambahKodering');

    const form =
        document.getElementById('formKebutuhan');

    const btnSimpan =
        document.getElementById('btnSimpan');


    /* =====================================================
       TEMPLATE BARIS BARANG
    ===================================================== */

    function buatBarisBarang(indexKelompok) {

        const tr =
            document.createElement('tr');

        tr.className =
            'baris-barang';

        tr.innerHTML = `
            <td class="nomor-barang text-center">
                1
            </td>

            <td>
                <input type="text"
                       name="nama_barang[${indexKelompok}][]"
                       class="form-control nama-barang"
                       placeholder="Nama barang/jasa"
                       autocomplete="off"
                       required>
            </td>

            <td>
                <input type="number"
                       name="jumlah[${indexKelompok}][]"
                       class="form-control jumlah-barang"
                       min="0.01"
                       step="0.01"
                       placeholder="0"
                       required>
            </td>

            <td>
                <input type="text"
                       name="satuan[${indexKelompok}][]"
                       class="form-control satuan-barang"
                       placeholder="Pcs"
                       autocomplete="off"
                       required>
            </td>

            <td>
                <input type="text"
                       name="keterangan_detail[${indexKelompok}][]"
                       class="form-control keterangan-barang"
                       placeholder="Opsional"
                       autocomplete="off">
            </td>

            <td class="text-center">

                <button type="button"
                        class="btn btn-outline-danger btn-sm btn-hapus-barang"
                        title="Hapus barang">

                    <i class="fas fa-times"></i>

                </button>

            </td>
        `;

        return tr;
    }


    /* =====================================================
       UPDATE NOMOR BARANG
    ===================================================== */

    function updateNomorBarang(kelompok) {

        const rows =
            kelompok.querySelectorAll('.baris-barang');

        rows.forEach(function (row, index) {

            const nomor =
                row.querySelector('.nomor-barang');

            if (nomor) {
                nomor.textContent =
                    index + 1;
            }

        });

    }


    /* =====================================================
       UPDATE INDEX KELOMPOK
    ===================================================== */

    function updateIndexKelompok() {

        const kelompokList =
            container.querySelectorAll('.kelompok-kodering');


        kelompokList.forEach(function (kelompok, indexKelompok) {

            kelompok.dataset.index =
                indexKelompok;


            const select =
                kelompok.querySelector('.kodering-select');


            if (select) {

                select.name =
                    'id_kategori[' +
                    indexKelompok +
                    ']';

            }


            const rows =
                kelompok.querySelectorAll('.baris-barang');


            rows.forEach(function (row) {

                const nama =
                    row.querySelector('.nama-barang');

                const jumlah =
                    row.querySelector('.jumlah-barang');

                const satuan =
                    row.querySelector('.satuan-barang');

                const keterangan =
                    row.querySelector('.keterangan-barang');


                if (nama) {

                    nama.name =
                        'nama_barang[' +
                        indexKelompok +
                        '][]';

                }


                if (jumlah) {

                    jumlah.name =
                        'jumlah[' +
                        indexKelompok +
                        '][]';

                }


                if (satuan) {

                    satuan.name =
                        'satuan[' +
                        indexKelompok +
                        '][]';

                }


                if (keterangan) {

                    keterangan.name =
                        'keterangan_detail[' +
                        indexKelompok +
                        '][]';

                }

            });


            updateNomorBarang(kelompok);

        });

    }


    /* =====================================================
       UPDATE TOMBOL HAPUS KODERING
    ===================================================== */

    function updateTombolHapusKodering() {

        const kelompokList =
            container.querySelectorAll(
                '.kelompok-kodering'
            );


        const jumlah =
            kelompokList.length;


        kelompokList.forEach(function (kelompok) {

            const tombol =
                kelompok.querySelector(
                    '.btn-hapus-kodering'
                );


            if (!tombol) {
                return;
            }


            if (jumlah <= 1) {

                tombol.style.display =
                    'none';

            } else {

                tombol.style.display =
                    'inline-block';

            }

        });

    }


    /* =====================================================
       TAMBAH BARANG
    ===================================================== */

    container.addEventListener('click', function (event) {

        const tombol =
            event.target.closest(
                '.btn-tambah-barang'
            );


        if (!tombol) {
            return;
        }


        const kelompok =
            tombol.closest(
                '.kelompok-kodering'
            );


        if (!kelompok) {
            return;
        }


        const kelompokList =
            Array.from(
                container.querySelectorAll(
                    '.kelompok-kodering'
                )
            );


        const indexKelompok =
            kelompokList.indexOf(
                kelompok
            );


        const tbody =
            kelompok.querySelector('tbody');


        if (!tbody) {
            return;
        }


        const baris =
            buatBarisBarang(
                indexKelompok
            );


        tbody.appendChild(
            baris
        );


        updateNomorBarang(
            kelompok
        );


        updateIndexKelompok();


        const inputNama =
            baris.querySelector(
                '.nama-barang'
            );


        if (inputNama) {

            setTimeout(function () {

                inputNama.focus();

            }, 50);

        }

    });


    /* =====================================================
       HAPUS BARANG
    ===================================================== */

    container.addEventListener('click', function (event) {

        const tombol =
            event.target.closest(
                '.btn-hapus-barang'
            );


        if (!tombol) {
            return;
        }


        const kelompok =
            tombol.closest(
                '.kelompok-kodering'
            );


        const baris =
            tombol.closest(
                '.baris-barang'
            );


        if (!kelompok || !baris) {
            return;
        }


        const jumlahBaris =
            kelompok.querySelectorAll(
                '.baris-barang'
            ).length;


        if (jumlahBaris <= 1) {

            alert(
                'Minimal satu barang harus tersedia pada setiap kodering.'
            );

            return;

        }


        baris.remove();


        updateNomorBarang(
            kelompok
        );


        updateIndexKelompok();

    });


    /* =====================================================
       TAMBAH KODERING
    ===================================================== */

    btnTambahKodering.addEventListener(
        'click',
        function () {

            const kelompokPertama =
                container.querySelector(
                    '.kelompok-kodering'
                );


            if (!kelompokPertama) {
                return;
            }


            const kelompok =
                kelompokPertama.cloneNode(
                    true
                );


            const select =
                kelompok.querySelector(
                    '.kodering-select'
                );


            if (select) {

                select.value = '';
                select.name = '';

            }


            const info =
                kelompok.querySelector(
                    '.kodering-info'
                );


            if (info) {

                info.textContent = '';

            }


            const tbody =
                kelompok.querySelector(
                    'tbody'
                );


            if (tbody) {

                tbody.innerHTML = '';

            }


            const indexBaru =
                container.querySelectorAll(
                    '.kelompok-kodering'
                ).length;


            if (tbody) {

                tbody.appendChild(
                    buatBarisBarang(
                        indexBaru
                    )
                );

            }


            container.appendChild(
                kelompok
            );


            updateIndexKelompok();
            updateTombolHapusKodering();


            if (select) {

                setTimeout(function () {

                    select.focus();

                }, 50);

            }

        }
    );


    /* =====================================================
       HAPUS KODERING
    ===================================================== */

    container.addEventListener('click', function (event) {

        const tombol =
            event.target.closest(
                '.btn-hapus-kodering'
            );


        if (!tombol) {
            return;
        }


        const kelompok =
            tombol.closest(
                '.kelompok-kodering'
            );


        if (!kelompok) {
            return;
        }


        const jumlahKelompok =
            container.querySelectorAll(
                '.kelompok-kodering'
            ).length;


        if (jumlahKelompok <= 1) {

            alert(
                'Minimal satu kodering harus tersedia.'
            );

            return;

        }


        if (!confirm(
            'Hapus kelompok kodering beserta seluruh barang di dalamnya?'
        )) {

            return;

        }


        kelompok.remove();


        updateIndexKelompok();
        updateTombolHapusKodering();

    });


    /* =====================================================
       PERUBAHAN KODERING
    ===================================================== */

    container.addEventListener('change', function (event) {

        const select =
            event.target.closest(
                '.kodering-select'
            );


        if (!select) {
            return;
        }


        const kelompok =
            select.closest(
                '.kelompok-kodering'
            );


        if (!kelompok) {
            return;
        }


        const info =
            kelompok.querySelector(
                '.kodering-info'
            );


        if (!info) {
            return;
        }


        if (!select.value) {

            info.textContent = '';

            return;

        }


        const option =
            select.options[
                select.selectedIndex
            ];


        const kodering =
            option.dataset.kodering || '';


        info.textContent =
            kodering
                ? 'Kodering: ' + kodering
                : '';

    });


    /* =====================================================
       VALIDASI FORM
    ===================================================== */

    form.addEventListener(
        'submit',
        function (event) {

            let valid = true;


            const kelompokList =
                container.querySelectorAll(
                    '.kelompok-kodering'
                );


            if (kelompokList.length === 0) {

                event.preventDefault();

                alert(
                    'Minimal satu kodering harus tersedia.'
                );

                return;

            }


            kelompokList.forEach(
                function (kelompok) {

                    if (!valid) {
                        return;
                    }


                    const select =
                        kelompok.querySelector(
                            '.kodering-select'
                        );


                    if (
                        !select ||
                        !select.value
                    ) {

                        valid = false;

                        if (select) {
                            select.focus();
                        }

                        return;

                    }


                    const rows =
                        kelompok.querySelectorAll(
                            '.baris-barang'
                        );


                    if (rows.length === 0) {

                        valid = false;

                        return;

                    }


                    rows.forEach(
                        function (row) {

                            if (!valid) {
                                return;
                            }


                            const nama =
                                row.querySelector(
                                    '.nama-barang'
                                );

                            const jumlah =
                                row.querySelector(
                                    '.jumlah-barang'
                                );

                            const satuan =
                                row.querySelector(
                                    '.satuan-barang'
                                );


                            const namaValue =
                                nama
                                    ? nama.value.trim()
                                    : '';


                            const jumlahValue =
                                jumlah
                                    ? parseFloat(
                                        jumlah.value
                                    )
                                    : 0;


                            const satuanValue =
                                satuan
                                    ? satuan.value.trim()
                                    : '';


                            if (
                                namaValue === '' ||
                                !jumlahValue ||
                                jumlahValue <= 0 ||
                                satuanValue === ''
                            ) {

                                valid = false;

                            }

                        }
                    );

                }
            );


            if (!valid) {

                event.preventDefault();

                alert(
                    'Mohon lengkapi kodering dan seluruh data barang terlebih dahulu.'
                );

                return;

            }


            /*
             * Pastikan seluruh name sudah
             * berurutan sebelum POST.
             */

            updateIndexKelompok();


            /*
             * Cegah double submit.
             */

            btnSimpan.disabled = true;

            btnSimpan.innerHTML =
                '<i class="fas fa-spinner fa-spin mr-1"></i>' +
                ' Menyimpan...';

        }
    );


    /* =====================================================
       INIT
    ===================================================== */

    updateIndexKelompok();
    updateTombolHapusKodering();

});

</script>