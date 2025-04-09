<?php
session_start(); // WAJIB ada sebelum pakai $_SESSION
include "../service/database.php";

// Cek role: hanya admin yang bisa akses
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== 'admin') {
    echo "<script>alert('Kamu tidak punya akses ke fitur ini!'); window.location='index.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_tabungan = isset($_POST['id_tabungan']) ? trim($_POST['id_tabungan']) : '';
    $jumlah_setoran = isset($_POST['jumlah_setoran']) ? trim($_POST['jumlah_setoran']) : '';

    if (empty($id_tabungan)) {
        echo "<script>alert('Harap pilih ID tabungan!'); window.history.back();</script>";
        exit;
    }

    if (empty($jumlah_setoran) || !is_numeric($jumlah_setoran) || $jumlah_setoran <= 0) {
        echo "<script>alert('Masukkan jumlah setoran yang valid!'); window.history.back();</script>";
        exit;
    }

    $id_tabungan = (int)$id_tabungan;
    $jumlah_setoran = (int)$jumlah_setoran;

    // GUNAKAN PREPARED STATEMENT
    $call = "CALL ProsesSetoran('$id_tabungan', $jumlah_setoran)";
    if ($db->query($call) === TRUE) {
        echo "<script>alert('Setoran berhasil!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . $db->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Setoran</title>
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
        <h2>Tambah Setoran</h2>
        <form method="POST">
            <label for="id_tabungan">Pilih ID Tabungan:</label>
            <select name="id_tabungan" id="id_tabungan" required onchange="isiData()">
                <option value="">-- Pilih ID Tabungan --</option>
                <?php
                $sql = "SELECT t.id_tabungan, t.id_siswa, s.nama, s.kelas, t.saldo 
                        FROM tabungan t 
                        JOIN siswa s ON t.id_siswa = s.id_siswa";
                $result = $db->query($sql);
                $tabunganData = [];
                while ($row = $result->fetch_assoc()) {
                    $tabunganData[$row['id_tabungan']] = [
                        'id_siswa' => $row['id_siswa'],
                        'nama' => $row['nama'],
                        'kelas' => $row['kelas'],
                        'saldo' => $row['saldo']
                    ];
                    echo "<option value='" . $row['id_tabungan'] . "'>" . $row['id_tabungan'] . "</option>";
                }
                ?>
            </select>

            <label for="id_siswa">ID Siswa:</label>
            <input type="text" id="id_siswa" readonly>

            <label for="nama">Nama Siswa:</label>
            <input type="text" id="nama" readonly>

            <label for="kelas">Kelas:</label>
            <input type="text" id="kelas" readonly>

            <label for="tanggal">Tanggal:</label>
            <input type="text" readonly value="<?php echo date('Y-m-d'); ?>">

            <label for="saldo">Saldo Anda:</label>
            <input type="text" id="saldo" readonly>

            <label for="jumlah_setoran">Jumlah Setoran:</label>
            <input type="number" name="jumlah_setoran" id="jumlah_setoran" min="1000" required>

            <div class="form-buttons">
                <button type="button" class="cancel-btn" onclick="window.history.back()">Batal</button>
                <button type="submit" class="save-btn">Simpan</button>
            </div>
        </form>

        <script>
            const tabunganData = <?php echo json_encode($tabunganData); ?>;

            function isiData() {
                const id = document.getElementById('id_tabungan').value;
                if (tabunganData[id]) {
                    document.getElementById('id_siswa').value = tabunganData[id].id_siswa;
                    document.getElementById('nama').value = tabunganData[id].nama;
                    document.getElementById('kelas').value = tabunganData[id].kelas;
                    document.getElementById('saldo').value = tabunganData[id].saldo;
                } else {
                    document.getElementById('id_siswa').value = '';
                    document.getElementById('nama').value = '';
                    document.getElementById('kelas').value = '';
                    document.getElementById('saldo').value = '';
                }
            }
        </script>
    </div>
</body>
</html>
