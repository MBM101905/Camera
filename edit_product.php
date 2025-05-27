<?php
session_start();
include 'config/db.php';

// Only logged-in users allowed
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = "";

// Get product ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$product_id = intval($_GET['id']);

// Fetch current product data
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    header("Location: index.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $uploadDir = __DIR__ . '/assets/';

    // Update image only if new image uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES['image']['name']);
        $targetFilePath = $uploadDir . $imageName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            // Update product with new image
            $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, image=? WHERE id=?");
            $stmt->bind_param("ssdsi", $name, $description, $price, $imageName, $product_id);
        } else {
            $message = "Failed to upload new image.";
        }
    } else {
        // Update without changing image
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=? WHERE id=?");
        $stmt->bind_param("ssdi", $name, $description, $price, $product_id);
    }

    if (isset($stmt) && $stmt->execute()) {
        $message = "Product updated successfully!";
        // Refresh product data
        $stmt->close();
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
    } else if (!empty($message)) {
        // image upload error already set
    } else {
        $message = "Failed to update product.";
    }
}

?>

<?php include 'includes/header.php'; ?>

<h2>Edit Product</h2>

<?php if ($message): ?>
  <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<form action="edit_product.php?id=<?php echo $product_id; ?>" method="post" enctype="multipart/form-data" class="w-50 mx-auto">
  <div class="mb-3">
    <label for="name" class="form-label">Product Name:</label>
    <input type="text" name="name" id="name" class="form-control" required value="<?php echo htmlspecialchars($product['name']); ?>">
  </div>
  
  <div class="mb-3">
    <label for="description" class="form-label">Description:</label>
    <textarea name="description" id="description" class="form-control" rows="3" required><?php echo htmlspecialchars($product['description']); ?></textarea>
  </div>
  
  <div class="mb-3">
    <label for="price" class="form-label">Price (USD):</label>
    <input type="number" name="price" id="price" step="0.01" class="form-control" required value="<?php echo htmlspecialchars($product['price']); ?>">
  </div>
  
  <div class="mb-3">
    <label>Current Image:</label><br>
    <img src="assets/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" style="max-width:200px;">
  </div>
  
  <div class="mb-3">
    <label for="image" class="form-label">Replace Image (optional):</label>
    <input type="file" name="image" id="image" class="form-control" accept="image/*">
  </div>
  
  <button type="submit" class="btn btn-primary">Update Product</button>

</form>

<?php include 'includes/footer.php'; ?>
