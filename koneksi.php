<?php
// Konfigurasi Database Supabase
$host     = 'db.exxgfobiwfqowwhgwgka.supabase.co'; // Ganti dengan Host Anda
$port     = '5432';                  // Port default PostgreSQL Supabase
$db_name  = 'postgres';              // Nama database default
$username = 'postgres';              // Username default
$password = 'YYpA5TpyhiW7saME';  // Ganti dengan password database Anda

try {
    // Membuat koneksi menggunakan PDO PostgreSQL
    $dsn = "pgsql:host=$host;port=$port;dbname=$db_name";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC    
    ]);

    // Jika berhasil (opsional, bisa dihapus jika sudah production)
    echo "Koneksi ke database Supabase berhasil!";

} catch (PDOException $e) {
    // Jika koneksi gagal
    die("Koneksi gagal: " . $e->getMessage());
}
?>