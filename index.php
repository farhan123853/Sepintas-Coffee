<?php
session_start();
include 'admin/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script type="module" src="https://cdn.jsdelivr.net/gh/domyid/tracker@main/index.js"></script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sepintas Coffee - Where Every Sip Becomes a Memory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="styles.css" />
</head>

<body class="font-sans bg-gray-900 text-white">
    <!-- Navbar -->
    <nav class="flex justify-between items-center py-4 px-8 shadow-md bg-gradient-to-r from-amber-900 via-[#3c2f28] to-black">

        <!-- Kiri: Logo -->
        <div class="flex items-center space-x-2 text-2xl font-bold text-white">
            <img src="https://raw.githubusercontent.com/farhan123853/assets/refs/heads/main/logo.jpeg" alt="Logo" class="h-8 w-auto">
            <span>☕</span>
            <span>Sepintas Coffee</span>
        </div>

        <!-- Tengah: Navigasi -->
        <div class="space-x-6 hidden md:flex text-sm font-medium text-white">
            <a href="index.php" class="hover:text-amber-400 transition flex items-center">
                <i class="fas fa-home mr-1"></i> Beranda
            </a>
            <a href="#menu" class="hover:text-amber-400 transition flex items-center">
                <i class="fas fa-mug-hot mr-1"></i> Menu
            </a>
            <a href="#about" class="hover:text-amber-400 transition flex items-center">
                <i class="fas fa-info-circle mr-1"></i> Tentang Kami
            </a>
            <a href="#contact" class="hover:text-amber-400 transition flex items-center">
                <i class="fas fa-phone-alt mr-1"></i> Kontak
            </a>
        </div>

        <!-- Kanan: Cart + Login/Register atau Nama + Logout -->
        <div class="flex items-center space-x-4 text-sm text-white">
            <!-- Keranjang -->
            <a href="cart.php" class="relative hover:text-amber-400 transition">
                <i class="fas fa-shopping-cart text-xl"></i>
                <?php
                $total_items = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
                if ($total_items > 0):
                ?>
                    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                        <?= $total_items ?>
                    </span>
                <?php endif; ?>
            </a>

            <!-- Autentikasi -->
            <?php if (!isset($_SESSION['customer_id'])): ?>
                <a href="customer/login_customer.php" class="hover:text-amber-400 transition flex items-center">
                    <i class="fas fa-sign-in-alt mr-1"></i> Login
                </a>
                <a href="customer/register_customer.php" class="hover:text-amber-400 transition flex items-center">
                    <i class="fas fa-user-plus mr-1"></i> Register
                </a>
            <?php else: ?>
                <!-- Nama User -->
                <span class="text-amber-300 hidden md:inline-flex items-center">
                    <i class="fas fa-user-circle mr-1"></i> Halo, <strong class="ml-1"><?= htmlspecialchars($_SESSION['customer_name']); ?></strong>
                </span>
                <!-- Logout -->
                <a href="customer/logout_customer.php" class="hover:text-red-400 transition flex items-center">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </a>
            <?php endif; ?>
        </div>
    </nav>





    <!-- Hero Section -->
    <section id="home" class="relative h-screen flex items-center justify-center text-center overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="https://raw.githubusercontent.com/farhan123853/assets/refs/heads/main/9a55dcc0af24ad05f76206bf8bb3363a.jpg"
                alt="Sepintas Coffee Background"
                class="w-full h-full object-cover object-center" />
            <div class="absolute inset-0 bg-black opacity-70"></div>
        </div>
        <!-- Content -->
        <div class="relative z-10 w-full flex flex-col items-center justify-center">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 drop-shadow-lg">
                Selamat Datang di Sepintas Coffee
            </h1>
            <p class="text-lg md:text-2xl text-amber-100 mb-8 font-medium drop-shadow">
                Rasakan kehangatan kopi terbaik dengan biji kopi Nusantara dan cita rasa yang istimewa
            </p>
            <button onclick="scrollToMenu()" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-10 rounded-full transition duration-300 shadow-lg text-lg">
                Order Now
            </button>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gradient-to-r from-[#7b2323] via-[#5a1717] to-black">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-2">Tentang Kami</h2>
                <div class="w-32 h-1 bg-amber-500 mx-auto mb-2"></div>
            </div>
            <div class="flex flex-col md:flex-row items-center md:items-start gap-10">
                <div class="md:w-1/2 mb-8 md:mb-0 md:pr-8 flex justify-center">
                    <img src="https://raw.githubusercontent.com/farhan123853/assets/refs/heads/main/9a55dcc0af24ad05f76206bf8bb3363a.jpg" alt="sepintas coffee" class="rounded-xl shadow-2xl w-full max-w-xl object-cover">
                </div>
                <div class="md:w-1/2 bg-transparent">
                    <h3 class="text-3xl font-bold text-white mb-4">Sepintas Coffee</h3>
                    <p class="text-white text-lg mb-6">
                        Sepintas Coffee adalah tempat yang mengundang setiap penikmat kopi untuk merasakan pengalaman tak terlupakan di setiap tegukan. Berdiri sejak 2015, kami berkomitmen untuk menyajikan kopi terbaik yang tidak hanya menggugah selera, tetapi juga memberikan suasana nyaman yang membuat setiap kunjungan menjadi kenangan manis.<br><br>
                        Dari biji kopi pilihan yang dipetik langsung dari petani berkelanjutan, hingga teknik roasting yang dipersonalisasi, setiap cangkir kopi yang kami sajikan merupakan hasil perpaduan sempurna antara seni dan keahlian. Nikmati varian kopi yang kaya rasa, disajikan dengan sentuhan profesionalisme, diiringi dengan atmosfer yang hangat dan desain modern yang memanjakan mata.<br><br>
                        Di Sepintas Coffee, kami percaya bahwa setiap tegukan kopi adalah cerita, dan kami ingin berbagi cerita itu dengan Anda. Apakah Anda datang untuk menikmati secangkir kopi yang menenangkan atau sekadar bersantai dengan teman-teman, tempat kami selalu siap menyambut Anda.<br><br>
                        Kunjungi kami dan rasakan betapa istimewanya setiap secangkir kopi yang kami sajikan, karena di sini, kopi lebih dari sekadar minuman—ini adalah pengalaman.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-seedling text-amber-400 text-2xl"></i>
                            <span class="text-white text-lg">Ethically Sourced Beans</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-fire text-amber-400 text-2xl"></i>
                            <span class="text-white text-lg">Small-Batch Roasted</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-heart text-amber-400 text-2xl"></i>
                            <span class="text-white text-lg">Handcrafted with Care</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-leaf text-amber-400 text-2xl"></i>
                            <span class="text-white text-lg">Sustainable Practices</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section id="menu" class="py-20 bg-gradient-to-r from-[#7b2323] via-[#5a1717] to-black">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-2">Our Menu</h2>
                <div class="w-32 h-1 bg-amber-500 mx-auto mb-6"></div>
                <!-- Kategori Menu (Tombol dengan Teks) -->
                <div class="flex flex-wrap justify-center gap-4 mb-10">
                    <button class="px-8 py-3 bg-white text-black font-bold rounded-full shadow hover:bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-500 transition text-lg uppercase">ALL</button>
                    <button class="px-8 py-3 bg-white text-black font-bold rounded-full shadow hover:bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-500 transition text-lg uppercase">COFFEE</button>
                    <button class="px-8 py-3 bg-white text-black font-bold rounded-full shadow hover:bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-500 transition text-lg uppercase">NON-COFFEE</button>
                    <button class="px-8 py-3 bg-white text-black font-bold rounded-full shadow hover:bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-500 transition text-lg uppercase">SNACK</button>
                </div>
            </div>

            <?php
            include 'admin/db.php';

            $query = "SELECT * FROM menu";
            $result = mysqli_query($conn, $query) or die("Query error: " . mysqli_error($conn));
            ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" id="menu-items">
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <div class="menu-item <?= htmlspecialchars($row['category'] ?? '') ?> bg-white p-6 rounded-lg shadow-lg text-center">
                        <img src="<?= htmlspecialchars($row['image_url'] ?? '') ?>" alt="<?= htmlspecialchars($row['name'] ?? '') ?>" class="w-full h-48 object-cover mb-4 rounded">

                        <h3 class="text-xl font-semibold text-amber-600 mb-2">
                            <?= htmlspecialchars($row['name'] ?? '') ?>
                        </h3>

                        <p class="text-sm text-gray-500 italic mb-2">
                            <?= htmlspecialchars($row['category'] ?? '') ?>
                        </p>

                        <p class="text-gray-700 text-sm mb-2">
                            <?= htmlspecialchars($row['description'] ?? '') ?>
                        </p>

                        <p class="text-lg font-bold text-gray-900 mb-4">
                            Rp <?= isset($row['price']) ? number_format($row['price'], 0, ',', '.') : '0' ?>
                        </p>

                        <a href="detail/<?= urlencode(strtolower(str_replace(' ', '-', $row['name'] ?? ''))) ?>.php" class="inline-block mt-2 bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-6 rounded-full transition">
                            Pesan Disini
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>


        </div>
    </section>

    <!-- Contact Section / Visit Us -->
    <section id="contact" class="py-20 bg-gradient-to-r from-[#7b2323] via-[#5a1717] to-black">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-2">Visit Us</h2>
                <p class="text-center mb-10 text-lg text-white-300">Kunjungi langsung kedai kami dan rasakan suasana hangat khas Sepintas Coffee.</p>
                <div class="w-32 h-1 bg-amber-500 mx-auto mb-2"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Contact & Social -->
                <div class="bg-white rounded-xl shadow-2xl p-10 flex flex-col justify-between min-h-[350px]">
                    <div class="mb-8">
                        <div class="flex items-center mb-4 text-amber-500 text-xl">
                            <i class="fas fa-map-marker-alt mr-3"></i>
                            <span class="text-base text-gray-800">Perum Acropolis Karadenan RT 08 RW 18 Cibinong, Bogor</span>
                        </div>
                        <div class="flex items-center mb-4 text-amber-500 text-xl">
                            <i class="fas fa-clock mr-3"></i>
                            <span class="text-base text-gray-800">Mon-Fri: 7:00-21:00, Sat-Sun: 8:00-22:00</span>
                        </div>
                        <div class="flex items-center mb-4 text-amber-500 text-xl">
                            <i class="fas fa-phone-alt mr-3"></i>
                            <span class="text-base text-gray-800">+62 85789051693</span>
                        </div>
                        <div class="flex items-center mb-8 text-amber-500 text-xl">
                            <i class="fas fa-envelope mr-3"></i>
                            <span class="text-base text-gray-800">sepintascoffee@gmail.com</span>
                        </div>
                    </div>
                    <div>
                        <div class="flex space-x-4 mt-4">
                            <a href="#" class="bg-amber-100 hover:bg-amber-200 text-amber-700 w-10 h-10 rounded-full flex items-center justify-center transition text-xl">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="bg-amber-100 hover:bg-amber-200 text-amber-700 w-10 h-10 rounded-full flex items-center justify-center transition text-xl">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="bg-amber-100 hover:bg-amber-200 text-amber-700 w-10 h-10 rounded-full flex items-center justify-center transition text-xl">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="bg-amber-100 hover:bg-amber-200 text-amber-700 w-10 h-10 rounded-full flex items-center justify-center transition text-xl">
                                <i class="fab fa-tiktok"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Map -->
                <div class="bg-white rounded-xl shadow-2xl p-6 flex items-center justify-center min-h-[350px]">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.304964295553!2d106.8309793147696!3d-6.214620995498998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e7e2e2e2e3%3A0x2e2e2e2e2e2e2e2e!2sPerpustakaan%20Nasional%20Republik%20Indonesia!5e0!3m2!1sen!2sid!4v1627891234567!5m2!1sen!2sid" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" class="rounded-lg"></iframe>
                </div>
            </div>
        </div>
    </section>


    <!-- Newsletter Section -->
    <section class="py-16 bg-gradient-to-r from-[#7b2323] via-[#5a1717] to-black text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-extrabold mb-4">Join Our Coffee Club</h2>
            <p class="mb-8 max-w-2xl mx-auto">Subscribe to our newsletter and get 10% off your first order plus exclusive access to new flavors and special events.</p>
            <form class="max-w-xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-2">
                <input type="email" placeholder="Your email address" class="flex-grow px-6 py-3 rounded-l-full rounded-r-full sm:rounded-r-none focus:outline-none text-gray-900">
                <button type="submit" class="bg-amber-700 hover:bg-amber-800 px-8 py-3 rounded-full font-semibold transition">Subscribe</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#4b2e13] text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="text-center md:text-left">
                    <h3 class="text-2xl font-bold mb-2">Sepintas Coffee</h3>
                    <p class="mb-4">Where every sip becomes a memory. Serving quality coffee since 2015.</p>
                    <div class="flex justify-center md:justify-start space-x-4 text-2xl">
                        <a href="#" class="hover:text-amber-400"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="hover:text-amber-400"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="hover:text-amber-400"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="text-center md:text-left">
                    <h4 class="font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#home" class="hover:text-amber-400 transition">Home</a></li>
                        <li><a href="#about" class="hover:text-amber-400 transition">About Us</a></li>
                        <li><a href="#menu" class="hover:text-amber-400 transition">Menu</a></li>
                        <li><a href="#gallery" class="hover:text-amber-400 transition">Gallery</a></li>
                        <li><a href="#contact" class="hover:text-amber-400 transition">Contact</a></li>
                    </ul>
                </div>
                <div class="text-center md:text-left">
                    <h4 class="font-bold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-amber-400 transition">FAQs</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition">Shipping Policy</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition">Return Policy</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="text-center md:text-left">
                    <h4 class="font-bold mb-4">Contact Info</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center justify-center md:justify-start text-amber-400"><i class="fas fa-map-marker-alt mr-2"></i><span class="text-white">123 Coffee Street, Jakarta 12345</span></li>
                        <li class="flex items-center justify-center md:justify-start text-amber-400"><i class="fas fa-phone-alt mr-2"></i><span class="text-white">+62 123 4567 890</span></li>
                        <li class="flex items-center justify-center md:justify-start text-amber-400"><i class="fas fa-envelope mr-2"></i><span class="text-white">hello@sepintascoffee.com</span></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-amber-800 pt-8 text-center">
                <p>&copy; 2023 Sepintas Coffee. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Shopping Cart Sidebar -->
    <div id="cart-sidebar" class="fixed top-0 right-0 h-full w-full md:w-96 bg-white shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out z-50 overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold">Your Order</h3>
                <button onclick="toggleCart()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <span class="order-step bg-amber-600 text-white rounded-full h-8 w-8 flex items-center justify-center">1</span>
                        <span class="font-medium">Order</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="order-step bg-gray-200 text-gray-700 rounded-full h-8 w-8 flex items-center justify-center">2</span>
                        <span class="font-medium text-gray-500">Payment</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="order-step bg-gray-200 text-gray-700 rounded-full h-8 w-8 flex items-center justify-center">3</span>
                        <span class="font-medium text-gray-500">Complete</span>
                    </div>
                </div>
            </div>
            <div id="cart-items" class="mb-6">
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-shopping-cart text-4xl mb-4"></i>
                    <p>Your cart is empty</p>
                </div>
            </div>
            <div class="border-t border-gray-200 pt-4 mb-6">
                <div class="flex justify-between mb-2">
                    <span>Subtotal</span>
                    <span id="cart-subtotal">$0.00</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span>Tax (10%)</span>
                    <span id="cart-tax">$0.00</span>
                </div>
                <div class="flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span id="cart-total">$0.00</span>
                </div>
            </div>
            <button id="checkout-btn" onclick="proceedToCheckout()" class="w-full bg-amber-600 hover:bg-amber-700 text-white py-3 px-4 rounded-lg font-bold transition disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                Proceed to Checkout
            </button>
        </div>
    </div>
    <div id="cart-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="toggleCart()"></div>

    <!-- Payment Modal -->
    <div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg w-full max-w-md mx-4">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold">Payment Information</h3>
                    <button onclick="closePaymentModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <span class="order-step bg-gray-200 text-gray-700 rounded-full h-8 w-8 flex items-center justify-center">1</span>
                            <span class="font-medium text-gray-500">Order</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="order-step bg-amber-600 text-white rounded-full h-8 w-8 flex items-center justify-center">2</span>
                            <span class="font-medium">Payment</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="order-step bg-gray-200 text-gray-700 rounded-full h-8 w-8 flex items-center justify-center">3</span>
                            <span class="font-medium text-gray-500">Complete</span>
                        </div>
                    </div>
                </div>
                <form id="payment-form" class="space-y-4">
                    <div>
                        <label for="card-name" class="block mb-1 font-medium">Name on Card</label>
                        <input type="text" id="card-name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                    </div>
                    <div>
                        <label for="card-number" class="block mb-1 font-medium">Card Number</label>
                        <input type="text" id="card-number" placeholder="1234 5678 9012 3456" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="card-expiry" class="block mb-1 font-medium">Expiry Date</label>
                            <input type="text" id="card-expiry" placeholder="MM/YY" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                        </div>
                        <div>
                            <label for="card-cvc" class="block mb-1 font-medium">CVC</label>
                            <input type="text" id="card-cvc" placeholder="123" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 pt-4 mb-6">
                        <div class="flex justify-between font-bold text-lg">
                            <span>Total</span>
                            <span id="payment-total">$0.00</span>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white py-3 px-4 rounded-lg font-bold transition">
                        Pay Now
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Order Complete Modal -->
    <div id="complete-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg w-full max-w-md mx-4 p-8 text-center">
            <div class="text-green-500 text-6xl mb-4">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3 class="text-2xl font-bold mb-2">Order Complete!</h3>
            <p class="mb-6">Thank you for your order. Your coffee will be ready soon.</p>
            <p class="text-sm text-gray-500 mb-6">Order #<span id="order-number">12345</span></p>
            <button onclick="closeCompleteModal()" class="bg-amber-600 hover:bg-amber-700 text-white py-2 px-6 rounded-lg font-medium transition">
                Back to Menu
            </button>
        </div>
    </div>

    <script src="scripts.js"></script>
</body>

</html>