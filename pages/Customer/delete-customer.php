<?php
// Ambil kode pelanggan dari URL
$kode_pelanggan = $_GET['kode_pelanggan'] ?? '';

if (isset($_SESSION['customers']) && !empty($kode_pelanggan)) {
    foreach ($_SESSION['customers'] as $index => $customer) {
        // Jika kode cocok, hapus dari array session
        if ($customer['kode_pelanggan'] === $kode_pelanggan) {
            unset($_SESSION['customers'][$index]);
            // Re-index array agar urutan nomor (key) kembali rapi
            $_SESSION['customers'] = array_values($_SESSION['customers']);
            break;
        }
    }
}

// Redirect otomatis kembali ke daftar pelanggan
echo "<script>window.location='dashboard.php?page=customer&group=Customer';</script>";
exit;
?>