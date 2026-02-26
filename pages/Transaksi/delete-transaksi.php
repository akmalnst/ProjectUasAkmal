<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$idx = $_GET['idx'] ?? '';

if (isset($_SESSION['transaksi'][$idx])) {
    unset($_SESSION['transaksi'][$idx]);
    // Re-index array
    $_SESSION['transaksi'] = array_values($_SESSION['transaksi']);
}

header("Location: dashboard.php?page=transaksi&group=Transaksi");
exit;
?>
