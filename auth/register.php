<?php
include '../database/config.php';

// Proses registrasi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nama_lengkap = $_POST['nama_lengkap'];

    // Validasi input
    if (empty($username) || empty($email) || empty($password) || empty($nama_lengkap)) {
        $error = "Semua field wajib diisi!";
    } else {
        // Cek apakah username atau email sudah ada di database
        $checkUsername = "SELECT * FROM users WHERE username = '$username'";
        $checkEmail = "SELECT * FROM users WHERE email = '$email'";

        $resultUsername = $conn->query($checkUsername);
        $resultEmail = $conn->query($checkEmail);

        if ($resultUsername->num_rows > 0) {
            // Username sudah ada
            $error = "Username sudah terdaftar!";
        } elseif ($resultEmail->num_rows > 0) {
            // Email sudah ada
            $error = "Email sudah terdaftar!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Query untuk memasukkan data ke database
            $sql = "INSERT INTO users (username, email, password, nama_lengkap, role, status) 
                    VALUES ('$username', '$email', '$hashed_password', '$nama_lengkap', 'user', 'aktif')";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['success'] = 'Anda terdaftar, silakan login!';
                header('Location: login.php');
                exit();
            } else {
                $error = "Terjadi kesalahan: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Daftar Pengguna</title>
    <link rel="stylesheet" href="../assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/images/favicon.ico" />
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                            <h4>Daftar Sekarang!</h4>
                            <h6 class="fw-light">Membuat akun itu mudah.</h6>
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= $error; ?>
                                </div>
                            <?php endif; ?>
                            <form class="pt-3" method="POST" action="">
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" value="<?= isset($username) ? $username : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" value="<?= isset($email) ? $email : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="nama_lengkap" class="form-control form-control-lg" placeholder="Nama Lengkap" value="<?= isset($nama_lengkap) ? $nama_lengkap : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
                                </div>
                                <div class="mb-4">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input" required>
                                            Saya setuju dengan semua Syarat & Ketentuan
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-3 d-grid gap-2">
                                    <button type="submit" name="register" class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn">DAFTAR</button>
                                </div>
                                <div class="text-center mt-4 fw-light">
                                    Sudah punya akun? <a href="login.php" class="text-primary">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/template.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/js/todolist.js"></script>
</body>

</html>
