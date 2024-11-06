<?php
include 'koneksi.php';

// Fungsi untuk mencegah inputan karakter yang tidak sesuai
function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Cek apakah ada nilai yang dikirim menggunakan metode GET dengan nama id
if (isset($_GET['id'])) {
    $id = input($_GET["id"]);

    // Query untuk mengambil data pesanan berdasarkan id
    $sql = "SELECT * FROM pesanan WHERE id='$id'";
    $hasil = mysqli_query($kon, $sql);
    $data = mysqli_fetch_assoc($hasil);
}

// Cek apakah ada kiriman form dari method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = input($_POST["id"]);
    $name = input($_POST["name"]);
    $email = input($_POST["email"]);
    $phone_number = input($_POST["phone_number"]);
    $tanggal = input($_POST["tanggal"]);
    $waktu = input($_POST["waktu"]);
    $jenis_layanan = input($_POST["jenis_layanan"]);

    $sql = "UPDATE pesanan SET 
                name='$name', 
                email='$email', 
                phone_number='$phone_number', 
                tanggal='$tanggal', 
                waktu='$waktu', 
                jenis_layanan='$jenis_layanan' 
            WHERE id='$id'";

    // Mengeksekusi atau menjalankan query di atas
    $hasil = mysqli_query($kon, $sql);

    // Kondisi apakah berhasil atau tidak dalam mengeksekusi query di atas
    if ($hasil) {
        header("Location:index_pesanan.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'> Data Gagal diupdate: " . mysqli_error($kon) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pesanan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h2>Edit Pesanan</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo isset($data['id']) ? $data['id'] : ''; ?>">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" placeholder="Enter Name" required value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>">
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" placeholder="Enter Email" required value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>">
        </div>
        <div class="form-group">
            <label>Phone Number:</label>
            <input type="text" name="phone_number" class="form-control" placeholder="Enter Phone Number" required value="<?php echo isset($data['phone_number']) ? $data['phone_number'] : ''; ?>">
        </div>
        <div class="form-group">
            <label>Tanggal:</label>
            <input type="date" name="tanggal" class="form-control" required value="<?php echo isset($data['tanggal']) ? $data['tanggal'] : ''; ?>">
        </div>
        <div class="form-group">
            <label>Waktu:</label>
            <input type="time" name="waktu" class="form-control" required value="<?php echo isset($data['waktu']) ? $data['waktu'] : ''; ?>">
        </div>
        <div class="form-group">
            <label>Jenis Layanan:</label>
            <input type="text" name="jenis_layanan" class="form-control" placeholder="Enter Jenis Layanan" required value="<?php echo isset($data['jenis_layanan']) ? $data['jenis_layanan'] : ''; ?>">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
