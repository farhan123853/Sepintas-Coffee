<?php
session_start();

include 'admin/db.php';

$order_id = $_GET['order_id'] ?? 0;

if (!$order_id) {
    echo "<p class='text-white'>Order ID tidak ditemukan.</p>";
    exit;
}

// Ambil data order dan pembayaran
$query = $conn->query("
    SELECT o.*, p.payment_method, p.status AS payment_status 
    FROM orders o 
    LEFT JOIN payment p ON o.order_id = p.order_id 
    WHERE o.order_id = $order_id
");
$order = $query->fetch_assoc();

if (!$order) {
    echo "<p class='text-white'>Data pesanan tidak ditemukan.</p>";
    exit;
}

// Ambil detail produk dari order_detail
$items = [];
$detail = $conn->query("
     SELECT od.*, m.name 
    FROM order_detail od 
    JOIN menu m ON od.menu_id = m.menu_id 
    WHERE od.order_id = $order_id
");

while ($row = $detail->fetch_assoc()) {
    $items[] = $row;
}
?>

<div class="min-h-screen bg-gradient-to-b from-red-900 to-black text-white p-8">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-6 text-black">
        <h2 class="text-2xl font-bold text-center mb-4">Pembayaran Berhasil</h2>
        <p class="text-center mb-6">Terima kasih atas pesanan Anda. Berikut adalah detail pesanan Anda:</p>

        <div class="mb-4">
            <p><strong>Nama:</strong> <?= htmlspecialchars($order['name']) ?></p>
            <p><strong>Telepon:</strong> <?= htmlspecialchars($order['phone']) ?></p>
            <p><strong>Metode Pengambilan:</strong> <?= htmlspecialchars($order['pickup_method']) ?></p>
            <p><strong>Metode Pembayaran:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
            <p><strong>Catatan:</strong> <?= htmlspecialchars($order['notes']) ?></p>
            <p><strong>Status Pembayaran:</strong> <?= htmlspecialchars($order['payment_status']) ?></p>
            <p><strong>Tanggal:</strong> <?= htmlspecialchars($order['created_at']) ?></p>
        </div>

        <h3 class="text-xl font-semibold mb-2 mt-4">Detail Pesanan</h3>
        <table class="w-full border border-gray-300 mb-4 text-sm">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-2 py-1">Produk</th>
                    <th class="border px-2 py-1">Jumlah</th>
                    <th class="border px-2 py-1">Harga</th>
                    <th class="border px-2 py-1">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $subtotal = 0;
                foreach ($items as $item):
                    $total = $item['qty'] * $item['price'];
                    $subtotal += $total;
                ?>
                    <tr>
                        <td class="border px-2 py-1"><?= htmlspecialchars($item['nama_menu']) ?></td>
                        <td class="border px-2 py-1 text-center"><?= $item['qty'] ?></td>
                        <td class="border px-2 py-1 text-right">Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
                        <td class="border px-2 py-1 text-right">Rp<?= number_format($total, 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-right text-lg font-bold">
            Total: Rp<?= number_format($subtotal, 0, ',', '.') ?>
        </div>

        <div class="text-center mt-6">
            <button onclick="window.print()" class="bg-red-700 hover:bg-red-800 text-white font-semibold py-2 px-4 rounded">
                Cetak Invoice
            </button>
        </div>
    </div>
</div>

<script>
    // Cetak otomatis saat halaman dibuka
    window.onload = function() {
        setTimeout(() => {
            window.print();
        }, 500);
    }
</script>

<?php include 'footer.php'; ?>
