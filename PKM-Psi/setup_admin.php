<?php
include "config/db.php";

$username = "saya"; // Ganti sesuai kebutuhan
$password = password_hash("saya123", PASSWORD_DEFAULT); // Ganti sesuai kebutuhan

$sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

if (mysqli_query($conn, $sql)) {
    echo "Admin berhasil ditambahkan.";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
