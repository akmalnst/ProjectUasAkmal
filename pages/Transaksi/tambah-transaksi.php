<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $no_transaksi = $_POST['no_transaksi'] ?? '';
    $kode_pelanggan = $_POST['kode_pelanggan'] ?? '';
    $kode_barang = $_POST['kode_barang'] ?? '';
    $quantity = $_POST['quantity'] ?? '';
    $harga_satuan = $_POST['harga_satuan'] ?? '';
    $tanggal = $_POST['tanggal'] ?? date('Y-m-d');

    // Get customer name
    $nama_pelanggan = '-';
    if (isset($_SESSION['customers'])) {
        foreach ($_SESSION['customers'] as $customer) {
            if ($customer['kode_pelanggan'] == $kode_pelanggan) {
                $nama_pelanggan = $customer['nama_pelanggan'];
                break;
            }
        }
    }

    // Get product name
    $nama_barang = '-';
    if (isset($_SESSION['products'])) {
        foreach ($_SESSION['products'] as $product) {
            if ($product['kode_barang'] == $kode_barang) {
                $nama_barang = $product['nama_barang'];
                $harga_satuan = $product['harga'];
                break;
            }
        }
    }

    // Calculate total
    $total = $quantity * $harga_satuan;

    if (!isset($_SESSION['transaksi'])) {
        $_SESSION['transaksi'] = [];
    }

    $_SESSION['transaksi'][] = [
        'no_transaksi' => $no_transaksi,
        'kode_pelanggan' => $kode_pelanggan,
        'nama_pelanggan' => $nama_pelanggan,
        'kode_barang' => $kode_barang,
        'nama_barang' => $nama_barang,
        'quantity' => $quantity,
        'harga_satuan' => $harga_satuan,
        'total' => $total,
        'tanggal' => $tanggal
    ];

    echo "<script>window.location='dashboard.php?page=transaksi&group=Transaksi';</script>";
    exit;
}

// Generate No Transaksi
$next_no = 1;
if (isset($_SESSION['transaksi']) && !empty($_SESSION['transaksi'])) {
    $next_no = count($_SESSION['transaksi']) + 1;
}
$no_transaksi_default = 'TRX' . str_pad($next_no, 4, '0', STR_PAD_LEFT);
$tanggal_default = date('Y-m-d');
?>
<style>
    .card { 
        background: #ffffff; 
        padding: 30px; 
        border-radius: 10px; 
        max-width: 800px; 
        margin-right: auto; 
        margin-left: 0; 
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08); 
    }
    .card h3 { 
        margin-bottom: 20px; 
        border-bottom: 1px solid #ddd; 
        padding-bottom: 10px; 
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .form-group { 
        margin-bottom: 15px; 
    }
    .form-full {
        grid-column: 1 / -1;
    }
    label { 
        display: block; 
        font-weight: bold; 
        margin-bottom: 6px; 
    }
    input, select { 
        width: 100%; 
        padding: 10px; 
        border-radius: 5px; 
        border: 1px solid #ccc; 
        box-sizing: border-box;
        font-size: 14px;
    }
    input:focus, select:focus {
        outline: none;
        border-color: #3498db;
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
        margin-right: 10px;
    }
    .btn-simpan { background: #27ae60; }
    .btn-simpan:hover { background: #219150; }
    .btn-batal { background: #95a5a6; }
    .btn-batal:hover { background: #7f8c8d; }
    .button-group {
        margin-top: 20px;
    }
    .info-box {
        background: #ecf0f1;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
        font-size: 13px;
    }
</style>

<div class="card">
    <h3>Tambah Transaksi Penjualan</h3>
    <form method="post">
        <div class="form-row">
            <div class="form-group">
                <label>No Transaksi</label>
                <input type="text" name="no_transaksi" value="<?php echo $no_transaksi_default; ?>" readonly>
            </div>
            <div class="form-group">
                <label>Tanggal Transaksi</label>
                <input type="date" name="tanggal" value="<?php echo $tanggal_default; ?>" required>
            </div>
        </div>

        <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">
        <h4 style="margin-top: 0;">Data Pelanggan</h4>

        <div class="form-row">
            <div class="form-group">
                <label>Pelanggan</label>
                <select name="kode_pelanggan" id="pelanggan" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    <?php
                    if (isset($_SESSION['customers']) && !empty($_SESSION['customers'])) {
                        foreach ($_SESSION['customers'] as $customer) {
                            echo "<option value='" . htmlspecialchars($customer['kode_pelanggan']) . "'>";
                            echo htmlspecialchars($customer['nama_pelanggan']);
                            echo "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">
        <h4 style="margin-top: 0;">Data Produk & Penjualan</h4>

        <div class="form-row">
            <div class="form-group">
                <label>Produk</label>
                <select name="kode_barang" id="produk" onchange="updateHarga()" required>
                    <option value="">-- Pilih Produk --</option>
                    <?php
                    if (isset($_SESSION['products']) && !empty($_SESSION['products'])) {
                        foreach ($_SESSION['products'] as $product) {
                            echo "<option value='" . htmlspecialchars($product['kode_barang']) . "'
                                    data-harga='" . htmlspecialchars($product['harga']) . "'
                                    data-nama='" . htmlspecialchars($product['nama_barang']) . "'>";
                            echo htmlspecialchars($product['nama_barang']);
                            echo " (Rp " . number_format((int)$product['harga'], 0, ',', '.') . ")";
                            echo "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" id="quantity" min="1" placeholder="0" onchange="hitungTotal()" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Harga Satuan</label>
                <input type="text" id="harga_satuan_display" readonly style="background: #ecf0f1;">
            </div>
            <div class="form-group">
                <label>Total Harga</label>
                <input type="text" id="total_display" readonly style="background: #ecf0f1;">
            </div>
        </div>

        <input type="hidden" name="harga_satuan" id="harga_satuan">

        <div class="button-group">
            <button type="submit" class="btn btn-simpan">Simpan Transaksi</button>
            <a href="dashboard.php?page=transaksi&group=Transaksi" class="btn btn-batal">Batal</a>
        </div>
    </form>
</div>

<script>
function updateHarga() {
    const produkSelect = document.getElementById('produk');
    const selectedOption = produkSelect.options[produkSelect.selectedIndex];
    const harga = selectedOption.getAttribute('data-harga') || 0;
    
    document.getElementById('harga_satuan').value = harga;
    document.getElementById('harga_satuan_display').value = 'Rp ' + formatRupiah(harga);
    
    hitungTotal();
}

function hitungTotal() {
    const quantity = parseFloat(document.getElementById('quantity').value) || 0;
    const hargaSatuan = parseFloat(document.getElementById('harga_satuan').value) || 0;
    const total = quantity * hargaSatuan;
    
    document.getElementById('total_display').value = 'Rp ' + formatRupiah(total);
}

function formatRupiah(value) {
    return parseInt(value).toLocaleString('id-ID');
}
</script>
