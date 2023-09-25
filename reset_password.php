<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
</head>
<body>

<h2>Password Reset</h2>

<?php
// Connect to the database (ganti DB_HOST, DB_USER, DB_PASSWORD, dan DB_NAME dengan kredensial database Anda)
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo "Passwords do not match.";
        exit();
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database
    $query = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
    $result = $mysqli->query($query);

    if ($result) {
        echo "Password updated successfully!";
    } else {
        echo "Error updating password: " . $mysqli->error;
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
$mysqli->close();
?>

<form action="reset_password.php" method="post">
    Email: <input type="email" name="email" required><br><br>
    New Password: <input type="password" name="new_password" required><br><br>
    Confirm Password: <input type="password" name="confirm_password" required><br><br>
    <input type="submit" value="Reset Password">
</form>

</body>
</html>
