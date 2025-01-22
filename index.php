<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabungan Siswa | SMKN 1 Kota Bekasi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* Body */
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
            background: linear-gradient(135deg,rgb(113, 187, 140),rgb(40, 162, 44)); /* Green gradient background */
            color: white;
        }

        /* Container */
        .home {
            max-width: 600px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            font-weight: 300;
        }

        /* Tombol Masuk */
        .btn-masuk {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            background: #007BFF; /* Blue color for button */
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s ease-in-out;
        }

        .btn-masuk:hover {
            background: #0056b3; /* Darker blue on hover */
        }

        /* Footer */
        footer {
            position: absolute;
            bottom: 20px;
            font-size: 14px;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.7);
        }
    </style>
</head>
<body>

    <div class="home">
        <h1>Tabungan Siswa/i <br> SMKN 1 KOTA BEKASI</h1>
        <p>Web pencatatan tabungan siswa/i yang modern & mudah digunakan.</p>
        <a href="login.php" class="btn-masuk">Masuk</a>
    </div>

    <footer>
        &copy; 2025 SMKN 1 Kota Bekasi | All Rights Reserved
    </footer>

</body>
</html>
