<?php include '../includes/header.php'; ?>

<h2 class="mb-4">Register</h2>
<form action="../actions/register_action.php" method="post" class="w-50 mx-auto">
  <div class="mb-3">
    <label for="username" class="form-label">Username:</label>
    <input type="text" id="username" name="username" class="form-control" required>
  </div>

  <div class="mb-3">
    <label for="email" class="form-label">Email:</label>
    <input type="email" id="email" name="email" class="form-control" required>
  </div>

  <div class="mb-3">
    <label for="password" class="form-label">Password:</label>
    <input type="password" id="password" name="password" class="form-control" required>
  </div>

  <button type="submit" class="btn btn-success w-100">Register</button>
</form>

<p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>

<?php include '../includes/footer.php'; ?>
