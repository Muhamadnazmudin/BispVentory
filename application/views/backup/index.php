<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
    <?= $this->session->flashdata('success') ?>
</div>
<?php endif; ?>

<div class="row">

    <!-- BACKUP -->
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                Backup Database
            </div>
            <div class="card-body">
                <p>
                    Download file backup database (.sql)
                </p>
                <a href="<?= base_url('backup/backup_db') ?>"
                   class="btn btn-success">
                   <i class="fas fa-database"></i> Backup Database
                </a>
            </div>
        </div>
    </div>

    <!-- RESTORE -->
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-warning text-white">
                Restore Database
            </div>
            <div class="card-body">
                <form method="post"
                      action="<?= base_url('backup/restore_db') ?>"
                      enctype="multipart/form-data">

                    <div class="form-group">
                        <input type="file"
                               name="file_sql"
                               class="form-control"
                               accept=".sql"
                               required>
                    </div>

                    <button class="btn btn-warning"
                            onclick="return confirm('Restore akan menimpa data. Lanjutkan?')">
                        <i class="fas fa-upload"></i> Restore Database
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
</div>
