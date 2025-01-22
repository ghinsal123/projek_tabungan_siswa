<?php
include "service/database.php";

// Cek jika tombol logout ditekan
if (isset($_POST['logout'])) {
    session_start();
    session_destroy();
    echo "<script>window.location='login.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan nilai yang diterima tidak kosong dan valid
    $id = isset($_POST['id_siswa']) ? trim($_POST['id_siswa']) : '';
    $setoran = isset($_POST['saldo']) ? trim($_POST['saldo']) : '';

    // Debug: Memeriksa data POST yang dikirim
    // var_dump($_POST);  // Hapus setelah selesai debugging

    // Cek apakah nilai kosong atau tidak valid
    if (empty($id)) {
        echo "<script>alert('Harap pilih siswa!'); window.history.back();</script>";
        exit;
    }

    if (empty($setoran) || !is_numeric($setoran) || $setoran <= 0) {
        echo "<script>alert('Harap masukkan jumlah setoran yang valid!'); window.history.back();</script>";
        exit;
    }

    // Escape nilai untuk keamanan
    $id = $db->real_escape_string($id);
    $setoran = (int)$setoran; // Pastikan saldo adalah integer

    // Cek apakah siswa sudah memiliki tabungan
    $checkSql = "SELECT * FROM tabungan WHERE id_siswa='$id'";
    $result = $db->query($checkSql);

    if ($result->num_rows > 0) {
        // Jika sudah ada, update saldo
        $updateSql = "UPDATE tabungan SET saldo = saldo + $setoran WHERE id_siswa='$id'";
        if ($db->query($updateSql) === TRUE) {
            echo "<script>alert('Setoran awal berhasil!'); window.location='tabungan.php';</script>";
        } else {
            echo "Error saat update: " . $db->error;
        }
    } else {
        // Jika belum ada, insert saldo baru
        $insertSql = "INSERT INTO tabungan (id_siswa, tanggal, saldo) VALUES ('$id', NOW(), '$setoran')";
        if ($db->query($insertSql) === TRUE) {
            echo "<script>alert('Setoran awal berhasil!'); window.location='tabungan.php';</script>";
        } else {
            echo "Error saat insert: " . $db->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setoran Awal</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2e7d32;
            padding: 15px 30px;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #fff;
        }

        .menu {
            display: flex;
            align-items: center;
        }

        .menu a {
            color: white;
            font-size: 18px;
            margin-right: 20px;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background 0.3s ease;
            text-decoration: none;
        }

        .menu a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .menu button {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .menu button:hover {
            background-color: #e53935;
        }

        .container {
            max-width: 500px;
            margin-top: 50px;
            margin-left: auto;
            margin-right: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #2e7d32;
            text-align: center;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        select, input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-buttons {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .form-buttons button {
            padding: 12px 20px;
            width: 48%;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }

        .form-buttons .cancel-btn {
            background-color: #dc3545;
            color:white ;
        }

        .form-buttons .cancel-btn:hover {
            background-color: #c82333;
        }

        .form-buttons .save-btn {
            background-color: #007bff;
            color: #fff;
        }

        .form-buttons .save-btn:hover {
            background-color: #0056b3;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #2e7d32;
            color: white;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">TS</div>
        <div class="menu">
            <a href="#">Dashboard</a>
            <a href="#">Siswa</a>
            <a href="#">Tabungan</a>
                <button>Logout</button>
        </div>
    </div>

    <div class="container">
        <h2>Setoran</h2>
        <form method="POST">
    <label for="id_siswa">Pilih Siswa:</label>
    <select name="id_siswa" required>
        <option value="">-- Pilih Siswa --</option>
        <?php
        // Mengambil data siswa dari database
        $sql = "SELECT * FROM siswa";
        $result = $db->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_siswa'] . "'>" . $row['nama'] . " (" . $row['kelas'] . ")</option>";
        }
        ?>
    </select>

    <label for="saldo">Jumlah Setoran:</label>
    <input type="number" name="saldo" min="1000" required>

    <div class="form-buttons">
        <button type="button" class="cancel-btn" onclick="window.history.back()">Batal</button>
        <button type="submit" class="save-btn">Simpan</button>
    </div>
</form>
    </div>

</body>
</html>
