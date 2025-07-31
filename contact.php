<?php include 'includes/header.php'; ?>
<section class="py-16 min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Contact Us</h2>
        <p class="mb-4">Jl. Kopi No. 1, Jakarta<br>Open: 07.00 - 22.00 WIB<br>Telp: 021-12345678<br>Email: info@sepintascoffee.com</p>
        <div class="w-full h-64 mb-4">
            <iframe src="https://www.google.com/maps?q=jakarta&output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <form action="subscribe.php" method="post" class="flex flex-col md:flex-row gap-2 justify-center mt-4">
            <input type="email" name="email" required placeholder="Subscribe to our newsletter" class="px-4 py-2 rounded-l-lg border border-gray-300 focus:outline-none">
            <button type="submit" class="bg-brown-700 hover:bg-brown-800 text-white px-6 py-2 rounded-r-lg font-semibold">Subscribe</button>
        </form>
    </div>
</section>
<?php include 'includes/footer.php'; ?>