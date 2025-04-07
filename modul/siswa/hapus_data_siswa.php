<?php
include "../service/database.php"; // Koneksi ke database

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query hapus data
    $sql = "DELETE FROM siswa WHERE id_siswa = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Data berhasil dihapus!');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data!');
                window.location.href = 'index.php';
              </script>";
    }

    $stmt->close();
    $db->close();
} else {
    echo "<script>
            alert('ID tidak ditemukan!');
            window.location.href = 'index.php';
          </script>";
}
?>
