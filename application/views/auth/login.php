<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="theme-color"
        content="#4e73df"
    >

    <title>
        Login | BispVentory
    </title>


    <!-- =====================================================
         SB ADMIN 2
    ====================================================== -->

    <link
        href="<?= base_url('assets/sbadmin2/vendor/fontawesome-free/css/all.min.css') ?>"
        rel="stylesheet"
    >

    <link
        href="<?= base_url('assets/sbadmin2/css/sb-admin-2.min.css') ?>"
        rel="stylesheet"
    >


    <style>

        /* =====================================================
           RESET
        ====================================================== */

        * {
            box-sizing: border-box;
        }


        html,
        body {
            min-height: 100%;
        }


        body {

            margin: 0;

            min-height: 100vh;

            font-family:
                "Nunito",
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #eef3ff 0%,
                    #f7f9fc 45%,
                    #e9efff 100%
                );

            color: #343a40;

            overflow-x: hidden;
        }


        /* =====================================================
           PAGE
        ====================================================== */

        .login-page {

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 30px 15px;

            position: relative;

            overflow: hidden;
        }


        /* =====================================================
           BACKGROUND DECORATION
        ====================================================== */

        .login-page::before {

            content: "";

            position: absolute;

            width: 420px;
            height: 420px;

            top: -180px;
            right: -120px;

            border-radius: 50%;

            background:
                rgba(78,115,223,.12);
        }


        .login-page::after {

            content: "";

            position: absolute;

            width: 300px;
            height: 300px;

            bottom: -160px;
            left: -100px;

            border-radius: 50%;

            background:
                rgba(54,185,204,.10);
        }


        /* =====================================================
           LOGIN WRAPPER
        ====================================================== */

        .login-wrapper {

            width: 100%;

            max-width: 440px;

            position: relative;

            z-index: 2;
        }


        /* =====================================================
           CARD
        ====================================================== */

        .login-card {

            border: 0;

            border-radius: 20px;

            overflow: hidden;

            background: #fff;

            box-shadow:
                0 15px 45px rgba(31,45,61,.12);
        }


        .login-card-body {

            padding: 42px 42px 35px;
        }


        /* =====================================================
           BRAND
        ====================================================== */

        .login-brand {

            text-align: center;

            margin-bottom: 28px;
        }


        .login-logo {

            width: 82px;
            height: 82px;

            display: flex;

            align-items: center;
            justify-content: center;

            margin: 0 auto 16px;

            padding: 10px;

            border-radius: 20px;

            background: #f0f4ff;

            box-shadow:
                0 5px 15px rgba(78,115,223,.08);
        }


        .login-logo img {

            width: 100%;
            height: 100%;

            object-fit: contain;
        }


        .login-title {

            margin: 0;

            color: #263238;

            font-size: 1.55rem;

            font-weight: 800;

            letter-spacing: -.3px;
        }


        .login-subtitle {

            margin: 5px 0 0;

            color: #858796;

            font-size: .78rem;
        }


        /* =====================================================
           ALERT
        ====================================================== */

        .login-alert {

            display: flex;

            align-items: center;

            gap: 10px;

            margin-bottom: 20px;

            padding: 11px 13px;

            border: 0;

            border-radius: 10px;

            background: #fff1f0;

            color: #c0392b;

            font-size: .78rem;
        }


        .login-alert i {

            font-size: .95rem;
        }


        /* =====================================================
           FORM
        ====================================================== */

        .form-label {

            display: block;

            margin-bottom: 7px;

            color: #5a5c69;

            font-size: .75rem;

            font-weight: 700;
        }


        .login-input-group {

            position: relative;

            margin-bottom: 18px;
        }


        .login-input {

            width: 100%;

            height: 48px;

            padding:
                10px
                45px
                10px
                45px;

            border: 1px solid #dfe3eb;

            border-radius: 10px;

            background: #fbfcff;

            color: #343a40;

            font-size: .84rem;

            outline: none;

            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                background .2s ease;
        }


        .login-input::placeholder {

            color: #adb3bf;
        }


        .login-input:hover {

            background: #fff;

            border-color: #cbd2df;
        }


        .login-input:focus {

            background: #fff;

            border-color: #4e73df;

            box-shadow:
                0 0 0 3px rgba(78,115,223,.12);
        }


        .input-left-icon {

            position: absolute;

            left: 16px;

            top: 50%;

            transform: translateY(-50%);

            color: #9aa2b1;

            pointer-events: none;

            font-size: .85rem;

            z-index: 2;
        }


        .password-toggle {

            position: absolute;

            right: 15px;

            top: 50%;

            transform: translateY(-50%);

            width: 25px;
            height: 25px;

            display: flex;

            align-items: center;
            justify-content: center;

            border: 0;

            background: transparent;

            color: #9aa2b1;

            cursor: pointer;

            padding: 0;

            z-index: 3;
        }


        .password-toggle:hover {

            color: #4e73df;
        }


        /* =====================================================
           BUTTON
        ====================================================== */

        .btn-login {

            width: 100%;

            height: 48px;

            display: flex;

            align-items: center;
            justify-content: center;

            gap: 8px;

            margin-top: 8px;

            border: 0;

            border-radius: 10px;

            background:
                linear-gradient(
                    135deg,
                    #4e73df,
                    #3b5fc5
                );

            color: #fff;

            font-size: .84rem;

            font-weight: 700;

            box-shadow:
                0 6px 15px rgba(78,115,223,.20);

            transition:
                transform .15s ease,
                box-shadow .15s ease,
                opacity .15s ease;
        }


        .btn-login:hover {

            color: #fff;

            transform: translateY(-1px);

            box-shadow:
                0 8px 18px rgba(78,115,223,.28);
        }


        .btn-login:active {

            transform: translateY(0);
        }


        .btn-login:disabled {

            opacity: .75;

            cursor: not-allowed;

            transform: none;
        }


        /* =====================================================
           FOOTER
        ====================================================== */

        .login-footer {

            margin-top: 25px;

            padding-top: 20px;

            border-top: 1px solid #edf0f5;

            text-align: center;

            color: #9aa0ad;

            font-size: .7rem;

            line-height: 1.6;
        }


        .login-footer strong {

            color: #6c7280;

            font-weight: 700;
        }


        /* =====================================================
           MOBILE
        ====================================================== */

        @media (max-width: 576px) {

            .login-page {

                padding:
                    20px
                    15px;
            }


            .login-card-body {

                padding:
                    32px
                    24px
                    25px;
            }


            .login-logo {

                width: 72px;
                height: 72px;

                border-radius: 17px;
            }


            .login-title {

                font-size: 1.35rem;
            }


            .login-subtitle {

                font-size: .74rem;
            }

        }


    </style>

