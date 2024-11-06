<?php
session_start();
$host = "localhost";
$username = "root";
$password = "";
$dbname = "konseling";

// Membuat koneksi ke database
$conn = new mysqli($host, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the admin credentials are provided
    if ($email === "admin@gmail.com" && $password === "admin") {
        // Redirect to index.php for admin
        header("Location: index.php");
        exit();
    } else {
        // Melakukan query untuk mendapatkan hash password dari database
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hash = $row['password'];

            // Verifikasi password dengan hash
            if (password_verify($password, $hash)) {
                // Jika login berhasil, arahkan ke dashboard.html
                header("Location: http://localhost/web%20project%20damind/dashboard.html");
                exit();
            } else {
                echo "Login gagal. Password salah.";
            }
        } else {
            echo "Login gagal. Email tidak ditemukan.";
        }
    }
}

$conn->close();
?>
