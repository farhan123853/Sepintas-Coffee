<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include __DIR__ . '/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Sepintas Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-[#7b2323] via-[#3a1010] to-black text-black">
    <nav class="bg-gradient-to-r from-[#5a3a1a] to-black text-white px-6 py-4 flex justify-between items-center shadow-lg">
        <div class="flex items-center gap-2">
            <img src="https://raw.githubusercontent.com/farhan123853/assets/refs/heads/main/logo.jpeg" alt="Logo" class="h-10 w-10 rounded shadow bg-white object-cover">
            <span class="font-extrabold text-2xl tracking-wide text-white drop-shadow">ADMIN</span>
            <span class="ml-2 px-2 py-1 bg-black text-yellow-400 rounded text-xs font-bold">Sepintas Coffee</span>
        </div>
        <div class="space-x-2 md:space-x-4 font-semibold">
            <a href="dashboard.php" class="px-3 py-1 rounded text-yellow-300 hover:bg-yellow-400 hover:text-brown-900 transition">🏠 Dashboard</a>
            <a href="menu_crud.php" class="px-3 py-1 rounded text-yellow-300 hover:bg-yellow-400 hover:text-brown-900 transition">☕ Menu</a>
            <a href="orders.php" class="px-3 py-1 rounded text-yellow-300 hover:bg-yellow-400 hover:text-brown-900 transition">📦 Orders</a>
            <a href="users.php" class="px-3 py-1 rounded text-yellow-300 hover:bg-yellow-400 hover:text-brown-900 transition">👤 Users</a>
            <a href="logout.php" class="px-3 py-1 rounded bg-red-600 hover:bg-red-700 text-white transition">Logout</a>
        </div>
    </nav>
    <div class="max-w-5xl mx-auto py-8">