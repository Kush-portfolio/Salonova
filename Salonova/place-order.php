<?php
session_start();
include 'Admin/db.php';

// Optional: Get seller from session if set
$seller = $_SESSION['seller'] ?? 'Unknown';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Fetch & sanitize form data
    $product_id = intval($_POST['product_id']);
    $product_price = floatval($_POST['product_price']); // From hidden input
    $quantity = intval($_POST['quantity']);
    $total_price = $product_price * $quantity;

    $customer_name = trim($_POST['customer_name']);
    $email = trim($_POST['customer_email']);
    // Other details like phone, address, city/state/pincode are NOT saved in this schema

    // Prepare SQL query (matches your table structure)
    $sql = "INSERT INTO orders (product_id, seller, customer_name, email, quantity, total_price, order_time, is_read)
            VALUES (?, ?, ?, ?, ?, ?, NOW(), 0)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "isssid", // i=int, s=string, d=decimal
        $product_id,
        $seller,
        $customer_name,
        $email,
        $quantity,
        $total_price
    );

    if ($stmt->execute()) {
        header("Location: thank-you.php");
        exit();
    } else {
        echo "Error placing order: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
