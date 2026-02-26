<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$kode_target = $_GET['kode_pelanggan'] ?? '';
$customer_edit = null;

if (isset($_SESSION['customers']) && !empty($kode_target)) {
    foreach ($_SESSION['customers'] as $customer) {
        if ($customer['kode_pelanggan'] === $kode_target) {
            $customer_edit = $customer;
            break;
        }
    }
}
if (!$customer_edit) {
    echo "<script>alert('Data pelanggan tidak ditemukan!'); window.location='dashboard.php?page=Customer/costomer';</script>";
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_baru   = $_POST['nama_pelanggan'] ?? '';
    $alamat_baru = $_POST['alamat'] ?? '';
    $no_hp_baru  = $_POST['no_hp'] ?? '';
    $email_baru  = $_POST['email'] ?? '';

    foreach ($_SESSION['customers'] as $index => $customer) {
        if ($customer['kode_pelanggan'] === $kode_target) {
            $_SESSION['customers'][$index] = [
                'kode_pelanggan' => $kode_target,
                'nama_pelanggan' => $nama_baru,
                'alamat'         => $alamat_baru,
                'no_hp'          => $no_hp_baru,
                'email'          => $email_baru
            ];
            break;
        }
    }
    echo "<script>window.location='dashboard.php?page=Customer/customer';</script>";
    exit;
}
?>

<style>
    .card { background: white; padding: 30px; border-radius: 10px; max-width: 600px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .form-group { margin-bottom: 15px; }
    label { display: block; font-weight: bold; margin-bottom: 5px; }
    input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
    .btn-update { background: #2980b9; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; }
    .btn-batal { background: #95a5a6; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px; display: inline-block; margin-left: 10px; }
</style>

<div class="card">
    <h3>Edit Data Pelanggan</h3>
    <form method="post">
        <div class="form-group">
            <label>Kode Pelanggan</label>
            <input type="text" name="kode_pelanggan" value="<?php echo $customer_edit['kode_pelanggan']; ?>" readonly style="background: #f9f9f9;">
        </div>
        <div class="form-group">
            <label>Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" value="<?php echo $customer_edit['nama_pelanggan']; ?>" required>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" value="<?php echo $customer_edit['alamat']; ?>" required>
        </div>
        <div class="form-group">
            <label>No. HP</label>
            <input type="text" name="no_hp" value="<?php echo $customer_edit['no_hp']; ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?php echo $customer_edit['email']; ?>" required>
        </div>
        <div style="margin-top: 20px;">
            <button type="submit" class="btn-update">Update Data</button>
            <a href="dashboard.php?page=Customer/customer" class="btn-batal">Batal</a>
        </div>
    </form>
</div>