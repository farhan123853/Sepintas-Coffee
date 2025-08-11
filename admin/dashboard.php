<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

include __DIR__ . '/db.php';
include 'admin_header.php';

// Statistik
$menu_count     = $conn->query("SELECT COUNT(*) FROM menu")->fetch_row()[0] ?? 0;
$user_count     = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0] ?? 0;
$order_count    = $conn->query("SELECT COUNT(*) FROM orders")->fetch_row()[0] ?? 0;
$total_income   = $conn->query("SELECT SUM(total) FROM orders")->fetch_row()[0] ?? 0;
?>

<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-white">Dashboard Admin</h2>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded shadow p-6 text-center">
        <div class="text-3xl font-bold text-brown-700 mb-2"><?= $menu_count ?></div>
        <div class="text-gray-600">Menu</div>
    </div>
    <div class="bg-white rounded shadow p-6 text-center">
        <div class="text-3xl font-bold text-brown-700 mb-2"><?= $user_count ?></div>
        <div class="text-gray-600">User</div>
    </div>
    <div class="bg-white rounded shadow p-6 text-center">
        <div class="text-3xl font-bold text-brown-700 mb-2"><?= $order_count ?></div>
        <div class="text-gray-600">Order</div>
    </div>
    <div class="bg-white rounded shadow p-6 text-center">
        <div class="text-3xl font-bold text-brown-700 mb-2">Rp<?= number_format($total_income, 0, ',', '.') ?></div>
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
                    <th class="py-2 px-4 border-r border-black">Nama</th>
                    <th class="py-2 px-4 border-r border-black">Total</th>
                    <th class="py-2 px-4 border-r border-black">Tanggal</th>
                    <th class="py-2 px-4 border-r border-black">Metode Pengambilan</th>
                    <th class="py-2 px-4">Metode Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $orders = $conn->query("SELECT * FROM orders ORDER BY order_id DESC LIMIT 5");
                if ($orders && $orders->num_rows > 0):
                    while ($o = $orders->fetch_assoc()): ?>
                        <tr class="border-b border-black">
                            <td class="py-2 px-4 border-r border-black"><?= htmlspecialchars($o['order_id']) ?></td>
                            <td class="py-2 px-4 border-r border-black"><?= htmlspecialchars($o['customer_name']) ?></td>
                            <td class="py-2 px-4 border-r border-black">Rp<?= number_format($o['total'], 0, ',', '.') ?></td>
                            <td class="py-2 px-4 border-r border-black"><?= htmlspecialchars($o['created_at']) ?></td>
                            <td class="py-2 px-4 border-r border-black"><?= htmlspecialchars($o['metode_pengambilan']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($o['metode_pembayaran']) ?></td>
                        </tr>
                    <?php endwhile;
                else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">Belum ada order.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'admin_footer.php'; ?>