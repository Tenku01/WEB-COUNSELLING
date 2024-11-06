<?php
include 'koneksi.php';

// Cek apakah parameter id telah dikirim melalui URL
if (isset($_GET['id'])) {
    // Ambil nilai parameter id dari URL
    $id = htmlspecialchars($_GET["id"]);

    // Query untuk menghapus data dari tabel pesanan berdasarkan id
    $sql = "DELETE FROM pesanan WHERE id = $id";

    // Eksekusi query untuk menghapus data
    if (mysqli_query($kon, $sql)) {
        // Jika berhasil dihapus, redirect ke halaman index_pesanan dengan pesan sukses
        header('location:index_pesanan.php?info=success&msg=Data berhasil dihapus');
        exit();
    } else {
        // Jika gagal menghapus, redirect ke halaman index_pesanan dengan pesan error
        header('location:index_pesanan.php?info=error&msg=Gagal menghapus data: ' . mysqli_error($kon));
        exit();
    }
} else {
    // Jika parameter id tidak ada, redirect ke halaman index_pesanan dengan pesan error
    header('location:index_pesanan.php?info=error&msg=Parameter id tidak ditemukan');
    exit();
}
?>
