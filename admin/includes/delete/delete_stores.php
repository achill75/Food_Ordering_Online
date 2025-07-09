<?php
include("../../../connection/connect.php");
error_reporting(0);
session_start();

// Proses hapus jika request POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['res_del'])) {
    $res_id = $_POST['res_del'];
    mysqli_query($db, "DELETE FROM restaurant WHERE rs_id = '$res_id'");
    echo json_encode(['status' => 'success']);
    exit;
}

$res_id = $_GET['res_del'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hapus Restoran</title>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<script>
    const resId = "<?php echo $res_id; ?>";

    if (resId) {
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Restoran akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('', { res_del: resId }, function(response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Restoran berhasil dihapus!',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.href = "../../allrestraunt.php";
                        });
                    } else {
                        Swal.fire('Gagal', 'Restoran gagal dihapus.', 'error');
                    }
                });
            } else {
                window.location.href = "../../allrestraunt.php";
            }
        });
    } else {
        Swal.fire('Error', 'ID restoran tidak ditemukan.', 'error').then(() => {
            window.location.href = "../../allrestraunt.php";
        });
    }
</script>

</body>
</html>
