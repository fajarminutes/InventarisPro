<?php
include 'partials/header.php';

// Cek apakah form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Password baru

    // Proses foto jika ada file yang diunggah
    $foto = $_FILES['foto']['name'];
    if ($foto) {
        $target_dir = "uploads/";
        // Pastikan folder uploads ada dan dapat ditulis
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true); // Membuat folder jika belum ada
        }
        $target_file = $target_dir . basename($foto);
        
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            // Jika foto berhasil diupload
        } else {
            echo "<script>Swal.fire('Gagal!', 'Gagal mengunggah foto!', 'error');</script>";
            exit;
        }
    } else {
        // Jika tidak ada foto yang diunggah, gunakan foto lama
        $query = "SELECT foto FROM users WHERE id_pengguna = $user[id_pengguna]";
        $result = $conn->query($query);
        $user = $result->fetch_assoc();
        $foto = $user['Foto'];
    }

    // Jika password tidak kosong, lakukan enkripsi
    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET 
                    nama_lengkap = '$nama_lengkap', 
                    username = '$username', 
                    email = '$email', 
                    status = '$status', 
                    foto = '$foto', 
                    password = '$password_hash' 
                WHERE id_pengguna = $user[id_pengguna]";
    } else {
        // Jika password kosong, jangan update password
        $sql = "UPDATE users SET 
                    nama_lengkap = '$nama_lengkap', 
                    username = '$username', 
                    email = '$email', 
                    status = '$status', 
                    foto = '$foto' 
                WHERE id_pengguna = $user[id_pengguna]";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script>Swal.fire('Berhasil!', 'Profil berhasil diperbarui!', 'success').then(function() { window.location.href = 'profil.php'; });</script>";
    } else {
        echo "<script>Swal.fire('Gagal!', 'Terjadi kesalahan: " . $conn->error . "', 'error');</script>";
    }
}
?>

<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Profil Pengguna</h4>

          <!-- Tampilkan Data Pengguna -->
          <table class="table table-bordered">
            <tr>
              <th>Nama Lengkap</th>
              <td><?php echo $user['nama_lengkap']; ?></td>
            </tr>
            <tr>
              <th>Username</th>
              <td><?php echo $user['username']; ?></td>
            </tr>
            <tr>
              <th>Email</th>
              <td><?php echo $user['email']; ?></td>
            </tr>
            <tr>
              <th>Status</th>
              <td><?php echo ucfirst($user['status']); ?></td>
            </tr>
            <tr>
              <th>Foto</th>
              <td>
                <img src="uploads/<?php echo $user['foto']; ?>" alt="Foto Profil" width="150" height="150">
              </td>
            </tr>
          </table>

          <!-- Tombol Edit Profil -->
          <button class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profil</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProfileModalLabel">Edit Profil Pengguna</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form Edit Profil -->
        <form method="POST" action="" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo $user['nama_lengkap']; ?>" required>
          </div>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
              <option value="aktif" <?php echo $user['status'] == 'aktif' ? 'selected' : ''; ?>>Aktif</option>
              <option value="nonaktif" <?php echo $user['status'] == 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="foto" class="form-label">Foto Profil</label>
            <input type="file" class="form-control" id="foto" name="foto">
            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password Baru (Opsional)</label>
            <input type="password" class="form-control" id="password" name="password">
            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti password.</small>
          </div>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include 'partials/footer.php'; ?>
