<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>
<?php include 'includes/functions.php'; ?>

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

<section class="py-16 bg-white min-h-screen">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Menu</h2>
        <div class="flex flex-wrap justify-center gap-2 mb-8">
            <a href="?category=all" class="filter-btn px-4 py-2 rounded-lg font-semibold border border-brown-700 text-brown-700 hover:bg-brown-700 hover:text-white transition <?php if (!isset($_GET['category']) || $_GET['category'] == 'all') echo 'bg-brown-700 text-white'; ?>">All</a>
            <?php foreach ($categories as $cat): ?>
                <a href="?category=<?php echo $cat; ?>" class="filter-btn px-4 py-2 rounded-lg font-semibold border border-brown-700 text-brown-700 hover:bg-brown-700 hover:text-white transition <?php if (isset($_GET['category']) && $_GET['category'] == $cat) echo 'bg-brown-700 text-white'; ?>"><?php echo ucfirst($cat); ?></a>
            <?php endforeach; ?>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php while ($item = $menu->fetch_assoc()): ?>
                <div class="bg-gray-100 rounded-lg shadow p-4 flex flex-col items-center">
                    <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['name']; ?>" class="w-32 h-32 object-cover rounded mb-4">
                    <h3 class="font-bold text-xl mb-2"><?php echo $item['name']; ?></h3>
                    <p class="mb-2 text-gray-700"><?php echo $item['description']; ?></p>
                    <div class="font-bold text-brown-700 mb-2">Rp<?php echo number_format($item['price'], 0, ',', '.'); ?></div>
                    <form method="post" action="cart.php" class="w-full flex flex-col items-center">
                        <input type="hidden" name="menu_id" value="<?php echo $item['menu_id']; ?>">
                        <input type="number" name="quantity" value="1" min="1" class="w-16 mb-2 text-center rounded border border-gray-300">
                        <button type="submit" name="add_to_cart" class="bg-brown-700 hover:bg-brown-800 text-white px-4 py-2 rounded-lg font-semibold w-full">Add to Cart</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>