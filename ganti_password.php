<?php
// Koneksi ke database
include 'components/connect.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil token dari URL
$token = $_GET['token'];

// Cari pengguna dengan token yang sesuai
$sql = "SELECT * FROM users WHERE token_ganti_password='$token'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $email = $user['email'];
    // Tampilkan formulir untuk mengubah password
    echo "<form action='proses_ganti_password.php' method='post'>";
    echo "<input type='hidden' name='email' value='$email'>";
    echo "Password Baru: <input type='password' name='password' required><br>";
    echo "<input type='submit' value='Ganti Password'>";
    echo "</form>";
} else {
    echo "Token tidak valid.";
}

$conn->close();
?>
