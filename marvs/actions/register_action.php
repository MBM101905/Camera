<?php
session_start();
include '../config/db.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

// Check if user already exists
$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
  echo "Email already registered. <a href='../pages/register.php'>Try again</a>";
  exit;
}

$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $password);
if ($stmt->execute()) {
  $_SESSION['user_id'] = $stmt->insert_id;
  $_SESSION['username'] = $username;
  header("Location: ../pages/index.php");
} else {
  echo "Registration failed.";
}
