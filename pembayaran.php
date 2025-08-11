<?php
session_start();
include 'admin/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $telepon = $_POST['telepon'];
    $metode_pengambilan = $_POST['metode_pengambilan'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $catatan = $_POST['catatan'] ?? '';
    $subtotal = $_POST['subtotal'];
    $total = $_POST['total'];
    $created_at = date('Y-m-d H:i:s');

    // Simpan ke tabel orders
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, phone, metode_pengambilan, subtotal, total, note, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssddss", $nama, $telepon, $metode_pengambilan, $subtotal, $total, $catatan, $created_at);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // Simpan ke tabel order_detail
    foreach ($_SESSION['cart'] as $menu_id => $item) {
        $quantity = $item['quantity'];
        $stmt_detail = $conn->prepare("INSERT INTO order_detail (order_id, menu_id, quantity) VALUES (?, ?, ?)");
        $stmt_detail->bind_param("iii", $order_id, $menu_id, $quantity);
        $stmt_detail->execute();
    }

    // Simpan ke tabel payment (status masih pending/manual)
    $status = "Belum Dibayar";
    $stmt_payment = $conn->prepare("INSERT INTO payment (order_id, total_amount, payment_method, status) VALUES (?, ?, ?, ?)");
    $stmt_payment->bind_param("idss", $order_id, $total, $metode_pembayaran, $status);
    $stmt_payment->execute();

    // Hapus keranjang
    unset($_SESSION['cart']);
}
?>

<?php include 'header.php'; ?>

<main class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-b from-red-900 via-red-950 to-black text-white px-6">
    <div class="bg-white text-black p-8 rounded-xl shadow-lg max-w-md text-center">
        <h2 class="text-2xl font-bold mb-4">✅ Orderan sedang dibuat</h2>
        <p class="mb-6">Terima kasih, <?= htmlspecialchars($nama) ?>.<br>
            Silakan lakukan pembayaran sesuai metode yang dipilih: <strong><?= ucfirst($metode_pembayaran) ?></strong>.
        </p>

        <a href="menu.php" class="inline-block bg-amber-600 hover:bg-amber-700 text-white px-6 py-2 rounded-lg transition font-semibold">
            Kembali ke Menu
        </a>
    </div>
</main>

<?php include 'footer.php'; ?>