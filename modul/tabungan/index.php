<?php
include "../service/database.php";

// Ambil data tabungan dari database
$sql = "SELECT tabungan.id_tabungan, siswa.id_siswa, siswa.nama, tabungan.tanggal, tabungan.saldo 
        FROM tabungan 
        JOIN siswa ON tabungan.id_siswa = siswa.id_siswa
        ORDER BY tabungan.tanggal DESC";

$result = $db->query($sql);

// Agregat saldo
$agregat = '';
$label = '';
$hasil_agregat = null;

if (isset($_GET['agregat']) && !empty($_GET['agregat'])) {
    $filter = $_GET['agregat'];

    switch ($filter) {
        case 'max':
            $agregat = "SELECT MAX(saldo) AS hasil FROM tabungan";
            $label = "Saldo Tertinggi";
            break;
        case 'min':
            $agregat = "SELECT MIN(saldo) AS hasil FROM tabungan";
            $label = "Saldo Terendah";
            break;
        case 'avg':
            $agregat = "SELECT AVG(saldo) AS hasil FROM tabungan";
            $label = "Rata-rata Saldo";
            break;
        case 'sum':
            $agregat = "SELECT SUM(saldo) AS hasil FROM tabungan";
            $label = "Total Saldo";
            break;
    }

    if ($agregat !== '') {
        $res = $db->query($agregat);
        $row = $res->fetch_assoc();
        $hasil_agregat = number_format($row['hasil'], 0, ',', '.');
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabungan Siswa</title>
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
            max-width: 1000px;
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
        .buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .buttons button {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .btn-setorawal {
            background-color:rgb(19, 194, 77);
            color: white;
        }
        .btn-setorawal:hover {
            background-color:rgb(0, 179, 48);
        }
        .btn-tambahsetor {
            background-color: #007bff;
            color: white;
        }
        .btn-tambahsetor:hover {
            background-color: #0056b3;
        }
        .btn-tarik {
            background-color: #f39c12;
            color: white;
        }
        .btn-tarik:hover {
            background-color: #e67e22;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }
        table th {
            background-color: #007bff;
            color: white;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .btn-edit {
            background-color: #ffc107;
            color: black;
            padding: 5px 10px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .btn-edit:hover {
            background-color: #e0a800;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .btn-delete:hover {
            background-color: #c82333;
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
        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .cek-saldo-box {
            background-color: #f9f9f9;
            padding: 12px 16px;
            border-left: 5px solid #2e7d32;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-width: 300px;
            min-width: 240px;
        }

        .cek-saldo-form {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .cek-saldo-form label {
            font-weight: 600;
        }

        .cek-saldo-form input[type="number"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .cek-saldo-form button {
            background-color: #2e7d32;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .cek-saldo-form button:hover {
            background-color: #1b5e20;
        }

        .hasil-saldo {
            margin-top: 10px;
            font-size: 15px;
        }

        .hasil-saldo.error {
            color: red;
        }
        form#agregat-form {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            align-items: center;
            background-color: #eef4ff;
            padding: 10px 20px;
            border-left: 5px solid #007bff;
            border-radius: 6px;
            max-width: 400px;
        }

        form#agregat-form label {
            font-weight: 500;
        }

        form#agregat-form select {
            padding: 6px 10px;
            font-size: 14px;
            border-radius: 4px;
            border: 1px solid #ccc;
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
            <form action="../dashboard.php" method="POST">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <h3>Tabungan Siswa</h3>
        <div class="top-actions">
            <div class="buttons">
                <a href="setoran_awal.php"><button class="btn-setorawal">Setoran Awal</button></a>
                <a href="tambah_setoran.php"><button class="btn-tambahsetor">Tambah Setoran</button></a>
                <a href="penarikan.php"><button class="btn-tarik">Penarikan</button></a>
            </div>
        </div>
        <form method="GET" id="agregat-form">            <label for="agregat">Lihat Agregat:</label>
            <select name="agregat" id="agregat" onchange="this.form.submit()">
                <option value="">-- Pilih --</option>
                <option value="max" <?php if (isset($_GET['agregat']) && $_GET['agregat'] == 'max') echo 'selected'; ?>>Saldo Tertinggi</option>
                <option value="min" <?php if (isset($_GET['agregat']) && $_GET['agregat'] == 'min') echo 'selected'; ?>>Saldo Terendah</option>
                <option value="avg" <?php if (isset($_GET['agregat']) && $_GET['agregat'] == 'avg') echo 'selected'; ?>>Rata-rata Saldo</option>
                <option value="sum" <?php if (isset($_GET['agregat']) && $_GET['agregat'] == 'sum') echo 'selected'; ?>>Total Saldo</option>
            </select>
        </form>

        <?php if ($hasil_agregat !== null): ?>
            <p><strong><?php echo $label; ?>:</strong> Rp <?php echo $hasil_agregat; ?></p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Saldo</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$no}</td>";
                        echo "<td>{$row['nama']}</td>";
                        echo "<td>" . date("d F Y", strtotime($row['tanggal'])) . "</td>";
                        echo "<td>Rp " . number_format($row['saldo'], 0, ',', '.') . "</td>";
                        echo "<td>
                        <a href='detail_riwayat.php?id_tabungan={$row['id_tabungan']}'><button class='btn-edit'>Detail</button></a> 
                            <form method='POST' action='hapus_tabungan.php' style='display:inline;' onsubmit=\"return confirm('Apakah kamu yakin ingin menghapus data ini?');\">
                                <input type='hidden' name='id_tabungan' value='{$row['id_tabungan']}'>
                                <button type='submit' class='btn-delete'>Hapus</button>
                            </form>
                        </td>";
                        echo "</tr>";
                        $no++;
                    }
                ?>
            </tbody>
        </table>
        <!-- Form Cek Saldo -->
        <div class="cek-saldo-box" style="margin-top: 30px; text-align: left;">
            <h4>Cek Saldo Tabungan</h4>
            <form action="" method="GET" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <label for="cek_saldo">ID Tabungan:</label>
                <input type="number" name="cek_saldo" id="cek_saldo" required style="padding: 5px 10px; border: 1px solid #ccc; border-radius: 4px;">
                <button type="submit" class="btn-saldo">Cek</button>
            </form>
            <?php
            if (isset($_GET['cek_saldo'])) {
                $id_tab = (int) $_GET['cek_saldo'];
                $query = "SELECT GetSaldoTabungan($id_tab) AS saldo";
                $res = $db->query($query);
                if ($res && $res->num_rows > 0) {
                    $row = $res->fetch_assoc();
                    echo "<p style='margin-top:10px;'><strong>Saldo:</strong> Rp " . number_format($row['saldo'], 0, ',', '.') . "</p>";
                } else {
                    echo "<p style='margin-top:10px; color:red;'>ID tabungan tidak ditemukan.</p>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
