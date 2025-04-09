<?php
session_start(); // WAJIB ada sebelum pakai $_SESSION
include "../service/database.php";

// Cek role: hanya admin yang bisa akses
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== 'admin') {
    echo "<script>alert('Kamu tidak punya akses ke fitur ini!'); window.location='index.php';</script>";
    exit();
}

if (isset($_GET['id_tabungan'])) {
    $id_tabungan = $_GET['id_tabungan'];

    $sql = "SELECT t.saldo, s.nama, s.kelas, s.jurusan 
            FROM tabungan t
            JOIN siswa s ON t.id_siswa = s.id_siswa
            WHERE t.id_tabungan = '$id_tabungan'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $dataTabungan = $result->fetch_assoc();
        $nama = $dataTabungan['nama'];
        $kelas = $dataTabungan['kelas'];
        $jurusan = $dataTabungan['jurusan'];
        $saldo = $dataTabungan['saldo'];
    } else {
        echo "<script>alert('Data tabungan tidak ditemukan!'); window.location='index.php';</script>";
        exit;
    }

    $sqlRiwayat = "SELECT tanggal, jenis, jumlah FROM detail_tabungan
                   WHERE id_tabungan = '$id_tabungan' ORDER BY tanggal DESC";
    $riwayat = $db->query($sqlRiwayat);
} else {
    echo "<script>alert('ID tabungan tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Tabungan</title>
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
            max-width: 800px;
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
        .info {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .info p {
            margin-bottom: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .btn-back {
            margin-top: 20px;
            background-color: #f39c12;
            padding: 10px 20px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease;
        }
        .btn-back:hover {
            background-color: #e67e22;
        }
        .btn-print {
            margin-top: 10px;
            background-color: #3498db;
            padding: 10px 20px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease;
        }
        .btn-print:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="logo">TS</div>
        <div class="menu">
            <a href="../dashboard.php">Dashboard</a>
            <a href="../siswa/index.php">Siswa</a>
            <a href="../tabungan/index.php">Tabungan</a>
            <form action="" method="POST" style="display:inline;">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <h3>Detail Tabungan</h3>
        <div class="info">
            <p><strong>Nama Siswa:</strong> <?= $nama ?></p>
            <p><strong>Kelas:</strong> <?= $kelas ?></p>
            <p><strong>Jurusan:</strong> <?= $jurusan ?></p>
            <p><strong>Saldo Saat Ini:</strong> Rp <?= number_format($saldo, 0, ',', '.') ?></p>
        </div>

        <h3>Riwayat Transaksi</h3>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($riwayat->num_rows > 0) {
                    while ($row = $riwayat->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . date("d M Y - H:i", strtotime($row['tanggal'])) . "</td>";
                        echo "<td>" . ucfirst($row['jenis']) . "</td>";
                        echo "<td>Rp " . number_format($row['jumlah'], 0, ',', '.') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Belum ada transaksi.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="index.php" class="btn-back">← Kembali</a>
        <a href="cetak_riwayat.php?id_tabungan=<?= $id_tabungan ?>" target="_blank" class="btn-print">🖨️ Cetak PDF</a>
    </div>
</body>
</html>
