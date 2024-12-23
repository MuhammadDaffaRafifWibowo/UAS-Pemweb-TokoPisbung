<?php
// Koneksi ke database
$host = 'sql205.infinityfree.com';
$user = 'if0_37970063';
$password = 'qmYAoFygtlgjneQ';
$database = 'if0_37970063_Pisang_Kembung';


$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses Pengiriman Formulir (Create)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit_inventory'])) {
    $itemName = $conn->real_escape_string($_POST['itemName']);
    $itemCategory = $conn->real_escape_string($_POST['itemCategory']);
    $itemQuantity = (int) $_POST['itemQuantity'];
    $itemPrice = (float) $_POST['itemPrice'];
    
    $query = "INSERT INTO Stok (name, category, quantity, price) VALUES ('$itemName', '$itemCategory', '$itemQuantity', '$itemPrice')";
    
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Barang berhasil ditambahkan');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Proses Update Data (Update)
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM Stok WHERE id = $id");
    $item = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_inventory'])) {
    $id = $_POST['itemId'];
    $itemName = $conn->real_escape_string($_POST['itemName']);
    $itemCategory = $conn->real_escape_string($_POST['itemCategory']);
    $itemQuantity = (int) $_POST['itemQuantity'];
    $itemPrice = (float) $_POST['itemPrice'];
    
    $query = "UPDATE Stok SET name = '$itemName', category = '$itemCategory', quantity = '$itemQuantity', price = '$itemPrice' WHERE id = $id";
    
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Barang berhasil diperbarui'); window.location = 'inventory.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Proses Hapus Data (Delete)
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM Stok WHERE id = $id");
    echo "<script>alert('Barang berhasil dihapus'); window.location = 'inventory.php';</script>";
}

// Query untuk mendapatkan data Stok
$query = "SELECT * FROM Stok";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok - Pisang Kembung</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js" defer></script>
</head>
<body>
    <header>
        <h1>Manajemen Stok</h1>
        <nav>
            <ul>
                <li><a href="index.php">Halaman Utama</a></li>
                <li><a href="Karyawan.php">Manajemen Karyawan</a></li>
                <li><a href="Kukisform.php">Manajemen Cookies</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Tambah/Edit Barang</h2>
        <form id="inventoryForm" method="POST">
            <label for="itemName">Nama Barang:</label>
            <input type="text" id="itemName" name="itemName" value="<?= isset($item['name']) ? $item['name'] : '' ?>" required>

            <label for="itemCategory">Kategori:</label>
            <input type="text" id="itemCategory" name="itemCategory" value="<?= isset($item['category']) ? $item['category'] : '' ?>" required>

            <label for="itemQuantity">Jumlah:</label>
            <input type="number" id="itemQuantity" name="itemQuantity" value="<?= isset($item['quantity']) ? $item['quantity'] : '' ?>" required>

            <label for="itemPrice">Harga:</label>
            <input type="number" id="itemPrice" name="itemPrice" value="<?= isset($item['price']) ? $item['price'] : '' ?>" required>

            <input type="hidden" name="itemId" value="<?= isset($item['id']) ? $item['id'] : '' ?>">

            <button type="submit" name="<?= isset($item['id']) ? 'update_inventory' : 'submit_inventory' ?>">
                <?= isset($item['id']) ? 'Perbarui Barang' : 'Tambah Barang' ?>
            </button>
        </form>

        <h2>Daftar Barang</h2>
        <table id="inventoryTable">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['category']) ?></td>
                            <td><?= htmlspecialchars($row['quantity']) ?></td>
                            <td><?= htmlspecialchars($row['price']) ?></td>
                            <td>
                                <a href="inventory.php?edit=<?= $row['id'] ?>">Edit</a> | 
                                <a href="inventory.php?delete=<?= $row['id'] ?>" onclick="return confirm('Anda yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Tidak ada data barang.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2024 Toko Pisang Kembung</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
