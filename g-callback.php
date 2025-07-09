<?php
require_once 'g-config.php'; 

session_start();

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);

        // Ambil data user dari Google
        $oauth =  new Google\Service\Oauth2($client);
        $userData = $oauth->userinfo->get();

        include("connection/connect.php");

        $google_id = mysqli_real_escape_string($db, $userData->id);
        $email     = mysqli_real_escape_string($db, $userData->email);
        $name      = mysqli_real_escape_string($db, $userData->name);
        $picture   = mysqli_real_escape_string($db, $userData->picture);
        $currtime  = date('Y-m-d H:i:s');

        // Cek apakah user sudah ada
        $check = mysqli_query($db, "SELECT * FROM users WHERE oauth_id='$google_id'");
        $user = mysqli_fetch_assoc($check);

        if ($user) {
            // Update data user
            mysqli_query($db, "UPDATE users SET username='$name', email='$email', picture='$picture', date='$currtime' WHERE oauth_id='$google_id'");
        } else {
            // Insert user baru
            mysqli_query($db, "INSERT INTO users (username, email, oauth_id, picture, date) VALUES ('$name', '$email', '$google_id', '$picture', '$currtime')");
        }

        // Ambil ulang user dari DB
        $res = mysqli_query($db, "SELECT * FROM users WHERE oauth_id='$google_id'");
        $user = mysqli_fetch_assoc($res);
        
        echo '<pre>';  // <<< Tambahkan ini
        print_r($user);
        echo '</pre>';
        exit();

        // Set session
        $_SESSION['user_id']   = $user['u_id'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['logged_in'] = true;
        $_SESSION['picture']   = $userData['picture']; // <-- Ini sudah dari DB

        header('Location: index.php');
        exit();
    } else {
        echo "Login failed!<br>";
        echo "<pre>";
        print_r($token);
        echo "</pre>";
        exit();
    }
}
?>
