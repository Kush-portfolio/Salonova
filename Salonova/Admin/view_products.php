<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

$seller = $_SESSION['seller'] ?? '';

if (!$seller) {
    echo "No seller logged in.";
    exit();
}

$stmt = $conn->prepare("SELECT * FROM products WHERE seller = ?");
if (!$stmt) {
    echo "Query failed: " . htmlspecialchars($conn->error);
    exit();
}

$stmt->bind_param("s", $seller);
$stmt->execute();
$result = $stmt->get_result();

echo "<table border='1' cellpadding='10' cellspacing='0'>
    <tr>
        <th>Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Description</th>
        <th>Features</th>
        <th>Image</th>
        <th>Actions</th>
    </tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imageSrc = !empty($row['image']) ? 'uploads/' . htmlspecialchars($row['image']) : 'placeholder.png';

        echo "<tr>
            <td>" . htmlspecialchars($row['name']) . "</td>
            <td>" . htmlspecialchars($row['category']) . "</td>
            <td>" . htmlspecialchars($row['price']) . "</td>
            <td>" . htmlspecialchars($row['quantity']) . "</td>
            <td>" . htmlspecialchars($row['description']) . "</td>
            <td>" . htmlspecialchars($row['features']) . "</td>
            <td><img src='$imageSrc' width='100' alt='Product Image'></td>
            <td>
                <a href='dashboard.php?delete=" . intval($row['id']) . "' onclick=\"return confirm('Are you sure you want to delete this product?');\">Delete</a>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='8'>No products uploaded yet.</td></tr>";
}

echo "</table>";

$stmt->close();
$conn->close();
?>
