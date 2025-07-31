<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sepintas Coffee</title>
    <link rel="icon" href="/assets/images/logo.png">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/assets/js/main.js" defer></script>
</head>

<body class="bg-gray-50 text-gray-900">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full bg-white shadow z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <div class="flex items-center">
                <a href="#home" class="flex items-center">
                    <img src="/assets/images/logo.png" alt="Logo" class="h-10 w-10 mr-2">
                    <span class="font-bold text-xl">Sepintas Coffee</span>
                </a>
            </div>
            <div class="hidden md:flex space-x-6">
                <a href="#home" class="hover:text-brown-700">Home</a>
                <a href="#about" class="hover:text-brown-700">About</a>
                <a href="#menu" class="hover:text-brown-700">Menu</a>
                <a href="#gallery" class="hover:text-brown-700">Gallery</a>
                <a href="#contact" class="hover:text-brown-700">Contact</a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="/cart.php" class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A1 1 0 007.5 17h9a1 1 0 00.85-1.53L17 13M7 13V6a1 1 0 011-1h3m4 0h2a1 1 0 011 1v7" />
                    </svg>
                    <span id="cart-badge" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full px-1">
                        <?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0; ?>
                    </span>
                </a>
                <button id="mobile-menu-btn" class="md:hidden focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden px-4 pb-4 bg-white">
            <a href="#home" class="block py-2">Home</a>
            <a href="#about" class="block py-2">About</a>
            <a href="#menu" class="block py-2">Menu</a>
            <a href="#gallery" class="block py-2">Gallery</a>
            <a href="#contact" class="block py-2">Contact</a>
        </div>
    </nav>
    <div class="pt-16"></div>