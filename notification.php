<?php
require_once 'vendor/autoload.php';
include("connection/connect.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Konfigurasi Midtrans
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$serverKey = 'SB-Mid-server-ua97Xoby-mXOong1piQYTuuZ';
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$appendNotifUrl = false;

// Ambil notifikasi JSON dari Midtrans
$json_result = file_get_contents('php://input');
file_put_contents("log.txt", date("Y-m-d H:i:s") . " - Raw Input: $json_result\n", FILE_APPEND);

// Validasi jika kosong
if (!$json_result) {
    file_put_contents("log.txt", "No input received.\n", FILE_APPEND);
    http_response_code(400);
    exit;
}

try {
    $notif = new \Midtrans\Notification();

    $order_id = $notif->order_id;
    $transaction_id = $notif->transaction_id;
    $transaction_status = $notif->transaction_status;
    $payment_type = $notif->payment_type;
    $gross_amount = $notif->gross_amount;
    $fraud_status = $notif->fraud_status;

    // Konversi status Midtrans ke internal sistem
    $status = 'pending';
    if ($transaction_status == 'capture') {
        $status = ($fraud_status == 'accept') ? 'paid' : 'challenge';
    } elseif ($transaction_status == 'settlement') {
        $status = 'paid';
    } elseif ($transaction_status == 'pending') {
        $status = 'pending';
    } elseif ($transaction_status == 'deny') {
        $status = 'denied';
    } elseif ($transaction_status == 'expire') {
        $status = 'expired';
    } elseif ($transaction_status == 'cancel') {
        $status = 'cancelled';
    }

    // Ambil user_id dari users_orders
    $user_res = mysqli_query($db, "SELECT u_id FROM users_orders WHERE order_id = '$order_id' LIMIT 1");
    $user_data = mysqli_fetch_assoc($user_res);
    $user_id = $user_data['u_id'] ?? null;

    // Simpan ke tabel transaksi jika belum ada
    $check = mysqli_query($db, "SELECT * FROM transactions WHERE order_id = '$order_id'");
    if (mysqli_num_rows($check) == 0) {
        $insert = mysqli_query($db, "
            INSERT INTO transactions (
                order_id, user_id, gross_amount, payment_type, transaction_time, transaction_status, transaction_id
            ) VALUES (
                '$order_id',
                " . ($user_id ? "'$user_id'" : "NULL") . ",
                '$gross_amount',
                '$payment_type',
                NOW(),
                '$transaction_status',
                '$transaction_id'
            )
        ");

        if ($insert) {
            file_put_contents("log.txt", "[$order_id] New transaction inserted.\n", FILE_APPEND);
        } else {
            file_put_contents("log.txt", "[$order_id] Failed to insert transaction: " . mysqli_error($db) . "\n", FILE_APPEND);
        }
    }

    // Update status di tabel users_orders
    $update = mysqli_query($db, "UPDATE users_orders SET status='$status' WHERE order_id='$order_id'");

    if ($update) {
        file_put_contents("log.txt", "[$order_id] status updated to $status\n", FILE_APPEND);
    } else {
        file_put_contents("log.txt", "[$order_id] Failed to update users_orders: " . mysqli_error($db) . "\n", FILE_APPEND);
    }

    http_response_code(200); // OK

} catch (Exception $e) {
    file_put_contents("log.txt", "EXCEPTION: " . $e->getMessage() . "\n", FILE_APPEND);
    http_response_code(500);
}
