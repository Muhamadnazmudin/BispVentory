<div class="container-fluid">

    <div class="d-flex align-items-center justify-content-between mb-4">

        <div>

            <h1 class="h3 mb-1 text-gray-800">
                BAST Internal
            </h1>

            <div class="text-muted small">
                Berita Acara Serah Terima Internal
            </div>

        </div>

    </div>


    <?php if ($this->session->flashdata('success')): ?>

        <div class="alert alert-success">
            <?= $this->session->flashdata('success') ?>
        </div>

    <?php endif; ?>


    <?php if ($this->session->flashdata('error')): ?>

        <div class="alert alert-danger">
            <?= $this->session->flashdata('error') ?>
        </div>

    <?php endif; ?>


    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <strong class="text-primary">

                <i class="fas fa-file-signature mr-1"></i>

                Daftar BAST Internal

            </strong>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead class="thead-light">

                        <tr>

                            <th width="5%" class="text-center">
                                No
                            </th>

                            <th>
                                Nomor Surat
                            </th>

                            <th>
                                Perihal
                            </th>

                            <th width="13%">
                                Tanggal
                            </th>

                            <th width="10%" class="text-center">
                                Item
                            </th>

                            <th width="15%" class="text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php if (!empty($kebutuhan)): ?>

                            <?php $no = 1; ?>

                            <?php foreach ($kebutuhan as $row): ?>

                                <tr>

                                    <td class="text-center">
                                        <?= $no++ ?>
                                    </td>


                                    <td>
                                        <?= html_escape($row->nomor_surat) ?>
                                    </td>


                                    <td>
                                        <?= html_escape($row->perihal) ?>
                                    </td>


                                    <td>

                                        <?= !empty($row->tanggal)
                                            ? date('d-m-Y', strtotime($row->tanggal))
                                            : '-'
                                        ?>

                                    </td>


                                    <td class="text-center">

                                        <span class="badge badge-info">
                                            <?= (int) $row->jumlah_item ?>
                                        </span>

                                    </td>


                                    <td class="text-center">

                                        <a href="<?= base_url('spj/detail_kebutuhan/' . $row->id_kebutuhan) ?>"
   class="btn btn-info btn-sm"
   title="Lihat">

    <i class="fas fa-eye"></i>

</a>


<a href="<?= base_url('spj/edit_bast_internal/' . $row->id_kebutuhan) ?>"
   class="btn btn-warning btn-sm"
   title="Edit BAST">

    <i class="fas fa-edit"></i>

</a>


<a href="<?= base_url('spj/cetak_bast_internal/' . $row->id_kebutuhan) ?>"
   class="btn btn-danger btn-sm"
   title="Cetak PDF">

    <i class="fas fa-file-pdf"></i>

</a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td colspan="6"
                                    class="text-center text-muted py-4">

                                    Belum ada data kebutuhan.

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>