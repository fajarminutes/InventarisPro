<?php
include 'database/config.php';
// Cek apakah pengguna sudah login
if (!isset($_SESSION['id_pengguna'])) {
  // error kalo tidak login dulu 
  $_SESSION['error'] = 'Anda harus login dulu!';
  // Jika session 'id_pengguna' tidak ada, redirect ke halaman login
  header("Location: auth/login.php");
  exit(); // Pastikan script berhenti setelah redirect
}
$user = mysqli_query($conn, "SELECT * FROM users WHERE id_pengguna = $_SESSION[id_pengguna]");
$user = mysqli_fetch_array($user);
$id_pengguna = $user['id_pengguna'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Inventaris Pro </title>
  <!-- base:css -->
  <link rel="stylesheet" href="assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="assets/images/favicon.ico" />
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css"/>
  <!-- End plugin css for this page -->
   <!-- Tambahkan SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- CDN for SheetJS (Excel Export) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<!-- CDN for jsPDF (PDF Export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<!-- CDN for jsPDF autoTable (Table Export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.16/jspdf.plugin.autotable.min.js"></script>
<style>
  /* Gaya khusus untuk tabel saat dicetak */
  @media print {
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      padding: 8px;
      text-align: left;
      border: 1px solid #ddd;
    }
    th {
      background-color: #f2f2f2;
    }
  }
</style>

</head>


<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
          <a class="navbar-brand brand-logo" href="index.html"><img src="assets/images/logo.svg" alt="logo"/></a>
          <a class="navbar-brand brand-logo-mini" href="index.html"><img src="assets/images/logo-mini.svg" alt="logo"/></a>
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="typcn typcn-th-menu"></span>
          </button>
        </div>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav me-lg-2">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link" href="#" data-bs-toggle="dropdown" id="profileDropdown">
              <img src="uploads/<?= $user['foto'] ?>" alt="profile"/>
              <span class="nav-profile-name"><?= $user['nama_lengkap'] ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a href="profil.php" class="dropdown-item">
                <i class="typcn typcn-cog-outline text-primary"></i>
                Profil
              </a>
              <a class="dropdown-item" href="#" id="logoutBtn">
              <i class="typcn typcn-eject text-primary"></i>
              Keluar
              </a>
            </div>
          </li>
          <li class="nav-item nav-user-status dropdown">
              <p class="mb-0">Klik samping kiri!</p>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-date dropdown">
            <a class="nav-link d-flex justify-content-center align-items-center" href="javascript:;">
              <h6 class="date mb-0"><?= $current ?></h6>
              <i class="typcn typcn-calendar"></i>
            </a>
          </li>
         
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="typcn typcn-th-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">      
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Beranda</span>
            </a>
          </li>        
          <li class="nav-item">
          <a class="nav-link" href="barang.php">
            <i class="fa fa-cube menu-icon"></i>
            <span class="menu-title">Data Barang</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profil.php">
            <i class="fa fa-cogs menu-icon"></i>
            <span class="menu-title">Profil</span>
          </a>
        </li>
          
          
        </ul>
      </nav>
      <!-- partial -->
 <div class="main-panel">
 