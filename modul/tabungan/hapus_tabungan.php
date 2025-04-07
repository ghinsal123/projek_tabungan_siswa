<?php
include "../service/database.php";

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
