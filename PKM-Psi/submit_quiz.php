<?php
session_start();
include "config/db.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Waktu selesai
$start_time = $_SESSION['start_time'] ?? time();
$end_time = time();
$time_taken = $end_time - $start_time;

// Ambil data dari POST
$question_ids = $_POST['question_ids'] ?? [];  // FIX ERROR LINE INI
$answers = $_POST['answers'] ?? [];

$correct = 0;
$total_questions = count($question_ids);  // PASTIKAN TOTALNYA ADA

foreach ($question_ids as $qid) {
    // Ambil jawaban user
    $user_answer = $answers[$qid] ?? '';

    // Ambil jawaban benar dari database
    $sql = "SELECT jawaban FROM soal WHERE id = $qid";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row && strtoupper($user_answer) == strtoupper($row['jawaban'])) {
        $correct++;
    }

    // Simpan ke table jawaban_user (opsional)
    $insert_query = "INSERT INTO jawaban_user (username, soal_id, jawaban_user, waktu_kerja) 
                    VALUES ('$username', '$qid', '$user_answer', '$time_taken')";
    mysqli_query($conn, $insert_query);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Ujian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f7f9fc; }
        .result-container {
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <div class="result-container">
            <h3>Selamat <?= htmlspecialchars($username); ?>!</h3>
            <p>Jawaban benar: <?= $correct; ?> dari <?= $total_questions; ?> soal</p>
            <p>Waktu pengerjaan: <?= $time_taken; ?> detik</p>
            <a href="index.php" class="btn btn-primary">Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
