<?php
include("../connection/connect.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (empty($_SESSION["username"])) {
    header('location:index.php');
    exit;
} else {
    // TRAFFIC ORDER - 7 HARI TERAKHIR
    $orders_per_day = array_fill(0, 7, 0);

    $sql = "SELECT DATE(`date`) as order_date, COUNT(*) as total 
            FROM users_orders 
            WHERE `date` >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
            GROUP BY DATE(`date`) 
            ORDER BY order_date ASC";
    $result = mysqli_query($db, $sql);

    $dates = [];
    $start = new DateTime();
    $start->sub(new DateInterval('P6D'));
    $end = new DateTime();
    $interval = new DateInterval('P1D');
    $period = new DatePeriod($start, $interval, (clone $end)->modify('+1 day'));

    foreach ($period as $i => $date) {
        $dates[$i] = $date->format('Y-m-d');
        $orders_per_day[$i] = 0;
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $date = $row['order_date'];
        $index = array_search($date, $dates);
        if ($index !== false) {
            $orders_per_day[$index] = (int)$row['total'];
        }
    }

    $labels = [];
    foreach ($dates as $d) {
        $labels[] = date('D', strtotime($d));
    }

    // REVENUE 7 HARI TERAKHIR
    $sql = "SELECT SUM(price * quantity) as total_revenue 
            FROM users_orders 
            WHERE `date` >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    $total_revenue = $row['total_revenue'] ? number_format($row['total_revenue'], 0, ',', '.') : 0;

    // LATEST ORDERS
    $sql = "SELECT o.o_id, o.title, o.quantity, o.price, o.status, u.username, DATE(o.date) as order_date
            FROM users_orders o
            JOIN users u ON o.u_id = u.u_id
            ORDER BY o.date DESC
            LIMIT 5";
    $result_latest = mysqli_query($db, $sql);

    // TOP SELLING DISHES
    $sql = "SELECT title, SUM(quantity) as total_sold
            FROM users_orders
            GROUP BY title
            ORDER BY total_sold DESC
            LIMIT 5";
    $result_top = mysqli_query($db, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="stylesheet" href="path/to/bootstrap/css/bootstrap.min.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <!-- Favicon icon -->

        <title>Online Food Order Dashboard</title>
        <!-- Bootstrap Core CSS -->
        <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="css/helper.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
    <style>
          /* Buat konten geser ke kanan sesuai lebar sidebar */
          .page-wrapper {
              margin-left: 250px; /* sesuaikan dengan lebar sidebar kamu */
              padding: 20px;
          }
          @media (max-width: 768px) {
              .page-wrapper {
                  margin-left: 0;
              }
          }
          .card-number {
              margin-left: 50px;
              text-align: center;
          }
      </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="fix-header">
    <div id="main-wrapper">
        <?php include("includes/header.php"); ?>
        <?php include("includes/sidebar.php"); ?>

          <div class="page-wrapper">
            <div class="row">

                <!-- RESTAURANT CARD -->
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3 bg-warning rounded-circle d-flex justify-content-center align-items-center" style="width:50px; height:50px;">
                                <i class="fa fa-archive text-white"></i>
                            </div>
                            <div class="card-number">
                                <h4 class="mb-0 fw-bold">
                                    <?php $sql = "SELECT * FROM restaurant"; $result = mysqli_query($db, $sql); echo mysqli_num_rows($result); ?>
                                </h4>
                                <p class="mb-0 text-muted small">Restaurants</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DISHES CARD -->
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3 bg-success rounded-circle d-flex justify-content-center align-items-center" style="width:50px; height:50px;">
                                <i class="fa fa-cutlery text-white"></i>
                            </div>
                            <div class="card-number">
                                <h4 class="mb-0 fw-bold">
                                    <?php $sql = "SELECT * FROM dishes"; $result = mysqli_query($db, $sql); echo mysqli_num_rows($result); ?>
                                </h4>
                                <p class="mb-0 text-muted small">Dishes</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CUSTOMERS CARD -->
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3 bg-primary rounded-circle d-flex justify-content-center align-items-center" style="width:50px; height:50px;">
                                <i class="fa fa-user text-white"></i>
                            </div>
                            <div class="card-number">
                                <h4 class="mb-0 fw-bold">
                                    <?php $sql = "SELECT * FROM users"; $result = mysqli_query($db, $sql); echo mysqli_num_rows($result); ?>
                                </h4>
                                <p class="mb-0 text-muted small">Customers</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ORDERS CARD -->
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3 bg-danger rounded-circle d-flex justify-content-center align-items-center" style="width:50px; height:50px;">
                                <i class="fa fa-shopping-cart text-white"></i>
                            </div>
                            <div class="card-number">
                                <h4 class="mb-0 fw-bold">
                                    <?php $sql = "SELECT * FROM users_orders"; $result = mysqli_query($db, $sql); echo mysqli_num_rows($result); ?>
                                </h4>
                                <p class="mb-0 text-muted small">Orders</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- REVENUE SUMMARY -->
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3 bg-secondary rounded-circle d-flex justify-content-center align-items-center" style="width:50px; height:50px;">
                                <i class="fa fa-money-bill text-white"></i>
                            </div>
                            <div class="card-number">
                                <h4 class="mb-0 fw-bold">Rp <?php echo $total_revenue; ?></h4>
                                <p class="mb-0 text-muted small">Revenue (7 days)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TRAFFIC CHART -->
                <div class="col-12">
                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Order Traffic This Week</h5>
                            <canvas id="trafficChart" height="100"></canvas>
                        </div>
                    </div>
                </div>

                <!-- LATEST ORDERS -->
                <div class="col-12">
                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Latest Orders</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Customer</th>
                                            <th>Item</th>
                                            <th>Qty</th>
                                            <th>Total Price</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result_latest)) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                                            <td><?php echo $row['quantity']; ?></td>
                                            <td>Rp <?php echo number_format($row['price'] * $row['quantity'], 0, ',', '.'); ?></td>
                                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TOP SELLING DISHES -->
                <div class="col-12">
                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Top Selling Dishes</h5>
                            <ul class="list-group">
                                <?php while ($row = mysqli_fetch_assoc($result_top)) { ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?php echo htmlspecialchars($row['title']); ?>
                                        <span class="badge bg-primary rounded-pill"><?php echo $row['total_sold']; ?> sold</span>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

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

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    const ctx = document.getElementById('trafficChart').getContext('2d');
    const trafficChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Orders',
                data: <?php echo json_encode($orders_per_day); ?>,
                fill: true,
                backgroundColor: 'rgba(63,81,181,0.1)',
                borderColor: 'rgba(63,81,181,1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false }},
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });
    </script>
</body>
</html>
