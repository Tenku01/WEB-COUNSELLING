<?php
$servername = "localhost"; // Ganti dengan nama server Anda
$username = "username"; // Ganti dengan username database Anda
$password = "password"; // Ganti dengan password database Anda
$dbname = "konseling"; // Ganti dengan nama database Anda

// Buat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$full_name = $_POST['name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$tanggal = $_POST['tanggal'];
$waktu = $_POST['waktu'];

// Masukkan data ke tabel bookings
$sql = "INSERT INTO bookings (full_name, email, phone_number, tanggal, waktu) 
        VALUES ('$full_name', '$email', '$phone_number', '$tanggal', '$waktu')";

if ($conn->query($sql) === TRUE) {
    echo "Pemesanan berhasil!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Tutup koneksi
$conn->close();
?>
