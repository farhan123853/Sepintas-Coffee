<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sepintas Coffee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body class="text-white">

    <!-- Header / Navbar -->
    <header class="bg-gradient-to-r from-[#4E342E] via-[#2E1E1A] to-black shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <!-- Logo dan Judul -->
            <div class="flex items-center gap-4">
                <img src="https://raw.githubusercontent.com/farhan123853/assets/refs/heads/main/logo.jpeg" alt="Logo Sepintas Coffee" class="h-10 w-10 object-cover rounded-full">
                <h1 class="text-2xl font-bold">Sepintas Coffee</h1>
            </div>

            <!-- Navigasi -->
            <nav class="space-x-6 font-medium text-white">
                <a href="index.php" class="hover:text-yellow-400 transition-all duration-200">
                    <i class="fas fa-home mr-1"></i> Beranda
                </a>
                <a href="menu.php" class="hover:text-yellow-400 transition-all duration-200">
                    <i class="fas fa-mug-hot mr-1"></i> Menu
                </a>
                <a href="cart.php" class="hover:text-yellow-400 transition-all duration-200">
                    <i class="fas fa-shopping-cart mr-1"></i> Keranjang
                </a>
            </nav>
        </div>
    </header>