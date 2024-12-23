<?php
class Employee {
    // Properti untuk menyimpan data karyawan dalam array
    private $Karyawan;

    // Konstruktor untuk inisialisasi
    public function __construct() {
        // Jika data karyawan sudah ada di localStorage (disimulasikan dengan sesi PHP)
        if (isset($_SESSION['Karyawan'])) {
            $this->Karyawan = $_SESSION['Karyawan'];
        } else {
            $this->Karyawan = [];
        }
    }

    // Menambahkan karyawan baru
    public function addEmployee($name, $position) {
        $newEmployee = [
            'name' => $name,
            'position' => $position
        ];
        
        // Menambahkan karyawan ke array
        $this->Karyawan[] = $newEmployee;

        // Menyimpan data ke session (simulasi penyimpanan ke localStorage)
        $_SESSION['Karyawan'] = $this->Karyawan;
    }

    // Mendapatkan semua data karyawan
    public function getAllKaryawan() {
        return $this->Karyawan;
    }

    // Menghapus karyawan berdasarkan nama
    public function deleteEmployee($name) {
        foreach ($this->Karyawan as $index => $employee) {
            if ($employee['name'] == $name) {
                unset($this->Karyawan[$index]);
                $_SESSION['Karyawan'] = $this->Karyawan; // Menyimpan perubahan
                return true;
            }
        }
        return false;
    }
}
?>
