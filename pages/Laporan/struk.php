<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$idx = $_GET['idx'] ?? '';

if (!isset($_SESSION['transaksi'][$idx])) {
    echo "<div style='color: red; padding: 20px;'>Transaksi tidak ditemukan</div>";
    exit;
}

$trx = $_SESSION['transaksi'][$idx];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk Penjualan - <?php echo htmlspecialchars($trx['no_transaksi']); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            background: #f4f4f4;
            padding: 20px;
        }

        .struk-container {
            background: white;
            max-width: 400px;
            margin: 0 auto;
            padding: 30px 20px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }

        .header h2 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 12px;
            color: #666;
        }

        .garis {
            border-top: 1px solid #000;
            margin: 10px 0;
        }

        .garis-tebal {
            border-top: 2px solid #000;
            margin: 10px 0;
        }

        .info-section {
            margin-bottom: 15px;
            font-size: 12px;
        }

        .info-label {
            color: #666;
            margin-bottom: 3px;
        }

        .info-value {
            font-weight: bold;
        }

        .produk-section {
            margin: 15px 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            margin: 10px 0;
            font-size: 12px;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            border-bottom: 1px solid #000;
            padding: 5px 0;
            font-weight: bold;
        }

        td {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .qty-col {
            text-align: center;
        }

        .harga-col {
            text-align: right;
        }

        .total-col {
            text-align: right;
            font-weight: bold;
        }

        .summary {
            margin: 15px 0;
            font-size: 13px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .summary-row.total {
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            padding: 8px 0;
            font-weight: bold;
            font-size: 14px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 11px;
            color: #666;
        }

        .thank-you {
            text-align: center;
            font-weight: bold;
            margin: 15px 0;
            font-size: 13px;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }
            .struk-container {
                box-shadow: none;
                border: none;
            }
            .print-button {
                display: none;
            }
        }

        .print-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .print-button:hover {
            background: #2980b9;
        }

        .back-button {
            display: block;
            margin: 10px auto;
            padding: 8px 15px;
            background: #95a5a6;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            text-decoration: none;
            text-align: center;
        }

        .back-button:hover {
            background: #7f8c8d;
        }
    </style>
</head>
<body>

<div class="struk-container">
    <!-- Header -->
    <div class="header">
        <h2>POS SYSTEM</h2>
        <p>Toko Penjualan Sederhana</p>
    </div>

    <!-- Info Transaksi -->
    <div class="info-section">
        <div class="info-label">No. Transaksi:</div>
        <div class="info-value"><?php echo htmlspecialchars($trx['no_transaksi']); ?></div>
    </div>

    <div class="info-section">
        <div class="info-label">Tanggal:</div>
        <div class="info-value"><?php echo date('d/m/Y H:i', strtotime($trx['tanggal'])); ?></div>
    </div>

    <div class="garis"></div>

    <!-- Info Pelanggan -->
    <div class="info-section">
        <div class="info-label">Pelanggan:</div>
        <div class="info-value"><?php echo htmlspecialchars($trx['nama_pelanggan']); ?></div>
    </div>

    <div class="garis-tebal"></div>

    <!-- Detail Produk -->
    <div class="produk-section">
        <p style="font-weight: bold; margin-bottom: 8px;">DETAIL PEMBELIAN</p>
        <table>
            <thead>
                <tr>
                    <th style="width: 50%;">Produk</th>
                    <th class="qty-col" style="width: 15%;">Qty</th>
                    <th class="harga-col" style="width: 35%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo htmlspecialchars($trx['nama_barang']); ?></td>
                    <td class="qty-col"><?php echo htmlspecialchars($trx['quantity']); ?></td>
                    <td class="total-col">Rp <?php echo number_format((int)$trx['total'], 0, ',', '.'); ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="garis-tebal"></div>

    <!-- Ringkasan -->
    <div class="summary">
        <div class="summary-row">
            <span>Harga Satuan</span>
            <span>Rp <?php echo number_format((int)$trx['harga_satuan'], 0, ',', '.'); ?></span>
        </div>
        <div class="summary-row">
            <span>Jumlah Item</span>
            <span><?php echo htmlspecialchars($trx['quantity']); ?> x</span>
        </div>
        <div class="summary-row total">
            <span>TOTAL</span>
            <span>Rp <?php echo number_format((int)$trx['total'], 0, ',', '.'); ?></span>
        </div>
    </div>

    <div class="thank-you">
        Terima Kasih Telah Berbelanja
    </div>

    <div class="footer">
        <p>Semoga Puas Dengan Produk Kami</p>
        <p style="margin-top: 8px;"><?php echo date('d F Y H:i'); ?></p>
    </div>
</div>

<button class="print-button" onclick="window.print()">🖨️ Cetak Struk</button>
<button class="back-button" onclick="window.history.back()">← Kembali</button>

</body>
</html>
