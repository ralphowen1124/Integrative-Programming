document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('featured-products')) {
        loadFeaturedProducts();
    }

    updateCartCount();
});

async function loadFeaturedProducts() {
    try {
        const response = await fetch('data/products.json');
        const data = await response.json();
        const featuredProducts = data.products.filter(product => product.featured);
        
        const productsGrid = document.getElementById('featured-products');
        productsGrid.innerHTML = '';
        
        featuredProducts.forEach(product => {
            const productCard = createProductCard(product);
            productsGrid.appendChild(productCard);
        });
    } catch (error) {
        console.error('Error loading products:', error);
    }
}

function createProductCard(product) {
    const card = document.createElement('div');
    card.className = 'product-card';
    card.innerHTML = `
        <div class="product-image">
            <img src="assets/images/products/${product.image}" alt="${product.name}">
        </div>
        <div class="product-info">
            <div class="product-category">${product.category}</div>
            <h3 class="product-title">${product.name}</h3>
            <div class="product-price">$${product.price}</div>
            <div class="product-rating">
                ${generateStarRating(product.rating)}
            </div>
            <button class="add-to-cart" onclick="addToCart(${product.id})">
                Add to Cart
            </button>
        </div>
    `;
    return card;
}

function generateStarRating(rating) {
    let stars = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= Math.floor(rating)) {
            stars += '<i class="fas fa-star"></i>';
        } else if (i === Math.ceil(rating) && !Number.isInteger(rating)) {
            stars += '<i class="fas fa-star-half-alt"></i>';
        } else {
            stars += '<i class="far fa-star"></i>';
        }
    }
    return stars;
}
