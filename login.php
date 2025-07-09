<?php
include("connection/connect.php");
require_once 'g-config.php'; // Google login config
error_reporting(0);
session_start();

$message = "";

if (isset($_POST['submit'])) {
    // Amankan input
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (!empty($username) && !empty($password)) {
        $hashedPassword = md5($password); 
        $loginquery = "SELECT * FROM users WHERE username='$username' AND password='$hashedPassword'";
        $result = mysqli_query($db, $loginquery);
        $row = mysqli_fetch_array($result);

        if (is_array($row)) {
            // Simpan ke session + sinyal login sukses
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['u_id'];
            $_SESSION['random_id'] = rand();
            $_SESSION['picture'] = '';
            $_SESSION['welcome'] = true; // <--- sinyal untuk popup selamat datang

            header("Location: index.php");
            exit;
        } else {
            $message = "Invalid Username or Password!";
        }
    } else {
        $message = "Please fill in both fields.";
    }
}

// URL Login Google
$google_login_url = $client->createAuthUrl();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/login.css">
</head>

<body style="background: url('https://img.freepik.com/free-photo/view-people-attending-chinese-new-year-reunion-dinner_23-2151040708.jpg?t=st=1742024291~exp=1742027891~hmac=e8af7e58d8de9c09c0e5336f33542594bca6b76d53d2c64bbb39950375f9d4cc&w=996') center/cover no-repeat fixed;">

  <div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-5 border p-5 my-5" style="background: rgba(255, 255, 255, 0.10); backdrop-filter: blur(5px);">
      <div class="card-body justify-content-center">
        <div class="form">
          <h2 style="text-align: center; color: white;">LOGIN FORM</h2>
          <form action="" method="post">
            <div class="mb-3">
              <input class="form-control" type="text" placeholder="Username" name="username" required />
            </div>
            <div class="mb-3">
              <input class="form-control" type="password" placeholder="Password" name="password" required />
            </div>
            <div class="d-grid mb-3">
              <button class="btn btn-primary" type="submit" name="submit" value="Login">Login</button>
            </div>
            <div class="d-grid mb-3">
              <a href="<?php echo $google_login_url; ?>">
                <img src="images/with_google2.png" alt="with google">
              </a>
            </div>
          </form>
        </div>
        <div class="regis" style="color: white;">Not registered?<a href="registration.php" style="color:yellow;"> Create an account</a></div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <?php if (!empty($message)) : ?>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Login Gagal',
      text: '<?php echo addslashes($message); ?>',
      confirmButtonText: 'Coba Lagi'
    });
  </script>
  <?php endif; ?>
</body>

</html>
