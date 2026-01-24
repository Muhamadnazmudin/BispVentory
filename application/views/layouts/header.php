<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>BIS Inventory Sekolah</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="<?= base_url('assets/sbadmin2/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/sbadmin2/css/sb-admin-2.min.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/dark-mode.css') ?>" rel="stylesheet">
<style>
html, body {
    height: 100%;
    overflow: hidden;
}

#wrapper {
    height: 100vh;
}

/* ======================
   SIDEBAR FIX
   ====================== */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    overflow: hidden; /* PENTING: jangan di sini */
    z-index: 1030;
}

/* SCROLL AKTUAL ADA DI SINI */
.sidebar .nav {
    height: calc(100vh - 70px); /* dikurangi tinggi brand */
    overflow-y: auto;
}

/* ======================
   CONTENT WRAPPER
   ====================== */
#content-wrapper {
    height: 100vh;
    overflow: hidden;
    margin-left: 224px;
}

body.sidebar-toggled #content-wrapper {
    margin-left: 80px;
}

/* ======================
   CONTENT SCROLL
   ====================== */
#content {
    height: 100vh;
    overflow-y: auto;
}

/* ======================
   MOBILE
   ====================== */
@media (max-width: 768px) {
    #content-wrapper {
        margin-left: 0;
    }
}
</style>

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">
