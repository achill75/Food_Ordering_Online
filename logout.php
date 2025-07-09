<?php
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['username']);
unset($_SESSION['access_token']);
unset($_SESSION['logged_in']);
session_destroy();
header('Location: login.php');
exit();
?>