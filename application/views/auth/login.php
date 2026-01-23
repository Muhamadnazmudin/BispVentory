<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Login | BIS Inventory</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="<?= base_url('assets/sbadmin2/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/sbadmin2/css/sb-admin-2.min.css') ?>" rel="stylesheet">

<style>
body {
    min-height: 100vh;
    background: linear-gradient(135deg, #1e3a8a, #2563eb);
}

/* Card Login */
.login-card {
    border-radius: 16px;
}

/* Logo */
.login-logo img {
    max-width: 90px;
}

/* Input */
.form-control {
    border-radius: 8px;
    padding-left: 40px;
}

.input-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

/* Button */
.btn-login {
    border-radius: 8px;
    font-weight: bold;
}

/* Footer */
.login-footer {
    font-size: 12px;
    color: #6c757d;
}

/* Mobile spacing */
@media (max-width: 576px) {
    .login-card {
        margin-top: 20px;
    }
}
</style>
</head>

<body>

<div class="container d-flex align-items-center justify-content-center" style="min-height:100vh">
<div class="row w-100 justify-content-center">

<div class="col-xl-4 col-lg-5 col-md-7 col-sm-10">

<div class="card login-card shadow-lg border-0">
<div class="card-body p-4 p-md-5">

<!-- LOGO -->
<div class="text-center login-logo mb-3">
    <img src="<?= base_url('assets/img/logobispar.png') ?>" alt="Logo">
</div>

<!-- TITLE -->
<div class="text-center mb-4">
    <h4 class="font-weight-bold text-gray-800 mb-1">Bispventory</h4>
    <small class="text-muted">Bispar Inventaris Sekolah</small>
</div>

<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger text-center py-2">
    <?= $this->session->flashdata('error') ?>
</div>
<?php endif; ?>

<form method="post">

<!-- USERNAME -->
<div class="form-group position-relative">
    <span class="input-icon">
        <i class="fas fa-user"></i>
    </span>
    <input type="text"
           name="username"
           class="form-control"
           placeholder="Username"
           required autofocus>
</div>

<!-- PASSWORD -->
<div class="form-group position-relative">
    <span class="input-icon">
        <i class="fas fa-lock"></i>
    </span>

    <input type="password"
           name="password"
           id="password"
           class="form-control"
           placeholder="Password"
           required>

    <!-- EYE ICON -->
    <span class="input-icon"
          style="right:12px; left:auto; cursor:pointer;"
          onclick="togglePassword()">
        <i class="fas fa-eye" id="eyeIcon"></i>
    </span>
</div>


<button type="submit" class="btn btn-primary btn-block btn-login mt-4">
    <i class="fas fa-sign-in-alt mr-1"></i> Login
</button>

</form>

<hr>

<div class="text-center login-footer">
    © <?= date('Y') ?> Anggi Juliansyah
</div>

</div>
</div>

</div>
</div>
</div>

<script src="<?= base_url('assets/sbadmin2/vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

</body>
</html>
<script>
function togglePassword() {
    const password = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');

    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
