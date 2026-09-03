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
                Buat pengajuan kebutuhan barang/jasa
            </div>

        </div>


        <a href="<?= base_url('spj/input_kebutuhan') ?>"
           class="btn btn-secondary">

            <i class="fas fa-arrow-left mr-1"></i>
            Kembali

        </a>

    </div>


    <!-- =====================================================
         FLASH ERROR
    ====================================================== -->

    <?php if ($this->session->flashdata('error')): ?>

        <div class="alert alert-danger">

            <i class="fas fa-exclamation-circle mr-1"></i>

            <?= html_escape($this->session->flashdata('error')) ?>

        </div>

    <?php endif; ?>


    <form method="post"
          action="<?= base_url('spj/tambah_kebutuhan') ?>"
          id="formKebutuhan">


        <!-- =================================================
             DATA SURAT
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
                            </label>

                            <input type="text"
                                   name="nomor_surat"
                                   class="form-control"
                                   placeholder="Contoh: 001/PL.01/SMKN 1 Clms"
                                   required>

                        </div>

                    </div>


                    <!-- TANGGAL -->

                    <div class="col-md-6">

                        <div class="form-group">

                            <label class="font-weight-bold">
                                Tanggal
                            </label>

                            <input type="date"
                                   name="tanggal"
                                   class="form-control"
                                   value="<?= date('Y-m-d') ?>"
                                   required>

                        </div>

                    </div>


                    <!-- PERIHAL -->

                    <div class="col-md-12">

                        <div class="form-group">

                            <label class="font-weight-bold">
                                Perihal
                            </label>

                            <input type="text"
                                   name="perihal"
                                   class="form-control"
                                   value="Pengajuan Kebutuhan Barang"
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
                                      placeholder="Keterangan tambahan..."></textarea>

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

                        Pilih kodering satu kali, kemudian tambahkan
                        barang di dalam kelompok tersebut.

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

                <!-- =================================================
                     CONTAINER KELOMPOK KODERING
                ================================================== -->

                <div id="containerKodering">


                    <!-- =================================================
                         KELOMPOK KODERING PERTAMA
                    ================================================== -->

                    <div class="kelompok-kodering">


                        <!-- HEADER KODERING -->

                        <div class="kodering-header">

                            <div class="row align-items-end">

                                <div class="col-md-9">

                                    <label class="font-weight-bold mb-1">

                                        Kodering

                                    </label>


                                    <select name="id_kategori[]"
                                            class="form-control kodering-select"
                                            required>

                                        <option value="">
                                            -- Pilih Kodering --
                                        </option>

                                        <?php foreach ($kategori as $k): ?>

                                            <option value="<?= $k->id_kategori ?>"
                                                    data-kodering="<?= html_escape($k->kodering) ?>">

                                                <?= html_escape($k->kodering) ?>
                                                -
                                                <?= html_escape($k->nama_kategori) ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>


                                    <div class="kodering-info text-primary small font-weight-bold mt-1"></div>

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



                        <!-- =================================================
                             TABEL BARANG
                        ================================================== -->

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
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    <tr class="baris-barang">

                                        <td class="nomor-barang text-center">
                                            1
                                        </td>


                                        <td>

                                            <input type="text"
                                                   name="nama_barang[0][]"
                                                   class="form-control nama-barang"
                                                   placeholder="Nama barang/jasa"
                                                   required>

                                        </td>


                                        <td>

                                            <input type="number"
                                                   name="jumlah[0][]"
                                                   class="form-control jumlah-barang"
                                                   min="0.01"
                                                   step="0.01"
                                                   placeholder="0"
                                                   required>

                                        </td>


                                        <td>

                                            <input type="text"
                                                   name="satuan[0][]"
                                                   class="form-control satuan-barang"
                                                   placeholder="Pcs"
                                                   required>

                                        </td>


                                        <td>

                                            <input type="text"
                                                   name="keterangan_detail[0][]"
                                                   class="form-control keterangan-barang"
                                                   placeholder="Opsional">

                                        </td>


                                        <td class="text-center">

                                            <button type="button"
                                                    class="btn btn-outline-danger btn-sm btn-hapus-barang"
                                                    title="Hapus barang">

                                                <i class="fas fa-times"></i>

                                            </button>

                                        </td>

                                    </tr>

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

                Simpan Kebutuhan

            </button>

        </div>


    </form>

</div>



<!-- =========================================================
     STYLE FORM
========================================================= -->

<style>

/* =========================================================
   KELOMPOK KODERING
========================================================= */

