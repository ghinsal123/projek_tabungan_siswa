<?php
include "service/database.php";

// Cek apakah ada ID tabungan yang dikirim melalui URL
if (isset($_GET['id_tabungan'])) {
    $id_tabungan = $_GET['id_tabungan'];
    
    // Ambil data tabungan berdasarkan ID
    $sql = "SELECT * FROM tabungan WHERE id_tabungan = '$id_tabungan'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $saldo = $row['saldo'];
    } else {
        echo "<script>alert('Tabungan tidak ditemukan!'); window.location='tabungan.php';</script>";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_saldo = $_POST['saldo'];

    // Update saldo tabungan
    $updateSql = "UPDATE tabungan SET saldo = '$new_saldo' WHERE id_tabungan = '$id_tabungan'";
    if ($db->query($updateSql) === TRUE) {
        echo "<script>alert('Saldo berhasil diperbarui!'); window.location='tabungan.php';</script>";
    } else {
        echo "Error: " . $db->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tabungan</title>
    <style>
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
            margin: 30px auto;
            max-width: 600px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        .container h3 {
            font-size: 26px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        form label {
            font-size: 16px;
            margin-bottom: 5px;
        }
        form input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        form button {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            transition: background 0.3s ease;
        }
        form button:hover {
            background-color: #0056b3;
        }
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-start;
        }
        .back-btn, .save-btn {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .back-btn {
            background-color: #f39c12;
            color: white;
        }
        .back-btn:hover {
            background-color: #e67e22;
        }
        .save-btn {
            background-color: #28a745;
            color: white;
        }
        .save-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="logo">TS</div>
        <div class="menu">
            <a href="">Dashboard</a>
            <a href="">Siswa</a>
            <a href="">Tabungan</a>
            <form action="" method="POST">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <h3>Edit Saldo Tabungan</h3>
        <form method="POST">
            <label for="saldo">Saldo Baru:</label>
            <input type="number" name="saldo" value="<?php echo $saldo; ?>" required>
            <div class="action-buttons">
                <a href="tabungan.php"><button type="button" class="back-btn">Kembali</button></a>
                <button type="submit" class="save-btn">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</body>
</html>


