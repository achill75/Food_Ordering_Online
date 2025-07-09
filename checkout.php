<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
include_once 'product-action.php';
error_reporting(0);
session_start();
if (empty($_SESSION["user_id"])) {
    header('location:login.php');
} else {

    foreach ($_SESSION["cart_item"] as $item) {

        $item_total += ($item["price"] * $item["quantity"]);

        if ($_POST['submit']) {

            $SQL = "insert into users_orders(u_id,title,quantity,price) values('" . $_SESSION["user_id"] . "','" . $item["title"] . "','" . $item["quantity"] . "','" . $item["price"] . "')";

            mysqli_query($db, $SQL);

            $success = "Thankyou! Your Order Placed successfully!";
        }
    }
?>


    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="#">
        <title>Check Out Page</title>
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/animsition.min.css" rel="stylesheet">
        <link href="css/animate.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">

    </head>

    <body>
        <!--header starts-->
        <?php include("includes/navbar.php"); ?>
        <!-- header end -->

        <div class="container mt-5">
        <div class="page-wrapper">
            <div class="top-links">
                <ul class="row links">
                    <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="restaurants.php">Choose Restaurant</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>2</span><a href="#">Pick Your Favorite Food</a></li>
                    <li class="col-xs-12 col-sm-4 link-item active"><span>3</span><a href="checkout.php">Order and Pay Online</a></li>
                </ul>
            </div>

            <div class="widget clearfix">
                <div class="widget-body">
                    <h4>Cart Summary</h4>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Cart Subtotal</td>
                                <td>Rp.<?php echo $item_total; ?></td>
                            </tr>
                            <tr>
                                <td>Shipping</td>
                                <td>Free</td>
                            </tr>
                            <tr>
                                <td><strong>Total</strong></td>
                                <td><strong>Rp.<?php echo $item_total; ?></strong></td>
                            </tr>
                        </tbody>
                    </table>

                    <button id="pay-button" class="btn btn-success btn-block">Bayar Sekarang</button>
                </div>
            </div>
        </div>
    </div>


        <!-- Featured restaurants ends -->

<!-- Midtrans Snap -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-6EfU8AamqS2y-L5E"></script>
<script src="js/jquery.min.js"></script>
<script>
document.getElementById('pay-button').addEventListener('click', function () {
    fetch('token.php')
        .then(response => response.text())
        .then(snapToken => {
            window.snap.pay(snapToken, {
                onSuccess: function(result) {
                    fetch('update_transaction.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(result)
                    }).then(res => {
                        if (res.ok) {
                            Swal.fire({
                                title: 'Pembayaran Berhasil!',
                                text: 'Transaksi kamu sudah diproses.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal Menyimpan!',
                                text: 'Pembayaran berhasil, tapi penyimpanan gagal.',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                        }
                    }).catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan koneksi saat menyimpan transaksi.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
                },
                onPending: function(result) {
                    Swal.fire({
                        title: 'Menunggu Pembayaran',
                        text: 'Transaksi belum selesai, tunggu hingga pembayaran dilakukan.',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                    console.log(result);
                },
                onError: function(result) {
                    Swal.fire({
                        title: 'Pembayaran Gagal!',
                        text: 'Terjadi kesalahan dalam proses pembayaran.',
                        icon: 'error',
                        confirmButtonText: 'Coba Lagi'
                    });
                    console.log(result);
                },
                onClose: function() {
                    Swal.fire({
                        title: 'Dibatalkan',
                        text: 'Kamu menutup popup pembayaran.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                }
            });
        })
        .catch(error => {
            Swal.fire({
                title: 'Token Gagal Dimuat!',
                text: 'Tidak dapat memuat token pembayaran.',
                icon: 'error',
                confirmButtonText: 'Coba Lagi'
            });
            console.error('Token error:', error);
        });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        </div>
        <!-- end:page wrapper -->
        </div>
        
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