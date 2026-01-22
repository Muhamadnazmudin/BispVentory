<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Login | BIS Inventory</title>

<link href="<?= base_url('assets/sbadmin2/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/sbadmin2/css/sb-admin-2.min.css') ?>" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

<div class="container">
<div class="row justify-content-center">
<div class="col-xl-5 col-lg-6 col-md-8">

<div class="card o-hidden border-0 shadow-lg my-5">
<div class="card-body p-4">

<div class="text-center">
<h1 class="h4 text-gray-900 mb-4">Login Admin</h1>
</div>

<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger">
<?= $this->session->flashdata('error') ?>
</div>
<?php endif ?>

<form method="post">
<div class="form-group">
<input type="text" name="username" class="form-control"
placeholder="Username" required>
</div>

<div class="form-group">
<input type="password" name="password" class="form-control"
placeholder="Password" required>
</div>

<button class="btn btn-primary btn-block">
Login
</button>
</form>

</div>
</div>

</div>
</div>
</div>

<script src="<?= base_url('assets/sbadmin2/vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
