<?php
session_start();
include 'header.php';
include 'admin/db.php';
include 'admin/functions.php';

$items = get_cart_items();
if (!$items || empty($items)) {
    echo "<div class='min-h-screen flex items-center justify-center bg-gradient-to-b from-red-900 to-black text-white'>
            <p class='text-xl font-semibold'>Keranjang kamu kosong.</p>
          </div>";
    include 'footer.php';
    exit;
}
?>

<section class="min-h-screen bg-gradient-to-b from-red-900 to-black py-10 px-4 text-black">
    <div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Checkout</h2>

        <form action="proses_pembayaran.php" method="POST" class="space-y-6">
            <!-- Ringkasan Keranjang -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h3>
                <table class="w-full text-sm border border-gray-300">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="p-2 border">Produk</th>
                            <th class="p-2 border">Qty</th>
                            <th class="p-2 border">Harga</th>
                            <th class="p-2 border">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $subtotal = 0; ?>
                        <?php foreach ($items as $item): ?>
                            <?php $item_total = $item['price'] * $item['quantity'];
                            $subtotal += $item_total; ?>
                            <tr>
                                <td class="p-2 border"><?php echo $item['name']; ?></td>
                                <td class="p-2 border"><?php echo $item['quantity']; ?></td>
                                <td class="p-2 border">Rp<?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                                <td class="p-2 border">Rp<?php echo number_format($item_total, 0, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="font-semibold bg-gray-100">
                            <td colspan="3" class="p-2 border text-right">Subtotal</td>
                            <td class="p-2 border">Rp<?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                        </tr>
                        <tr class="font-semibold bg-gray-100">
                            <td colspan="3" class="p-2 border text-right">Pajak (10%)</td>
                            <td class="p-2 border">Rp<?php echo number_format($subtotal * 0.10, 0, ',', '.'); ?></td>
                        </tr>
                        <tr class="font-bold bg-amber-100">
                            <td colspan="3" class="p-2 border text-right">Total Bayar</td>
                            <td class="p-2 border text-green-600">Rp<?php echo number_format($subtotal * 1.10, 0, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Form Pelanggan -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Informasi Pelanggan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="customer_name" required placeholder="Nama Lengkap" class="border border-gray-300 rounded px-3 py-2">
                    <input type="text" name="phone" required placeholder="No. Telepon" class="border border-gray-300 rounded px-3 py-2">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <select name="pickup_method" required class="border border-gray-300 rounded px-3 py-2">
                        <option value="">Pilih Metode Pengambilan</option>
                        <option value="Dine In">Dine In</option>
                        <option value="Take Away">Take Away</option>
                    </select>
                    <select name="payment_method" required class="border border-gray-300 rounded px-3 py-2">
                        <option value="">Pilih Metode Pembayaran</option>
                        <option value="Tunai">Tunai</option>
                        <option value="Transfer Bank">Transfer Bank</option> <!-- diperbaiki -->
                        <option value="QRIS">QRIS</option>
                    </select>

                </div>
                <textarea name="note" rows="3" placeholder="Catatan (opsional)" class="border border-gray-300 rounded px-3 py-2 mt-4 w-full"></textarea>
            </div>

            <!-- Tombol Submit -->
            <div class="text-right">
                <button type="submit" class="bg-amber-600 text-white px-6 py-2 rounded hover:bg-amber-700 transition">
                    Bayar Sekarang
                </button>
            </div>
        </form>
    </div>
</section>

<?php include 'footer.php'; ?>