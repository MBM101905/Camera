<?php
session_start();
include '../config/db.php';

// Simple auth check (only logged-in users can add products)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Use absolute path for upload directory
    $uploadDir = __DIR__ . '/../assets/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // create folder if not exists
    }

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES['image']['name']);
        $targetFilePath = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssds", $name, $description, $price, $imageName);

            if ($stmt->execute()) {
                $message = "Product added successfully!";
            } else {
                $message = "Database error: Could not add product.";
            }
        } else {
            $message = "Failed to upload image.";
        }
    } else {
        $message = "Please upload an image.";
    }
}
?>

<?php include '../includes/header.php'; ?>

<h2>Add New Product</h2>

<?php if ($message): ?>
  <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<form action="add_product.php" method="post" enctype="multipart/form-data" class="w-50 mx-auto">
  <div class="mb-3">
    <label for="name" class="form-label">Product Name:</label>
    <input type="text" name="name" id="name" class="form-control" required>
  </div>
  
  <div class="mb-3">
    <label for="description" class="form-label">Description:</label>
    <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
  </div>
  
  <div class="mb-3">
    <label for="price" class="form-label">Price (USD):</label>
    <input type="number" name="price" id="price" step="0.01" class="form-control" required>
  </div>
  
  <div class="mb-3">
    <label for="image" class="form-label">Product Image:</label>
    <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
  </div>
  
  <button type="submit" class="btn btn-primary">Add Product</button>
</form>

<?php include '../includes/footer.php'; ?>
