<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

include __DIR__ . '/db.php';
include 'admin_header.php';

$order_id = intval($_GET['id']);

// Ambil data order utama
$order = $conn->query("
    SELECT * 
    FROM orders 
    WHERE order_id = $order_id
")->fetch_assoc();

// Ambil detail item yang dipesan
$details = $conn->query("
    SELECT od.*,
        m.name,
        ROUND(od.price * od.quantity * 1.10, 0) AS subtotal_with_tax
        FROM order_detail od
        JOIN menu m ON od.menu_id = m.menu_id
        WHERE od.order_id = $order_id
");

// Ambil data pembayaran
$payment = $conn->query("
    SELECT * 
    FROM payment 
    WHERE order_id = $order_id
")->fetch_assoc();
?>

<div class="min-h-screen bg-gradient-to-b from-red-900 to-black p-8">
    <h2 class="text-2xl font-bold mb-6 text-white">Detail Order #<?= $order_id; ?></h2>

    <div class="mb-6 text-white space-y-2">
        <p><strong>Nama Pelanggan:</strong> <?= htmlspecialchars($order['customer_name'] ?? '-'); ?></p>
        <p><strong>Tanggal Order:</strong> <?= htmlspecialchars($order['created_at'] ?? '-'); ?></p>
        <p><strong>Total Order:</strong> Rp<?= number_format($order['total'] ?? 0, 0, ',', '.'); ?></p>
    </div>

    <h3 class="text-xl font-bold mb-4 text-white">Rincian Item:</h3>
    <div class="overflow-x-auto">
        <table class="w-full bg-white rounded shadow mb-6 border border-black">
            <thead class="bg-gray-100 border-b-2 border-black">
                <tr>
                    <th class="py-2 px-4 border-r border-black">Menu</th>
                    <th class="py-2 px-4 border-r border-black">Harga</th>
                    <th class="py-2 px-4 border-r border-black">Qty</th>
                    <th class="py-2 px-4">Subtotal </th>
                </tr>
            </thead>
            <tbody>
                <?php while ($d = $details->fetch_assoc()): ?>
                    <tr class="border-b border-black text-center">
                        <td class="py-2 px-4 border-r border-black"><?= htmlspecialchars($d['name'] ?? '-'); ?></td>
                        <td class="py-2 px-4 border-r border-black">Rp<?= number_format($d['price'] ?? 0, 0, ',', '.'); ?></td>
                        <td class="py-2 px-4 border-r border-black"><?= (int)($d['quantity'] ?? 0); ?></td>
                        <td class="py-2 px-4">Rp<?= number_format($d['subtotal_with_tax'], 0, ',', '.') ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <h3 class="text-xl font-bold mb-4 text-white">Informasi Pembayaran:</h3>
    <div class="mb-6 text-white space-y-2">
        <p><strong>Metode Pembayaran:</strong> <?= htmlspecialchars($payment['payment_method'] ?? $order['metode_pembayaran'] ?? 'Belum dipilih'); ?></p>
        <p><strong>Metode Pengambilan:</strong> <?= htmlspecialchars($order['metode_pengambilan'] ?? 'Belum dipilih'); ?></p>
        <p><strong>Jumlah Bayar:</strong> Rp<?= number_format($payment['total_amount'] ?? 0, 0, ',', '.'); ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($payment['status'] ?? 'Belum Dibayar'); ?></p>
        <p><strong>Tanggal Pembayaran:</strong> <?= htmlspecialchars($payment['payment_date'] ?? $order['created_at'] ?? '-'); ?></p>
    </div>

    <a href="orders.php" class="inline-block bg-amber-700 hover:bg-amber-800 text-white px-6 py-2 rounded">Kembali</a>
</div>

<?php include 'admin_footer.php'; ?>