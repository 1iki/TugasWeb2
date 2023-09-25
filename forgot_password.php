<?php

// Connect to the database
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

// Get the user's email address
$email = $_POST['email'];

// Check if the user exists in the database
$query = 'SELECT * FROM users WHERE email = :email';
$stmt = $db->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->execute();

$user = $stmt->fetch();

if (!$user) {
  // The user does not exist
  echo 'Email Anda Tidak Terdaftar';
  die();
}

// Generate a random reset token
$token = bin2hex(random_bytes(16));

// Insert the reset token into the database
$query = 'INSERT INTO password_resets (user_id, token) VALUES (:user_id, :token)';
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $user['id']);
$stmt->bindParam(':token', $token);
$stmt->execute();

// Send a reset email to the user
$to = $user['email'];
$subject = 'Reset your password';
$message = 'To reset your password, please click on the following link:

http://localhost/ecomerce/ecommerce%20website/reset_password.php?token='.$token;

mail($to, $subject, $message);

// Redirect the user to the login page
header('user_login.php');

?>
