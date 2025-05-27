<?php
session_start();
include '../config/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
  echo '<div class="alert alert-warning">Please login to view your cart.</div>';
  exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT products.name, products.price, cart.quantity
        FROM cart
        JOIN products ON cart.product_id = products.id
        WHERE cart.user_id = $user_id";

$result = $conn->query($sql);

$total = 0;
?>

<h2 class="mb-4">Your Cart</h2>

<?php if ($result->num_rows > 0): ?>
<table class="table table-bordered w-75 mx-auto">
  <thead>
    <tr>
      <th>Product</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Subtotal</th>
    </tr>
  </thead>
  <tbody>
  <?php while ($row = $result->fetch_assoc()): 
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;
  ?>
    <tr>
      <td><?php echo htmlspecialchars($row['name']); ?></td>
      <td>$<?php echo $row['price']; ?></td>
      <td><?php echo $row['quantity']; ?></td>
      <td>$<?php echo number_format($subtotal, 2); ?></td>
      <td><a href="checkout.php" class="btn btn-primary w-100 mt-3"
   onclick="return confirm('Are you sure you want to proceed to checkout?');">
   <i class="bi bi-credit-card"></i> Checkout
</a></td>
      
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>

<div class="text-center fw-bold fs-4">Total: $<?php echo number_format($total, 2); ?></div>

<?php else: ?>
  <div class="alert alert-info text-center">Your cart is empty.</div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>




