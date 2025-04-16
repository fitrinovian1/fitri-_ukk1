<?php
session_start();
include 'config.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Pastikan ada ID subtugas yang dikirim
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$subtaks_id = $_GET['id'];

// Ambil status subtaks sekarang
$sql = "SELECT * FROM subtasks WHERE id='$subtaks_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Subtask tidak ditemukan!";
    exit();
}

$row = $result->fetch_assoc();
$status_lama = $row['status'];

// Toggle status
$status_baru = ($status_lama == "Selesai") ? "Belum Selesai" : "Selesai";

// Update status di database
$sql_update = "UPDATE subtasks SET status='$status_baru' WHERE id='$subtaks_id'";
if ($conn->query($sql_update) === TRUE) {
    header("Location: index.php");
    exit();
} else {
    echo "Gagal mengubah status: " . $conn->error;
}
?>
