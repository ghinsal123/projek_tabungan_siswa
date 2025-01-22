<?php
include "service/database.php";

if (isset($_POST['id_tabungan'])) {
    $id_tabungan = $_POST['id_tabungan'];
    
    $deleteSql = "DELETE FROM tabungan WHERE id_tabungan = '$id_tabungan'";
    
    if ($db->query($deleteSql) === TRUE) {
        echo "<script>alert('Tabungan berhasil dihapus!'); window.location='tabungan.php';</script>";
    } else {
        echo "Error: " . $db->error;
    }
}
?>
