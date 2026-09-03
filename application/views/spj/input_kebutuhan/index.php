<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>
            <h1 class="h3 mb-1 text-gray-800">
                Input Kebutuhan
            </h1>

            <div class="text-muted small">
                Pengajuan kebutuhan barang/jasa sekolah
            </div>
        </div>

        <a href="<?= base_url('spj/tambah_kebutuhan') ?>"
           class="btn btn-primary">

            <i class="fas fa-plus mr-1"></i>
            Input Kebutuhan

        </a>

    </div>


    <?php if ($this->session->flashdata('success')): ?>

        <div class="alert alert-success">
            <i class="fas fa-check-circle mr-1"></i>
            <?= $this->session->flashdata('success') ?>
        </div>

    <?php endif; ?>


    <?php if ($this->session->flashdata('error')): ?>

        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle mr-1"></i>
            <?= $this->session->flashdata('error') ?>
        </div>

    <?php endif; ?>


    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Kebutuhan
            </h6>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="thead-light">

                        <tr>

                            <th width="5%">No</th>

                            <th>Nomor Surat</th>

                            <th>Perihal</th>

                            <th>Tanggal</th>

                            <th width="10%" class="text-center">
                                Item
                            </th>

                            <th width="18%" class="text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php if (!empty($kebutuhan)): ?>

                            <?php $no = 1; ?>

                            <?php foreach ($kebutuhan as $row): ?>

                                <tr>

                                    <td>
                                        <?= $no++ ?>
                                    </td>

                                    <td>
                                        <?= html_escape(
                                            $row->nomor_surat
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= html_escape(
                                            $row->perihal
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= date(
                                            'd-m-Y',
                                            strtotime($row->tanggal)
                                        ) ?>
                                    </td>

                                    <td class="text-center">

                                        <span class="badge badge-info">
                                            <?= (int) $row->jumlah_item ?>
                                        </span>

                                    </td>

                                    <td class="text-center">

                                        <div class="d-flex justify-content-center">

    <!-- DETAIL -->
    <a href="<?= base_url('spj/detail_kebutuhan/' . $row->id_kebutuhan) ?>"
       class="btn btn-info btn-sm mr-1"
       title="Lihat Detail">

        <i class="fas fa-eye"></i>

    </a>


    <!-- EDIT -->
    <a href="<?= base_url('spj/edit_kebutuhan/' . $row->id_kebutuhan) ?>"
       class="btn btn-warning btn-sm mr-1"
       title="Edit Kebutuhan">

        <i class="fas fa-edit"></i>

    </a>


    <!-- PDF -->
    <a href="<?= base_url('spj/cetak_kebutuhan/' . $row->id_kebutuhan) ?>"
       class="btn btn-danger btn-sm mr-1"
       target="_blank"
       title="Cetak PDF">

        <i class="fas fa-file-pdf"></i>

    </a>


    <!-- HAPUS -->
    <a href="<?= base_url('spj/hapus_kebutuhan/' . $row->id_kebutuhan) ?>"
       class="btn btn-danger btn-sm"
       title="Hapus"
       onclick="return confirm('Yakin ingin menghapus data kebutuhan ini?')">

        <i class="fas fa-trash"></i>

    </a>

</div>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td colspan="6"
                                    class="text-center text-muted py-4">

                                    <i class="fas fa-folder-open fa-2x mb-2"></i>

                                    <div>
                                        Belum ada data kebutuhan.
                                    </div>

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>