

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Camera Store</title>
  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <div class="container">
    <a class="navbar-brand" href="../pages/index.php">Camera Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
      <?php if (isset($_SESSION['user_id'])): ?>
        <li class="nav-item">
          <span class="nav-link">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../pages/cart.php">Cart</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../pages/logout.php">Logout</a>
        </li>
      <?php else: ?>
        <li class="nav-item"><a class="nav-link" href="../pages/login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="../pages/register.php">Register</a></li>
      <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
