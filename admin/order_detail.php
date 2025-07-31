<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
include '../includes/db.php';
include 'admin_header.php';

$order_id = intval($_GET['id']);
$order = $conn->query("SELECT o.*, u.name FROM orders o JOIN users u ON o.user_id=u.user_id WHERE o.order_id=$order_id")->fetch_assoc();
$details = $conn->query("SELECT od.*, m.name FROM order_detail od JOIN menu m ON od.menu_id=m.menu_id WHERE od.order_id=$order_id");
$payment = $conn->query("SELECT * FROM payment WHERE order_id=$order_id")->fetch_assoc();
?>
<h2 class="text-2xl font-bold mb-6 text-white">Detail Order #<?php echo $order_id; ?></h2>
<div class="mb-4">
    <strong>Nama User:</strong> <?php echo $order['name']; ?><br>
    <strong>Status:</strong> <?php echo $order['status']; ?><br>
    <strong>Tanggal:</strong> <?php echo $order['order_date']; ?><br>
    <strong>Total:</strong> Rp<?php echo number_format($order['total_amount'], 0, ',', '.'); ?><br>
</div>
<h3 class="font-bold mb-2">Item:</h3>
<div class="overflow-x-auto">
    <table class="w-full bg-white rounded shadow mb-4 border border-black">
        <thead class="bg-brown-100 border-b-2 border-black">
            <tr>
                <th class="py-2 px-4 border-r border-black">Menu</th>
                <th class="py-2 px-4 border-r border-black">Harga</th>
                <th class="py-2 px-4 border-r border-black">Qty</th>
                <th class="py-2 px-4">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($d = $details->fetch_assoc()): ?>
                <tr class="border-b border-black">
                    <td class="py-2 px-4 border-r border-black align-middle"><?php echo $d['name']; ?></td>
                    <td class="py-2 px-4 border-r border-black align-middle">Rp<?php echo number_format($d['price_at_time'], 0, ',', '.'); ?></td>
                    <td class="py-2 px-4 border-r border-black align-middle"><?php echo $d['quantity']; ?></td>
                    <td class="py-2 px-4 align-middle">Rp<?php echo number_format($d['price_at_time'] * $d['quantity'], 0, ',', '.'); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php if ($payment): ?>
    <div class="mb-4">
        <strong>Pembayaran:</strong> <?php echo $payment['payment_method']; ?><br>
        <strong>Jumlah:</strong> Rp<?php echo number_format($payment['amount'], 0, ',', '.'); ?><br>
        <strong>Status:</strong> <?php echo $payment['status']; ?><br>
        <strong>Tanggal:</strong> <?php echo $payment['payment_date']; ?><br>
    </div>
<?php endif; ?>
<a href="orders.php" class="inline-block bg-brown-700 hover:bg-brown-800 text-white px-6 py-2 rounded">Kembali</a>
<?php include 'admin_footer.php'; ?>