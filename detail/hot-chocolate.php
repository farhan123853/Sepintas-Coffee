<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Produk - Hot Chocolate</title>
    <link rel="stylesheet" href="../styles.css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white min-h-screen flex flex-col">
    <div class="container mx-auto px-4 py-10 flex-1">
        <a href="../index.php#menu" class="text-amber-500 hover:underline mb-6 inline-block">
            &larr; Kembali ke Menu
        </a>

        <div class="bg-white rounded-lg shadow-lg p-8 flex flex-col md:flex-row items-center">
            <img src="https://raw.githubusercontent.com/farhan123853/assets/refs/heads/main/coklat%20panas.jpg"
                alt="Hot Chocolate"
                class="w-full md:w-1/3 h-64 object-cover rounded mb-6 md:mb-0 md:mr-8" />

            <div class="flex-1 text-black">
                <h1 class="text-3xl font-bold text-amber-700 mb-4">Hot Chocolate</h1>
                <p class="text-gray-800 mb-4">
                    Coklat panas yang creamy dan lezat, cocok untuk segala suasana.
                </p>

                <!-- Tombol pemesanan -->
                <form action="../cart.php" method="post" class="mt-4">
                    <input type="hidden" name="menu_id" value="6">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" name="add_to_cart"
                        class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-full transition">
                        Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>