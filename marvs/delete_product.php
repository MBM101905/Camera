<?php
session_start();
include '../config/db.php';

// Only allow logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ensure product ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Fetch product image to delete from assets folder
    $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($image);
    if ($stmt->fetch()) {
        $imagePath = "../assets/" . $image;
        if (file_exists($imagePath)) {
            unlink($imagePath); // delete image file
        }
    }
    $stmt->close();

    // Delete product from database
    $deleteStmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $deleteStmt->bind_param("i", $product_id);
    if ($deleteStmt->execute()) {
        $deleteStmt->close();
        header("Location: index.php?deleted=1");
        exit;
    } else {
        echo "Failed to delete product: " . $conn->error;
    }
} else {
    echo "Invalid product ID.";
}
?>
