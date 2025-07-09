<?php
session_start();
include("../connection/connect.php"); // Perbaikan path

// Cek login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID transaksi dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID transaksi tidak valid.";
    exit();
}

$id = intval($_GET['id']);

// Ambil data transaksi dari database
$query = mysqli_query($db, "SELECT * FROM transaksi WHERE id = $id") or die(mysqli_error($db));
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data transaksi tidak ditemukan.";
    exit();
}

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = mysqli_real_escape_string($db, $_POST['status']);

    $update = mysqli_query($db, "UPDATE transaksi SET status = '$status' WHERE id = $id");

    if ($update) {
        echo "<script>alert('Transaksi berhasil diperbarui');window.location='transaction.php';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal memperbarui transaksi');</script>";
    }
}
?>

<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Update Transaksi</h1>

    <div class="card shadow mb-4 col-md-6">
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label>Nama Pemesan</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($data['nama_pemesan']) ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Nama Rumah</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($data['nama_rumah']) ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Total Bayar</label>
                    <input type="text" class="form-control" value="Rp <?= number_format($data['total_bayar'], 0, ',', '.') ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Menunggu" <?= ($data['status'] == 'Menunggu') ? 'selected' : '' ?>>Menunggu</option>
                        <option value="Diproses" <?= ($data['status'] == 'Diproses') ? 'selected' : '' ?>>Diproses</option>
                        <option value="Selesai" <?= ($data['status'] == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                        <option value="Dibatalkan" <?= ($data['status'] == 'Dibatalkan') ? 'selected' : '' ?>>Dibatalkan</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="transaction.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
