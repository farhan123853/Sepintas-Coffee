<?php include 'header.php'; ?>
<?php include 'admin/functions.php'; ?>

<?php
// Ambil kategori unik dari database
$categories = array();
$result = $conn->query("SELECT DISTINCT category FROM menu");
while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
}

// Ambil data menu
$where = '';
if (isset($_GET['category']) && $_GET['category'] != 'all') {
    $cat = $conn->real_escape_string($_GET['category']);
    $where = "WHERE category = '" . $cat . "'";
}
$menu = $conn->query("SELECT * FROM menu $where");
?>

<section class="py-16 min-h-screen bg-gradient-to-b from-red-900 to-black text-black">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Judul -->
        <h2 class="text-4xl font-extrabold text-white text-center mb-2 relative">
            Our Menu
            <div class="w-24 h-1 bg-amber-500 mx-auto mt-2"></div>
        </h2>

        <!-- Filter Kategori -->
        <div class="flex flex-wrap justify-center gap-4 mb-8 mt-6">
            <a href="?category=all"
                class="px-6 py-2 rounded-full font-bold border border-amber-700 bg-white text-black hover:bg-amber-700 hover:text-white transition <?php if (!isset($_GET['category']) || $_GET['category'] == 'all') echo 'bg-amber-700 text-white'; ?>">
                ALL
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="?category=<?php echo $cat; ?>"
                    class="px-6 py-2 rounded-full font-bold border border-amber-700 bg-white text-black hover:bg-amber-700 hover:text-white transition <?php if (isset($_GET['category']) && $_GET['category'] == $cat) echo 'bg-amber-700 text-white'; ?>">
                    <?php echo strtoupper($cat); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Daftar Menu -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php while ($item = $menu->fetch_assoc()): ?>
                <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center">
                    <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['name']; ?>" class="w-32 h-32 object-cover rounded mb-4">
                    <h3 class="font-bold text-xl mb-2 text-center text-black"><?php echo $item['name']; ?></h3>
                    <p class="mb-2 text-center text-black"><?php echo $item['description']; ?></p>
                    <div class="font-bold text-amber-700 mb-2">Rp<?php echo number_format($item['price'], 0, ',', '.'); ?></div>
                    
                    <form method="post" action="cart.php" class="w-full flex flex-col items-center">
                        <input type="hidden" name="menu_id" value="<?php echo $item['menu_id']; ?>">

                        <!-- Jumlah -->
                        <input type="number" name="quantity" value="1" min="1" class="w-16 mb-2 text-center rounded border border-gray-300 text-black">

                        <!-- Tombol Pesan -->
                        <button type="submit" name="add_to_cart" class="bg-amber-700 hover:bg-amber-800 text-white px-4 py-2 rounded-lg font-semibold w-full">
                            Pesan sekarang
                        </button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
