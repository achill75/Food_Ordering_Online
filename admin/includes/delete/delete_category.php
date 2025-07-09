<?php
include("../../../connection/connect.php");
error_reporting(0);
session_start();

// Hapus jika dikirim melalui POST & ID valid
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cat_del'])) {
    $cat_id = $_POST['cat_del'];
    if (!empty($cat_id) && is_numeric($cat_id)) {
        mysqli_query($db, "DELETE FROM res_category WHERE c_id = '$cat_id'");
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'invalid_id']);
    }
    exit;
}

$cat_id = $_GET['cat_del'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hapus Kategori</title>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<script>
    const catId = "<?php echo $cat_id; ?>";

    if (catId) {
        Swal.fire({
            title: 'Hapus Kategori Ini?',
            text: "Kategori akan dihapus secara permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('', { cat_del: catId }, function(response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Kategori berhasil dihapus!',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.href = "../../add_category.php";
                        });
                    } else {
                        Swal.fire('Gagal', 'Kategori gagal dihapus.', 'error');
                    }
                });
            } else {
                window.location.href = "../../add_category.php";
            }
        });
    } else {
        Swal.fire('Error', 'ID kategori tidak ditemukan.', 'error').then(() => {
            window.location.href = "../../add_category.php";
        });
    }
</script>

</body>
</html>
