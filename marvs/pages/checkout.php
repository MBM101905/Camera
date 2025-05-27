<?php
session_start();
include '../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Assuming cart is stored in session
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header("Location: cart.php?empty=1");
    exit;
}

// Process checkout (you can expand this)
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Here, you can insert order into a database if needed

// Clear cart after checkout
unset($_SESSION['cart']);

?>
<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <div class="alert alert-success">
        <h4 class="alert-heading">Checkout Complete</h4>
        <p>Thank you for your purchase!</p>
        <hr>
        <p class="mb-0">Total Paid: <strong>$<?php echo number_format($total, 2); ?></strong></p>
    </div>
    <a href="index.php" class="btn btn-secondary">Continue Shopping</a>
</div>

<?php include '../includes/footer.php'; ?>
