<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<!-- FILTER -->
<div class="card mb-3">
    <div class="card-body">
        <div class="row">

            <div class="col-md-3">
                <label>Bulan</label>
                <select id="bulan" class="form-control">
                    <option value="">- Semua Bulan -</option>
                    <?php
                    $bulanArr = [
                        1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
                        5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
                        9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
                    ];
                    foreach($bulanArr as $k=>$v):
                    ?>
                        <option value="<?= $k ?>" <?= ($this->input->get('bulan')==$k?'selected':'') ?>>
                            <?= $v ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label>Tahun</label>
                <select id="tahun" class="form-control">
                    <option value="">- Semua Tahun -</option>
                    <?php for($t=date('Y');$t>=2020;$t--): ?>
                        <option value="<?= $t ?>" <?= ($this->input->get('tahun')==$t?'selected':'') ?>>
                            <?= $t ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="col-md-3 align-self-end">
                <button type="button" id="btnFilter" class="btn btn-primary">
                    <i class="fas fa-search"></i> Filter
                </button>
                <a href="<?= base_url('laporan/stok') ?>" class="btn btn-secondary">
                    Reset
                </a>
            </div>

            <div class="col-md-3 text-right align-self-end">
                <a target="_blank"
                   href="<?= base_url('laporan/stok_pdf?'.http_build_query($_GET)) ?>"
                   class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
                <a target="_blank"
                   href="<?= base_url('laporan/stok_excel?'.http_build_query($_GET)) ?>"
                   class="btn btn-success btn-sm">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
            </div>

        </div>
    </div>
</div>

<!-- TABLE -->
<table class="table table-bordered table-striped" id="dataTable">
    <thead class="thead-dark">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Merk</th>
            <th>Satuan</th>
            <th>Sisa Stok</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach($list as $r): ?>
        <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= $r->nama_barang ?></td>
            <td><?= $r->merk ?></td>
            <td class="text-center"><?= $r->satuan ?></td>
            <td class="text-center font-weight-bold"><?= $r->stok ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>

<!-- DATATABLE -->
<script>
if (window.jQuery && $.fn.DataTable) {
    $(function () {
        $('#dataTable').DataTable();
    });
}
</script>

<!-- FILTER REDIRECT -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('btnFilter');

    btn.addEventListener('click', function () {
        const bulan = document.getElementById('bulan').value;
        const tahun = document.getElementById('tahun').value;

        let query = [];

        if (bulan !== '') query.push('bulan=' + bulan);
        if (tahun !== '') query.push('tahun=' + tahun);

        let url = '<?= site_url('laporan/stok') ?>';
        if (query.length > 0) {
            url += '?' + query.join('&');
        }

        window.location.assign(url);
    });
});
</script>

