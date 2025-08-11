<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

include __DIR__ . '/db.php';
include 'admin_header.php';

// Ambil data order terbaru
$orders = $conn->query("SELECT * FROM orders ORDER BY order_id DESC");
?>

<h2 class="text-2xl font-bold mb-6 text-white">Daftar Order</h2>

<div class="overflow-x-auto">
    <table class="w-full bg-white rounded shadow border border-black mb-8">
        <thead class="bg-brown-100 border-b-2 border-black">
            <tr>
                <th class="py-2 px-4 border-r border-black">Order ID</th>
                <th class="py-2 px-4 border-r border-black">Customer</th>
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
                    <td class="py-2 px-4 border-r border-black align-middle"><?php echo htmlspecialchars($o['customer_name']); ?></td>
                    <td class="py-2 px-4 border-r border-black align-middle">Rp<?php echo number_format($o['total'], 0, ',', '.'); ?></td>
                    <td class="py-2 px-4 border-r border-black align-middle"><?php echo htmlspecialchars($o['status'] ?? '-'); ?></td>
                    <td class="py-2 px-4 border-r border-black align-middle"><?php echo $o['created_at'] ?? '-'; ?></td>
                    <td class="py-2 px-4 align-middle">
                        <a href="order_detail.php?id=<?php echo $o['order_id']; ?>" class="text-blue-600 hover:underline">Lihat</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'admin_footer.php'; ?>