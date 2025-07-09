<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

$error = "";
$success = "";

// Handle form submission
if (isset($_POST['submit'])) {

    // Ambil input dan amankan
    $d_name = mysqli_real_escape_string($db, $_POST['d_name']);
    $about = mysqli_real_escape_string($db, $_POST['about']);
    $price = mysqli_real_escape_string($db, $_POST['price']);
    $res_name = mysqli_real_escape_string($db, $_POST['res_name']);

    // Validasi input kosong
    if (empty($d_name) || empty($about) || empty($price) || empty($res_name)) {
        $error = '<div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>All fields must be filled!</strong>
                </div>';
    } else {
        // Validasi gambar
        if (!empty($_FILES['file']['name'])) {
            $fname = $_FILES['file']['name'];
            $temp = $_FILES['file']['tmp_name'];
            $fsize = $_FILES['file']['size'];

            $extension = strtolower(pathinfo($fname, PATHINFO_EXTENSION));
            $allowed_ext = array("jpg", "png", "gif");

            if (in_array($extension, $allowed_ext)) {
                if ($fsize > 1000000) {
                    $error = '<div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Max Image Size is 1024kb!</strong> Try different image.
                            </div>';
                } else {
                    $fnew = uniqid() . '.' . $extension;
                    $store = "Res_img/dishes/" . basename($fnew);
                    move_uploaded_file($temp, $store);
                    $CreatedBy = $_SESSION['username'];// Update CreatedBy  

                    // Insert to database
                    $query = "INSERT INTO dishes (rs_id, title, slogan, price, img, CreatedBy) 
                              VALUES ('$res_name', '$d_name', '$about', '$price', '$fnew','$CreatedBy')";
                    if (mysqli_query($db, $query)) {
                        $success = '<div class="alert alert-success alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>New Dish Added Successfully!</strong>
                                    </div>';
                    } else {
                        $error = '<div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Database Error!</strong> Could not add dish.
                                </div>';
                    }
                }
            } else {
                $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Invalid file type!</strong> Only JPG, PNG, and GIF allowed.
                        </div>';
            }
        } else {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Please upload an image!</strong>
                    </div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add Menu</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <style>
  /* Sembunyikan tampilan default tombol "Choose File" */
  input[type="file"]::-webkit-file-upload-button {
    visibility: hidden;
  }

  input[type="file"]::before {
    content: "\f1c5"; /* Unicode untuk fa-file-image */
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    display: inline-block;
    background: #dc3545; /* Warna merah */
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 13px;
    cursor: pointer;
    transition: background 0.3s;
  }

  input[type="file"]:hover::before {
    background: #b02a37;
  }
</style>
</head>
<body class="fix-header">
    <div id="main-wrapper">
        <?php include("includes/header.php"); ?>
        <?php include("includes/sidebar.php"); ?>
        <div class="page-wrapper" style="height:1200px;">
            <div class="container-fluid">
                <?php echo $error; ?>
                <?php echo $success; ?>

                <div class="col-lg-12">
                    <div class="card card-outline-primary">
                        <div class="card-header" style="background: rgb(0, 128, 0);">
                            <h4 class="m-b-0 text-white">Add Menu to Restaurant</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-body">
                                    <hr>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Dish Name</label>
                                                <input type="text" name="d_name" class="form-control" placeholder="Morzirella">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label>About</label>
                                                <input type="text" name="about" class="form-control form-control-danger" placeholder="Slogan">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Price</label>
                                                <input type="text" name="price" class="form-control" placeholder="Rp.">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Image</label>
                                                <input type="file" name="file" class="form-control form-control-danger">
                                            </div>
                                        </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Select Restaurant</label>
                                                <select name="res_name" class="form-control custom-select" required>
                                                    <option disabled selected value="">--Select Restaurant--</option>
                                                    <?php
                                                    $res = mysqli_query($db, "SELECT * FROM restaurant");
                                                    while ($row = mysqli_fetch_array($res)) {
                                                        echo '<option value="' . $row['rs_id'] . '">' . $row['title'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <input type="submit" name="submit" class="btn btn-success" value="Save" style="background: rgb(0, 188, 126);">
                                    <a href="dashboard.php" class="btn btn-warning">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- JS scripts -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="js/custom.min.js"></script>
</body>
</html>
