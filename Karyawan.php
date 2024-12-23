<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Karyawan</title>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
    <header>
        <h1>Manajemen Karyawan</h1>
        <nav>
            <ul>
                <li><a href="index.php">Halaman Utama</a></li>
                <li><a href="inventory.php">Manajemen Stok</a></li>
                <li><a href="Kukisform.php">Manajemen Cookies</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Tambah / Edit Karyawan</h2>
        <form id="KaryawanForm">
            <input type="hidden" id="KaryawanIndex" name="KaryawanIndex" value="">
            <label for="KaryawanName">Nama Karyawan:</label>
            <input type="text" id="KaryawanName" name="KaryawanName" required>
            
            <label for="KaryawanPosition">Jabatan:</label>
            <input type="text" id="KaryawanPosition" name="KaryawanPosition" required>
            
            <button type="submit">Simpan Karyawan</button>
        </form>

        <h2>Daftar Karyawan</h2>
        <table id="KaryawanTable">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data karyawan akan diisi oleh JavaScript -->
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2024 Toko Pisang Kembung</p>
    </footer>

    <script>
        // Fungsi untuk memuat data karyawan dari localStorage
        function loadKaryawans() {
            const Karyawans = JSON.parse(localStorage.getItem('Karyawans')) || [];
            const tableBody = document.getElementById('KaryawanTable').getElementsByTagName('tbody')[0];
            tableBody.innerHTML = '';

            Karyawans.forEach((Karyawan, index) => {
                const row = tableBody.insertRow();
                row.innerHTML = `
                    <td>${Karyawan.name}</td>
                    <td>${Karyawan.position}</td>
                    <td>
                        <button onclick="editKaryawan(${index})">Edit</button>
                        <button onclick="deleteKaryawan(${index})">Hapus</button>
                    </td>
                `;
            });
        }

        // Fungsi untuk menambah atau mengedit karyawan
        document.getElementById('KaryawanForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const name = document.getElementById('KaryawanName').value;
            const position = document.getElementById('KaryawanPosition').value;
            const index = document.getElementById('KaryawanIndex').value;

            const Karyawans = JSON.parse(localStorage.getItem('Karyawans')) || [];

            if (index !== "") {
                // Jika index ada, berarti kita sedang mengedit
                Karyawans[index].name = name;
                Karyawans[index].position = position;
            } else {
                // Jika index kosong, berarti kita sedang menambah karyawan baru
                Karyawans.push({ name, position });
            }

            // Menyimpan data karyawan ke localStorage
            localStorage.setItem('Karyawans', JSON.stringify(Karyawans));

            // Mengosongkan form
            document.getElementById('KaryawanName').value = '';
            document.getElementById('KaryawanPosition').value = '';
            document.getElementById('KaryawanIndex').value = '';

            // Memuat ulang daftar karyawan
            loadKaryawans();
        });

        // Fungsi untuk menghapus karyawan
        function deleteKaryawan(index) {
            const Karyawans = JSON.parse(localStorage.getItem('Karyawans')) || [];
            Karyawans.splice(index, 1);

            // Menyimpan data terbaru ke localStorage
            localStorage.setItem('Karyawans', JSON.stringify(Karyawans));

            // Memuat ulang daftar karyawan
            loadKaryawans();
        }

        // Fungsi untuk mengedit karyawan
        function editKaryawan(index) {
            const Karyawans = JSON.parse(localStorage.getItem('Karyawans')) || [];
            const Karyawan = Karyawans[index];

            // Mengisi form dengan data karyawan yang dipilih
            document.getElementById('KaryawanName').value = Karyawan.name;
            document.getElementById('KaryawanPosition').value = Karyawan.position;
            document.getElementById('KaryawanIndex').value = index;
        }

        // Memuat data karyawan saat halaman pertama kali dibuka
        loadKaryawans();
    </script>
</body>
</html>
