<?php
include "../service/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_tabungan = trim($_POST['id_tabungan']);
    $id_siswa = trim($_POST['id_siswa']);
    $jumlah = (int)$_POST['jumlah'];

    if (empty($id_tabungan) || empty($id_siswa) || $jumlah <= 0) {
        echo "<script>alert('Data tidak valid!'); window.history.back();</script>";
        exit;
    }

    $stmt = $db->prepare("CALL SetoranAwal(?, ?, ?)");
    $stmt->bind_param("ssi", $id_tabungan, $id_siswa, $jumlah);

    if ($stmt->execute()) {
        echo "<script>alert('Setoran awal berhasil!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal melakukan setoran awal!'); window.history.back();</script>";
    }

    $stmt->close();
    $db->close();
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
            <label for="id_siswa">Id Siswa:</label>
            <select name="id_siswa" id="id_siswa" required onchange="isiDataSiswa()">
                <option value="">-- id siswa --</option>
                <?php
                // Ambil data siswa
                $sql = "SELECT * FROM siswa";
                $result = $db->query($sql);
                $siswaData = [];
                while ($row = $result->fetch_assoc()) {
                    $siswaData[$row['id_siswa']] = [
                        'nama' => $row['nama'],
                        'kelas' => $row['kelas']
                    ];
                    echo "<option value='" . $row['id_siswa'] . "'>" . $row['id_siswa'] . "</option>";
                }
                ?>
            </select>

            <label for="nama">Nama Siswa:</label>
            <input type="text" id="nama" name="nama" readonly>

            <label for="kelas">Kelas:</label>
            <input type="text" id="kelas" name="kelas" readonly>

            <label for="tanggal">Tanggal:</label>
            <input type="text" id="tanggal" name="tanggal" readonly value="<?php echo date('Y-m-d'); ?>">

            <label for="saldo">Setoran Awal:</label>
            <input type="number" name="saldo" min="1000" required>

            <div class="form-buttons">
                <button type="button" class="cancel-btn" onclick="window.history.back()">Batal</button>
                <button type="submit" class="save-btn">Simpan</button>
            </div>
        </form>

        <script>
            // Data siswa dari PHP ke JS
            const dataSiswa = <?php echo json_encode($siswaData); ?>;

            function isiDataSiswa() {
                const id = document.getElementById('id_siswa').value;
                if (dataSiswa[id]) {
                    document.getElementById('nama').value = dataSiswa[id].nama;
                    document.getElementById('kelas').value = dataSiswa[id].kelas;
                } else {
                    document.getElementById('nama').value = '';
                    document.getElementById('kelas').value = '';
                }
            }
        </script>
    </div>
</body>
</html>
