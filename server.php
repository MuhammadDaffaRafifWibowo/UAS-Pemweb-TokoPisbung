<?php
session_start();
header('Content-Type: application/json');

// Koneksi ke database
$host = 'sql205.infinityfree.com';
$user = 'if0_37970063';
$password = 'qmYAoFygtlgjneQ';
$database = 'if0_37970063_Pisang_Kembung';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['itemName'])) {
        // Validasi input untuk tabel Stok
        $name = trim($_POST['itemName']);
        $category = trim($_POST['itemCategory']);
        $quantity = (int)$_POST['itemQuantity'];
        $price = (int)$_POST['itemPrice'];

        if (empty($name) || empty($category) || $quantity <= 0 || $price <= 0) {
            die(json_encode(['success' => false, 'error' => 'Input tidak valid!']));
        }

        // Simpan data ke tabel Stok
        $stmt = $conn->prepare("INSERT INTO Stok (name, category, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $name, $category, $quantity, $price);

        if (!$stmt->execute()) {
            die(json_encode(['success' => false, 'error' => $stmt->error]));
        }

        echo json_encode(['success' => true, 'message' => 'Data stok berhasil ditambahkan!']);
    } elseif (isset($_POST['employeeName'])) {
        // Validasi input untuk tabel Karyawan
        $name = trim($_POST['employeeName']);
        $position = trim($_POST['employeePosition']);

        if (empty($name) || empty($position)) {
            die(json_encode(['success' => false, 'error' => 'Input tidak valid!']));
        }

        // Simpan data ke tabel Karyawan
        $stmt = $conn->prepare("INSERT INTO Karyawan (name, position) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $position);

        if (!$stmt->execute()) {
            die(json_encode(['success' => false, 'error' => $stmt->error]));
        }

        echo json_encode(['success' => true, 'message' => 'Data karyawan berhasil ditambahkan!']);
    }
}

$conn->close();
?>
