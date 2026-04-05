<?php
session_start();
include 'Admin/db.php';

// ✅ Get Product ID
$product_id = $_GET['id'] ?? null;

if (!$product_id || !is_numeric($product_id)) {
    echo "Invalid Product ID.";
    exit;
}

$product_id = intval($product_id);

// ✅ Fetch product with all images
$sql = "SELECT name, description, price, image, image1, image2, image3, image4, image5 FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Prepare Failed: " . $conn->error);
}

$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Product not found.";
    exit;
}

$product = $result->fetch_assoc();
$user_data = ['user_name' => $_SESSION['user_name'] ?? 'Guest'];

// ✅ Collect all images
$images = [];
foreach (['image', 'image1', 'image2', 'image3', 'image4', 'image5'] as $key) {
    if (!empty($product[$key])) {
        $images[] = 'Admin/uploads/' . htmlspecialchars($product[$key]);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($product['name']); ?> - Buy Now</title>
  <link rel="icon" type="image/x-icon" href="images/logo.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="icon" type="image/png" href="images/logo.png" />
  <style>
   

    .product-page {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
         margin-top: 25vh;
      padding: 40px;
      gap: 40px;
    }

    .slider-container {
      position: relative;   
      width: 400px;
      height: 450px;
      border: 1px solid #000;
      overflow: hidden;
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(32, 31, 30, 0.3);
    }

    .slider-container img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: none;
      transition: transform 0.5s ease;
      border-radius: 20px;
    }

    .slider-container img.active {
      display: block;
    }

    .slider-container img:hover {
      transform: scale(1.05);
      cursor: zoom-in;
    }

    .prev, .next {
      position: absolute;      
      top: 50%;
      transform: translateY(-20%);
      background-color: rgba(255, 255, 255, 0.1);
      color: black;
      font-weight: bold;
      padding: 6px 16px;
      cursor: pointer;
      border: none;
      border-radius: 10px;
      z-index: 999;
    }

    .prev:hover, .next:hover {
      background-color:rgba(255, 254, 254, 0.6);
    }

    .prev { left: 10px; }
    .next { right: 10px; }

    .product-details {
      max-width: 400px;      
    }

    .product-details h1 {
      font-size: 2rem;
      color: black;
      margin-bottom: 15px;
    }

    .product-details h3 {
      margin: 10px 0;
      color:#363636;
    }

    .product-details p {
      color: black;
      line-height: 1.6;
    }

    input[type="number"], input[type="text"], input[type="email"], input[type="tel"], textarea, select {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      border-radius: 5px;
      border: 1px solid #999;
      color: #333;
    }

    button {
      margin-top: 10px;
      padding: 10px 20px;
      background-color: rgb(240, 181, 18);
      border: none;
      border-radius: 25px;
      color: #353535;
      font-weight: bold;
      margin-right: 10px;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    button:hover {
      background-color: goldenrod;
      transform: scale(1.05);
      color: black;
    }

    /* Modal Styling */
    #orderModal {
      display: none; 
      position: fixed; 
      top: 0; left: 0; 
      width: 100%; height: 100%; 
      background-color: rgba(0,0,0,0.7); 
      z-index: 10000; 
      justify-content: center; 
      align-items: center;
    }

    #orderModal .modal-content {
      background: white;
      padding: 30px;
      border-radius: 10px;
      width: 400px;
      position: relative;
      color: black;
    }

    #orderModal .close {
      position: absolute;
      top: 10px;
      right: 15px;
      cursor: pointer;
      font-size: 20px;
    }
    /*mobile responsive*/

    /* ✅ Responsive Styling */
@media (max-width: 768px) {
  .product-page {
    flex-direction: column;
    align-items: center;
    padding: 20px;
    margin-top: 20vh;
  }

  .slider-container {
    width: 100%;
    max-width: 90vw;
    height: auto;
    aspect-ratio: 4 / 5;
  }

  .product-details {
    max-width: 90vw;
  }

  button {
    width: 100%;
    margin: 10px 0;
  }
}

@media (max-width: 480px) {
  .product-details h1 {
    font-size: 1.5rem;
  }

  .prev, .next {
    padding: 4px 10px;
    font-size: 14px;
  }

  .slider-container {
    aspect-ratio: 4 / 5;
    height: auto;
  }
}

  </style>
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


<div class="product-page">
  <div class="slider-container">
    <?php foreach ($images as $index => $img): ?>
      <img src="<?php echo $img; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>" alt="Product Image">
    <?php endforeach; ?>
    <button class="prev">&#10094;</button>
    <button class="next">&#10095;</button>
  </div>

  <div class="product-details">
    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
    <h3>Price: ₹<?php echo htmlspecialchars($product['price']); ?></h3>
    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

    <button type="button" onclick="openOrderForm()">Buy Now</button>
    <button type="button" onclick="alert('Added to cart!')">Add to Cart</button>
  </div>
</div>

<!-- Order Modal -->
<div id="orderModal">
  <div class="modal-content">
    <span class="close" onclick="closeOrderForm()">&times;</span>
    <h3>Order Details</h3>
    <form action="place-order.php" method="POST">
      <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
      <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
      <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($product['price']); ?>">

      <input type="text" name="customer_name" placeholder="Full Name" required>
      <input type="email" name="customer_email" placeholder="Email" required>
      <input type="tel" name="customer_phone" placeholder="Phone Number" required>
      <textarea name="customer_address" placeholder="Address, Landmark" required></textarea>
      <input type="text" name="customer_city" placeholder="City" required>
      <input type="text" name="customer_state" placeholder="State" required>
      <input type="text" name="customer_zip" placeholder="Pincode" required>

      <input type="number" name="quantity" min="1" value="1" required>

      <select name="payment_method" required>
        <option value="COD">Cash on Delivery</option>
        <option value="Online">Online Payment</option>
      </select>

        <p>Total Price: ₹<span id="totalPrice"><?php echo htmlspecialchars($product['price']); ?></span></p>
      <button type="submit">Place Order</button>
    </form>
  </div>
</div>

<!--footer-->
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
<script>
  const images = document.querySelectorAll('.slider-container img');
  const next = document.querySelector('.next');
  const prev = document.querySelector('.prev');
  let current = 0;

  function showImage(index) {
    images.forEach(img => img.classList.remove('active'));
    images[index].classList.add('active');
  }

  next.addEventListener('click', () => {
    current = (current + 1) % images.length;
    showImage(current);
  });

  prev.addEventListener('click', () => {
    current = (current - 1 + images.length) % images.length;
    showImage(current);
  });

  // Modal controls
  function openOrderForm() {
    document.getElementById("orderModal").style.display = "flex";
  }

  function closeOrderForm() {
    document.getElementById("orderModal").style.display = "none";
  }
</script>

</body>
</html>
