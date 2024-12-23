<?php
session_start();
require_once 'includes/Kukis.php';

// Membuat objek Kukis
$Kukis = new Kukis();

// Menangani pengaturan cookie
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit_action'])) {
    $action = $_POST['action'];
    $cookieName = $_POST['cookieName'];
    $cookieValue = isset($_POST['cookieValue']) ? $_POST['cookieValue'] : null;

    switch ($action) {
        case 'set':
            if ($cookieName && $cookieValue) {
                // Set the cookie for 1 hour
                $Kukis->setCookie($cookieName, $cookieValue, 3600);
                echo "<script>alert('Cookie berhasil diset!');</script>";
            }
            break;
        
        case 'get':
            $cookieData = $Kukis->getCookie($cookieName);
            echo "<script>alert('Nilai Cookie: " . htmlspecialchars($cookieData) . "');</script>";
            break;
        
        case 'delete':
            $Kukis->deleteCookie($cookieName);
            echo "<script>alert('Cookie berhasil dihapus!');</script>";
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengelolaan Cookies</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Form Pengelolaan Cookies</h1>
        <nav>
            <ul>
                <li><a href="index.php">Halaman Utama</a></li>
                <li><a href="inventory.php">Manajemen Inventory</a></li>
                <li><a href="Karyawan.php">Manajemen Karyawan</a></li>
            </ul>
      </nav>
    </header>

    <main>
        <form method="POST">
            <label for="action">Pilih Aksi:</label>
            <select id="action" name="action" required>
                <option value="set">Set Cookie</option>
                <option value="get">Get Cookie</option>
                <option value="delete">Delete Cookie</option>
            </select>

            <!-- Fields for setting cookie -->
            
                <label for="cookieName">Nama Cookie:</label>
                <input type="text" id="cookieName" name="cookieName" required>

                <label for="cookieValue">Nilai Cookie:</label>
                <input type="text" id="cookieValue" name="cookieValue">
        
            <button type="submit" name="submit_action">Lakukan Aksi</button>
        </form>

        <script>
            // Menyesuaikan form yang ditampilkan berdasarkan pilihan menu dropdown
            const actionSelect = document.getElementById('action');
            const setFields = document.getElementById('setFields');
            const getDeleteFields = document.getElementById('getDeleteFields');

            // Update form berdasarkan aksi yang dipilih
            actionSelect.addEventListener('change', function() {
                if (this.value === 'set') {
                    setFields.style.display = 'block';
                    getDeleteFields.style.display = 'none';
                } else if (this.value === 'get' || this.value === 'delete') {
                    setFields.style.display = 'none';
                    getDeleteFields.style.display = 'block';
                }
            });

            // Trigger event untuk menampilkan form yang sesuai saat pertama kali memuat
            actionSelect.dispatchEvent(new Event('change'));
        </script>
    </main>

    <footer>
        <p>&copy; 2024 Toko Pisang Kembung</p>
    </footer>
</body>
</html>
