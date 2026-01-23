<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <!-- FILTER -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="get" action="<?= base_url('laporan/masuk') ?>">
                <div class="row">

                    <div class="col-md-3">
                        <label>Bulan</label>
                        <select name="bulan" class="form-control">
                            <option value="">- Semua Bulan -</option>
                            <?php
                            $bulan = [
                                1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
                                5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
                                9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
                            ];
                            foreach ($bulan as $key=>$val):
                            ?>
                            <option value="<?= $key ?>"
                                <?= ($this->input->get('bulan')==$key?'selected':'') ?>>
                                <?= $val ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Tahun</label>
                        <select name="tahun" class="form-control">
                            <option value="">- Semua Tahun -</option>
                            <?php for($t=date('Y'); $t>=2020; $t--): ?>
                                <option value="<?= $t ?>"
                                    <?= ($this->input->get('tahun')==$t?'selected':'') ?>>
                                    <?= $t ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="col-md-3 align-self-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="<?= base_url('laporan/masuk') ?>" class="btn btn-secondary">
                            Reset
                        </a>
                    </div>

                    <div class="col-md-3 text-right align-self-end">
                        <a href="<?= base_url('laporan/barang_masuk_pdf?'.http_build_query($_GET)) ?>"
   target="_blank"
   class="btn btn-danger btn-sm">
    <i class="fas fa-file-pdf"></i> PDF
</a>

                        <a href="<?= base_url('laporan/barang_masuk_excel?'.http_build_query($_GET)) ?>"
                           class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Excel
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- TABEL -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered table-striped" id="dataTable" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Barang</th>
                            <th>Merk</th>
                            <th>Jumlah</th>
                            <th>Perolehan</th>
                            <th>Toko</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($list as $r): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d-m-Y',strtotime($r->tanggal)) ?></td>
                            <td><?= $r->nama_barang ?></td>
                            <td><?= $r->merk ?></td>
                            <td><?= $r->jumlah ?></td>
                            <td><?= $r->perolehan ?></td>
                            <td><?= $r->toko ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>

<!-- DATATABLES -->
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        "pageLength": 10,
        "lengthMenu": [10, 25, 50, 100],
        "ordering": true,
        "responsive": true,
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data",
            "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            "paginate": {
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        }
    });
});
</script>
