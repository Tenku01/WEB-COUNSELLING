<?php
// Set server key dan client key dari Midtrans
$serverKey = 'SB-Mid-server-kSFApf9BYpT-ekOcdjQ3XekN';
$clientKey = 'SB-Mid-client-41MWTx_GXkcBSkKv';

// Koneksi ke database
include "C:/xampp/htdocs/web project damind/koneksi.php";

// Dapatkan order_id dari URL
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
} else {
    die("Order ID tidak ditemukan.");
}

// Query untuk mendapatkan data klien berdasarkan order_id
$query = "SELECT * FROM pesanan WHERE order_id='$order_id'";
$sql = mysqli_query($kon, $query);  
$data = mysqli_fetch_array($sql);

if (!$data) {
    die("Data pesanan tidak ditemukan.");
}

$nama = $data['name'];
$email = $data['email'];
$phone_number = $data['phone_number'];
$tanggal = $data['tanggal'];
$waktu = $data['waktu'];
$jenis_layanan = $data['jenis_layanan'];

// Data transaksi
$transaction_details = array(
    'order_id' => $order_id,
    'gross_amount' => 100000, // Sesuaikan jumlah pembayaran sesuai kebutuhan
);

$item_details = array(
    array(
        'id' => 'a1',
        'price' => 100000,
        'quantity' => 1,
        'name' => $jenis_layanan
    )
);

$customer_details = array(
    'first_name' => $nama,
    'last_name' => "",
    'email' => $email,
    'phone' => $phone_number
);

$transaction = array(
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $item_details
);

$payload = json_encode($transaction);

// Buat permintaan HTTP menggunakan cURL
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://app.sandbox.midtrans.com/snap/v1/transactions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Authorization: Basic " . base64_encode($serverKey . ":"),
    "Content-Type: application/json",
    "Accept: application/json"
));

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$response = json_decode($result, true);

if (!isset($response['token'])) {
    die("Token pembayaran tidak ditemukan. Respon: " . $result);
}

$snap_token = $response['token'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PAYMENT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
    <br><br>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <p>Registrasi Berhasil, Selesaikan Pembayaran Sekarang</p>
                <button id="pay-button" class="btn btn-primary">PILIH METODE PEMBAYARAN</button>
                <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo $clientKey; ?>"></script>
                <script type="text/javascript">
                    document.getElementById('pay-button').onclick = function(){
                        snap.pay('<?php echo $snap_token; ?>');
                    };
                </script>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

</body>
</html>
