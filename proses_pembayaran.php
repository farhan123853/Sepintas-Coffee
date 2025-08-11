<?php
session_start();
include 'admin/db.php';
include 'admin/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $name            = $_POST['customer_name'];
    $phone           = $_POST['phone'];
    $pickup_method   = $_POST['pickup_method']; // Diubah jadi 'metode_pengambilan' di query
    $payment_method  = $_POST['payment_method'];
    $note            = $_POST['note'] ?? '';
    $cart_items      = get_cart_items();
    $subtotal        = calculate_subtotal($cart_items);
    $tax             = $subtotal * 0.10;
    $total           = $subtotal + $tax;
    $order_date      = date('Y-m-d H:i:s');

    // Ambil tanggal dan waktu sekarang dalam format MySQL yang valid
    $order_date = date('Y-m-d H:i:s');

    // Simpan ke tabel orders
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, phone, metode_pengambilan, metode_pembayaran, total, created_at) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssds", $name, $phone, $pickup_method, $payment_method, $total, $order_date);
    if (!$stmt->execute()) {
        die("Gagal simpan orders: " . $stmt->error);
    }
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Simpan ke tabel order_detail
    $stmt_detail = $conn->prepare("INSERT INTO order_detail (order_id, menu_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($cart_items as $item) {
        $stmt_detail->bind_param("iiid", $order_id, $item['menu_id'], $item['quantity'], $item['price']);
        $stmt_detail->execute();
    }
    $stmt_detail->close();

    // Simpan ke tabel payment
    $stmt_payment = $conn->prepare("INSERT INTO payment (order_id, total_amount, payment_method, status, payment_date) VALUES (?, ?, ?, ?, ?)");
    $status = "Belum Dibayar";
    $stmt_payment->bind_param("idsss", $order_id, $total, $payment_method, $status, $order_date);
    $stmt_payment->execute();


    // Kosongkan keranjang
    clear_cart();

    // Redirect ke halaman invoice
    header("Location: invoice.php?order_id=$order_id");
    exit;
} else {
    echo "<p class='text-white'>Akses tidak sah.</p>";
}
