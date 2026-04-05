
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="icon" type="image/png" href="images/logo.png">
  <script defer>

  </script>
  <title>Best online shopping site</title>
  
  <style>
   body {
  background: url('images/form bg.jpg') no-repeat center center fixed;
  background-size: cover;
}
    form {
       
      background: rgba(214, 198, 198,0.5);
      padding: 20px;
      max-width: 500px;
      margin: 150px  auto;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
   form input, form textarea {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      margin-bottom: 20px;
      border: 1px solid #e1b6b6;
      border-radius: 4px;
    }
    label{
      font-weight: 700;
      background-color: rgba(255, 255, 255,0.5);
      padding: 10px 20px;
      border-radius: 5px;
    }
    button {
      background: #28a745;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    button:hover {
      background: #218838;
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
<!--seller registration form-->
  <form id="sellerForm">
    <h2>Seller Registration</h2>
<br>
    <label>Full Name </label>
    <input type="text" name="name" required />

    <label>Business Name</label>
    <input type="text" name="Business-name" required />
    
    <label>Email Address</label>
    <input type="email" name="email" required />

    <label>Phone Number</label>
    <input type="tel" name="phone" required />

    <label>GST No. </label>
    <input type="text" name="gst" required />

    <label>PAN No</label>
    <input type="text" name="pan" required />

    <label>Business Address</label>
    <textarea name="address" rows="3" required></textarea>

    

   <center> <button type="submit">Submit</button></center>
  </form>


<footer class="footer">
    <div class="up-footer">
      <div class="footer-section about-us">
        <h3>About Us</h3>
        <p>Welcome to our online marketplace, your trusted destination for premium-quality dry fruits and more. We specialize in offering a wide range of nutritious, handpicked dry fruits to promote healthy living. In addition, we empower sellers by providing a reliable platform to showcase and sell a variety of other high-quality products.</p>
      </div>

      <div class="footer-section contact-us">
        <h3>Contact Us</h3>
        <div class="social-icons">
          <a href="https://www.instagram.com/salonovaofficial/" target="_blank"> <i class="fab fa-instagram"></i> Instagram</a>
          <a href="#" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a>
          <a href="#" target="_blank"><i class="fab fa-twitter"> </i> X (Twitter)</a>
        </div>
      </div>

      <div class="footer-section become-seller">
        <h3>Become a Seller</h3>
        <ul>
          <li><a href="#"><i class="fas fa-envelope"></i> Business query </a></li>
         <li> <a href="tel:+917529809681" class="call-link"><i class="fas fa-phone"></i> +91 7529809681</a></li>


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
      <p> Design and developed by <a href="https://digitalpromasters.io" target="_blank"> Digital Promasters </a> </p>
    </div>
  </footer>



<script src="https://cdn.jsdelivr.net/npm/emailjs-com@3/dist/email.min.js"></script>
<script>
  (function(){
    emailjs.init("o71gXpTbxjsLoK7dH"); 
  })();

  document.getElementById('sellerForm').addEventListener('submit', function(event) {
    event.preventDefault();

    emailjs.sendForm('service_m12chkj', 'template_254z1um', this)
      .then(function() {
        alert('Form submitted successfully! We will get back to you within 2 working days');
        document.getElementById('sellerForm').reset();
      }, function(error) {
        alert('Error sending form: ' + JSON.stringify(error));
      });
  });
</script>


</body>
</html>
