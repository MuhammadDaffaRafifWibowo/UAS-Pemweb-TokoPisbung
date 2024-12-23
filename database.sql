-- Membuat database Pisang_Kembung
CREATE DATABASE Pisang_Kembung;

-- Gunakan database Pisang_Kembung
USE Pisang_Kembung;

-- Membuat tabel Stok
CREATE TABLE Stok (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    price INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Membuat tabel Karyawan
CREATE TABLE Karyawan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    position VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
