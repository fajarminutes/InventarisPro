<?php
include '../database/config.php';

// Proses login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi input
    if (empty($username) || empty($password)) {
        $error = "Username dan Password wajib diisi!";
    } else {
        // Query untuk memeriksa apakah username atau email ada di database
        $sql = "SELECT * FROM users WHERE username = '$username' OR email = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Username ditemukan
            $user = $result->fetch_assoc();

            // Cek apakah password benar
            if (password_verify($password, $user['password'])) {
              $id = $user['id_pengguna'];
              // Query untuk tabel aktivitas 
              $query_aktivitas = mysqli_query($conn, "INSERT INTO aktivitas (id_pengguna, aksi, deskripsi, tanggal_aktivitas) VALUES ('$id', 'Login', 'Melakukan login', '$currentdate')");
                // Set session login
                $_SESSION['id_pengguna'] = $user['id_pengguna'];
                // Redirect ke halaman dashboard setelah login berhasil
                header('Location: ../dashboard.php'); // Ganti dengan halaman yang diinginkan
                exit();
            } else {
                $error = "Password yang Anda masukkan salah!";
            }
        } else {
            $error = "Username atau Email tidak ditemukan!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login Pengguna</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
  <!-- inject:css -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="shortcut icon" href="../assets/images/favicon.ico" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-start py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="../assets/images/logo-dark.svg" alt="logo">
              </div>
              <h4>Selamat datang!</h4>
              <h6 class="fw-light">Masuk untuk melanjutkan</h6>
              
              <?php if (isset($error)) { ?>
                <div class="alert alert-danger" role="alert">
                  <?= $error; ?>
                </div>
                <?php } elseif (isset($_SESSION['error']) || isset($_SESSION['success'])) { ?>
                <div class="alert <?= isset($_SESSION['error']) ? 'alert-danger' : 'alert-success'; ?>">
                  <?= isset($_SESSION['error']) ? $_SESSION['error'] : $_SESSION['success']; ?>
                </div>
                <?php 
                  // Hapus session setelah menampilkan pesan
                  session_unset(); // Menghapus semua variabel session
                  session_destroy(); // Menghancurkan session secara keseluruhan
                ?>
              <?php } ?>

              <form class="pt-3" method="POST" action="">
                <div class="form-group">
                  <input type="text" name="username" class="form-control form-control-lg" placeholder="Username / Email" required>
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
                </div>
                <div class="mb-4">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Tetap masuk
                    </label>
                  </div>
                </div>
                <div class="mt-3 d-grid gap-2">
                  <button type="submit" name="login" class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn">MASUK</button>
                </div>
                <div class="text-center mt-4 fw-light">
                  Belum punya akun? <a href="register.php" class="text-primary">Daftar</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- inject:js -->
  <script src="../assets/js/off-canvas.js"></script>
  <script src="../assets/js/hoverable-collapse.js"></script>
  <script src="../assets/js/template.js"></script>
  <script src="../assets/js/settings.js"></script>
  <script src="../assets/js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>
