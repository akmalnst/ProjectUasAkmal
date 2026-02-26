<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$kode_barang = $_GET['kode_barang'] ?? '';
$product_edit = null;
$index_edit = null;

if (isset($_SESSION['products'])) {
    foreach ($_SESSION['products'] as $index => $product) {
        if (isset($product['kode_barang']) && $product['kode_barang'] == $kode_barang) {
            $product_edit = $product;
            $index_edit = $index;
            break;
        }
    }
}

if (!$product_edit) {
    echo "Data tidak ditemukan!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $_SESSION['products'][$index_edit] = [
        'kode_barang' => $kode_barang, // tetap
        'nama_barang' => $_POST['nama_barang'],
        'kategori'    => $_POST['kategori'],
        'harga'       => $_POST['harga'],
        'stok'        => $_POST['stok'],
        'satuan'      => $_POST['satuan']
    ];

    echo "<script>window.location='dashboard.php?page=listproducts&group=Product';</script>";
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

    select,
    input {
        width: 100%;
        background-color: white;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        font-size: 14px;
        transition: 0.2s ease-in-out;
    }

    select:focus,
    input:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 4px rgba(52, 152, 219, 0.4);
    }

    select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        cursor: pointer;
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

    .btn-tambah {
        background: #27ae60;
    }

    .btn-tambah:hover {
        background: #219150;
    }

    .btn-hapus {
        background: #c0392b;
    }

    .btn-hapus:hover {
        background: #a93226;
    }
</style>

<div class="card">
    <h3>Edit Data Produk</h3>
    <form method="post">
        <div class="form-group">
            <label>Kode Produk</label>
            <input type="text" value="<?php echo $product_edit['kode_barang']; ?>" readonly>
        </div>

        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" 
                   value="<?php echo $product_edit['nama_barang']; ?>" required>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Elektronik" <?= (isset($data['kategori']) && $data['kategori'] == 'Elektronik') ? 'selected' : ''; ?>>Elektronik</option>
                <option value="Pakaian" <?= (isset($data['kategori']) && $data['kategori'] == 'Pakaian') ? 'selected' : ''; ?>>Pakaian</option>
                <option value="Makanan" <?= (isset($data['kategori']) && $data['kategori'] == 'Makanan') ? 'selected' : ''; ?>>Makanan</option>
                <option value="Minuman" <?= (isset($data['kategori']) && $data['kategori'] == 'Minuman') ? 'selected' : ''; ?>>Minuman</option>
                <option value="Alat Tulis" <?= (isset($data['kategori']) && $data['kategori'] == 'Alat Tulis') ? 'selected' : ''; ?>>Alat Tulis</option>
            </select>
        </div>

        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" 
                   value="<?php echo $product_edit['harga']; ?>" required>
        </div>

        <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" 
                   value="<?php echo $product_edit['stok']; ?>" required>
        </div>

        <div class="form-group">
            <label>Satuan</label>
            <select name="satuan" required>
                <option value="">-- Pilih Satuan --</option>

                <option value="pcs" <?php if($product_edit['satuan']=='pcs') echo 'selected'; ?>>pcs</option>

                <option value="box" <?php if($product_edit['satuan']=='box') echo 'selected'; ?>>box</option>

                <option value="kg" <?php if($product_edit['satuan']=='kg') echo 'selected'; ?>>kg</option>

                <option value="liter" <?php if($product_edit['satuan']=='liter') echo 'selected'; ?>>liter</option>
            </select>
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-tambah">Update Data</button>
            <a href="dashboard.php?page=Product/listproducts" class="btn btn-hapus">Batal</a>
        </div>
    </form>
</div>