<?php
include 'db.php';

$categories = ['Men']; // Add more if needed

foreach ($categories as $cat) {
    $stmt = $conn->prepare("SELECT name, price, image FROM products WHERE category = ?");
    $stmt->bind_param("s", $cat);
    $stmt->execute();
    $result = $stmt->get_result();

    $catId = strtolower($cat);

    $html = '
<div class="category" id="' . $catId . '">
    <h2>' . htmlspecialchars($cat) . '</h2>
    <button class="scroll-btn left" onclick="scrollProducts(\'' . $catId . '\', -1)">&#10094;</button>
    <div class="product-container horizontal-scroll">
';

    while ($row = $result->fetch_assoc()) {
        $name = htmlspecialchars($row['name']);
        $price = htmlspecialchars($row['price']);
        $image = htmlspecialchars($row['image']);
        $imagePath = 'Admin/uploads/' . $image;

        $html .= '
        <div class="product-card">
            <img src="' . $imagePath . '" alt="' . $name . '">
            <h3>' . $name . '</h3>
            <p class="price">₹' . $price . '</p>
            <div class="product-buttons">
                <a href="#" class="btn buy-now">Buy Now</a>
                <button class="btn add-cart" onclick="addToCart(\'' . $name . '\', ' . $price . ')">Add to Cart</button>
            </div>
        </div>
        ';
    }

    $html .= '
    </div>
    <button class="scroll-btn right" onclick="scrollProducts(\'' . $catId . '\', 1)">&#10095;</button>
</div>';

    file_put_contents("../men-snippet.html", $html);
    file_put_contents("../category-men-snippet.html", $html);
}

$conn->close();
?>
