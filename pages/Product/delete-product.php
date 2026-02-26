<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$kode_barang = $_GET['kode_barang'] ?? '';

if (isset($_SESSION['products'])) {
    foreach ($_SESSION['products'] as $index => $product) {

        if (isset($product['kode_barang']) && $product['kode_barang'] == $kode_barang) {
            unset($_SESSION['products'][$index]);
            break;
        }

    }
}

header("Location: dashboard.php?page=listproducts&group=Product");
exit;