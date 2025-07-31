// Menu filter script for Sepintas Coffee

document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('#menu .flex button');
    const menuItems = document.querySelectorAll('#menu-items .menu-item');

    const menuSection = document.getElementById('menu');
    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active style from all buttons
            buttons.forEach(b => b.classList.remove('ring-2', 'ring-amber-500', 'font-extrabold'));
            // Add active style to clicked button
            btn.classList.add('ring-2', 'ring-amber-500', 'font-extrabold');

            const filter = btn.textContent.trim().toLowerCase();
            menuItems.forEach(item => {
                if (filter === 'all') {
                    item.style.display = '';
                } else if (filter === 'snack') {
                    // snack = pastry
                    item.style.display = item.classList.contains('snack') ? '' : 'none';
                } else {
                    item.style.display = item.classList.contains(filter) ? '' : 'none';
                }
            });
            // Scroll ke section menu
            if (menuSection) {
                menuSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});

// Cart logic for pelanggan
let cart = JSON.parse(localStorage.getItem('cart')) || [];

function updateCartCount() {
    document.getElementById('cart-count').textContent = cart.reduce((sum, item) => sum + item.qty, 0);
    const mobileCart = document.getElementById('mobile-cart-count');
    if (mobileCart) mobileCart.textContent = cart.reduce((sum, item) => sum + item.qty, 0);
}

function toggleCart() {
    document.getElementById('cart-sidebar').classList.toggle('translate-x-full');
    document.getElementById('cart-overlay').classList.toggle('hidden');
    renderCartItems();
}

function addToCart(menuId, name, price, image) {
    let found = cart.find(item => item.menuId === menuId);
    if (found) {
        found.qty += 1;
    } else {
        cart.push({ menuId, name, price, image, qty: 1 });
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
}

function removeFromCart(menuId) {
    cart = cart.filter(item => item.menuId !== menuId);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    renderCartItems();
}

function renderCartItems() {
    const cartItemsDiv = document.getElementById('cart-items');
    if (!cart.length) {
        cartItemsDiv.innerHTML = `<div class="text-center py-8 text-gray-500">
            <i class='fas fa-shopping-cart text-4xl mb-4'></i>
            <p>Your cart is empty</p>
        </div>`;
        document.getElementById('cart-subtotal').textContent = '$0.00';
        document.getElementById('cart-tax').textContent = '$0.00';
        document.getElementById('cart-total').textContent = '$0.00';
        document.getElementById('checkout-btn').disabled = true;
        return;
    }
    let subtotal = 0;
    cartItemsDiv.innerHTML = cart.map(item => {
        subtotal += (item.price * item.qty);
        return `<div class='flex items-center justify-between mb-4'>
            <div class='flex items-center gap-3'>
                <img src='${item.image}' alt='${item.name}' class='w-12 h-12 object-cover rounded'>
                <div>
                    <div class='font-bold'>${item.name}</div>
                    <div class='text-sm text-gray-500'>Qty: ${item.qty}</div>
                </div>
            </div>
            <div class='flex flex-col items-end'>
                <div class='font-semibold'>Rp${item.price.toLocaleString('id-ID')}</div>
                <button onclick="removeFromCart('${item.menuId}')" class='text-xs text-red-500 hover:underline mt-1'>Remove</button>
            </div>
        </div>`;
    }).join('');
    const tax = subtotal * 0.1;
    const total = subtotal + tax;
    document.getElementById('cart-subtotal').textContent = 'Rp' + subtotal.toLocaleString('id-ID');
    document.getElementById('cart-tax').textContent = 'Rp' + tax.toLocaleString('id-ID');
    document.getElementById('cart-total').textContent = 'Rp' + total.toLocaleString('id-ID');
    document.getElementById('checkout-btn').disabled = false;
}

// Tambahkan tombol Add to Cart di setiap menu item
document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
    // Tambahkan tombol ke setiap menu item
    document.querySelectorAll('.menu-item').forEach(function(card) {
        if (!card.querySelector('.add-to-cart-btn')) {
            const name = card.querySelector('h3').textContent;
            const image = card.querySelector('img').src;
            // Ambil harga dari database jika ada, atau set 0
            let price = 0;
            // Coba ambil harga dari atribut data-price jika sudah ada
            if (card.dataset.price) price = parseInt(card.dataset.price);
            // Ambil id menu dari data-menu-id jika sudah ada
            let menuId = card.dataset.menuId || name;
            const btn = document.createElement('button');
            btn.textContent = 'Add to Cart';
            btn.className = 'add-to-cart-btn mt-3 bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-6 rounded-full transition duration-300 shadow';
            btn.onclick = function() {
                addToCart(menuId, name, price, image);
            };
            card.appendChild(btn);
        }
    });
    document.getElementById('cart-btn').onclick = toggleCart;
    document.getElementById('cart-overlay').onclick = toggleCart;
    // Tambahkan event untuk tombol keranjang di mobile menu
    var mobileCartBtn = document.querySelector('#mobile-menu button[onclick*="toggleCart"]');
    if (mobileCartBtn) {
        mobileCartBtn.onclick = function(e) {
            e.preventDefault();
            toggleCart();
        };
    }
    renderCartItems();
});
