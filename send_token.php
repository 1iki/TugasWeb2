<?php
// Koneksi ke database
$db_name = 'mysql:host=localhost;dbname=shop_db';
$user_name = 'root';
$user_password = '';

$conn = new PDO($db_name, $user_name, $user_password);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil email dari formulir
$email = $_POST['email'];

// Cek apakah email ada di database
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Email ditemukan, buat token acak dan simpan ke database
    $token = bin2hex(random_bytes(16));

    $sql = "UPDATE users SET token_ganti_password='$token' WHERE email='$email'";

    if ($conn->query($sql) === TRUE) {
        // Kirim email dengan token
        $subject = "Ganti Password";
        $message = "Klik tautan berikut untuk mengganti password Anda: http://alamat_web_anda/ganti_password.php?token=$token";
        $headers = "From: webmaster@example.com";

        mail($email, $subject, $message, $headers);

        echo "Email dengan tautan penggantian password telah dikirim.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Email tidak ditemukan.";
}

$conn->close();
?>
