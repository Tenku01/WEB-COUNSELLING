<?php
include 'koneksi.php';

// Fungsi untuk mencegah inputan karakter yang tidak sesuai
function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Menggunakan rand() untuk menghasilkan order_id acak
    $order_id = rand(100000, 999999);  // Menghasilkan angka acak antara 100000 dan 999999
    $name = input($_POST["name"]);
    $email = input($_POST["email"]);
    $phone_number = input($_POST["phone_number"]);
    $tanggal = input($_POST["tanggal"]);
    $waktu = input($_POST["waktu"]);
    $jenis_layanan = input($_POST["jenis_layanan"]);

    // Query untuk menyimpan data ke dalam tabel pesanan termasuk order_id
    $sql = "INSERT INTO pesanan (order_id, name, email, phone_number, tanggal, waktu, jenis_layanan) VALUES ('$order_id', '$name', '$email', '$phone_number', '$tanggal', '$waktu', '$jenis_layanan')";

    // Mengeksekusi atau menjalankan query di atas
    if (mysqli_query($kon, $sql)) {
        header("Location: ./midtrans/examples/snap/checkout-process-simple-version.php?order_id=$order_id");
        exit();
    } else {
        echo "<div class='alert alert-danger'> Data gagal disimpan: " . mysqli_error($kon) . "</div>";
    }
}
?>
