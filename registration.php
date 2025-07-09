<!DOCTYPE html>
<html lang="en">
<?php
session_start();
error_reporting(0);
include("connection/connect.php");

$message = "";
$success = "";

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $cpassword = trim($_POST['cpassword']);
    $address = trim($_POST['address']);

    if (empty($username) || empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($password) || empty($cpassword)) {
        $message = "All fields must be required!";
    } elseif ($password !== $cpassword) {
        $message = "Password does not match!";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters!";
    } elseif (strlen($phone) < 10) {
        $message = "Invalid phone number!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email address!";
    } else {
        $check_username = mysqli_query($db, "SELECT username FROM users WHERE username = '$username'");
        $check_email = mysqli_query($db, "SELECT email FROM users WHERE email = '$email'");

        if (mysqli_num_rows($check_username) > 0) {
            $message = "Username already exists!";
        } elseif (mysqli_num_rows($check_email) > 0) {
            $message = "Email already exists!";
        } else {
            $password_hashed = md5($password);
            $query = "INSERT INTO users(username, f_name, l_name, email, phone, password, address) 
                      VALUES('$username', '$firstname', '$lastname', '$email', '$phone', '$password_hashed', '$address')";
            mysqli_query($db, $query);

            $success = "Account created successfully! Redirecting to login...";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'login.php';
                    }, 3000);
                  </script>";
        }
    }
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register Form</title>
    
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link href="css/footer.css" rel="stylesheet">
</head>

<body>

    <!-- Header -->
    <?php include("includes/navbar.php") ?>

    <div class="page-wrapper">
        <div class="breadcrumb">
            <div class="container">
                <ul>
                    <li>
                        <?php if ($message) echo "<span style='color:red;'>$message</span>"; ?>
                        <?php if ($success) echo "<span style='color:green;'>$success</span>"; ?>
                    </li>
                </ul>
            </div>
        </div>
        <div style="text-align: center; margin-top: 30px">
        <div class="h2">Register Account</div>
        </div>
        <section class="contact-page inner-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget">
                            <div class="widget-body">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label>Username</label>
                                            <input class="form-control" type="text" name="username" placeholder="Username">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label>First Name</label>
                                            <input class="form-control" type="text" name="firstname" placeholder="First Name">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label>Last Name</label>
                                            <input class="form-control" type="text" name="lastname" placeholder="Last Name">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label>Email address</label>
                                            <input type="text" class="form-control" name="email" placeholder="Enter email">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label>Phone number</label>
                                            <input class="form-control" type="text" name="phone" placeholder="Phone">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label>Password</label>
                                            <input type="password" class="form-control" name="password" placeholder="Password">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label>Repeat password</label>
                                            <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password">
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label>Delivery Address</label>
                                            <textarea class="form-control" name="address" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <p><input type="submit" value="Register" name="submit" class="btn btn-primary"></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        <!-- Footer -->
        <?php include("includes/footer.php"); ?>

    </div>

    <!-- JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>

</body>

</html>
