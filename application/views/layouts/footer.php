</div> <!-- End of Main Content -->
<footer class="sticky-footer bg-white">
<div class="container my-auto">
<div class="copyright text-center my-auto">
<span>© <?= date('Y') ?> BIS Inventory Sekolah</span>
</div>
</div>
</footer>
</div> <!-- End of Content Wrapper -->
</div> <!-- End of Page Wrapper -->



<!-- jQuery (WAJIB PERTAMA & SATU-SATUNYA) -->
<script src="<?= base_url('assets/sbadmin2/vendor/jquery/jquery.min.js') ?>"></script>

<!-- Bootstrap -->
<script src="<?= base_url('assets/sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<!-- jQuery Easing -->
<script src="<?= base_url('assets/sbadmin2/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

<!-- SB Admin 2 -->
<script src="<?= base_url('assets/sbadmin2/js/sb-admin-2.min.js') ?>"></script>

<!-- DataTables -->
<script src="<?= base_url('assets/sbadmin2/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>




<script>
document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById('toggleDarkMode');
    const body = document.body;
    const icon = toggle.querySelector('i');

    // Load dark mode preference
    if (localStorage.getItem('darkMode') === 'enabled') {
        body.classList.add('dark-mode');
        icon.classList.replace('fa-moon', 'fa-sun');
    }

    toggle.addEventListener('click', function (e) {
        e.preventDefault();
        body.classList.toggle('dark-mode');

        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('darkMode', 'enabled');
            icon.classList.replace('fa-moon', 'fa-sun');
        } else {
            localStorage.setItem('darkMode', 'disabled');
            icon.classList.replace('fa-sun', 'fa-moon');
        }
    });
});
</script>
<script>
$(document).ready(function () {
    if ($('#barangSelect').length) {
        $('#barangSelect').select2({
            placeholder: '- Pilih Barang -',
            width: '100%',
            minimumResultsForSearch: 0
        });
    }
});
</script>
<script>
$(document).ready(function () {

    function formatRupiah(angka){
        return new Intl.NumberFormat('id-ID').format(angka);
    }

    function setBarangInfo() {
        const opt = $('#barangSelect option:selected');
        if (!opt.length) return;

        $('[name="satuan"]').val(opt.data('satuan') || '');
        $('[name="merk"]').val(opt.data('merk') || '');

        const harga = opt.data('harga') || 0;
        $('[name="harga_view"]').val(harga ? formatRupiah(harga) : '');
        $('[name="harga"]').val(harga);
    }

    // select2 untukselect
    $('#barangSelect')
        .on('select2:select', setBarangInfo)
        .on('change', setBarangInfo);

    // 🔁 untuk mode edit
    setBarangInfo();
});
</script>
<script>
$(document).ready(function () {

    /* =========================
       SELECT2 GURU & SISWA
    ========================= */
    $('.select2-guru').select2({
        placeholder: '- Pilih Guru -',
        width: '100%',
        minimumResultsForSearch: 0
    });

    $('.select2-siswa').select2({
        placeholder: '- Pilih Siswa -',
        width: '100%',
        minimumResultsForSearch: 0
    });

    /* =========================
       SELECT2 BARANG (SEMUA ROW)
       INIT SEKALI SAJA
    ========================= */
    $('.barangSelect').select2({
        placeholder: '- Pilih Barang -',
        width: '100%',
        minimumResultsForSearch: 0
    });

    /* =========================
       EVENT BARANG (STOK)
       DELEGATION (AMAN)
    ========================= */
    $(document).on('select2:select', '.barangSelect', function () {
        const opt   = $(this).find('option:selected');
        const stok  = opt.data('stok') || 0;
        const row   = $(this).closest('tr');

        row.find('.stokView').val(stok);
        row.find('.jumlahInput').attr('max', stok);
    });

    $(document).on('input', '.jumlahInput', function () {
        const max = parseInt($(this).attr('max') || 0);
        if (parseInt(this.value) > max) {
            alert('Jumlah melebihi stok tersedia');
            this.value = max;
        }
    });

});
</script>


</body>
</html>
