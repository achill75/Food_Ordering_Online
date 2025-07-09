<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

$alert_script = '';

if (isset($_POST['update'])) {
    $form_id = $_GET['form_id'];
    $status = $_POST['status'];
    $remark = $_POST['remark'];

    $query = mysqli_query($db, "INSERT INTO remark(frm_id, status, remark) VALUES('$form_id', '$status', '$remark')");
    $sql = mysqli_query($db, "UPDATE users_orders SET status='$status' WHERE o_id='$form_id'");

    if ($query && $sql) {
        $alert_script = "
            <script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data formulir berhasil diperbarui.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                };
            </script>
        ";
    } else {
        $alert_script = "
            <script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data formulir berhasil diperbarui.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    }).then(() => {
                        window.location.href = 'all_orders.php';
                    });
                };
            </script>
        ";

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Update Status</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <style>
        table {
            width: 650px;
            border-collapse: collapse;
            margin: 50px auto;
        }
        tr:nth-of-type(odd) { background: #eee; }
        th {
            background: #004684;
            color: white;
            font-weight: bold;
        }
        td, th {
            padding: 10px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div style="margin-left:10px;">
    <form name="updateticket" method="post">
        <table>
            <tr>
                <td><b>Form Number</b></td>
                <td><?php echo htmlentities($_GET['form_id']); ?></td>
            </tr>
            <tr>
                <td><b>Status</b></td>
                <td>
                    <select name="status" required>
                        <option value="">Select Status</option>
                        <option value="in process">In Process</option>
                        <option value="On Delivery">On Delivery</option>
                        <option value="closed">Delivered</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><b>Remark</b></td>
                <td><textarea name="remark" cols="50" rows="10" required></textarea></td>
            </tr>
            <tr>
                <td><b>Action</b></td>
                <td>
                    <input type="submit" name="update" class="btn btn-primary" value="Submit">
                    <input type="button" class="btn btn-danger" value="Close this window" onclick="window.close();">
                </td>
            </tr>
        </table>
    </form>
</div>

<!-- SweetAlert script if triggered -->
<?php echo $alert_script; ?>

</body>
</html>
