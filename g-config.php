<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

require_once __DIR__ . '/vendor/autoload.php'; // pastikan composer autoload sudah di-include
include("connection/connect.php");  // koneksi database

$client = new Google_Client();
$client->setClientId('.apps.googleusercontent.com'); // ganti dengan client ID dari Google Console
$client->setClientSecret(''); // ganti dengan client secret
$client->setRedirectUri('http://localhost/Food-Ordering-Sistem-master/g-callback.php'); // sesuaikan
$client->addScope('email');
$client->addScope('profile');

// Proses setelah user kembali dari Google
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);

        $service = new Google\Service\Oauth2($client);
        $profile = $service->userinfo->get();

        $g_name = $profile['name'];
        $g_email = $profile['email'];
        $g_id = $profile['id'];
        $currtime = date('Y-m-d H:i:s');

        // Cek apakah user sudah ada di database
        $query_check = "SELECT * FROM users WHERE oauth_id = '$g_id'";
        $run_query_check = mysqli_query($db, $query_check);
        $user = mysqli_fetch_assoc($run_query_check);

        if ($user) {
            // Update data jika user sudah ada
            $query_update = "UPDATE users SET username='$g_name', email='$g_email', date='$currtime' WHERE oauth_id='$g_id'";
            mysqli_query($db, $query_update);
        } else {
            // Insert user baru jika belum ada
            $query_insert = "INSERT INTO users (username, email, oauth_id, date) VALUES ('$g_name', '$g_email', '$g_id', '$currtime')";
            mysqli_query($db, $query_insert);
        }

        // Ambil user lagi untuk dapatkan user_id
        $result = mysqli_query($db, "SELECT * FROM users WHERE oauth_id = '$g_id'");
        $user = mysqli_fetch_assoc($result);
        $userData = $service->userinfo->get();

        // Set session agar index.php mengenali login Google
        $_SESSION['user_id'] = $user['u_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['access_token'] = $token['access_token'];
        $_SESSION['logged_in'] = true;

        // Redirect ke homepage
        header('Location: index.php');
        exit();
    } else {
        echo "Login Google gagal: " . $token['error_description'];
    }
}
?>
