<?php
// Koneksi ke database
include 'components/connect.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari formulir
$email = $_POST['email'];
$password = sha1($_POST['password']); // Ganti dengan algoritma hash yang lebih kuat

// Update password dan hapus token
$sql = "UPDATE users SET password='$password', token_ganti_password='' WHERE email='$email'";

if ($conn->query($sql) === TRUE) {
    echo "Password berhasil diubah.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
