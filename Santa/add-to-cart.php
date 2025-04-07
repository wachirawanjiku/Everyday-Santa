<?php
session_start();
header('Content-Type: application/json');

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get and decode product data
$product_data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (isset($product_data['id'], $product_data['name'], $product_data['price'])) {
    $id = htmlspecialchars((string)$product_data['id']);
    $name = htmlspecialchars($product_data['name']);
    $price = floatval($product_data['price']);

    $product = [
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'quantity' => 1
    ];

    $product_found = false;
    foreach ($_SESSION['cart'] as &$cart_item) {
        if ($cart_item['id'] === $product['id']) {
            $cart_item['quantity'] += 1;
            $product_found = true;
            break;
        }
    }

    if (!$product_found) {
        $_SESSION['cart'][] = $product;
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Product added to cart',
        'cart_count' => array_sum(array_column($_SESSION['cart'], 'quantity'))
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid product data'
    ]);
}
?>
