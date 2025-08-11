<?php
session_start();
include 'header.php';
include 'admin/db.php';

$order_id = $_GET['order_id'] ?? 0;
$order_id = (int) $order_id;

if (!$order_id) {
    echo "<div class='text-white p-8'>ID pesanan tidak ditemukan.</div>";
    include 'footer.php';
    exit;
}

// Ambil data order
$order_query = $conn->query("
    SELECT o.*, p.payment_method 
    FROM orders o 
    LEFT JOIN payment p ON o.order_id = p.order_id 
    WHERE o.order_id = $order_id
");
$order = $order_query->fetch_assoc();

if (!$order) {
    echo "<div class='text-white p-8'>Data pesanan tidak ditemukan.</div>";
    include 'footer.php';
    exit;
}

// Ambil data detail item
$items_query = $conn->query("
    SELECT od.*, m.name, m.price 
    FROM order_detail od 
    JOIN menu m ON od.menu_id = m.menu_id 
    WHERE od.order_id = $order_id
");
?>

<section class="min-h-screen bg-gradient-to-b from-red-900 to-black text-white py-10">
    <div class="max-w-3xl mx-auto bg-white text-black rounded-xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-center mb-4 text-amber-700">Invoice Pembayaran</h2>

        <!-- Informasi Pelanggan -->
        <div class="border-b border-gray-300 pb-4 mb-4">
            <p><span class="font-semibold">Nama Pelanggan:</span> <?= htmlspecialchars($order['customer_name'] ?? '-') ?></p>
            <p><span class="font-semibold">No. Telepon:</span> <?= htmlspecialchars($order['phone'] ?? '-') ?></p>
            <p><span class="font-semibold">Metode Pengambilan:</span> <?= htmlspecialchars($order['metode_pengambilan'] ?? '-') ?></p>
            <p><span class="font-semibold">Metode Pembayaran:</span> <?= htmlspecialchars($order['payment_method'] ?? '-') ?></p>
            <p><span class="font-semibold">Catatan:</span> <?= !empty($order['note']) ? htmlspecialchars($order['note']) : '-' ?></p>
            <p><span class="font-semibold">Tanggal Pesan:</span> <?= isset($order['created_at']) ? date('d-m-Y H:i', strtotime($order['created_at'])) : '-' ?></p>
        </div>

        <!-- Rincian Pesanan -->
        <div class="mb-4">
            <h3 class="text-xl font-semibold mb-2 text-amber-700">Rincian Pesanan</h3>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-amber-700 text-white">
                        <th class="p-2 border">Menu</th>
                        <th class="p-2 border">Jumlah</th>
                        <th class="p-2 border">Harga</th>
                        <th class="p-2 border">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $subtotal = 0;
                    while ($item = $items_query->fetch_assoc()):
                        $total = $item['price'] * $item['quantity'];
                        $subtotal += $total;
                    ?>
                        <tr class="border-t">
                            <td class="p-2 border"><?= htmlspecialchars($item['name']) ?></td>
                            <td class="p-2 border"><?= $item['quantity'] ?></td>
                            <td class="p-2 border">Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td class="p-2 border">Rp<?= number_format($total, 0, ',', '.') ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Ringkasan Pembayaran -->
        <?php
        $tax = $subtotal * 0.10;
        $grand_total = $subtotal + $tax;
        ?>
        <div class="mt-6 text-right">
            <p class="text-lg"><strong>Subtotal:</strong> Rp<?= number_format($subtotal, 0, ',', '.') ?></p>
            <p class="text-lg"><strong>PPN 10%:</strong> Rp<?= number_format($tax, 0, ',', '.') ?></p>
            <p class="text-xl font-bold text-amber-700"><strong>Total:</strong> Rp<?= number_format($grand_total, 0, ',', '.') ?></p>
        </div>

        <!-- Tombol -->
        <div class="mt-8 text-center">
            <a href="menu.php" class="inline-block bg-amber-700 hover:bg-amber-800 text-white px-6 py-2 rounded-full font-semibold">
                Kembali ke Menu
            </a>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>