<?php
include 'partials/header.php';

// Query untuk mendapatkan data aktivitas pengguna
$query_aktivitas = "SELECT * FROM aktivitas WHERE id_pengguna = $id_pengguna ORDER BY tanggal_aktivitas DESC LIMIT 5";
$result_aktivitas = $conn->query($query_aktivitas);

// Query untuk menghitung jumlah barang
$query_barang_count = "SELECT COUNT(*) AS total_barang FROM barang";
$result_barang_count = $conn->query($query_barang_count);
$total_barang = $result_barang_count->fetch_assoc()['total_barang'];

?>

<div class="content-wrapper">
  <div class="row">
    <!-- Dashboard Overview -->
    <div class="col-lg-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Profil Pengguna</h4>
          <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
          <p><strong>Nama:</strong> <?php echo $user['nama_lengkap']; ?></p>
          <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
          <p><strong>Role:</strong> <?php echo $user['role'] === 'user' ? 'Pegawai' : 'Admin' ?></p>
          <p><strong>Status:</strong> <?php echo $user['status'] == 'aktif' ? 'Aktif' : 'Nonaktif' ?></p>
          <p><strong>Akun dibuat:</strong> <?php echo $user['tanggal_buat']; ?></p>
        </div>
      </div>
    </div>

  <!-- Aktivitas Pengguna -->
<div class="col-lg-6 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Aktivitas Terakhir</h4>
      <ul class="list-group" style="max-height: 300px; overflow-y: auto;">
        <?php while ($aktivitas = $result_aktivitas->fetch_assoc()) { ?>
          <li class="list-group-item">
            <strong><?php echo ucfirst($aktivitas['aksi']); ?></strong>: <?php echo $aktivitas['deskripsi']; ?><br>
            <small><?php echo $aktivitas['tanggal_aktivitas']; ?></small>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</div>


    <!-- Jumlah Barang -->
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Jumlah Data Barang</h4>
          <p>Total Barang: <?php echo $total_barang; ?> barang</p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'partials/footer.php'; ?>
