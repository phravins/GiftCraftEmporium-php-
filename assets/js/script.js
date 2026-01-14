// DOM Content Loaded
document.addEventListener('DOMContentLoaded', function() {
    // Load featured products
    loadFeaturedProducts();
    
    // Initialize cart functionality
    initCart();
    
    // Set up event listeners
    setupEventListeners();
});

// Load Featured Products
function loadFeaturedProducts() {
    const productsContainer = document.querySelector('#featured .grid');
    
    // Simulated product data - in a real app, this would come from an API
    const featuredProducts = [
        {
            id: 1,
            name: 'Personalized Wooden Photo Frame',
            category: 'Photo Frames',
            price: 24.99,
            image: 'http://static.photos/nature/640x360/10',
            available: true
        },
        {
            id: 2,
            name: 'Ocean Resin Coaster Set',
            category: 'Resin Arts',
            price: 19.99,
            image: 'http://static.photos/blue/640x360/20',
            available: true
        },
        {
            id: 3,
            name: 'Custom Engraved Jewelry Box',
            category: 'Customized Gifts',
            price: 34.99,
            image: 'http://static.photos/yellow/640x360/30',
            available: true
        },
        {
            id: 4,
            name: 'Handmade Ceramic Mug',
            category: 'Other Gifts',
            price: 16.99,
            image: 'http://static.photos/green/640x360/40',
            available: false
        }
    ];
    
    // Clear existing content
    productsContainer.innerHTML = '';
    
    // Add products to the page
    featuredProducts.forEach((product, index) => {
        const productCard = document.createElement('div');
        productCard.className = `product-card bg-white shadow-md rounded-lg overflow-hidden fade-in`;
        productCard.style.animationDelay = `${index * 0.1}s`;
        
        productCard.innerHTML = `
            <img src="${product.image}" alt="${product.name}" class="product-image w-full">
            <div class="p-4">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-semibold text-lg">${product.name}</h3>
                    <span class="text-purple-600 font-bold">$${product.price}</span>
                </div>
                <p class="text-gray-500 text-sm mb-3">${product.category}</p>
                <div class="flex justify-between items-center">
                    <span class="text-sm ${product.available ? 'text-green-500' : 'text-red-500'}">
                        ${product.available ? 'In Stock' : 'Out of Stock'}
                    </span>
                    <button class="add-to-cart-btn btn-primary px-4 py-2 rounded-md text-sm" 
                            data-id="${product.id}" 
                            ${!product.available ? 'disabled' : ''}>
                        Add to Cart
                    </button>
                </div>
            </div>
        `;
        
        productsContainer.appendChild(productCard);
    });
}

// Initialize Cart
function initCart() {
    // Check if cart exists in localStorage
    if (!localStorage.getItem('giftShopCart')) {
        localStorage.setItem('giftShopCart', JSON.stringify([]));
    }
}

// Setup Event Listeners
function setupEventListeners() {
    // Cart toggle buttons
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('cart-toggle') || 
            e.target.closest('.cart-toggle')) {
            const cartSidebar = document.querySelector('custom-cart-sidebar');
            cartSidebar.toggleCart();
        }
    });
    
    // Add to cart buttons
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('add-to-cart-btn')) {
            const productId = parseInt(e.target.getAttribute('data-id'));
            addToCart(productId);
            
            // Show a quick notification
            showNotification('Item added to cart!');
        }
    });
}

// Add to Cart Function
function addToCart(productId) {
    // In a real app, we would get the full product details from an API
    // For now, we'll just store the ID and quantity
    
    const cart = JSON.parse(localStorage.getItem('giftShopCart'));
    const existingItem = cart.find(item => item.id === productId);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            id: productId,
            quantity: 1
        });
    }
    
    localStorage.setItem('giftShopCart', JSON.stringify(cart));
    
    // Update cart count in navbar
    updateCartCount(cart.length);
    
    // Refresh cart sidebar if open
    const cartSidebar = document.querySelector('custom-cart-sidebar');
    if (cartSidebar) {
        cartSidebar.refreshCart();
    }
}

// Update Cart Count
function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(el => {
        el.textContent = count;
        el.classList.toggle('hidden', count === 0);
    });
}

// Show Notification
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('opacity-0', 'transition-opacity', 'duration-300');
        setTimeout(() => notification.remove(), 300);
    }, 2000);
}

// Function to handle product search
function handleSearch(query) {
    console.log(`Searching for: ${query}`);
    // In a real app, this would make an API call to search products
}

// Function to handle filter changes
function handleFilterChange(filterType, value) {
    console.log(`Filter changed: ${filterType} = ${value}`);
    // In a real app, this would update the product listing
}