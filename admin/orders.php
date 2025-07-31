<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
include '../includes/db.php';
include 'admin_header.php';

$orders = $conn->query("SELECT o.*, u.name FROM orders o JOIN users u ON o.user_id=u.user_id ORDER BY o.order_id DESC");
?>
<h2 class="text-2xl font-bold mb-6 text-white">Daftar Order</h2>
<div class="overflow-x-auto">
    <table class="w-full bg-white rounded shadow border border-black mb-8">
        <thead class="bg-brown-100 border-b-2 border-black">
            <tr>
                <th class="py-2 px-4 border-r border-black">Order ID</th>
                <th class="py-2 px-4 border-r border-black">Nama User</th>
                <th class="py-2 px-4 border-r border-black">Total</th>
                <th class="py-2 px-4 border-r border-black">Status</th>
                <th class="py-2 px-4 border-r border-black">Tanggal</th>
                <th class="py-2 px-4">Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($o = $orders->fetch_assoc()): ?>
                <tr class="border-b border-black">
                    <td class="py-2 px-4 border-r border-black align-middle"><?php echo $o['order_id']; ?></td>
                    <td class="py-2 px-4 border-r border-black align-middle"><?php echo $o['name']; ?></td>
                    <td class="py-2 px-4 border-r border-black align-middle">Rp<?php echo number_format($o['total_amount'], 0, ',', '.'); ?></td>
                    <td class="py-2 px-4 border-r border-black align-middle"><?php echo $o['status']; ?></td>
                    <td class="py-2 px-4 border-r border-black align-middle"><?php echo $o['order_date']; ?></td>
                    <td class="py-2 px-4 align-middle"><a href="order_detail.php?id=<?php echo $o['order_id']; ?>" class="text-blue-600 hover:underline">Lihat</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include 'admin_footer.php'; ?>