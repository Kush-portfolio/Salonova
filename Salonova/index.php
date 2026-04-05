<?php
include 'Admin/db.php';  // DB connection

// Function to display products by category with scroll buttons
function showProductsByCategory($conn, $category) {
    $stmt = $conn->prepare("SELECT id, name, price, image FROM products WHERE category = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<p>No products found in <strong>" . htmlspecialchars($category) . "</strong>.</p>";
        return;
    }

    $catId = strtolower(str_replace([' ', '&'], ['-', 'and'], $category));
    ?>
    <div class="category" id="<?php echo $catId; ?>">
      <h2><?php echo htmlspecialchars($category); ?></h2>

      <!-- Scroll Buttons -->
      <button class="scroll-btn left" onclick="scrollProducts('<?php echo $catId; ?>', -1)">&#10094;</button>
      <button class="scroll-btn right" onclick="scrollProducts('<?php echo $catId; ?>', 1)">&#10095;</button>

      <!-- Scrollable Product Row -->
      <div class="product-container horizontal-scroll">
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="product-card">
            <img src="Admin/uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
            <p class="price">₹<?php echo number_format($row['price']); ?></p>
            <div class="product-buttons">
              <a href="buy-now.php?id=<?php echo $row['id']; ?>" class="btn buy-now">Buy Now</a>
              <button class="btn add-cart" onclick="addToCart('<?php echo addslashes($row['name']); ?>', <?php echo $row['price']; ?>)">Add to Cart</button>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
    <?php
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Best online shopping site</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="icon" type="image/png" href="images/logo.png" />
</head>

<body>
 <nav class="navbar">
  <div class="logo">
    <img src="images/logo.png" alt="Logo" />
    <h2> Salonova</h2>
  </div>

  <!-- Search Box -->
  <div class="search-container">
    <input type="text" placeholder="Search here..." class="search-input" />
    <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
  </div>

  <!-- Navigation Links -->
  <ul class="nav-links1">
    <li><a href="#" class="box1"><i class="fa-solid fa-user"></i> Profile</a></li>
    <li><a href="#" class="box1"><i class="fa-solid fa-cart-plus"></i> Cart</a></li>
  </ul>
</nav>

<!-- 2nd Navbar -->
<nav class="navbar2">
  <div class="menu-toggle2" onclick="toggleSecondNavbar()">☰ Menu</div>
  <ul class="nav-links2" id="navLinks2">
    <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
    <li class="dropdown-parent">
      <a href="#">Category <i class="fas fa-caret-down caret-icon"></i></a>
      <ul class="dropdown">
        <li class="sub-parent">
          <a href="category.php">Dry Fruits</a>
          <ul class="sub-dropdown">
            <li><a href="category.php">Almonds</a></li>
            <li><a href="category.php">Cashew</a></li>
            <li><a href="category.php">Raisins</a></li>
            <li><a href="category.php">Dates</a></li>
          </ul>
        </li>
        <li class="sub-parent">
          <a href="category.php">Men</a>
          <ul class="sub-dropdown">
            <li><a href="category.php">T-Shirts</a></li>
            <li><a href="category.php">Jeans</a></li>
            <li><a href="category.php">Shoes</a></li>
          </ul>
        </li>
        <li class="sub-parent">
          <a href="category.php">Women</a>
          <ul class="sub-dropdown">
            <li><a href="category.php">Dresses</a></li>
            <li><a href="category.php">Handbags</a></li>
            <li><a href="category.php">Heels</a></li>
          </ul>
        </li>
        <li class="sub-parent">
          <a href="category.php">Electronics</a>
          <ul class="sub-dropdown">
            <li><a href="category.php">Mobiles</a></li>
            <li><a href="category.php">Laptops</a></li>
            <li><a href="category.php">Headphones</a></li>
          </ul>
        </li>
        <li class="sub-parent">
          <a href="category.php">Home & Kitchen</a>
          <ul class="sub-dropdown">
            <li><a href="category.php">Cookware</a></li>
            <li><a href="category.php">Decor</a></li>
            <li><a href="category.php">Furniture</a></li>
          </ul>
        </li>
      </ul>
    </li>
    <li><a href="today.php"><i class="fas fa-tags"></i> Today's Deals</a></li>
    <li><a href="new-releases.php"><i class="fas fa-calendar-plus"></i> New Releases</a></li>
    <li><a href="trending.php"><i class="fas fa-fire"></i> Trending</a></li>
    <li><a href="become-seller.php"><i class="fas fa-store"></i> Become a Seller</a></li>
  </ul>
</nav>

<div class="main-content">

  <div class="carousel-container">
    <div class="carousel-slide">
      <div class="slide">
        <img src="images/almonds.jpg" alt="Almonds" />
        <div class="discount">20% OFF on Almonds</div>
      </div>
      <div class="slide">
        <img src="images/cashews.jpg" alt="Cashews" />
        <div class="discount">15% OFF on Cashews</div>
      </div>
      <div class="slide">
        <img src="images/raisins.jpg" alt="Raisins" />
        <div class="discount">Buy 1 Get 1 on Raisins</div>
      </div>
      <div class="slide">
        <img src="images/walnuts.jpg" alt="Walnuts" />
        <div class="discount">25% OFF on Walnuts</div>
      </div>
    </div>

    <button class="prev" onclick="moveSlide(-1)">❮</button>
    <button class="next" onclick="moveSlide(1)">❯</button>
  </div>



<?php
// Categories to show
$categories = [
  "Dry Fruits",
  "Electronics",
  "Men",
  "Women",
  "Home & Kitchen",
];

foreach ($categories as $cat) {
  showProductsByCategory($conn, $cat);
}
?>
<button id="backToTop" >⬆ Back to Top</button>

<!-- Footer -->
<footer class="footer">
  <div class="up-footer">
    <div class="footer-section about-us">
      <h3>About Us</h3>
      <p>Welcome to our online marketplace, your trusted destination for premium-quality dry fruits and more. We specialize in offering a wide range of nutritious, handpicked dry fruits to promote healthy living. In addition, we empower sellers by providing a reliable platform to showcase and sell a variety of other high-quality products.</p>
    </div>

    <div class="footer-section contact-us">
      <h3>Contact Us</h3>
      <div class="social-icons">
        <a href="https://www.instagram.com/salonovaofficial/" target="_blank"><i class="fab fa-instagram"></i> Instagram</a>
        <a href="#" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a>
        <a href="#" target="_blank"><i class="fab fa-twitter"></i> X (Twitter)</a>
      </div>
    </div>

    <div class="footer-section become-seller">
      <h3>Become a Seller</h3>
      <ul>
        <li><a href="#"><i class="fas fa-envelope"></i> Business query </a></li>
        <li><a href="tel:+917529809681" class="call-link"><i class="fas fa-phone"></i> +91 7529809681</a></li>
      </ul>
      <button onclick="location.href='become-seller.php'">Join Now</button>
    </div>

    <div class="footer-section help">
      <h3>Help</h3>
      <ul>
        <li><a href="#">Customer Care</a></li>
        <li><a href="#">Return Policy</a></li>
        <li><a href="#">Privacy Policy</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; 2025 Salonova (Discover luxe living). All rights reserved.</p>
    <p> Design and developed by <a href="https://digitalpromasters.io" target="_blank">Digital Promasters</a></p>
  </div>
</footer>
<!-- Back to top button -->
<script>
  let slideIndex = 0;
  const slides = document.querySelector('.carousel-slide');
  const totalSlides = document.querySelectorAll('.slide').length;
  let autoSlide = setInterval(() => moveSlide(1), 4000);

  function moveSlide(n) {
    slideIndex += n;
    if (slideIndex < 0) slideIndex = totalSlides - 1;
    if (slideIndex >= totalSlides) slideIndex = 0;
    updateCarousel();
    resetAutoSlide();
  }

  function updateCarousel() {
    slides.style.transform = `translateX(-${slideIndex * 100}%)`;
  }

  function resetAutoSlide() {
    clearInterval(autoSlide);
    autoSlide = setInterval(() => moveSlide(1), 4000);
  }

  function addToCart(name, price) {
    alert(`Added ${name} (₹${price}) to cart!`);
    // Add your cart logic here
  }
</script>

<script src="index.js"></script>
</body>
</html>
