<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>
<?php include 'includes/functions.php'; ?>

<?php
$items = get_cart_items();
if (!$items) {
    header('Location: cart.php');
    exit;
}
$menu_data = array();
$subtotal = 0;
$ids = implode(',', array_map('intval', array_keys($items)));
$result = $conn->query("SELECT * FROM menu WHERE menu_id IN ($ids)");
while ($row = $result->fetch_assoc()) {
    $menu_data[$row['menu_id']] = $row;
}
foreach ($items as $id => $item) {
    $subtotal += $menu_data[$id]['price'] * $item['quantity'];
}
$tax = $subtotal * 0.10;
$total = $subtotal + $tax;

// Simulasi user_id (harusnya dari session login)
$user_id = 1;

// Proses checkout
$order_complete = false;
if (isset($_POST['pay'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $cc = $conn->real_escape_string($_POST['cc']);
    $exp = $conn->real_escape_string($_POST['exp']);
    $cvc = $conn->real_escape_string($_POST['cvc']);
    // Simpan order
    $conn->query("INSERT INTO orders (user_id, total_amount, status, order_date) VALUES ($user_id, $total, 'paid', NOW())");
    $order_id = $conn->insert_id;
    foreach ($items as $id => $item) {
        $price = $menu_data[$id]['price'];
        $qty = $item['quantity'];
        $conn->query("INSERT INTO order_detail (order_id, menu_id, quantity, price_at_time) VALUES ($order_id, $id, $qty, $price)");
    }
    $conn->query("INSERT INTO payment (order_id, payment_method, amount, payment_date, status) VALUES ($order_id, 'credit_card', $total, NOW(), 'success')");
    clear_cart();
    $order_complete = true;
}
?>

<section class="py-16 min-h-screen bg-white">
    <div class="max-w-2xl mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Checkout</h2>
        <?php if ($order_complete): ?>
            <div id="order-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 z-50">
                <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                    <h3 class="text-2xl font-bold mb-4">Order Complete!</h3>
                    <p class="mb-4">Thank you for your order at Sepintas Coffee.</p>
                    <a href="index.php" class="bg-brown-700 hover:bg-brown-800 text-white px-6 py-2 rounded-lg">Back to Home</a>
                </div>
            </div>
            <script>
                setTimeout(() => {
                    document.getElementById('order-modal').style.display = 'none';
                    window.location = 'index.php';
                }, 3000);
            </script>
        <?php else: ?>
            <form method="post" class="bg-gray-100 p-6 rounded-lg shadow">
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 rounded border border-gray-300">
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Credit Card</label>
                    <input type="text" name="cc" required maxlength="16" class="w-full px-4 py-2 rounded border border-gray-300" placeholder="1234 5678 9012 3456">
                </div>
                <div class="flex gap-4 mb-4">
                    <div class="flex-1">
                        <label class="block mb-1 font-semibold">Expiry</label>
                        <input type="text" name="exp" required maxlength="5" class="w-full px-4 py-2 rounded border border-gray-300" placeholder="MM/YY">
                    </div>
                    <div class="flex-1">
                        <label class="block mb-1 font-semibold">CVC</label>
                        <input type="text" name="cvc" required maxlength="4" class="w-full px-4 py-2 rounded border border-gray-300" placeholder="123">
                    </div>
                </div>
                <div class="mb-4 text-right">
                    <div>Subtotal: <span class="font-bold">Rp<?php echo number_format($subtotal, 0, ',', '.'); ?></span></div>
                    <div>Pajak (10%): <span class="font-bold">Rp<?php echo number_format($tax, 0, ',', '.'); ?></span></div>
                    <div class="text-xl mt-2">Total: <span class="font-bold text-brown-700">Rp<?php echo number_format($total, 0, ',', '.'); ?></span></div>
                </div>
                <button type="submit" name="pay" class="w-full bg-brown-700 hover:bg-brown-800 text-white px-6 py-3 rounded-lg font-semibold">Bayar &amp; Selesaikan Order</button>
            </form>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>