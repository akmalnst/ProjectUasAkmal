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

    .btn-lihat { background: #2980b9; }
    .btn-lihat:hover { background: #1a5f7a; }
    .btn-cetak { background: #16a085; }
    .btn-cetak:hover { background: #117a65; }

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

    .filter-box {
        background: #ecf0f1;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
        align-items: flex-end;
    }

    .filter-box label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    .filter-box input, .filter-box select {
        padding: 8px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .btn-filter {
        background: #3498db;
        color: white;
        padding: 8px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-filter:hover {
        background: #2980b9;
    }

    .summary-box {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .summary-item {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
    }

    .summary-item h4 {
        margin: 0;
        font-size: 12px;
        opacity: 0.9;
    }

    .summary-item .value {
        font-size: 24px;
        font-weight: bold;
        margin: 10px 0 0 0;
    }
</style>

<div class="card">
    <div class="card-header">
        <h3>Laporan Penjualan</h3>
    </div>

    <div class="filter-box">
        <div>
            <label>Filter Tanggal:</label>
            <input type="date" id="filterTanggal">
        </div>
        <button class="btn-filter" onclick="filterLaporan()">Tampilkan</button>
        <button class="btn-filter" onclick="resetFilter()" style="background: #95a5a6;">Reset</button>
    </div>

    <div class="summary-box">
        <div class="summary-item" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <h4>Total Transaksi</h4>
            <div class="value" id="totalTrx">0</div>
        </div>
        <div class="summary-item" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <h4>Total Penjualan</h4>
            <div class="value" id="totalPenjualan">Rp 0</div>
        </div>
        <div class="summary-item" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <h4>Total Pelanggan</h4>
            <div class="value" id="totalPelanggan">0</div>
        </div>
        <div class="summary-item" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <h4>Total Produk</h4>
            <div class="value" id="totalProduk">0</div>
        </div>
    </div>

    <table id="tabelLaporan">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No Transaksi</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Quantity</th>
                <th>Harga Satuan</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="isiTabel">
        </tbody>
    </table>
</div>

<script>
let semuaTransaksi = [];

// Load transaksi dari session
function loadTransaksi() {
    semuaTransaksi = [
        <?php
        if (isset($_SESSION['transaksi']) && !empty($_SESSION['transaksi'])) {
            foreach ($_SESSION['transaksi'] as $idx => $trx) {
                echo "{
                    idx: " . $idx . ",
                    tanggal: '" . htmlspecialchars($trx['tanggal']) . "',
                    no_transaksi: '" . htmlspecialchars($trx['no_transaksi']) . "',
                    nama_pelanggan: '" . htmlspecialchars($trx['nama_pelanggan']) . "',
                    nama_barang: '" . htmlspecialchars($trx['nama_barang']) . "',
                    quantity: " . (int)$trx['quantity'] . ",
                    harga_satuan: " . (int)$trx['harga_satuan'] . ",
                    total: " . (int)$trx['total'] . "
                },";
            }
        }
        ?>
    ];
    tampilkanLaporan(semuaTransaksi);
}

function tampilkanLaporan(dataLaporan) {
    const tbody = document.getElementById('isiTabel');
    tbody.innerHTML = '';

    if (dataLaporan.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" style="text-align: center; padding: 20px;">Tidak ada transaksi</td></tr>';
        updateSummary([]);
        return;
    }

    let no = 1;
    dataLaporan.forEach(trx => {
        const row = `
            <tr>
                <td>${no++}</td>
                <td>${trx.tanggal}</td>
                <td>${trx.no_transaksi}</td>
                <td>${trx.nama_pelanggan}</td>
                <td>${trx.nama_barang}</td>
                <td>${trx.quantity}</td>
                <td>Rp ${formatRupiah(trx.harga_satuan)}</td>
                <td><strong>Rp ${formatRupiah(trx.total)}</strong></td>
                <td>
                    <a href="dashboard.php?page=struk&group=Laporan&idx=${trx.idx}" class="btn btn-lihat" target="_blank">Lihat Struk</a>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });

    updateSummary(dataLaporan);
}

function updateSummary(dataLaporan) {
    const totalTrx = dataLaporan.length;
    let totalPenjualan = 0;
    let pelangganSet = new Set();
    let produkSet = new Set();

    dataLaporan.forEach(trx => {
        totalPenjualan += trx.total;
        pelangganSet.add(trx.nama_pelanggan);
        produkSet.add(trx.nama_barang);
    });

    document.getElementById('totalTrx').textContent = totalTrx;
    document.getElementById('totalPenjualan').textContent = 'Rp ' + formatRupiah(totalPenjualan);
    document.getElementById('totalPelanggan').textContent = pelangganSet.size;
    document.getElementById('totalProduk').textContent = produkSet.size;
}

function filterLaporan() {
    const tanggal = document.getElementById('filterTanggal').value;
    
    if (!tanggal) {
        alert('Pilih tanggal terlebih dahulu');
        return;
    }

    const filtered = semuaTransaksi.filter(trx => trx.tanggal === tanggal);
    tampilkanLaporan(filtered);
}

function resetFilter() {
    document.getElementById('filterTanggal').value = '';
    tampilkanLaporan(semuaTransaksi);
}

function formatRupiah(value) {
    return parseInt(value).toLocaleString('id-ID');
}

// Load saat halaman terbuka
document.addEventListener('DOMContentLoaded', function() {
    loadTransaksi();
});
</script>
