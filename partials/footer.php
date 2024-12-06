 <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024 <a href="https://www.bootstrapdash.com/" class="text-muted" target="_blank">Bootstrapdash</a>. All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center text-muted">Hand-crafted & made with <i class="typcn typcn-heart-full-outline text-danger"></i></span>
                    </div>
                </div>    
            </div>        
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  
<!-- container-scroller -->
  <!-- base:js -->
  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
     <!-- Plugin js for this page-->
  <script src="assets/vendors/chart.js/chart.umd.js"></script>
  <script src="assets/js/jquery.cookie.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/hoverable-collapse.js"></script>
  <script src="assets/js/template.js"></script>
  <script src="assets/js/settings.js"></script>
  <script src="assets/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
    <!-- Custom js for this page-->
  <script src="assets/js/dashboard.js"></script>

  
  <script>
  // Tanggal dan Waktu Saat Ini
  const date = new Date();
  const formattedDate = date.toLocaleString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) + ' Jam ' + date.toLocaleTimeString('id-ID');

  // Export to PDF with preview
  document.getElementById('export-pdf').addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    // Menambahkan tanggal dan waktu ke PDF
    doc.text(`Data Barang - Diambil pada: ${formattedDate}`, 14, 10);
    
    // Menambahkan tabel ke PDF
    doc.autoTable({
      html: 'table', // Ambil elemen tabel di halaman
      theme: 'grid', // Gunakan grid untuk garis tabel
      headStyles: { fillColor: [22, 160, 133] }, // Warna header
      bodyStyles: { lineColor: [255, 255, 255], lineWidth: 0.5 },
      styles: { fontSize: 10, cellPadding: 2 },
    });

    // Menampilkan PDF di jendela baru
    doc.output('dataurlnewwindow');
  });

  // Export to Excel (Sudah benar)
  document.getElementById('export-excel').addEventListener('click', function() {
    const table = document.querySelector('table');
    const wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
    
    // Menyimpan Excel dengan nama file yang berisi tanggal
    const fileName = `data-barang-${date.toLocaleDateString('id-ID')}.xlsx`;
    XLSX.write(wb, { bookType: "xlsx", type: "binary" });
    XLSX.writeFile(wb, fileName);
  });

  // Print Table with proper style
  document.getElementById('export-print').addEventListener('click', function() {
    const printWindow = window.open('', '_blank');
    const table = document.querySelector('table').outerHTML;
    
    // HTML untuk tampilan print
    printWindow.document.write('<html><head><title>Print Data Barang</title>');
    printWindow.document.write('<style>table {border-collapse: collapse;width: 100%;} th, td {padding: 8px;text-align: left;border: 1px solid #ddd;} th {background-color: #f2f2f2;}</style>');
    printWindow.document.write('</head><body>');
    
    // Menambahkan tanggal dan waktu ke bagian atas halaman print
    printWindow.document.write(`<h2>Data Barang - Diambil pada: ${formattedDate}</h2>`);
    printWindow.document.write(table);
    
    printWindow.document.write('</body></html>');
    
    printWindow.document.close();
    printWindow.print();
  });
</script>

  <!-- End custom js for this page-->
  <script>
  // Event listener untuk tombol logout
  document.getElementById('logoutBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Mencegah aksi default (redirect langsung)

    // Menampilkan SweetAlert2 konfirmasi logout
    Swal.fire({
      title: 'Apakah Anda yakin?',
      text: "Anda akan logout dari akun ini!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, Logout!',
      cancelButtonText: 'Batal',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        // Redirect ke halaman logout.php jika pengguna klik 'Ya, Logout!'
        window.location.href = 'auth/logout.php';
      }
    });
  });
</script>
</body>

</html>
