<?php
session_start();

if (!isset($_SESSION['seller'])) {
    header("Location: index.php");
    exit();
}

include 'db.php';

if (isset($_GET['delete'])) {
    $product_id = intval($_GET['delete']);
    $seller = $_SESSION['seller'];

    // Prepare select statement to fetch images
    $stmt = $conn->prepare("SELECT image, image1, image2, image3, image4, image5 FROM products WHERE id = ? AND seller = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("is", $product_id, $seller);

    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($img0, $img1, $img2, $img3, $img4, $img5);
        $stmt->fetch();

        $images = [$img0, $img1, $img2, $img3, $img4, $img5];

        foreach ($images as $img) {
            if (!empty($img)) {
                $image_path = "uploads/" . basename($img); // basename for safety
                if (file_exists($image_path)) {
                    if (!unlink($image_path)) {
                        error_log("Failed to delete image file: " . $image_path);
                    }
                }
            }
        }

        $stmt->close();

        // Delete product record
        $delete_stmt = $conn->prepare("DELETE FROM products WHERE id = ? AND seller = ?");
        if (!$delete_stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $delete_stmt->bind_param("is", $product_id, $seller);
        if (!$delete_stmt->execute()) {
            die("Execute failed: " . $delete_stmt->error);
        }
        $delete_stmt->close();

        header("Location: dashboard.php?deleted=1");
        exit();
    }

    $stmt->close();
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
            background-color: rgb(255, 255, 255);
            color: black;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar img:hover {
            opacity: 0.8;
            border: 1px solid blue;
            border-radius: 5px;
        }

        .navbar .brand {
            font-family: 'Times New Roman', Times, serif;
            text-decoration: none;
            color: black;
            font-size: 1.5rem;
            font-weight: bold;
            transition: color 0.3s ease;

        }

        .navbar .tagline {
            font-size: 1rem;
            color: rgb(36, 34, 34);
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

        <?php if (isset($_GET['deleted'])): ?>
            <p style="color: green;">Product deleted successfully.</p>
        <?php endif; ?>

        <h2>Upload Product</h2>
        <form action="upload_product.php" method="POST" enctype="multipart/form-data">
            <label for="name">Product Name:</label><br>
            <input type="text" id="name" name="name" placeholder="Enter product name" required><br><br>

            <label for="price">Price:</label><br>
            <input type="number" id="price" name="price" placeholder="Enter price" required><br><br>

            <label for="quantity">Quantity:</label><br>
            <input type="number" id="quantity" name="quantity" placeholder="Enter quantity" required><br><br>

            <label for="category">Category:</label><br>
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
            <textarea id="description" name="description" placeholder="Enter product description" required></textarea><br><br>

            <label for="features">Features:</label><br>
            <textarea id="features" name="features" placeholder="Enter product features" required></textarea><br><br>

            <label for="image">Main Product Image:</label><br>
            <input type="file" id="image" name="image" accept="image/*" required><br><br>

            <label for="image1">Additional Image 1:</label><br>
            <input type="file" id="image1" name="image1" accept="image/*"><br><br>

            <label for="image2">Additional Image 2:</label><br>
            <input type="file" id="image2" name="image2" accept="image/*"><br><br>

            <label for="image3">Additional Image 3:</label><br>
            <input type="file" id="image3" name="image3" accept="image/*"><br><br>

            <label for="image4">Additional Image 4:</label><br>
            <input type="file" id="image4" name="image4" accept="image/*"><br><br>

            <label for="image5">Additional Image 5:</label><br>
            <input type="file" id="image5" name="image5" accept="image/*"><br><br>

            <button type="submit">Upload</button>
        </form>

        <h2>Your Products</h2>
        <?php include 'view_products.php'; ?>
    </div>
</body>
</html>
