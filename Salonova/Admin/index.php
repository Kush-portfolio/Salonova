<?php
session_start();

// Redirect to login if seller is not logged in
if (!isset($_SESSION['seller'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';  // Your DB connection

// Delete product function
function deleteProduct($conn, $productId, $seller)
{
    // Check product belongs to seller
    $stmt = $conn->prepare("SELECT image FROM products WHERE id = ? AND seller = ?");
    $stmt->bind_param("is", $productId, $seller);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return "Product not found or access denied.";
    }

    $row = $result->fetch_assoc();
    $imageFile = $row['image'];

    // Delete product
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ? AND seller = ?");
    $stmt->bind_param("is", $productId, $seller);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Delete image file
        $imagePath = __DIR__ . "/uploads/" . $imageFile;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        return "Product deleted successfully.";
    } else {
        return "Failed to delete product.";
    }
}

// Handle delete request
if (isset($_GET['delete'])) {
    $productId = intval($_GET['delete']);
    $message = deleteProduct($conn, $productId, $_SESSION['seller']);
    echo "<script>alert('" . addslashes($message) . "'); window.location.href='dashboard.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Seller Dashboard - Salonova</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Navbar */
        .navbar {
            background-color: rgb(69, 67, 67);
            color: goldenrod;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar img:hover {
            opacity: 0.8;
            border: 1px solid goldenrod;
            border-radius: 5px;
        }

        .navbar .brand {
            text-decoration: none;
            color: goldenrod;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .navbar .tagline {
            font-size: 1rem;
            color: rgb(255, 255, 255);
            font-style: italic;
        }
 
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <img src="logo.png" alt="Salonova Logo" style="height: 50px; width: auto;">
        <a href="dashboard.php" class="brand">Salonova Admin Portal</a>
        <div class="tagline">Discover Luxe Living</div>

    </div>


    <div class="dashboard-container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['seller']); ?></h1>

        <a href="logout.php">Logout</a>

        <h2>Upload Product</h2>
        <form action="upload_product.php" method="POST" enctype="multipart/form-data">
            <label for="name">Product Name:</label><br>
            <input type="text" id="name" name="name" placeholder="Enter product name" required><br><br>

            <label for="price">Price:</label><br>
            <input type="number" id="price" name="price" placeholder="Enter price" required><br><br>

            <label for="quantity">Quantity:</label><br>
            <input type="number" id="quantity" name="quantity" placeholder="Enter quantity" required><br><br>

            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="">-- Select Category --</option>
                <option value="Books & Stationery">Books & Stationery</option>
                <option value="Dry Fruits">Dry Fruits</option>
                <option value="Electronics">Electronics</option>
                <option value="Fashion Accessories">Fashion Accessories</option>
                <option value="Home & Kitchen">Home & Kitchen</option>
                <option value="Men">Men</option>
                <option value="Mobile & Gadgets">Mobile & Gadgets</option>
                <option value="Sports & Outdoors">Sports & Outdoors</option>
                <option value="Toys & Kids">Toys & Kids</option>
                <option value="Women">Women</option>
            </select><br><br>

            <label for="description">Description:</label><br>
            <textarea id="description" name="description" placeholder="Enter product description"
                required></textarea><br><br>

            <label for="features">Features:</label><br>
            <textarea id="features" name="features" placeholder="Enter product features" required></textarea><br><br>

            <label for="image">Product Image:</label><br>
            <input type="file" id="image" name="image" accept="image/*" required><br><br>

            <button type="submit">Upload</button>
        </form>

        <h2>Your Products</h2>
        <?php include 'view_products.php'; ?>
    </div>
</body>

</html>