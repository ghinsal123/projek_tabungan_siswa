<?php
session_start(); // WAJIB ada sebelum pakai $_SESSION
include "../service/database.php"; // Hubungkan dengan database

// Cek role: hanya admin yang bisa akses
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== 'admin') {
    echo "<script>alert('Kamu tidak punya akses ke fitur ini!'); window.location='index.php';</script>";
    exit();
}
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];

    // Query untuk memasukkan data ke database
    $sql = "INSERT INTO siswa (nama, kelas, jurusan) VALUES ('$nama', '$kelas', '$jurusan')";

    if ($db->query($sql) === TRUE) {
        echo "<script>
            alert('Data berhasil disimpan!');
            window.location.href = 'index.php';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }

    $db->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* General reset and global styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            color: #333;
        }

        a {
            text-decoration: none;
        }

        /* Navbar Styles */
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

        /* Add Student Form */
        .form-container {
            background-color: white;
            padding: 20px;
            margin: 100px auto;
            width: 80%; /* Adjust the width to make it more centered */
            max-width: 500px; /* Limit the maximum width */
            border-radius: 8px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .form-container h4 {
            font-size: 22px;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .form-container input,
        .form-container select,
        .form-container button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .form-container input,
        .form-container select {
            margin-bottom: 20px; /* Add more spacing between form elements */
        }

        .form-container button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #218838;
        }

        /* Align Save and Cancel buttons in the same row */
        .form-buttons {
            display: flex;
            justify-content: space-between;
        }

        .form-buttons button {
            width: 48%; /* Each button will take 48% of the width */
        }

        .form-buttons .cancel-btn {
            background-color: #dc3545;
        }

        .form-buttons .cancel-btn:hover {
            background-color: #c82333;
        }

        /* Footer */
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
    <div class="navbar">
        <div class="logo">TS</div>
        <div class="menu">
            <a href="#">Dashboard</a>
            <a href="#">Siswa</a>
            <a href="#">Tabungan</a>
            <form action="" method="POST">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>
    </div>

    <!-- Add Student Form -->
    <div class="form-container">
        <h4>Tambah Data Siswa</h4>
        <form action="tambah_data_siswa.php" method="POST">
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
            <select name="kelas" placeholder="Kelas">
                <option value="">Pilih Kelas</option>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
            </select>
            <select name="jurusan" required>
                <option value="">Pilih Jurusan</option>
                <option value="RPL">RPL</option>
                <option value="DKV">DKV</option>
                <option value="TKJ">TKJ</option>
                <option value="AK">AK</option>
                <option value="DPB">DPB</option>
                <option value="TP">TP</option>
                <option value="TPL">TPL</option>
                <option value="TKR">TKR</option>
            </select>

            <!-- Action Buttons: Save and Cancel -->
            <div class="form-buttons">
                <button type="button" class="cancel-btn" onclick="window.history.back()">Batal</button>
                <button type="submit" name="simpan">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>

