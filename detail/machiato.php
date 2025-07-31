<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - Machiato</title>
    <link rel="stylesheet" href="../styles.css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white min-h-screen flex flex-col">
    <div class="container mx-auto px-4 py-10 flex-1">
        <a href="../index.php#menu" class="text-amber-500 hover:underline mb-6 inline-block">&larr; Kembali ke Menu</a>
        <div class="bg-white rounded-lg shadow-lg p-8 flex flex-col md:flex-row items-center">
            <img src="../machiato.jpg" alt="Machiato" class="w-full md:w-1/3 h-64 object-cover rounded mb-6 md:mb-0 md:mr-8">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-amber-700 mb-4">Machiato</h1>
                <p class="text-gray-800 mb-4">Kopi Machiato dengan perpaduan espresso dan foam susu, memberikan sensasi rasa yang khas dan nikmat.</p>
                <form action="../cart.php" method="post" class="mt-4">
                    <input type="hidden" name="menu_id" value="">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" name="add_to_cart" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-full transition inline-block text-center">Pesan Sekarang</button>
                </form>
                <a href="../cart.php" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-full transition inline-block text-center">Pesan Sekarang</a>
                <form action="../cart.php" method="post" class="mt-4">
                    <input type="hidden" name="menu_id" value="2">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" name="add_to_cart" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-full transition inline-block text-center">Pesan Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>