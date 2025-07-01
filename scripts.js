// Fungsi untuk memfilter menu berdasarkan kategori
function filterMenu(category) {
    const menuItems = document.querySelectorAll('.menu-item');
    
    if (category === 'all') {
        menuItems.forEach(item => {
            item.style.display = 'block'; // Menampilkan semua produk
        });
    } else {
        menuItems.forEach(item => {
            if (item.classList.contains(category)) {
                item.style.display = 'block'; // Menampilkan produk sesuai kategori
            } else {
                item.style.display = 'none'; // Menyembunyikan produk lain
            }
        });
    }
}
