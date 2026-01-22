<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
</button>

<ul class="navbar-nav ml-auto">

    <!-- 🌙 Dark Mode Toggle -->
    <li class="nav-item">
        <a class="nav-link" href="#" id="toggleDarkMode" title="Dark Mode">
            <i class="fas fa-moon"></i>
        </a>
    </li>

    <!-- User Dropdown -->
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                <?= $this->session->userdata('nama') ?>
            </span>
            <img class="img-profile rounded-circle"
                 src="<?= base_url('assets/sbadmin2/img/undraw_profile.svg') ?>">
        </a>
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
            <a class="dropdown-item" href="<?= base_url('auth/logout') ?>">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
            </a>
        </div>
    </li>

</ul>

</nav>
