<?php
include 'koneksi.php';

// Proses delete data jika ada request penghapusan
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = htmlspecialchars($_GET["id"]);

    $sql = "DELETE FROM users WHERE id='$id'";
    $hasil = mysqli_query($kon, $sql);

    if ($hasil) {
        header("Location:index.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'> Data Gagal dihapus: " . mysqli_error($kon) . "</div>";
    }
}

// Proses pencarian
if (isset($_GET['search'])) {
    $keyword = $_GET['search'];
    $sql = "SELECT * FROM users WHERE name LIKE '%$keyword%' OR email LIKE '%$keyword%'";
} else {
    $sql = "SELECT * FROM users ORDER BY id DESC";
}

$result = mysqli_query($kon, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <span class="navbar-brand mb-0 h1">User Management</span>
</nav>
<div class="container">
    <br>
    <h4><center>DATA USERS</center></h4>
    <!-- Form pencarian -->
    <form action="index.php" method="GET" class="mb-3">
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
                <td><?php echo $data["name"]; ?></td>
                <td><?php echo $data["email"]; ?></td>
                <td>
                    <a href="update.php?id=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-warning" role="button">Update</a>
                    <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?action=delete&id=<?php echo $data['id']; ?>" class="btn btn-danger" role="button">Delete</a>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <a href="index_pesanan.php" class="btn btn-primary" role="button">MANAJEMEN PESANAN</a>
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
                x = rows[i].querySelectorAll("td")[columnName === 'name' ? 1 : 2];
                y = rows[i + 1].querySelectorAll("td")[columnName === 'name' ? 1 : 2];

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

        var arrow = document.querySelector('th.' + columnName + ' button');
        arrow.innerHTML = dir;
    }
</script>

</body>
</html>
