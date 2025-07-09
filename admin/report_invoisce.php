<?php
require_once '../connection/connect.php';
require_once '../vendor/autoload.php';

if (!isset($_GET['order_id'])) {
    die('Order ID tidak tersedia.');
}
$order_id = intval($_GET['order_id']);

// Ambil data user dan order
$sql = "SELECT u.username, u.f_name, u.l_name, u.email, u.phone, u.address,
               o.o_id, o.title AS dish_title, o.quantity, o.price, o.date
        FROM users_orders o
        JOIN users u ON u.u_id = o.u_id
        WHERE o.o_id = $order_id";
$result = mysqli_query($db, $sql);
if (!$result || mysqli_num_rows($result) === 0) {
    die('Order tidak ditemukan.');
}
$row = mysqli_fetch_assoc($result);

// Nama pemesan
$full_name = trim($row['f_name'].' '.$row['l_name']);
if ($full_name === '') $full_name = $row['username'];

// Hitung total
$qty = (int)$row['quantity'];
$harga = (float)$row['price'];
$total = $qty * $harga;

// Cari restoran dari judul menu
$menu_title = mysqli_real_escape_string($db, $row['dish_title']);
$queryRest = "
    SELECT r.title AS restaurant_name
    FROM dishes d
    JOIN restaurant r ON d.rs_id = r.rs_id
    WHERE TRIM(LOWER(d.title)) = TRIM(LOWER('$menu_title'))
    LIMIT 1
";
$restResult = mysqli_query($db, $queryRest);
$rest = mysqli_fetch_assoc($restResult);
$restaurant_name = $rest ? $rest['restaurant_name'] : 'Tidak diketahui';

// PDF
$pdf = new TCPDF('P', 'mm', [80, 170]);
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(true, 4);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetFont('helvetica', '', 9);
$pdf->AddPage();

// HTML untuk struk
$html = '
<style>
    .center { text-align:center; }
    .right { text-align:right; }
    .bold { font-weight:bold; }
</style>

<div class="center">
    <span class="bold">NUSANTARA FOOD</span><br>
    Jl. Kuliner No. 123, Indonesia<br>
    Telp: 0812-3456-7890
</div>

<hr>

<table width="100%" cellpadding="1">
    <tr><td><b>Kode Transaksi</b></td><td>: '.$row['o_id'].'</td></tr>
    <tr><td><b>Nama Pemesan</b></td><td>: '.htmlspecialchars($full_name).'</td></tr>
    <tr><td><b>Email</b></td><td>: '.htmlspecialchars($row['email']).'</td></tr>
    <tr><td><b>Telp</b></td><td>: '.htmlspecialchars($row['phone']).'</td></tr>
    <tr><td><b>Alamat</b></td><td>: '.htmlspecialchars($row['address']).'</td></tr>
    <tr><td><b>Tanggal</b></td><td>: '.$row['date'].'</td></tr>
    <tr><td><b>Restoran</b></td><td>: '.htmlspecialchars($restaurant_name).'</td></tr>
</table>

<hr>

<table width="100%" cellpadding="1">
    <thead>
        <tr class="bold">
            <td>Menu</td>
            <td class="right">Qty</td>
            <td class="right">Harga</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>'.htmlspecialchars($row['dish_title']).'</td>
            <td class="right">'.$qty.'</td>
            <td class="right">Rp '.number_format($harga, 0, ',', '.').'</td>
        </tr>
    </tbody>
</table>

<hr>

<table width="100%" cellpadding="1">
    <tr>
        <td class="bold">Total Bayar</td>
        <td class="right bold">Rp '.number_format($total, 0, ',', '.').'</td>
    </tr>
</table>

<br>
<div class="center">
    <i>Catatan Kasir:</i><br>
    Harap dicek kembali pesanan anda.<br>
    --- Terima kasih ---
</div>
';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('struk_order_'.$order_id.'.pdf', 'I');
