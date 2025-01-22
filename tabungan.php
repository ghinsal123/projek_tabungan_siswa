<?php
include "service/database.php";

// Ambil data tabungan dari database
$sql = "SELECT tabungan.id_tabungan, siswa.id_siswa, siswa.nama, tabungan.tanggal, tabungan.saldo 
        FROM tabungan 
        JOIN siswa ON tabungan.id_siswa = siswa.id_siswa
        ORDER BY tabungan.tanggal DESC";

$result = $db->query($sql);
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
        .btn-setor {
            background-color: #007bff;
            color: white;
        }
        .btn-setor:hover {
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
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">TS</div>
        <div class="menu">
            <a href="dashboard.php">Dashboard</a>
            <a href="siswa.php">Siswa</a>
            <a href="tabungan.php">Tabungan</a>
            <form action="dashboard.php" method="POST">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <h3>Tabungan Siswa</h3>
        <div class="buttons">
            <a href="setoran.php"><button class="btn-setor">Setoran</button></a>
            <a href="penarikan.php"><button class="btn-tarik">Penarikan</button></a>
        </div>
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
                    echo "<td><a href='edit_tabungan.php?id_tabungan={$row['id_tabungan']}'><button class='btn-edit'>Edit</button></a> 
                        <form method='POST' action='hapus_tabungan.php' style='display:inline;'>
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
    </div>
</body>
</html>
