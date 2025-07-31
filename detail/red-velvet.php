<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - Hot Red Velvet</title>
    <link rel="stylesheet" href="../styles.css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white min-h-screen flex flex-col">
    <div class="container mx-auto px-4 py-10 flex-1">
        <a href="../index.php#menu" class="text-amber-500 hover:underline mb-6 inline-block">&larr; Kembali ke Menu</a>
        <div class="bg-white rounded-lg shadow-lg p-8 flex flex-col md:flex-row items-center">
            <img src="../Red Velvet.jpg" alt="Hot Red Velvet" class="w-full md:w-1/3 h-64 object-cover rounded mb-6 md:mb-0 md:mr-8">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-amber-700 mb-4">Hot Red Velvet</h1>
                <p class="text-gray-800 mb-4">Minuman red velvet hangat dengan rasa manis dan lembut, cocok untuk menemani waktu santai Anda.</p>
                <button class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-full transition">Pesan Sekarang</button>
                <a href="../cart.php" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-full transition inline-block text-center">Pesan Sekarang</a>
                <form action="../cart.php" method="post" class="mt-4">
                    <input type="hidden" name="menu_id" value="5">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" name="add_to_cart" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-full transition inline-block text-center">Pesan Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>