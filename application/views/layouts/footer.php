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

    // 🔥 EVENT SELECT2
    $('#barangSelect')
        .on('select2:select', setBarangInfo)
        .on('change', setBarangInfo);

    // 🔁 untuk mode edit
    setBarangInfo();
});
</script>

</body>
</html>
