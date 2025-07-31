<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>
<?php include 'includes/functions.php'; ?>

<?php
// Tambah ke cart
if (isset($_POST['add_to_cart'])) {
    $menu_id = intval($_POST['menu_id']);
    $qty = intval($_POST['quantity']);
    add_to_cart($menu_id, $qty);
    header('Location: cart.php');
    exit;
}
// Hapus item
if (isset($_GET['remove'])) {
    remove_from_cart(intval($_GET['remove']));
    header('Location: cart.php');
    exit;
}
$items = get_cart_items();
$menu_data = array();
$subtotal = 0;
if ($items) {
    $ids = implode(',', array_map('intval', array_keys($items)));
    $result = $conn->query("SELECT * FROM menu WHERE menu_id IN ($ids)");
    while ($row = $result->fetch_assoc()) {
        $menu_data[$row['menu_id']] = $row;
    }
}
?>

<section class="py-16 min-h-screen bg-white">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Shopping Cart</h2>
        <?php if (!$items): ?>
            <div class="text-center text-gray-500">Keranjang kosong.</div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full mb-8">
                    <thead>
                        <tr class="bg-brown-100">
                            <th class="py-2 px-4">Produk</th>
                            <th class="py-2 px-4">Harga</th>
                            <th class="py-2 px-4">Qty</th>
                            <th class="py-2 px-4">Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $id => $item):
                            $data = $menu_data[$id];
                            $item_sub = $data['price'] * $item['quantity'];
                            $subtotal += $item_sub;
                        ?>
                            <tr>
                                <td class="py-2 px-4 flex items-center gap-2"><img src="<?php echo $data['image_url']; ?>" class="w-12 h-12 object-cover rounded"> <?php echo $data['name']; ?></td>
                                <td class="py-2 px-4">Rp<?php echo number_format($data['price'], 0, ',', '.'); ?></td>
                                <td class="py-2 px-4 text-center"><?php echo $item['quantity']; ?></td>
                                <td class="py-2 px-4">Rp<?php echo number_format($item_sub, 0, ',', '.'); ?></td>
                                <td class="py-2 px-4"><a href="?remove=<?php echo $id; ?>" class="text-red-500 hover:underline">Hapus</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php
            $tax = $subtotal * 0.10;
            $total = $subtotal + $tax;
            ?>
            <div class="text-right mb-8">
                <div>Subtotal: <span class="font-bold">Rp<?php echo number_format($subtotal, 0, ',', '.'); ?></span></div>
                <div>Pajak (10%): <span class="font-bold">Rp<?php echo number_format($tax, 0, ',', '.'); ?></span></div>
                <div class="text-xl mt-2">Total: <span class="font-bold text-brown-700">Rp<?php echo number_format($total, 0, ',', '.'); ?></span></div>
            </div>
            <div class="flex justify-end">
                <a href="checkout.php" class="bg-brown-700 hover:bg-brown-800 text-white px-6 py-3 rounded-lg font-semibold">Checkout</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>