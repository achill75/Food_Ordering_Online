<?php
include("../../../connection/connect.php");
error_reporting(0);
session_start();

// Hapus order jika dikirim via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_del'])) {
    $order_id = $_POST['order_del'];
    mysqli_query($db, "DELETE FROM users_orders WHERE o_id = '$order_id'");
    echo json_encode(['status' => 'success']);
    exit;
}

$order_id = $_GET['order_del'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hapus Pesanan</title>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<script>
    const orderId = "<?php echo $order_id; ?>";

    if (orderId) {
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Pesanan ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('', { order_del: orderId }, function(response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pesanan berhasil dihapus!',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.href = "../../all_orders.php";
                        });
                    } else {
                        Swal.fire('Gagal', 'Pesanan gagal dihapus.', 'error');
                    }
                });
            } else {
                window.location.href = "../../all_orders.php";
            }
        });
    } else {
        Swal.fire('Error', 'ID pesanan tidak ditemukan.', 'error').then(() => {
            window.location.href = "../../all_orders.php";
        });
    }
</script>

</body>
</html>
