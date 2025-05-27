<?php if (isset($_GET['deleted'])): ?>
  <div class="alert alert-success">Product deleted successfully!</div>
<?php endif; ?>


<?php
session_start();
include '../config/db.php';
include '../includes/header.php';

$result = $conn->query("SELECT * FROM products");
?>
<?php if (isset($_GET['added'])): ?>
  <div class="alert alert-success">Product added to cart!</div>
<?php endif; ?>

<h2 class="mb-4">Available Cameras</h2>
<div class="row row-cols-1 row-cols-md-3 g-4">
  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="col">
      <div class="card h-100">
        <img src="../assets/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
          <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
          <p class="card-text fw-bold">$<?php echo $row['price']; ?></p>
          <form action="../actions/add_to_cart.php" method="post" class="mt-auto">
  <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
  <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
  <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-warning mt-2 w-100">Edit</a>
  <a href="delete_product.php?id=<?php echo $row['id']; ?>" 
   class="btn btn-danger mt-2 w-100"
   onclick="return confirm('Are you sure you want to delete this product?');">
   <i class="bi bi-trash"></i> Delete
</a>



</form>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<h2>Product List
  <a href="add_product.php" class="btn btn-success btn-sm float-end">
    <i class="bi bi-plus-circle"></i> Add Product
  </a>
</h2>

<?php include '../includes/footer.php'; ?>
