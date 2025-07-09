<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
session_start();
error_reporting(0);

// Amankan input GET
if (!isset($_GET['user_upd']) || empty($_GET['user_upd'])) {
    echo "<h3>Order ID tidak ditemukan!</h3>";
    exit;
}

$user_upd = mysqli_real_escape_string($db, $_GET['user_upd']);

$sql = "SELECT users.*, users_orders.* 
        FROM users 
        INNER JOIN users_orders ON users.u_id = users_orders.u_id 
        WHERE o_id = '$user_upd'";
$query = mysqli_query($db, $sql);

if (!$query || mysqli_num_rows($query) == 0) {
    echo "<h3>Data pesanan tidak ditemukan!</h3>";
    exit;
}

$rows = mysqli_fetch_array($query);
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - View Order</title>

    <!-- CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript">
        var popUpWin = 0;
        function popUpWindow(URLStr, left, top, width, height) {
            if (popUpWin && !popUpWin.closed) popUpWin.close();
            popUpWin = window.open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=600,height=600,left=' + left + ',top=' + top);
        }
    </script>
</head>

<body class="fix-header fix-sidebar">

    <div id="main-wrapper">
        <?php include("includes/header.php"); ?>
        <?php include("includes/sidebar.php"); ?>

        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Dashboard - View Order</h3>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Detail Pesanan</h4>

                                <div class="table-responsive m-t-20">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <td><strong>Username:</strong></td>
                                                <td><center><?php echo htmlspecialchars($rows['username']); ?></center></td>
                                                <td>
                                                    <center>
                                                        <a href="javascript:void(0);" onClick="popUpWindow('order_update.php?form_id=<?php echo htmlentities($rows['o_id']); ?>');" title="Update order">
                                                            <button type="button" class="btn btn-primary">Take Action</button>
                                                        </a>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Quantity:</strong></td>
                                                <td colspan="2"><center><?php echo htmlspecialchars($rows['quantity']); ?></center></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Price:</strong></td>
                                                <td colspan="2"><center>Rp. <?php echo number_format(htmlspecialchars($rows['price']) * 1000, 0, ',', '.'); ?></center></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Address:</strong></td>
                                                <td colspan="2"><center><?php echo htmlspecialchars($rows['address']); ?></center></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Date:</strong></td>
                                                <td colspan="2"><center><?php echo htmlspecialchars($rows['date']); ?></center></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status:</strong></td>
                                                <td colspan="2">
                                                    <center>
                                                        <?php
                                                        $status = strtolower(trim($rows['status']));
                                                        switch ($status) {
                                                            case '':
                                                            case 'null':
                                                                echo '<button type="button" class="btn btn-info"><span class="fa fa-bars" aria-hidden="true"></span> Memasak</button>';
                                                                break;
                                                            case 'sedang di antar':
                                                            case 'sedang diantar':
                                                            case 'on delivery':
                                                                echo '<button type="button" class="btn btn-warning"><span class="fa fa-cog fa-spin" aria-hidden="true"></span> Sedang Diantar</button>';
                                                                break;
                                                            case 'datang':
                                                            case 'delivered':
                                                                echo '<button type="button" class="btn btn-success"><span class="fa fa-check-circle" aria-hidden="true"></span> Datang</button>';
                                                                break;
                                                            case 'rejected':
                                                            case 'cancelled':
                                                                echo '<button type="button" class="btn btn-danger"><i class="fa fa-close"></i> Cancelled</button>';
                                                                break;
                                                            default:
                                                                echo '<button type="button" class="btn btn-secondary">Status tidak diketahui: ' . htmlspecialchars($rows['status']) . '</button>';
                                                                break;
                                                        }


                                                        ?>
                                                    </center>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="text-center m-t-20">
                                    <a href="all_orders.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali ke Daftar Pesanan</a>
                                </div>

                            </div>
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
