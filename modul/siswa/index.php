<?php
include "../service/database.php"; // Hubungkan dengan database

// Ambil data siswa dari database
$sql = "SELECT * FROM siswa";
$result = $db->query($sql);

// Ambil data siswa dari database
$where = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $keyword = $db->real_escape_string($_GET['search']);
    $where = "WHERE nama LIKE '%$keyword%'";
}
$sql = "SELECT * FROM siswa $where";
$result = $db->query($sql);

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

        /* Table Section */
        .table-container {
            margin: 30px auto;
            max-width: 1000px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .table-container h3 {
            font-size: 26px;
            margin-bottom: 20px;
            color: #333;
            font-weight: 600;
        }

        .table-container .search-add {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .table-container input[type="text"] {
            width: 300px;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .table-container button {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .table-container button:hover {
            background-color: #0056b3;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .menu a {
                margin-right: 15px;
                font-size: 16px;
            }

            .table-container input[type="text"] {
                width: 100%;
            }

            table th, table td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">TS</div>
        <div class="menu">
            <a href="../dashboard.php">Dashboard</a>
            <a href="index.php">Siswa</a>
            <a href="../tabungan/index.php">Tabungan</a>
            <form action="../dashboard.php" method="POST">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>
    </div>

    <div class="table-container">
        <h3>Data Siswa</h3>

        <div class="search-add">
            <div>
                <input type="text" id="search" placeholder="Cari nama siswa">
                <div id="hasil-pencarian"></div>
            </div>
            <a href="tambah_data_siswa.php"><button type="button">Tambah Data</button></a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$no++."</td>
                                <td>".$row['nama']."</td>
                                <td>".$row['jurusan']."</td>
                                <td>".$row['kelas']."</td>
                                <td>
                                    <a href='edit_data_siswa.php?id=".$row['id_siswa']."'><button>Edit</button></a>
                                    <a href='hapus_data_siswa.php?id=".$row['id_siswa']."' onclick='return confirm(\"Yakin ingin menghapus?\")'>
                                        <button style='background-color: red; color: white;'>Hapus</button>
                                    </a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align: center;'>Belum ada data siswa.</td></tr>";
                }
                $db->close();
                ?>
            </tbody>
        </table>
    </div>
    <script>
        document.getElementById('search').addEventListener('keyup', function() {
            let keyword = this.value;

            fetch(`?search=${encodeURIComponent(keyword)}`)
                .then(response => response.text())
                .then(html => {
                    // Ambil hanya tbody isi tabel dari respon
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const tbody = doc.querySelector('tbody').innerHTML;
                    document.querySelector('tbody').innerHTML = tbody;
                });
        });
    </script>
</body>
</html>
