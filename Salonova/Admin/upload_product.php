<?php
session_start();
include 'db.php';

if (!isset($_SESSION['seller'])) {
    header("Location: index.php");
    exit();
}

$seller = $_SESSION['seller'];

$name        = trim($_POST['name']);
$category    = trim($_POST['category']);
$price       = floatval($_POST['price']);
$quantity    = intval($_POST['quantity']);
$description = trim($_POST['description']);
$features    = trim($_POST['features']);

// Validate category against allowed list
$allowed_categories = [
    "Books & Stationery", "Dry Fruits", "Electronics",
    "Fashion Accessories", "Home & Kitchen", "Men",
    "Mobile & Gadgets", "Sports & Outdoors", "Toys & Kids", "Women"
];
if (!in_array($category, $allowed_categories)) {
    die("Invalid category selected.");
}

// ✅ Reusable image uploader with MIME type check
function uploadImage($fileKey) {
    if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
        $imageTmp  = $_FILES[$fileKey]['tmp_name'];
        $imageName = basename($_FILES[$fileKey]['name']);
        $targetDir = "uploads/";
        $uniqueFilename = time() . "_" . preg_replace("/[^a-zA-Z0-9.\-_]/", "", $imageName);
        $targetFile = $targetDir . $uniqueFilename;

        // Check mime type for security
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $imageTmp);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes)) {
            return null; // invalid image type
        }

        if (move_uploaded_file($imageTmp, $targetFile)) {
            return $uniqueFilename; // ✅ return filename only
        }
    }
    return null;
}

// ✅ Main image is required
$image  = uploadImage('image');
if (!$image) {
    die("Main product image is required and must be a valid image file.");
}

// ✅ Optional images
$image1 = uploadImage('image1');
$image2 = uploadImage('image2');
$image3 = uploadImage('image3');
$image4 = uploadImage('image4');
$image5 = uploadImage('image5');

// Convert null optional images to empty string for DB binding
$image1 = $image1 ?? "";
$image2 = $image2 ?? "";
$image3 = $image3 ?? "";
$image4 = $image4 ?? "";
$image5 = $image5 ?? "";

// ✅ Prepare statement
$stmt = $conn->prepare("
    INSERT INTO products 
    (seller, name, category, price, quantity, description, features, image, image1, image2, image3, image4, image5) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
    die("SQL prepare failed: " . $conn->error);
}

$stmt->bind_param(
    "sssdissssssss",
    $seller,
    $name,
    $category,
    $price,
    $quantity,
    $description,
    $features,
    $image,
    $image1,
    $image2,
    $image3,
    $image4,
    $image5
);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    include 'generate_products_html.php'; // optional HTML updater
    header("Location: dashboard.php?msg=Product uploaded successfully");
    exit();
} else {
    echo "Error uploading product: " . htmlspecialchars($stmt->error);
    $stmt->close();
}
?>
