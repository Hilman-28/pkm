<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Ujian Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc;
        }
        .card {
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Selamat Datang, <?= $_SESSION['username']; ?>!</h2>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <h4>Siap Mulai Ujian?</h4>
                    <p>Waktu akan mulai dihitung setelah klik tombol di bawah.</p>
                    <a href="quiz.php" class="btn btn-success">Mulai Ujian</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
