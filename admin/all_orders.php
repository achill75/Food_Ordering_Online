<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Dashboard</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

</head>

<body class="fix-header fix-sidebar">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <!-- start header  -->
        <?php include("includes/header.php"); ?>
        <!-- End header header -->
        <!-- start left Sidebar -->
        <?php include("includes/sidebar.php"); ?>
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Dashboard</h3>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">All user Orders</h4>

                                <div class="table-responsive m-t-40">
                                    <!-- ... bagian awal file tetap sama ... -->
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Action</th> <!-- Dipindahkan ke posisi awal -->
                                                <th>Username</th>
                                                <th>Title</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Address</th>
                                                <th>Status</th>
                                                <th>Reg-Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id ";
                                            $query = mysqli_query($db, $sql);

                                            if (!mysqli_num_rows($query) > 0) {
                                                echo '<td colspan="8"><center>No Orders-Data!</center></td>';
                                            } else {
                                                while ($rows = mysqli_fetch_array($query)) {
                                                    echo '<tr>';

                                                    // Action Column
                                                    echo '<td>
                                                            <a href="includes/delete/delete_orders.php?order_del=' . $rows['o_id'] . '" onclick="return confirmDelete(event, this);" class="btn btn-danger btn-xs" title="Delete"><i class="fa-solid fa-trash"></i></a>
                                                            <a href="view_order.php?user_upd=' . $rows['o_id'] . '" class="btn btn-info btn-xs" title="View/Edit"><i class="fa-solid fa-gear"></i></a>
                                                            <a href="report_invoisce.php?order_id=' . $rows['o_id'] . '" class="btn btn-secondary btn-xs" title="Download PDF" target="_blank"><i class="fa-solid fa-file-pdf"></i></a>
                                                        </td>';

                                                    // Data Kolom Lainnya
                                                    echo '<td>' . $rows['username'] . '</td>';
                                                    echo '<td>' . $rows['title'] . '</td>';
                                                    echo '<td>' . $rows['quantity'] . '</td>';
                                                   echo '<td>Rp ' . number_format($rows['price'] * 1000, 0, ',', '.') . '</td>';
                                                    echo '<td>' . $rows['address'] . '</td>';

                                                    // Status
                                                    $status = $rows['status'];
                                                    echo '<td>';
                                                    if ($status == "" || $status == "NULL") {
                                                        echo '<button class="btn btn-info btn-sm"><i class="fa fa-bars"></i> No Action</button>';
                                                    } elseif ($status == "in process") {
                                                        echo '<button class="btn btn-warning btn-sm"><i class="fa fa-cog fa-spin"></i> Memasak</button>';
                                                    } elseif ($status == "On Delivery") {
                                                        echo '<button class="btn btn-warning btn-sm"><i class="fa fa-cog fa-spin"></i> Sedang diantar</button>';
                                                    } elseif ($status == "closed") {
                                                        echo '<button class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> Datang</button>';
                                                    } elseif ($status == "rejected") {
                                                        echo '<button class="btn btn-danger btn-sm"><i class="fa fa-close"></i> Cancelled</button>';
                                                    }
                                                    echo '</td>';

                                                    echo '<td>' . $rows['date'] . '</td>';

                                                    echo '</tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
    </div>
    <!-- End Container fluid  -->

    </div>
    <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function confirmDelete(event, anchor) {
    event.preventDefault(); // cegah link langsung jalan
    Swal.fire({
        title: 'Apakah kamu yakin?',
        text: 'Pesanan akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
        window.location.href = anchor.href;
        }
    });
    return false; // cegah default action
    }
    </script>
    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>


    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="js/lib/datatables/datatables-init.js"></script>
</body>

</html>