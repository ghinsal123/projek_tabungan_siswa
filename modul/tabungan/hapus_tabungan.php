<?php
session_start(); // WAJIB ada sebelum pakai $_SESSION
include "../service/database.php";

// Cek role: hanya admin yang bisa akses
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== 'admin') {
    echo "<script>alert('Kamu tidak punya akses ke fitur ini!'); window.location='index.php';</script>";
    exit();
}

if (isset($_POST['id_tabungan'])) {
    $id_tabungan = $_POST['id_tabungan'];
    
    $deleteSql = "DELETE FROM tabungan WHERE id_tabungan = '$id_tabungan'";
    
    if ($db->query($deleteSql) === TRUE) {
        echo "<script>alert('Tabungan berhasil dihapus!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus tabungan: " . addslashes($db->error) . "'); window.location='index.php';</script>";
    }
}
?>
