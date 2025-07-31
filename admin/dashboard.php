<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
include '../includes/db.php';
include 'admin_header.php';

// Statistik
$menu_count = $conn->query("SELECT COUNT(*) FROM menu")->fetch_row()[0];
$user_count = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
$order_count = $conn->query("SELECT COUNT(*) FROM orders")->fetch_row()[0];
$total_income = $conn->query("SELECT SUM(total_amount) FROM orders WHERE status='paid'")->fetch_row()[0];
if (!$total_income) $total_income = 0;
?>
<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-white">Dashboard Admin</h2>
</div>
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded shadow p-6 text-center">
        <div class="text-3xl font-bold text-brown-700 mb-2"><?php echo $menu_count; ?></div>
        <div class="text-gray-600">Menu</div>
    </div>
    <div class="bg-white rounded shadow p-6 text-center">
        <div class="text-3xl font-bold text-brown-700 mb-2"><?php echo $user_count; ?></div>
        <div class="text-gray-600">User</div>
    </div>
    <div class="bg-white rounded shadow p-6 text-center">
        <div class="text-3xl font-bold text-brown-700 mb-2"><?php echo $order_count; ?></div>
        <div class="text-gray-600">Order</div>
    </div>
    <div class="bg-white rounded shadow p-6 text-center">
        <div class="text-3xl font-bold text-brown-700 mb-2">Rp<?php echo number_format($total_income, 0, ',', '.'); ?></div>
        <div class="text-gray-600">Total Income</div>
    </div>
</div>
<div class="bg-white rounded shadow p-6">
    <h3 class="font-bold mb-4">Order Terbaru</h3>
    <div class="overflow-x-auto">
        <table class="w-full border border-black">
            <thead class="bg-brown-100 border-b-2 border-black">
                <tr>
                    <th class="py-2 px-4 border-r border-black">Order ID</th>
                    <th class="py-2 px-4 border-r border-black">User</th>
                    <th class="py-2 px-4 border-r border-black">Total</th>
                    <th class="py-2 px-4 border-r border-black">Status</th>
                    <th class="py-2 px-4">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $orders = $conn->query("SELECT o.*, u.name FROM orders o JOIN users u ON o.user_id=u.user_id ORDER BY o.order_id DESC LIMIT 5");
                while ($o = $orders->fetch_assoc()): ?>
                    <tr class="border-b border-black">
                        <td class="py-2 px-4 border-r border-black align-middle"><?php echo $o['order_id']; ?></td>
                        <td class="py-2 px-4 border-r border-black align-middle"><?php echo $o['name']; ?></td>
                        <td class="py-2 px-4 border-r border-black align-middle">Rp<?php echo number_format($o['total_amount'], 0, ',', '.'); ?></td>
                        <td class="py-2 px-4 border-r border-black align-middle"><?php echo $o['status']; ?></td>
                        <td class="py-2 px-4 align-middle"><?php echo $o['order_date']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'admin_footer.php'; ?>