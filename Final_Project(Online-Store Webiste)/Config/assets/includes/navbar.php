<!-- Top Bar -->
<div class="top-bar">
    <div class="container">
        <div class="top-bar-content">
            <span>Free shipping on orders over $99</span>
            <div class="top-bar-links">
                <a href="contact.php"><i class="fas fa-phone"></i> Contact</a>
                <a href="about.php"><i class="fas fa-info-circle"></i> About</a>
                <a href="admin/login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
            </div>
        </div>
    </div>
</div>

<header>
    <div class="container">
        <nav class="navbar">
            
            <a href="logo.jpg" class="logo">
                <i class="fas fa-laptop-code"></i>
                CyberCart Store
            </a>
            
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>

                <li class="nav-dropdown">
                    <a href="products.php">
                        Products <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a href="products.php?category=laptops">Laptops</a>
                        <a href="products.php?category=smartphones">Smartphones</a>
                        <a href="products.php?category=accessories">Accessories</a>
                        <a href="products.php?category=tablets">Tablets</a>
                        <a href="products.php" class="view-all">View All Products</a>
                    </div>
                </li>

                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>

            <div class="nav-icons">
                <div class="search-container">
                    <button class="search-toggle"><i class="fas fa-search"></i></button>
                    <div class="search-box">
                        <form action="products.php" method="GET">
                            <input type="text" name="search" placeholder="Search products..." class="search-input">
                            <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>

                <a href="admin/login.php" class="user-account">
                    <i class="fas fa-user"></i>
                </a>

                <a href="cart.php" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count">0</span>
                </a>

                <button class="mobile-menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </nav>
    </div>
</header>

<div class="mobile-nav">
    <div class="mobile-nav-content">
        <a href="index.php"><i class="fas fa-home"></i> Home</a>

        <div class="mobile-nav-dropdown">
            <a href="products.php"><i class="fas fa-box"></i> Products</a>
            <div class="mobile-dropdown-menu">
                <a href="products.php?category=laptops">Laptops</a>
                <a href="products.php?category=smartphones">Smartphones</a>
                <a href="products.php?category=accessories">Accessories</a>
                <a href="products.php?category=tablets">Tablets</a>
            </div>
        </div>

        <a href="about.php"><i class="fas fa-info-circle"></i> About</a>
        <a href="contact.php"><i class="fas fa-phone"></i> Contact</a>
        <a href="admin/login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
    </div>
</div>
