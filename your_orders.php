<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();

if (empty($_SESSION['user_id'])) {
    header('location:login.php');
} else {
?>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="#">
        <title>My Orders</title>
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/animsition.min.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
        <style type="text/css" rel="stylesheet">
            .indent-small {
                margin-left: 5px;
            }

            .form-group.internal {
                margin-bottom: 0;
            }

            .dialog-panel {
                margin: 10px;
            }

            .datepicker-dropdown {
                z-index: 200 !important;
            }

            label.control-label {
                font-weight: 600;
                color: #777;
            }


            table {
                width: 750px;
                border-collapse: collapse;
                margin: auto;

            }

            tr:nth-of-type(odd) {
                background: #eee;
            }

            th {
                background: rgb(0, 128, 0);
                color: white;
                font-weight: bold;

            }

            td,
            th {
                padding: 10px;
                border: 1px solid #ccc;
                text-align: left;
                font-size: 14px;

            }

            @media only screen and (max-width: 760px),
            (min-device-width: 768px) and (max-device-width: 1024px) {

                table {
                    width: 100%;
                }

                table,
                thead,
                tbody,
                th,
                td,
                tr {
                    display: block;
                }

                thead tr {
                    position: absolute;
                    top: -9999px;
                    left: -9999px;
                }

                tr {
                    border: 1px solid #ccc;
                }

                td {
                    border: none;
                    border-bottom: 1px solid #eee;
                    position: relative;
                    padding-left: 50%;
                }

                td:before {
                    position: absolute;
                    top: 6px;
                    left: 6px;
                    width: 45%;
                    padding-right: 10px;
                    white-space: nowrap;
                    content: attr(data-column);

                    color: #000;
                    font-weight: bold;
                }

            }
        </style>

    </head>

    <body>

        <!--header starts-->
        <?php include("includes/navbar.php") ?>
        <!-- header end -->

        <div class="page-wrapper">
            <!-- top Links -->

            <!-- end:Top links -->
            <!-- start: Inner page hero -->
            <div class="inner-page-hero bg-image" data-image-src="images/makanan3.jpg">
                <div class="container"> </div>
                <!-- end:Container -->
            </div>
            <div class="result-show">
                <div class="container">
                    <div class="row">


                    </div>
                </div>
            </div>
            <!-- //results show -->
            <section class="restaurants-page">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 ">
                            <div class="bg-gray restaurant-entry">
                                <div class="row">

                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Item</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query_res = mysqli_query($db, "SELECT * FROM users_orders WHERE u_id='" . $_SESSION['user_id'] . "' ORDER BY o_id DESC");
                                            if (!mysqli_num_rows($query_res)) {
                                                echo '<tr><td colspan="7"><center>You have No orders Placed yet.</center></td></tr>';
                                            } else {
                                                while ($row = mysqli_fetch_array($query_res)) {
                                            ?>
                                                    <tr>
                                                        <td data-column="Order ID"><?php echo $row['order_id'] ?? '-'; ?></td>
                                                        <td data-column="Item"><?php echo $row['title']; ?></td>
                                                        <td data-column="Quantity"><?php echo $row['quantity']; ?></td>
                                                        <td data-column="Price">Rp.<?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                                                        <td data-column="Status">
                                                            <?php
                                                            $status = strtolower($row['status']);
                                                            if ($status == "" || $status == "null") {
                                                                echo '<button class="btn btn-info btn-sm">Menunggu</button>';
                                                            } elseif ($status == "in process") {
                                                                echo '<button class="btn btn-warning btn-sm"><i class="fa fa-cog fa-spin"></i> Dimasak</button>';
                                                            } elseif ($status == "on delivery") {
                                                                echo '<button class="btn btn-warning btn-sm"><i class="fa fa-truck"></i> Sedang Diantar</button>';
                                                            } elseif ($status == "settlement" || $status == "paid" || $status == "closed") {
                                                                echo '<button class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> Lunas</button>';
                                                            } elseif ($status == "pending") {
                                                                echo '<button class="btn btn-secondary btn-sm"><i class="fa fa-clock"></i> Menunggu Pembayaran</button>';
                                                            } elseif ($status == "cancel" || $status == "rejected") {
                                                                echo '<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Dibatalkan</button>';
                                                            } elseif ($status == "expire") {
                                                                echo '<button class="btn btn-dark btn-sm"><i class="fa fa-times-circle"></i> Expired</button>';
                                                            } else {
                                                                echo '<button class="btn btn-secondary btn-sm">Status tidak diketahui</button>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-column="Date"><?php echo $row['date']; ?></td>
                                                        <td data-column="Action">
                                                             <a href="cetak_invoice.php?order_id=<?php echo $row['order_id'] ?? '-'; ?>" class="btn btn-primary btn-sm" title="View Invoice">
                                                                <i class="fa fa-file-invoice"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                </div>
                                <!--end:row -->
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </section>
        <!-- Featured restaurants ends -->



        <!-- FOOTER SECTION ----------------------- -->
        <?php include("includes/footer.php"); ?>
        <!-- FOOTER SECTION END----------------- -->

        <!-- Bootstrap core JavaScript
    ================================================== -->
        <script src="js/jquery.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/animsition.min.js"></script>
        <script src="js/bootstrap-slider.min.js"></script>
        <script src="js/jquery.isotope.min.js"></script>
        <script src="js/headroom.js"></script>
        <script src="js/foodpicky.min.js"></script>
    </body>

</html>
<?php
}
?>