</head>


<body>


<div class="login-page">


    <div class="login-wrapper">


        <div class="card login-card">


            <div class="login-card-body">


                <!-- =================================================
                     BRAND
                ================================================== -->

                <div class="login-brand">


                    <div class="login-logo">

                        <img
                            src="<?= base_url('assets/img/logobispar.png') ?>"
                            alt="Logo BispVentory"
                        >

                    </div>


                    <h1 class="login-title">

                        BispVentory

                    </h1>


                    <p class="login-subtitle">

                        Sistem Informasi Inventaris Sekolah

                    </p>


                </div>



                <!-- =================================================
                     ERROR
                ================================================== -->

                <?php if ($this->session->flashdata('error')): ?>

                    <div
                        class="login-alert"
                        role="alert"
                    >

                        <i class="fas fa-exclamation-circle"></i>

                        <span>

                            <?= html_escape(
                                $this->session->flashdata('error')
                            ) ?>

                        </span>

                    </div>

                <?php endif; ?>



                <!-- =================================================
                     FORM LOGIN
                ================================================== -->

                <form
                    method="post"
                    action="<?= site_url('auth/login') ?>"
                    id="loginForm"
                    autocomplete="on"
                >


                    <?php if (
                        isset($this->security) &&
                        $this->config->item('csrf_protection')
                    ): ?>

                        <input
                            type="hidden"
                            name="<?= $this->security->get_csrf_token_name() ?>"
                            value="<?= $this->security->get_csrf_hash() ?>"
                        >

                    <?php endif; ?>



                    <!-- USERNAME -->

                    <label
                        for="username"
                        class="form-label"
                    >

                        Username

                    </label>


                    <div class="login-input-group">


                        <i
                            class="fas fa-user input-left-icon"
                        ></i>


                        <input
                            type="text"
                            name="username"
                            id="username"
                            class="login-input"
                            placeholder="Masukkan username"
                            autocomplete="username"
                            autocapitalize="none"
                            spellcheck="false"
                            required
                            autofocus
                        >


                    </div>



                    <!-- PASSWORD -->

                    <label
                        for="password"
                        class="form-label"
                    >

                        Password

                    </label>


                    <div class="login-input-group">


                        <i
                            class="fas fa-lock input-left-icon"
                        ></i>


                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="login-input"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >


                        <button
                            type="button"
                            class="password-toggle"
                            id="togglePassword"
                            aria-label="Tampilkan password"
                        >

                            <i
                                class="fas fa-eye"
                                id="eyeIcon"
                            ></i>

                        </button>


                    </div>



                    <!-- LOGIN BUTTON -->

                    <button
                        type="submit"
                        class="btn btn-login"
                        id="loginButton"
                    >

                        <i
                            class="fas fa-sign-in-alt"
                            id="loginIcon"
                        ></i>

                        <span id="loginText">
                            Masuk ke Sistem
                        </span>

                    </button>


                </form>



                <!-- =================================================
                     FOOTER
                ================================================== -->

                <div class="login-footer">

                    © <?= date('Y') ?>

                    <strong>BispVentory</strong>

                    <br>

                    Sistem Inventaris Sekolah

                </div>


            </div>

        </div>


    </div>

</div>



<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>

(function () {


    /* =========================================================
       PASSWORD TOGGLE
    ========================================================== */

    const password =
        document.getElementById('password');

    const toggle =
        document.getElementById('togglePassword');

    const eyeIcon =
        document.getElementById('eyeIcon');


    if (toggle && password) {

        toggle.addEventListener(
            'click',
            function () {

                const isPassword =
                    password.type === 'password';


                password.type =
                    isPassword
                        ? 'text'
                        : 'password';


                eyeIcon.classList.toggle(
                    'fa-eye',
                    !isPassword
                );


                eyeIcon.classList.toggle(
                    'fa-eye-slash',
                    isPassword
                );


                toggle.setAttribute(
                    'aria-label',
                    isPassword
                        ? 'Sembunyikan password'
                        : 'Tampilkan password'
                );

            }
        );

    }



    /* =========================================================
       PREVENT DOUBLE SUBMIT
    ========================================================== */

    const form =
        document.getElementById('loginForm');

    const button =
        document.getElementById('loginButton');

    const text =
        document.getElementById('loginText');

    const icon =
        document.getElementById('loginIcon');


    if (form) {

        form.addEventListener(
            'submit',
            function () {

                if (!button) {
                    return;
                }


                button.disabled = true;


                if (text) {

                    text.textContent =
                        'Memproses...';

                }


                if (icon) {

                    icon.classList.remove(
                        'fa-sign-in-alt'
                    );

                    icon.classList.add(
                        'fa-spinner',
                        'fa-spin'
                    );

                }

            }
        );

    }


})();

</script>


</body>
</html>