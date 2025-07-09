<?php
include("../../../connection/connect.php");
error_reporting(0);
session_start();

// Proses penghapusan jika request POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_del'])) {
    $user_id = $_POST['user_del'];
    mysqli_query($db, "DELETE FROM users WHERE u_id = '$user_id'");
    echo json_encode(['status' => 'success']);
    exit;
}

// Dapatkan ID user dari GET untuk ditampilkan ke JavaScript
$user_id = $_GET['user_del'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hapus User</title>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<script>
    const userId = "<?php echo $user_id; ?>";

    if (userId) {
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "User akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim request POST ke file yang sama
                $.post('', { user_del: userId }, function(response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'User berhasil dihapus!',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.href = "../../allusers.php";
                        });
                    } else {
                        Swal.fire('Gagal', 'User gagal dihapus.', 'error');
                    }
                });
            } else {
                // Jika batal
                window.location.href = "../../allusers.php";
            }
        });
    } else {
        // Jika tidak ada ID
        Swal.fire('Error', 'ID user tidak ditemukan.', 'error').then(() => {
            window.location.href = "../../allusers.php";
        });
    }
</script>

</body>
</html>
