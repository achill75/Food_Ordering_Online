<?php
include("../../../connection/connect.php");
error_reporting(0);
session_start();

// Proses hapus jika request-nya POST dan ID valid
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['menu_del'])) {
    $menu_id = $_POST['menu_del'];
    if (!empty($menu_id) && is_numeric($menu_id)) {
        mysqli_query($db, "DELETE FROM dishes WHERE d_id = '$menu_id'");
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'invalid_id']);
    }
    exit;
}

$menu_id = $_GET['menu_del'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hapus Menu</title>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<script>
    const menuId = "<?php echo $menu_id; ?>";

    if (menuId) {
        Swal.fire({
            title: 'Hapus Menu Ini?',
            text: "Data akan hilang secara permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('', { menu_del: menuId }, function(response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Menu berhasil dihapus!',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.href = "../../all_menu.php";
                        });
                    } else {
                        Swal.fire('Gagal', 'Menu gagal dihapus.', 'error');
                    }
                });
            } else {
                window.location.href = "../../all_menu.php";
            }
        });
    } else {
        Swal.fire('Error', 'ID menu tidak ditemukan.', 'error').then(() => {
            window.location.href = "../../all_menu.php";
        });
    }
</script>

</body>
</html>
