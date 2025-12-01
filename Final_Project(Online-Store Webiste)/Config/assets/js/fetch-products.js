async function fetchProducts(category = 'all') {
    try {
        const response = await fetch('data/products.json');
        const data = await response.json();
        
        let products = data.products;
        
        if (category !== 'all') {
            products = products.filter(product => product.category === category);
        }
        
        return products;
    } catch (error) {
        console.error('Error fetching products:', error);
        return [];
    }
}

function createProductCard(product) {
    const card = document.createElement('div');
    card.className = 'product-card';
    card.innerHTML = `
        <div class="product-image">
            <img src="assets/images/products/${product.image}" alt="${product.name}" onerror="this.src='assets/images/products/placeholder.jpg'">
        </div>
        <div class="product-info">
            <div class="product-category">${formatCategory(product.category)}</div>
            <h3 class="product-title">${product.name}</h3>
            <div class="product-price">$${product.price.toFixed(2)}</div>
            <div class="product-rating">
                ${generateStarRating(product.rating)}
                <span class="rating-count">(${product.rating})</span>
            </div>
            <div class="product-actions">
                <button class="add-to-cart" onclick="addToCart(${product.id})">
                    <i class="fas fa-shopping-cart"></i>
                    Add to Cart
                </button>
                <a href="product-details.php?id=${product.id}" class="view-details">
                    <i class="fas fa-eye"></i>
                </a>
            </div>
        </div>
    `;
    return card;
}

function formatCategory(category) {
    return category.charAt(0).toUpperCase() + category.slice(1);
}

function initializeSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function(e) {
            const searchTerm = e.target.value.toLowerCase();
            filterProducts(searchTerm);
        }, 300));
    }
}

function filterProducts(searchTerm) {
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        const title = card.querySelector('.product-title').textContent.toLowerCase();
        const category = card.querySelector('.product-category').textContent.toLowerCase();
        
        if (title.includes(searchTerm) || category.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

document.addEventListener('DOMContentLoaded', function() {
    initializeSearch();
});
