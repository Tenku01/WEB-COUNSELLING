<?php
include 'koneksi.php';

// Proses delete data jika ada request penghapusan
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = htmlspecialchars($_GET["id"]);

    $sql = "DELETE FROM pesanan WHERE id='$id'";
    $hasil = mysqli_query($kon, $sql);

    if ($hasil) {
        header("Location:index_pesanan.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'> Data Gagal dihapus: " . mysqli_error($kon) . "</div>";
    }
}

// Proses pencarian
if (isset($_GET['search'])) {
    $keyword = $_GET['search'];
    $sql = "SELECT * FROM pesanan WHERE name LIKE '%$keyword%' OR email LIKE '%$keyword%'";
} else {
    $sql = "SELECT * FROM pesanan ORDER BY id DESC";
}

$result = mysqli_query($kon, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pesanan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <span class="navbar-brand mb-0 h1">Pesanan Management</span>
</nav>
<div class="container">
    <br>
    <h4><center>DATA PESANAN</center></h4>
    <!-- Form pencarian -->
    <form action="index_pesanan.php" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Cari..." name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </div>
    </form>
    <table class="my-3 table table-bordered">
        <thead>
            <tr class="table-primary">
                <th>No</th>
                <th>
                    Name
                    <button class="btn btn-link" onclick="sortTable('name')">↑↓</button>
                </th>
                <th>
                    Email
                    <button class="btn btn-link" onclick="sortTable('email')">↑↓</button>
                </th>
                <th>
                    Phone Number
                    <button class="btn btn-link" onclick="sortTable('phone_number')">↑↓</button>
                </th>
                <th>
                    Tanggal
                    <button class="btn btn-link" onclick="sortTable('tanggal')">↑↓</button>
                </th>
                <th>
                    Waktu
                    <button class="btn btn-link" onclick="sortTable('waktu')">↑↓</button>
                </th>
                <th>
                    Jenis Layanan
                    <button class="btn btn-link" onclick="sortTable('jenis_layanan')">↑↓</button>
                </th>
                <th colspan='2'>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            while ($data = mysqli_fetch_array($result)) {
                $no++;
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo htmlspecialchars($data["name"]); ?></td>
                <td><?php echo htmlspecialchars($data["email"]); ?></td>
                <td><?php echo htmlspecialchars($data["phone_number"]); ?></td>
                <td><?php echo htmlspecialchars($data["tanggal"]); ?></td>
                <td><?php echo htmlspecialchars($data["waktu"]); ?></td>
                <td><?php echo htmlspecialchars($data["jenis_layanan"]); ?></td>
                <td>
                    <a href="update_pesanan.php?id=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-warning" role="button">Update</a>
                    <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?action=delete&id=<?php echo $data['id']; ?>" class="btn btn-danger" role="button">Delete</a>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-primary" role="button">MANAJEMEN USERS</a>
</div>
<script>
    function sortTable(columnName) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.querySelector('table');
        switching = true;
        dir = "asc";

        while (switching) {
            switching = false;
            rows = table.rows;

            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].querySelectorAll("td")[getColumnIndex(columnName)];
                y = rows[i + 1].querySelectorAll("td")[getColumnIndex(columnName)];

                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }

            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }

        var arrows = document.querySelectorAll('th button');
        arrows.forEach(function(arrow) {
            arrow.innerHTML = '↑↓';
        });

        var arrow = document.querySelector('th button[onclick="sortTable(\'' + columnName + '\')"]');
        arrow.innerHTML = dir == 'asc' ? '↑' : '↓';
    }

    function getColumnIndex(columnName) {
        switch (columnName) {
            case 'name': return 1;
            case 'email': return 2;
            case 'phone_number': return 3;
            case 'tanggal': return 4;
            case 'waktu': return 5;
            case 'jenis_layanan': return 6;
            default: return 0;
        }
    }
</script>
</body>
</html>
