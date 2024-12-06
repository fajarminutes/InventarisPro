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
?>

<script>
  // Mengarahkan pengguna kembali ke halaman sebelumnya
  window.history.back();
</script>
