<?php
include "../service/database.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM siswa WHERE id_siswa='$id'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $kelas = $_POST['kelas'];

    $updateSql = "UPDATE siswa SET nama='$nama', jurusan='$jurusan', kelas='$kelas' WHERE id_siswa='$id'";
    
    if ($db->query($updateSql) === TRUE) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$db->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            color: #333;
        }

        /* Navbar Styles */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2e7d32;
            padding: 15px 30px;
            color: white;
            box-shadow: 0 4px 10px rgba(255, 255, 255, 0.1);
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
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

        /* Container */
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
            margin: 50px auto;
        }

        h2 {
            margin-bottom: 20px;
            color: #2e7d32;
        }

        label {
            font-weight: bold;
            display: block;
            text-align: left;
            margin-bottom: 5px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-save {
            background-color: #007bff;
            color: white;
        }

        .btn-save:hover {
            background-color: #0056b3;
        }

        .btn-cancel {
            background-color: #f44336;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">TS</div>
        <div class="menu">
            <a href="">Dashboard</a>
            <a href="">Siswa</a>
            <a href="">Tabungan</a>
                <button type="" name="">Logout</button>
        </div>
    </div>

    <div class="container">
        <h2>Edit Data Siswa</h2>
        <form method="POST">
            <label>Nama:</label>
            <input type="text" name="nama" value="<?php echo $row['nama']; ?>" required>

            <label>Jurusan:</label>
            <select name="jurusan" required>
                <option value="RPL" <?php echo ($row['jurusan'] == 'RPL') ? 'selected' : ''; ?>>RPL</option>
                <option value="TKJ" <?php echo ($row['jurusan'] == 'TKJ') ? 'selected' : ''; ?>>TKJ</option>
                <option value="DKV" <?php echo ($row['jurusan'] == 'DKV') ? 'selected' : ''; ?>>DKV</option>
            </select>

            <label>Kelas:</label>
            <select name="kelas" required>
                <option value="X" <?php echo ($row['kelas'] == 'X') ? 'selected' : ''; ?>>X</option>
                <option value="XI" <?php echo ($row['kelas'] == 'XI') ? 'selected' : ''; ?>>XI</option>
                <option value="XII" <?php echo ($row['kelas'] == 'XII') ? 'selected' : ''; ?>>XII</option>
            </select>

            <div class="buttons">
                <button type="button" class="btn-cancel" onclick="window.history.back()">Batal</button>
                <button type="submit" class="btn-save">Simpan Perubahan</button>
            </div>
        </form>
    </div>

</body>
</html>
