<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    // Not logged in, redirect to login page
    header("Location: ../pages/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);

    // Check if product already in cart
    $stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Product already in cart, increase quantity by 1
        $stmt->bind_result($quantity);
        $stmt->fetch();
        $new_quantity = $quantity + 1;

        $updateStmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $updateStmt->bind_param("iii", $new_quantity, $user_id, $product_id);
        $updateStmt->execute();
        $updateStmt->close();
    } else {
        // Insert new product into cart
        $insertStmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
        $insertStmt->bind_param("ii", $user_id, $product_id);
        $insertStmt->execute();
        $insertStmt->close();
    }

    $stmt->close();

    // Redirect back to the products page or wherever
    header("Location: ../pages/index.php?added=1");
    exit;
} else {
    header("Location: ../pages/index.php");
    exit;
}
?>
