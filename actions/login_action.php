<?php
session_start();
include '../config/db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 1) {
  $stmt->bind_result($id, $username, $hashed_password);
  $stmt->fetch();

  if (password_verify($password, $hashed_password)) {
    $_SESSION['user_id'] = $id;
    $_SESSION['username'] = $username;
    header("Location: ../pages/index.php");
  } else {
    echo "Invalid password. <a href='../pages/login.php'>Try again</a>";
  }
} else {
  echo "User not found. <a href='../pages/login.php'>Try again</a>";
}
