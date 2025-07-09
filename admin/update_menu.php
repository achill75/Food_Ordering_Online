<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

$error = "";
$success = "";

if (isset($_GET['menu_upd'])) {
    $dish_id = mysqli_real_escape_string($db, $_GET['menu_upd']);
    $qry = mysqli_query($db, "SELECT * FROM dishes WHERE d_id='$dish_id'");
    $dish = mysqli_fetch_assoc($qry);
} else {
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST['submit'])) {
    $LastUpdatedBy = $_SESSION['username'];
    
    $d_name = mysqli_real_escape_string($db, $_POST['d_name']);
    $about = mysqli_real_escape_string($db, $_POST['about']);
    $raw_price = str_replace('.', '', $_POST['price']);
    $price = mysqli_real_escape_string($db, $raw_price);
    $res_name = mysqli_real_escape_string($db, $_POST['res_name']);
    $LastUpdatedBy = mysqli_real_escape_string($db, $_POST['LastUpdatedBy']);

    if (empty($d_name) || empty($about) || empty($price) || empty($res_name)) {
        $error = '<div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>All fields must be filled!</strong>
                  </div>';
    } else {
        $update_img = "";
        if (!empty($_FILES['file']['name'])) {
            $fname = $_FILES['file']['name'];
            $temp = $_FILES['file']['tmp_name'];
            $fsize = $_FILES['file']['size'];
            $extension = strtolower(pathinfo($fname, PATHINFO_EXTENSION));
            $allowed_ext = array("jpg", "png", "gif");

            if (!in_array($extension, $allowed_ext)) {
                $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Invalid file type!</strong> Only JPG, PNG, and GIF allowed.
                          </div>';
            } elseif ($fsize > 1000000) {
                $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Max image size is 1024KB!</strong> Try a smaller image.
                          </div>';
            } else {
                $fnew = uniqid() . '.' . $extension;
                $store = "Res_img/dishes/" . basename($fnew);
                move_uploaded_file($temp, $store);
                $update_img = ", img='$fnew'";
            }
        }

        if (empty($error)) {
            $LastUpdateBy ="";
            $LastUpdatedBy = $_SESSION['username'];
            $query = "UPDATE dishes SET 
                        rs_id='$res_name',
                        LastUpdatedBy='$LastUpdatedBy',
                        title='$d_name', 
                        slogan='$about', 
                        price='$price'
                        $update_img
                      WHERE d_id='$dish_id'";

            if (mysqli_query($db, $query)) {
                $LastUpdateBy = $_SESSION['username'];
                $qry="UPDATE dishes SET LastUpdateBy='$LastUpdateBy' WHERE d_id='$dish_id'";
                mysqli_query($db, $qry);
                $success = '<div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Dish updated successfully!</strong>
                            </div>';
                // Refresh data
                $qry = mysqli_query($db, "SELECT * FROM dishes WHERE d_id='$dish_id'");
                $dish = mysqli_fetch_assoc($qry);
            } else {
                $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Database error!</strong> Please try again.
                          </div>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Menu</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
  /* Sembunyikan tombol default */
  input[type="file"]::-webkit-file-upload-button {
    visibility: hidden;
  }

  input[type="file"]::before {
    content: "\f1c5"; /* Tambahkan teks jika ingin */
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    display: inline-block;
    background: #dc3545;
    color: white;
    padding: 6px 12px;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    transition: background 0.3s;
  }

  input[type="file"]:hover::before {
    background: #b02a37;
  }

  /* Agar cursor tetap pointer ketika hover input area */
  input[type="file"] {
    cursor: pointer;
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
                        <h4 class="m-b-0 text-white">Update Menu</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <hr>
                                <div class="row p-t-20">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Dish Name</label>
                                            <input type="text" name="d_name" value="<?php echo htmlspecialchars($dish['title']); ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-danger">
                                            <label>About</label>
                                            <input type="text" name="about" value="<?php echo htmlspecialchars($dish['slogan']); ?>" class="form-control form-control-danger">
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-t-20">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Price</label>
                                            <input type="text" name="price" id="price" value="<?php echo number_format($dish['price'], 0, ',', '.'); ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-danger">
                                            <label>Image</label>
                                            <input type="file" name="file" class="form-control form-control-danger">
                                            <?php if (!empty($dish['img'])): ?>
                                                <br>
                                                <img src="Res_img/dishes/<?php echo $dish['img']; ?>" width="100" height="80">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Select Restaurant</label>
                                            <select name="res_name" class="form-control custom-select" required>
                                                <option disabled>--Select Restaurant--</option>
                                                <?php
                                                $res = mysqli_query($db, "SELECT * FROM restaurant");
                                                while ($row = mysqli_fetch_array($res)) {
                                                    $selected = ($row['rs_id'] == $dish['rs_id']) ? "selected" : "";
                                                    echo '<option value="' . $row['rs_id'] . '" ' . $selected . '>' . htmlspecialchars($row['title']) . '</option>';
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

<!-- JS -->
<script src="js/lib/jquery/jquery.min.js"></script>
<script src="js/lib/bootstrap/js/popper.min.js"></script>
<script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="js/jquery.slimscroll.js"></script>
<script src="js/sidebarmenu.js"></script>
<script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="js/custom.min.js"></script>
</body>
</html>
