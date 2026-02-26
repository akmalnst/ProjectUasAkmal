<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $kode_pelanggan = $_POST['kode_pelanggan'] ?? '';
    $nama_pelanggan = $_POST['nama_pelanggan'] ?? '';
    $alamat         = $_POST['alamat'] ?? '';
    $no_hp          = $_POST['no_hp'] ?? '';
    $email          = $_POST['email'] ?? '';

    $_SESSION['customers'][] = [
        'kode_pelanggan' => $kode_pelanggan,
        'nama_pelanggan' => $nama_pelanggan,
        'alamat'         => $alamat,
        'no_hp'          => $no_hp,
        'email'          => $email
    ];

    echo "<script>window.location='dashboard.php?page=Customer/customer';</script>";
    exit;
}
?>

<style>
    .card { 
        background: #ffffff; 
        padding: 30px; 
        border-radius: 10px; 
        max-width: 720px; 
        margin-right: auto; 
        margin-left: 0; 
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08); 
    }
    .card h3 { 
        margin-bottom: 20px; 
        border-bottom: 1px solid #ddd; 
        padding-bottom: 10px; 
    }
    .form-group { 
        margin-bottom: 15px; 
    }
    label { 
        display: block; 
        font-weight: bold; 
        margin-bottom: 6px; 
    }
    input { 
        width: 100%; 
        padding: 10px; 
        border-radius: 5px; 
        border: 1px solid #ccc; 
        box-sizing: border-box;
    }
    .btn { 
        padding: 10px 16px; 
        border-radius: 5px; 
        text-decoration: none; 
        color: white; 
        border: none; 
        cursor: pointer; 
        font-size: 14px;
        display: inline-block;
    }
    .btn-tambah { background: #27ae60; }
    .btn-hapus { background: #c0392b; }
</style>

<div class="card">
    <h3>Tambah Pelanggan</h3>
    <form method="post">
        <div class="form-group">
            <label>Kode Pelanggan</label>
            <input type="text" name="kode_pelanggan" placeholder="Contoh: CS001" required>
        </div>
        <div class="form-group">
            <label>Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" required>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" required>
        </div>
        <div class="form-group">
            <label>No. HP</label>
            <input type="text" name="no_hp" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-tambah">Simpan Pelanggan</button>
            <a href="dashboard.php?page=customer" class="btn btn-hapus">Batal</a>
        </div>
    </form>
</div>