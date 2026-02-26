<style>
    .card {
        background: white;
        padding: 20px;
        border-radius: 6px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .btn {
        padding: 8px 12px;
        text-decoration: none;
        border-radius: 4px;
        color: white;
        font-size: 14px;
        display: inline-block;
    }

    .btn-tambah { background: #27ae60; }
    .btn-tambah:hover { background: #219150; }
    .btn-edit { background: #2980b9; }
    .btn-edit:hover { background: #1a5f7a; }
    .btn-hapus { background: #c0392b; }
    .btn-hapus:hover { background: #a93226; }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    th { 
        background: #f8f8f8; 
        font-weight: bold;
    }

    tr:hover {
        background: #f5f5f5;
    }

    .status {
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 12px;
    }
</style>

<div class="card">
    <div class="card-header">
        <h3>Daftar Transaksi Penjualan</h3>
        <a href="dashboard.php?page=tambah-transaksi&group=Transaksi" class="btn btn-tambah">+ Tambah Transaksi</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Transaksi</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Quantity</th>
                <th>Harga Satuan</th>
                <th>Total</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_SESSION['transaksi']) && !empty($_SESSION['transaksi'])) {
                $i = 1;
                foreach ($_SESSION['transaksi'] as $idx => $trx) {
                    echo "<tr>";
                    echo "<td>" . $i++ . "</td>";
                    echo "<td>" . htmlspecialchars($trx['no_transaksi'] ?? '-') . "</td>";
                    echo "<td>" . htmlspecialchars($trx['nama_pelanggan'] ?? '-') . "</td>";
                    echo "<td>" . htmlspecialchars($trx['nama_barang'] ?? '-') . "</td>";
                    echo "<td>" . htmlspecialchars($trx['quantity'] ?? '-') . "</td>";
                    echo "<td>Rp " . number_format((int)($trx['harga_satuan'] ?? 0), 0, ',', '.') . "</td>";
                    echo "<td>Rp " . number_format((int)($trx['total'] ?? 0), 0, ',', '.') . "</td>";
                    echo "<td>" . htmlspecialchars($trx['tanggal'] ?? '-') . "</td>";
                    echo "<td>
                            <a href='dashboard.php?page=edit-transaksi&group=Transaksi&idx=" . $idx . "' class='btn btn-edit'>Edit</a>
                            <a href='dashboard.php?page=delete-transaksi&group=Transaksi&idx=" . $idx . "' 
                               class='btn btn-hapus' 
                               onclick=\"return confirm('Yakin hapus transaksi ini?')\">
                               Hapus
                            </a>
                          </td>";
                    echo "</tr>";
                }    
            } else {
                echo "<tr><td colspan='9' style='padding: 20px; text-align: center;'>Belum Ada Transaksi</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