.kelompok-kodering {

    border: 1px solid #e3e6f0;

    border-radius: 10px;

    padding: 16px;

    margin-bottom: 20px;

    background: #fff;

    box-shadow: 0 2px 8px rgba(0,0,0,.04);

}


/* =========================================================
   HEADER KODERING
========================================================= */

.kodering-header {

    padding-bottom: 12px;

    border-bottom: 1px solid #eaecf4;

}


/* =========================================================
   TABLE
========================================================= */

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


/* =========================================================
   NOMOR
========================================================= */

.nomor-barang {

    font-weight: 700;

    color: #858796;

}


/* =========================================================
   KODERING INFO
========================================================= */

.kodering-info {

    min-height: 17px;

}


/* =========================================================
   TAMBAH BARANG
========================================================= */

.btn-tambah-barang {

    border-radius: 7px;

}


/* =========================================================
   MOBILE
========================================================= */

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

    const container = document.getElementById('containerKodering');
    const btnTambahKodering = document.getElementById('btnTambahKodering');
    const form = document.getElementById('formKebutuhan');
    const btnSimpan = document.getElementById('btnSimpan');


    /* =====================================================
       TEMPLATE BARIS BARANG
    ===================================================== */

    function buatBarisBarang(indexKelompok) {

        const tr = document.createElement('tr');

        tr.className = 'baris-barang';

        tr.innerHTML = `
            <td class="nomor-barang text-center">
                1
            </td>

            <td>

                <input type="text"
                       name="nama_barang[${indexKelompok}][]"
                       class="form-control nama-barang"
                       placeholder="Nama barang/jasa"
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
                       required>

            </td>

            <td>

                <input type="text"
                       name="keterangan_detail[${indexKelompok}][]"
                       class="form-control keterangan-barang"
                       placeholder="Opsional">

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

        const rows = kelompok.querySelectorAll('.baris-barang');

        rows.forEach(function (row, index) {

            const nomor = row.querySelector('.nomor-barang');

            if (nomor) {
                nomor.textContent = index + 1;
            }

        });

    }


    /* =====================================================
       UPDATE SEMUA INDEX KELOMPOK
       
       Penting supaya:
       
       nama_barang[0][]
       nama_barang[1][]
       nama_barang[2][]
       
       tetap berurutan setelah kelompok dihapus.
    ===================================================== */

    function updateIndexKelompok() {

        const kelompokList =
            container.querySelectorAll('.kelompok-kodering');

        kelompokList.forEach(function (kelompok, indexKelompok) {

            kelompok.dataset.index = indexKelompok;


            /*
             * Kodering
             */

            const select =
                kelompok.querySelector('.kodering-select');

            if (select) {

                select.name =
                    'id_kategori[' + indexKelompok + ']';

            }


            /*
             * Semua barang
             */

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
            container.querySelectorAll('.kelompok-kodering');

        const jumlah =
            kelompokList.length;


        kelompokList.forEach(function (kelompok) {

            const tombol =
                kelompok.querySelector('.btn-hapus-kodering');

            if (!tombol) {
                return;
            }


            if (jumlah <= 1) {

                tombol.style.display = 'none';

            } else {

                tombol.style.display = 'inline-block';

            }

        });

    }


    /* =====================================================
       TAMBAH BARANG
    ===================================================== */

    container.addEventListener('click', function (event) {

        const tombol =
            event.target.closest('.btn-tambah-barang');


        if (!tombol) {
            return;
        }


        const kelompok =
            tombol.closest('.kelompok-kodering');


        if (!kelompok) {
            return;
        }


        /*
         * Ambil index kelompok sekarang.
         */

        const semuaKelompok =
            Array.from(
                container.querySelectorAll('.kelompok-kodering')
            );


        const indexKelompok =
            semuaKelompok.indexOf(kelompok);


        /*
         * Cari tbody.
         */

        const tbody =
            kelompok.querySelector('tbody');


        if (!tbody) {
            return;
        }


        /*
         * Tambahkan baris baru.
         */

        const baris =
            buatBarisBarang(indexKelompok);


        tbody.appendChild(baris);


        /*
         * Update nomor.
         */

        updateNomorBarang(kelompok);


        /*
         * Fokus otomatis ke nama barang baru.
         */

        const inputNama =
            baris.querySelector('.nama-barang');


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
            event.target.closest('.btn-hapus-barang');


        if (!tombol) {
            return;
        }


        const kelompok =
            tombol.closest('.kelompok-kodering');


        const baris =
            tombol.closest('.baris-barang');


        if (!kelompok || !baris) {
            return;
        }


        const jumlahBaris =
            kelompok.querySelectorAll('.baris-barang').length;


        if (jumlahBaris <= 1) {

            alert(
                'Minimal satu barang harus tersedia pada setiap kodering.'
            );

            return;
        }


        baris.remove();


        updateNomorBarang(kelompok);

        updateIndexKelompok();

    });


    /* =====================================================
       TAMBAH KODERING
    ===================================================== */

    btnTambahKodering.addEventListener('click', function () {

        const kelompokPertama =
            container.querySelector('.kelompok-kodering');


        if (!kelompokPertama) {
            return;
        }


        /*
         * Clone kelompok.
         */

        const kelompok =
            kelompokPertama.cloneNode(true);


        /*
         * Reset select kodering.
         */

        const select =
            kelompok.querySelector('.kodering-select');


        if (select) {

            select.value = '';

            select.name = '';

        }


        /*
         * Reset informasi kodering.
         */

        const info =
            kelompok.querySelector('.kodering-info');


        if (info) {

            info.textContent = '';

        }


        /*
         * Kosongkan semua barang.
         */

        const tbody =
            kelompok.querySelector('tbody');


        if (tbody) {

            tbody.innerHTML = '';

        }


        /*
         * Tambahkan satu baris barang awal.
         */

        const indexBaru =
            container.querySelectorAll('.kelompok-kodering').length;


        if (tbody) {

            tbody.appendChild(
                buatBarisBarang(indexBaru)
            );

        }


        /*
         * Masukkan kelompok baru.
         */

        container.appendChild(kelompok);


        /*
         * Rapikan index.
         */

        updateIndexKelompok();

        updateTombolHapusKodering();


        /*
         * Fokus ke kodering baru.
         */

        if (select) {

            setTimeout(function () {

                select.focus();

            }, 50);

        }

    });


    /* =====================================================
       HAPUS KODERING
    ===================================================== */

    container.addEventListener('click', function (event) {

        const tombol =
            event.target.closest('.btn-hapus-kodering');


        if (!tombol) {
            return;
        }


        const kelompok =
            tombol.closest('.kelompok-kodering');


        if (!kelompok) {
            return;
        }


        const jumlahKelompok =
            container.querySelectorAll('.kelompok-kodering').length;


        if (jumlahKelompok <= 1) {

            alert(
                'Minimal satu kodering harus tersedia.'
            );

            return;
        }


        const konfirmasi =
            confirm(
                'Hapus kelompok kodering beserta seluruh barang di dalamnya?'
            );


        if (!konfirmasi) {
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
            event.target.closest('.kodering-select');


        if (!select) {
            return;
        }


        const kelompok =
            select.closest('.kelompok-kodering');


        if (!kelompok) {
            return;
        }


        const info =
            kelompok.querySelector('.kodering-info');


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

    form.addEventListener('submit', function (event) {

        let valid = true;

        const kelompokList =
            container.querySelectorAll('.kelompok-kodering');


        if (kelompokList.length === 0) {

            event.preventDefault();

            alert(
                'Minimal satu kodering harus tersedia.'
            );

            return;

        }


        kelompokList.forEach(function (kelompok) {

            if (!valid) {
                return;
            }


            /*
             * Cek kodering
             */

            const select =
                kelompok.querySelector('.kodering-select');


            if (!select || !select.value) {

                valid = false;

                select.focus();

                return;

            }


            /*
             * Cek semua barang
             */

            const rows =
                kelompok.querySelectorAll('.baris-barang');


            if (rows.length === 0) {

                valid = false;

                return;

            }


            rows.forEach(function (row) {

                if (!valid) {
                    return;
                }


                const nama =
                    row.querySelector('.nama-barang');


                const jumlah =
                    row.querySelector('.jumlah-barang');


                const satuan =
                    row.querySelector('.satuan-barang');


                const namaValue =
                    nama
                        ? nama.value.trim()
                        : '';


                const jumlahValue =
                    jumlah
                        ? parseFloat(jumlah.value)
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

            });

        });


        if (!valid) {

            event.preventDefault();

            alert(
                'Mohon lengkapi kodering dan seluruh data barang terlebih dahulu.'
            );

            return;

        }


        /*
         * Pastikan struktur name sudah rapi
         * sebelum dikirim ke controller.
         */

        updateIndexKelompok();


        /*
         * Hindari double submit.
         */

        btnSimpan.disabled = true;

        btnSimpan.innerHTML =
            '<i class="fas fa-spinner fa-spin mr-1"></i>' +
            ' Menyimpan...';

    });


    /* =====================================================
       INIT
    ===================================================== */

    updateIndexKelompok();

    updateTombolHapusKodering();

});

</script>