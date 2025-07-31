<?php
// Helper functions for Sepintas Coffee

function get_cart_count()
{
    return isset($_SESSION['cart']) ? array_sum(array_map(function ($item) {
        return $item['quantity'];
    }, $_SESSION['cart'])) : 0;
}

function get_cart_items()
{
    return isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
}

function add_to_cart($menu_id, $quantity = 1)
{
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = array();
    if (isset($_SESSION['cart'][$menu_id])) {
        $_SESSION['cart'][$menu_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$menu_id] = array('menu_id' => $menu_id, 'quantity' => $quantity);
    }
}

function remove_from_cart($menu_id)
{
    if (isset($_SESSION['cart'][$menu_id])) {
        unset($_SESSION['cart'][$menu_id]);
    }
}

function clear_cart()
{
    unset($_SESSION['cart']);
}
