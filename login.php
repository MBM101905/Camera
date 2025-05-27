<?php include 'includes/header.php'; ?>

<h2 class="mb-4">Login</h2>
<form action="actions/login_action.php" method="post" class="w-50 mx-auto">
  <div class="mb-3">
    <label for="email" class="form-label">Email:</label>
    <input type="email" id="email" name="email" class="form-control" required>
  </div>

  <div class="mb-3">
    <label for="password" class="form-label">Password:</label>
    <input type="password" id="password" name="password" class="form-control" required>
  </div>

  <button type="submit" class="btn btn-primary w-100">Login</button>
</form>

<p class="text-center mt-3">Don't have an account? <a href="register.php">Register here</a></p>

<?php include 'includes/footer.php'; ?>
