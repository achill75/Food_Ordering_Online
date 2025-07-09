<?php
include("../connection/connect.php");
session_start();

if (!isset($_GET['order_id'])) {
    echo "Order ID tidak ditemukan.";
    exit;
}

$order_id = mysqli_real_escape_string($db, $_GET['order_id']);

// Ambil data transaksi
$query = mysqli_query($db, "SELECT t.*, u.username, u.email 
                            FROM transactions t 
                            JOIN users u ON t.user_id = u.u_id 
                            WHERE t.order_id = '$order_id'");

if (!$query || mysqli_num_rows($query) == 0) {
    echo "Data transaksi tidak ditemukan.";
    exit;
}

$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Pembayaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        .invoice-box {
            max-width: 700px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            font-size: 16px;
            line-height: 24px;
        }
        .invoice-box table {
            width: 100%;
        }
    </style>
</head>
<body onload="window.print()">

<div class="invoice-box">
    <h2 class="text-center">Invoice Pembayaran</h2>
    <hr>

    <table class="table">
        <tr>
            <th>Order ID</th>
            <td><?= htmlspecialchars($data['order_id']) ?></td>
        </tr>
        <tr>
            <th>Nama</th>
            <td><?= htmlspecialchars($data['username']) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= htmlspecialchars($data['email']) ?></td>
        </tr>
        <tr>
            <th>Total Pembayaran</th>
            <td>Rp. <?= number_format($data['gross_amount'], 0, ',', '.') ?></td>
        </tr>
        <tr>
            <th>Status Pembayaran</th>
            <td><?= ucfirst($data['transaction_status']) ?></td>
        </tr>
        <tr>
            <th>Tanggal Transaksi</th>
            <td><?= $data['transaction_time'] ?></td>
        </tr>
    </table>

    <p class="text-center mt-4">Terima kasih telah melakukan pembayaran. Simpan bukti ini untuk referensi Anda.</p>
</div>

</body>
</html>
