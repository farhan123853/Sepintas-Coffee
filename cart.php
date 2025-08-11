<?php
include 'header.php';
include 'admin/functions.php';
include 'admin/db.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// Tambah ke cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $menu_id = intval($_POST['menu_id']);
    $quantity = max(1, intval($_POST['quantity']));
    add_to_cart($menu_id, $quantity);
    header("Location: cart.php");
    exit;
}

// Update quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_qty'])) {
    $menu_id = intval($_POST['menu_id']);
    $new_qty = max(1, intval($_POST['quantity']));
    update_cart_quantity($menu_id, $new_qty);
    exit;
}

// Hapus item
if (isset($_GET['remove'])) {
    remove_from_cart(intval($_GET['remove']));
    header("Location: cart.php");
    exit;
}

// Ambil isi keranjang
$items = get_cart_items();
$menu_data = [];
$subtotal = 0;

if ($items) {
    $ids = implode(',', array_map('intval', array_keys($items)));
    $result = $conn->query("SELECT * FROM menu WHERE menu_id IN ($ids)");
    while ($row = $result->fetch_assoc()) {
        $menu_data[$row['menu_id']] = $row;
    }
}
?>

<main class="min-h-screen py-10 px-6 bg-gradient-to-b from-red-900 via-red-950 to-black text-black">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-xl font-semibold mb-6">🛒 Keranjang Belanja Anda</h2>

        <?php if (empty($items)): ?>
            <p class="text-center text-gray-600">Keranjang kosong.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 text-black">
                    <thead class="bg-amber-100">
                        <tr>
                            <th class="px-4 py-2 border">Produk</th>
                            <th class="px-4 py-2 border">Harga</th>
                            <th class="px-4 py-2 border">Qty</th>
                            <th class="px-4 py-2 border">Subtotal</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $id => $item): ?>
                            <?php if (!isset($menu_data[$id])) continue; ?>
                            <?php
                            $data = $menu_data[$id];
                            $item_sub = $data['price'] * $item['quantity'];
                            $subtotal += $item_sub;
                            ?>
                            <tr class="text-center">
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($data['name']); ?></td>
                                <td class="px-4 py-2 border">Rp<?php echo number_format($data['price'], 0, ',', '.'); ?></td>
                                <td class="px-4 py-2 border">
                                    <input
                                        type="number"
                                        name="quantity"
                                        value="<?php echo $item['quantity']; ?>"
                                        min="1"
                                        data-id="<?php echo $id; ?>"
                                        class="qty-input w-16 border rounded text-center text-sm">
                                </td>
                                <td class="px-4 py-2 border">Rp<?php echo number_format($item_sub, 0, ',', '.'); ?></td>
                                <td class="px-4 py-2 border">
                                    <a href="?remove=<?php echo $id; ?>" class="text-red-600 hover:underline text-sm" onclick="return confirm('Yakin ingin menghapus item ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="bg-gray-100 font-semibold">
                            <td colspan="3" class="px-4 py-2 text-right">Subtotal</td>
                            <td colspan="2" class="px-4 py-2">Rp<?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                        </tr>
                        <tr class="bg-gray-100">
                            <td colspan="3" class="px-4 py-2 text-right">Pajak (10%)</td>
                            <td colspan="2" class="px-4 py-2">Rp<?php echo number_format($subtotal * 0.10, 0, ',', '.'); ?></td>
                        </tr>
                        <tr class="bg-amber-100 font-bold">
                            <td colspan="3" class="px-4 py-2 text-right">Total</td>
                            <td colspan="2" class="px-4 py-2 text-green-600">Rp<?php echo number_format($subtotal * 1.10, 0, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-right mt-6">
                <a href="checkout.php" class="inline-block bg-amber-600 text-white px-6 py-2 rounded hover:bg-amber-700 transition">Checkout</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
    // Auto update qty saat diubah
    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('change', function () {
            const menuId = this.getAttribute('data-id');
            const quantity = this.value;

            const formData = new FormData();
            formData.append('menu_id', menuId);
            formData.append('quantity', quantity);
            formData.append('update_qty', '1');

            fetch('cart.php', {
                method: 'POST',
                body: formData
            }).then(() => {
                window.location.reload();
            });
        });
    });
</script>

<?php include 'footer.php'; ?>
