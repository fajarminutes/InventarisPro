<?php
include 'partials/header.php';

// Menangani aksi Create, Update, Delete
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // CREATE
    if ($action == 'create' && $_SERVER['REQUEST_METHOD'] == 'POST') {
      $nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
      $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
      $harga = mysqli_real_escape_string($conn, $_POST['harga']);
      $stok = mysqli_real_escape_string($conn, $_POST['stok']);
      

        $sql = "INSERT INTO barang (nama_barang, kategori, harga, stok) VALUES ('$nama_barang', '$kategori', '$harga', '$stok')";
        if ($conn->query($sql) === TRUE) {
            $query_aktivitas = mysqli_query($conn, "INSERT INTO aktivitas (id_pengguna, aksi, deskripsi, tanggal_aktivitas) VALUES ('$id_pengguna', 'Tambah Barang', 'Melakukan Tambah ($nama_barang)', '$currentdate')");
            echo "<script>Swal.fire('Berhasil!', 'Barang berhasil ditambahkan!', 'success').then(function() { window.location.href = 'barang.php'; });</script>";
        } else {
          echo "<script>Swal.fire('Gagal!', 'Terjadi kesalahan: " . htmlspecialchars($conn->error) . "', 'error');</script>";
        }
    }

    // EDIT
    if ($action == 'edit' && isset($_GET['id'])) {
        $id_barang = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
          $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
          $harga = mysqli_real_escape_string($conn, $_POST['harga']);
          $stok = mysqli_real_escape_string($conn, $_POST['stok']);
          

            $sql = "UPDATE barang SET nama_barang = '$nama_barang', kategori = '$kategori', harga = '$harga', stok = '$stok' WHERE id_barang = $id_barang";
            if ($conn->query($sql) === TRUE) {
                $query_aktivitas = mysqli_query($conn, "INSERT INTO aktivitas (id_pengguna, aksi, deskripsi, tanggal_aktivitas) VALUES ('$id_pengguna', 'Update Barang', 'Melakukan Update ($nama_barang)', '$currentdate')");
                echo "<script>Swal.fire('Berhasil!', 'Barang berhasil diperbarui!', 'success').then(function() { window.location.href = 'barang.php'; });</script>";
            } else {
                echo "<script>Swal.fire('Gagal!', 'Terjadi kesalahan: " . $conn->error . "', 'error');</script>";
            }
        } else {
            $query = "SELECT * FROM barang WHERE id_barang = $id_barang";
            $result = $conn->query($query);
            $barang = $result->fetch_assoc();
        }
    }

    // DELETE
    if ($action == 'delete' && isset($_GET['id'])) {
        $id_barang = $_GET['id'];

        $sql = "DELETE FROM barang WHERE id_barang = $id_barang";
        if ($conn->query($sql) === TRUE) {
            $query_aktivitas = mysqli_query($conn, "INSERT INTO aktivitas (id_pengguna, aksi, deskripsi, tanggal_aktivitas) VALUES ('$id_pengguna', 'Delete Barang', 'Melakukan Delete', '$currentdate')");
            echo "<script>Swal.fire('Berhasil!', 'Barang berhasil dihapus!', 'success').then(function() { window.location.href = 'barang.php'; });</script>";
        } else {
        echo "<script>Swal.fire('Gagal!', 'Terjadi kesalahan: " . htmlspecialchars($conn->error) . "', 'error');</script>";
        }
    }
}

// Ambil data barang untuk ditampilkan di tabel
$query = "SELECT * FROM barang";
$result = $conn->query($query);
?>

<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card" id="data-barang">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Data Barang</h4>
          <?php
          // Tampilkan tombol sesuai role pengguna
          if ($user['role'] == 'admin') {
            echo ' <a href="barang.php?action=create" class="btn btn-sm btn-success mb-3"><i class="fa fa-plus"></i> Tambah Barang</a>';
          } else { ?>
                 <div class="btn-group">
    <button type="button" class="btn btn-success">Ekspor Data</button>
    <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" id="dropdownMenuSplitButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
        <a class="dropdown-item" href="#" id="export-pdf">PDF</a>
        <a class="dropdown-item" href="#" id="export-excel">Excel</a>
        <a class="dropdown-item" href="#" id="export-print">Print</a>
    </div>
</div>


            <?php
          }
          ?>
          <div class="table-responsive pt-3">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Barang</th>
                  <th>Kategori</th>
                  <th>Harga</th>
                  <th>Stok</th>
                  <?php if ($user['role'] == 'admin') { ?>
                    <th>Aksi</th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1; // Inisialisasi nomor urut
                while ($row = $result->fetch_assoc()) {
                ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['nama_barang']; ?></td>
                    <td><?php echo $row['kategori']; ?></td>
                    <td><?php echo $row['harga']; ?></td>
                    <td><?php echo $row['stok']; ?></td>
                    <?php if ($user['role'] == 'admin') { ?>
                      <td>
                        <a href="barang.php?action=edit&id=<?php echo $row['id_barang']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $row['id_barang']; ?>)">Hapus</button>
                      </td>
                    <?php } ?>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
// Pastikan $user['role'] sudah benar, jika tidak bisa ditambahkan pengecekan lebih lanjut
if (isset($action) && ($action == 'create' || $action == 'edit') && $user['role'] == 'admin') {
    $isEdit = ($action == 'edit');

    // // Cek apakah data barang ada jika action 'edit'
    // if ($isEdit && (!isset($barang) || empty($barang))) {
    //     echo "<script>window.location.href = 'barang.php';</script>";
    //     exit;
    // }
?>
    <div class="row form-barang">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $isEdit ? 'Edit' : 'Tambah'; ?> Barang</h4>
                    <form method="POST" action="barang.php?action=<?php echo $isEdit ? 'edit&id=' . $barang['id_barang'] : 'create'; ?>">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" value="<?php echo $isEdit ? $barang['nama_barang'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <input type="text" name="kategori" class="form-control" value="<?php echo $isEdit ? $barang['kategori'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" name="harga" class="form-control" value="<?php echo $isEdit ? $barang['harga'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" name="stok" class="form-control" value="<?php echo $isEdit ? $barang['stok'] : ''; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary"><?php echo $isEdit ? 'Perbarui' : 'Simpan'; ?></button>
                        <button type="button" class="btn btn-secondary" onclick="goBack()">Kembali</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>



</div>




<?php include 'partials/footer.php'; ?>

<script>
  function confirmDelete(id) {
    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: "Data ini akan dihapus secara permanen!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Hapus!',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = 'barang.php?action=delete&id=' + id;
      }
    });
  }

  // Fungsi untuk kembali ke tampilan data barang
  function goBack() {
    window.location.href = 'barang.php';
  }

  <?php if (isset($action) && ($action == 'create' || $action == 'edit')) { ?>
  document.getElementById('data-barang').style.display = 'none';
  document.querySelector('.form-barang').style.display = 'block';
<?php } ?>

</script>



