<?php
include __DIR__ . '/db.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// Tambahkan item ke keranjang
function add_to_cart($menu_id, $qty = 1)
{
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $menu_id = (int)$menu_id;
    $qty = max(1, (int)$qty);

    // Gabungkan quantity jika item sudah ada
    if (isset($_SESSION['cart'][$menu_id])) {
        $_SESSION['cart'][$menu_id]['quantity'] += $qty;
    } else {
        $_SESSION['cart'][$menu_id] = [
            'quantity' => $qty
        ];
    }
}

// Update jumlah item di keranjang
function update_cart_quantity($menu_id, $new_qty)
{
    $menu_id = (int)$menu_id;
    $new_qty = max(1, (int)$new_qty);

    if (isset($_SESSION['cart'][$menu_id])) {
        $_SESSION['cart'][$menu_id]['quantity'] = $new_qty;
    }
}

// Hapus item dari keranjang
function remove_from_cart($menu_id)
{
    $menu_id = (int)$menu_id;

    if (isset($_SESSION['cart'][$menu_id])) {
        unset($_SESSION['cart'][$menu_id]);
    }
}

// Ambil seluruh item keranjang beserta data lengkap dari database
function get_cart_items()
{
    global $conn;

    if (empty($_SESSION['cart'])) return [];

    $items = [];

    foreach ($_SESSION['cart'] as $menu_id => $cart_item) {
        $menu_id = (int)$menu_id;
        $quantity = (int)$cart_item['quantity'];

        $result = $conn->query("SELECT * FROM menu WHERE menu_id = $menu_id");

        if ($result && $row = $result->fetch_assoc()) {
            $row['menu_id'] = $menu_id;
            $row['quantity'] = $quantity;
            $row['total'] = $row['price'] * $quantity;
            $items[$menu_id] = $row;
        }
    }

    return $items;
}

// Hitung subtotal dari keranjang
function calculate_subtotal($cart_items)
{
    $subtotal = 0;

    foreach ($cart_items as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }

    return $subtotal;
}

// Kosongkan keranjang
function clear_cart()
{
    unset($_SESSION['cart']);
}
