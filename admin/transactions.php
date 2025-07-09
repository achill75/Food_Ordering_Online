<?php
require_once 'vendor/autoload.php';
include("connection/connect.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Midtrans Config
\Midtrans\Config::$serverKey = 'SB-Mid-server-ua97Xoby-mXOong1piQYTuuZ';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$appendNotifUrl = false;

// Logging
file_put_contents("notif_debug.log", date("Y-m-d H:i:s") . " - DIPANGGIL\n", FILE_APPEND);

// Ambil data JSON dari Midtrans
$json_result = file_get_contents('php://input');
$notif = json_decode($json_result);

// Log data
file_put_contents("notif_debug.log", $json_result . "\n", FILE_APPEND);

$notification = new \Midtrans\Notification();

$order_id = $notification->order_id;
$transaction_status = $notification->transaction_status;
$payment_type = $notification->payment_type;
$transaction_time = $notification->transaction_time;
$fraud_status = $notification->fraud_status;

// Log status awal
file_put_contents("notif_debug.log", "ORDER: $order_id | STATUS: $transaction_status | PAYMENT: $payment_type\n", FILE_APPEND);

// Default status
$status = $transaction_status;
if ($transaction_status == 'capture' && $fraud_status == 'accept') {
    $status = 'settlement';
}

// Update transaksi
$updateTrans = mysqli_query($db, "UPDATE transactions SET 
    transaction_status='$status',
    payment_type='$payment_type',
    transaction_time='$transaction_time'
    WHERE order_id='$order_id'
");

// Update order user
$updateOrder = mysqli_query($db, "UPDATE users_orders SET 
    status='$status'
    WHERE order_id='$order_id'
");

if ($updateTrans && $updateOrder) {
    file_put_contents("notif_debug.log", "UPDATE SUCCESS\n", FILE_APPEND);
} else {
    file_put_contents("notif_debug.log", "UPDATE FAILED\n", FILE_APPEND);
}

http_response_code(200);
?>
