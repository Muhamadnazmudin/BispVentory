<!-- =========================================================
     CONTENT WRAPPER
========================================================= -->

<div id="content-wrapper" class="d-flex flex-column">

    <!-- =====================================================
         MAIN CONTENT
    ====================================================== -->

    <div id="content">


        <!-- =================================================
             TOPBAR
        ================================================== -->

        <nav
            class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"
        >


            <!-- =============================================
                 MOBILE SIDEBAR TOGGLE
            ============================================== -->

            <button
                id="sidebarToggleTop"
                class="btn btn-link d-md-none rounded-circle mr-3"
                type="button"
                aria-label="Buka menu"
            >

                <i class="fa fa-bars"></i>

            </button>


            <!-- =============================================
                 TOPBAR RIGHT
            ============================================== -->

            <ul class="navbar-nav ml-auto">


                <!-- =========================================
                     DARK MODE
                ========================================== -->

                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="#"
                        id="toggleDarkMode"
                        title="Dark Mode"
                    >

                        <i class="fas fa-moon"></i>

                    </a>

                </li>


                <!-- =========================================
                     USER
                ========================================== -->

                <li class="nav-item dropdown no-arrow">

                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        id="userDropdown"
                        role="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >

                        <span
                            class="mr-2 d-none d-lg-inline text-gray-600 small"
                        >
                            <?= htmlspecialchars(
                                (string) $this->session->userdata('nama'),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </span>


                        <img
                            class="img-profile rounded-circle"
                            src="<?= base_url('assets/sbadmin2/img/undraw_profile.svg') ?>"
                            alt="Profile"
                        >

                    </a>


                    <!-- =====================================
                         USER DROPDOWN
                    ====================================== -->

                    <div
                        class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown"
                    >

                        <a
                            class="dropdown-item"
                            href="<?= base_url('auth/logout') ?>"
                        >

                            <i
                                class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"
                            ></i>

                            Logout

                        </a>

                    </div>

                </li>


            </ul>

        </nav>