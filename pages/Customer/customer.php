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
    .btn-edit { background: #2980b9; }
    .btn-hapus { background: #c0392b; }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    th { background: #f8f8f8; }
</style>

<div class="card">
    <div class="card-header">
        <h3>Daftar Pelanggan</h3>
        <a href="dashboard.php?page=tambah-customer&group=Customer" class="btn btn-tambah">+ Tambah Pelanggan</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Pelanggan</th>
                <th>Nama Pelanggan</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_SESSION['customers']) && !empty($_SESSION['customers'])) {
                $i = 1;
                foreach ($_SESSION['customers'] as $customer) {
                    echo "<tr>";
                    echo "<td>" . $i++ . "</td>";
                    echo "<td>" . htmlspecialchars($customer['kode_pelanggan']) . "</td>";
                    echo "<td>" . htmlspecialchars($customer['nama_pelanggan']) . "</td>";
                    echo "<td>" . htmlspecialchars($customer['alamat']) . "</td>";
                    echo "<td>" . htmlspecialchars($customer['no_hp']) . "</td>";
                    echo "<td>" . htmlspecialchars($customer['email']) . "</td>";
                    echo "<td>
                            <a href='dashboard.php?page=edit-customer&group=Customer&kode_pelanggan=" . $customer['kode_pelanggan'] . "' class='btn btn-edit'>Edit</a>
                            <a href='dashboard.php?page=delete-customer&group=Customer&kode_pelanggan=" . $customer['kode_pelanggan'] . "' 
                               class='btn btn-hapus' 
                               onclick=\"return confirm('Yakin hapus data?')\">
                               Hapus
                            </a>
                          </td>";
                    echo "</tr>";
                }    
            } else {
                echo "<tr><td colspan='7' style='padding: 20px;'>Belum Ada Data Pelanggan</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>