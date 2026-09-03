<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="h3 mb-1 text-gray-800">
                Detail Kebutuhan
            </h1>

            <div class="text-muted small">
                <?= html_escape($kebutuhan->nomor_surat) ?>
            </div>

        </div>

        <a href="<?= base_url('spj/input_kebutuhan') ?>"
           class="btn btn-secondary">

            <i class="fas fa-arrow-left mr-1"></i>
            Kembali

        </a>

    </div>


    <div class="card shadow mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <strong>Nomor Surat</strong>

                    <div>
                        <?= html_escape(
                            $kebutuhan->nomor_surat
                        ) ?>
                    </div>

                </div>


                <div class="col-md-6">

                    <strong>Tanggal</strong>

                    <div>
                        <?= date(
                            'd-m-Y',
                            strtotime($kebutuhan->tanggal)
                        ) ?>
                    </div>

                </div>


                <div class="col-md-12 mt-3">

                    <strong>Perihal</strong>

                    <div>
                        <?= html_escape(
                            $kebutuhan->perihal
                        ) ?>
                    </div>

                </div>


                <?php if (!empty($kebutuhan->kegiatan)): ?>

                    <div class="col-md-12 mt-3">

                        <strong>Kegiatan</strong>

                        <div>
                            <?= html_escape(
                                $kebutuhan->kegiatan
                            ) ?>
                        </div>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>


    <div class="card shadow mb-4">

        <div class="card-header">

            <strong class="text-primary">
                Rincian Kebutuhan
            </strong>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead class="thead-light">

                        <tr>

                            <th width="5%">No</th>

                            <th>Kodering</th>

                            <th>Nama Barang/Jasa</th>

                            <th width="10%">Jumlah</th>

                            <th width="12%">Satuan</th>

                            <th>Keterangan</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php $no = 1; ?>

                        <?php foreach ($detail as $row): ?>

                            <tr>

                                <td>
                                    <?= $no++ ?>
                                </td>

                                <td>
                                    <?= html_escape(
                                        $row->kodering
                                    ) ?>
                                </td>

                                <td>
                                    <?= html_escape(
                                        $row->nama_barang
                                    ) ?>
                                </td>

                                <td>
                                    <?= rtrim(
                                        rtrim(
                                            number_format(
                                                $row->jumlah,
                                                2,
                                                ',',
                                                '.'
                                            ),
                                            '0'
                                        ),
                                        ','
                                    ) ?>
                                </td>

                                <td>
                                    <?= html_escape(
                                        $row->satuan
                                    ) ?>
                                </td>

                                <td>
                                    <?= html_escape(
                                        $row->keterangan
                                    ) ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!--
    =========================================================
    NANTI TOMBOL PDF DI SINI
    =========================================================

    <a href="<?= base_url(
        'spj/bast_internal/' .
        $kebutuhan->id_kebutuhan
    ) ?>"
       class="btn btn-primary">

        <i class="fas fa-file-pdf"></i>
        BAST Internal

    </a>

    <a href="<?= base_url(
        'spj/bast_pemeriksaan/' .
        $kebutuhan->id_kebutuhan
    ) ?>"
       class="btn btn-success">

        <i class="fas fa-file-pdf"></i>
        BAST Pemeriksaan

    </a>
    -->

</div>