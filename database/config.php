<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'inventarispro');
if(!$conn) {
 echo 'Tidak terkoneksi';
}
// Set default timezone ke Asia/Jakarta
date_default_timezone_set('Asia/Jakarta');

// Menampilkan hasil dalam format 'Y-m-d H:i:s'
$current = date('Y-m-d H:i');
$currentdate = date('Y-m-d H:i:s');
?> 