<?php
    session_start();
    include "service/database.php"; // Assuming this file contains your database connection

    if(isset($_POST['logout'])){
        session_unset();
        session_destroy();
        header('location: ../index.php');
    }

    // Fetch the number of students from the 'siswa' table
    $sqlSiswa = "SELECT COUNT(*) AS jumlah_siswa FROM siswa";
    $resultSiswa = $db->query($sqlSiswa);
    $jumlahSiswa = 0;
    if ($resultSiswa->num_rows > 0) {
        $rowSiswa = $resultSiswa->fetch_assoc();
        $jumlahSiswa = $rowSiswa['jumlah_siswa'];
    }

    // Fetch the total saldo from the 'tabungan' table
    $sqlSaldo = "SELECT SUM(saldo) AS total_saldo FROM tabungan";
    $resultSaldo = $db->query($sqlSaldo);
    $totalSaldo = 0;
    if ($resultSaldo->num_rows > 0) {
        $rowSaldo = $resultSaldo->fetch_assoc();
        $totalSaldo = $rowSaldo['total_saldo'];
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

        /* Welcome Box */
        .kotak1 {
            text-align: center;
            background-color: white;
            padding: 40px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            border-radius: 8px;
        }

        .kotak1 h3 {
            font-size: 26px;
            color: #333;
            font-weight: 600;
        }

        /* Stats Cards */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); /* Adjusted for responsiveness */
            gap: 20px;
            padding: 20px;
            max-width: 1200px; /* Limit to larger screens */
            margin: 0 auto;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.3s ease;
            cursor: pointer;
            height: 150px; /* Fixed height for uniform cards */
            border: 2px solid #f4f7fc; /* Box border */
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card .icon {
            font-size: 40px;
            color: #2e7d32;
        }

        .card .details h3 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .card .details p {
            font-size: 16px;
            color: #555;
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
        @media (max-width: 1024px) {
            .stats {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Adjust for tablets/laptops */
            }

            .card {
                height: 180px; /* Adjust height */
                padding: 15px;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .menu a {
                margin-right: 15px;
                font-size: 16px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .kotak1 {
                padding: 30px 20px;
            }

            .card {
                padding: 15px;
                height: auto; /* Adjust height for small screens */
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">TS</div>
        <div class="menu">
            <a href="dashboard.php">Dashboard</a>
            <a href="siswa/index.php">Siswa</a>
            <a href="tabungan/index.php">Tabungan</a>
            <form action="../modul/dashboard.php" method="POST">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>
    </div>

    <div class="kotak1">
        <h3>Selamat datang, <?= $_SESSION["username"]?></h3>
    </div>

    <!-- Stats Cards -->
    <div class="stats">
        <!-- First row: Jumlah Siswa & Jumlah Setoran -->
        <a href="siswa/index.php">
            <div class="card">
                <div class="icon">👥</div>
                <div class="details">
                    <h3><?= $jumlahSiswa ?></h3>
                    <p>Jumlah Siswa</p>
                </div>
            </div>
        </a>
        <a href="tabungan/index.php">
            <div class="card">
                <div class="icon">💰</div>
                <div class="details">
                    <h3>Rp <?= number_format($totalSaldo, 0, ',', '.') ?></h3>
                    <p>Jumlah Setoran</p>
                </div>
            </div>
        </a>
    </div>

    <div class="stats">
        <!-- Second row: Jumlah Penarikan & Jumlah Saldo -->
        <a href="penarikan.php">
            <div class="card">
                <div class="icon">📤</div>
                <div class="details">
                    <h3>Rp 3,000</h3>
                    <p>Jumlah Penarikan</p>
                </div>
            </div>
        </a>
        <a href="saldo.php">
            <div class="card">
                <div class="icon">📖</div>
                <div class="details">
                    <h3>Rp 5,000</h3>
                    <p>Jumlah Saldo</p>
                </div>
            </div>
        </a>
    </div>

</body>
</html>
