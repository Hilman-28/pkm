<?php
session_start();
include "config/db.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM soal ORDER BY RAND() LIMIT 5";
$result = mysqli_query($conn, $sql);
$pertanyaan = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Quiz - Ujian Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #eef1f7;
        }
        .quiz-container {
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        #timer {
            font-size: 1.5rem;
            color: #ff4d4f;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="quiz-container">
            <h3 class="text-center mb-4">Ujian Online</h3>
            <div class="d-flex justify-content-between mb-3">
                <p><strong>Peserta:</strong> <?= $_SESSION['username']; ?></p>
                <div id="timer">00:00</div>
            </div>
            <!-- quiz.php -->
            <form action="submit_quiz.php" method="POST">
                <?php foreach ($pertanyaan as $index => $q): ?>
                    <div class="mb-3">
                        <h5><?= ($index + 1) . ". " . $q['pertanyaan']; ?></h5>

                        <!-- INI YANG PENTING, pastikan pakai 'question_ids[]' -->
                        <input type="hidden" name="question_ids[]" value="<?= $q['id']; ?>">

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[<?= $q['id']; ?>]" value="A" required>
                            <label class="form-check-label"><?= $q['pilihan_a']; ?></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[<?= $q['id']; ?>]" value="B">
                            <label class="form-check-label"><?= $q['pilihan_b']; ?></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[<?= $q['id']; ?>]" value="C">
                            <label class="form-check-label"><?= $q['pilihan_c']; ?></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[<?= $q['id']; ?>]" value="D">
                            <label class="form-check-label"><?= $q['pilihan_d']; ?></label>
                        </div>
                    </div>
                <?php endforeach; ?>

                <button type="submit" class="btn btn-primary w-100">Selesai & Kirim Jawaban</button>
            </form>
        </div>
    </div>

    <script>
        let seconds = 0;
        let minutes = 0;
        const timerElement = document.getElementById('timer');

        const timer = setInterval(() => {
            seconds++;
            if (seconds === 60) {
                minutes++;
                seconds = 0;
            }

            let displayMinutes = minutes < 10 ? '0' + minutes : minutes;
            let displaySeconds = seconds < 10 ? '0' + seconds : seconds;

            timerElement.textContent = `${displayMinutes}:${displaySeconds}`;
        }, 1000);
    </script>
</body>
</html>
