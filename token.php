<?php
require_once 'vendor/autoload.php';
include("connection/connect.php");
session_start();

\Midtrans\Config::$serverKey = 'SB-Mid-server-ua97Xoby-mXOong1piQYTuuZ'; // Ganti dengan server key kamu
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

// Ambil data user dari database
$user_id = $_SESSION["user_id"] ?? '';
$queryUser = mysqli_query($db, "SELECT * FROM users WHERE u_id = '$user_id' ");
$userData = mysqli_fetch_assoc($queryUser);

// Ambil nama dan email dari database
$fullname = $userData['username'] ?? 'Guest';
$email = isset($userData['email']) && !empty($userData['email']) ? $userData['email'] : 'user@example.com';

// Hitung total dari cart
$item_total = 0;
foreach ($_SESSION["cart_item"] as $item) {
    $item_total += ($item["price"] * $item["quantity"]);
}

// Buat order ID unik
$order_id = 'FOOD-' . time();

// Buat transaksi Snap
$params = [
    'transaction_details' => [
        'order_id' => $order_id,
        'gross_amount' => $item_total,
    ],
    'customer_details' => [
        'first_name' => $fullname,
        'email' => $email
    ]
];

try {
    $snapToken = \Midtrans\Snap::getSnapToken($params);

    // Simpan token dan transaksi ke database
    $stmt = $db->prepare("INSERT INTO transactions (order_id, user_id, gross_amount, payment_type, transaction_time, transaction_status, snap_token) 
    VALUES (?, ?, ?, ?, NOW(), ?, ?)");
    $payment_type = "midtrans";
    $transaction_status = "pending";
    $stmt->bind_param("sidsss", $order_id, $user_id, $item_total, $payment_type, $transaction_status, $snapToken);
    $stmt->execute();
    $stmt->close();

    echo $snapToken;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
