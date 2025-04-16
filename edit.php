<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM tasks WHERE id='$id' AND user_id='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header("Location: index.php");
    exit();
}

$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $prioritas = $_POST['prioritas'];
    $tanggal = $_POST['tanggal'];

    if (!empty($nama) && !empty($prioritas) && !empty($tanggal)) {
        $sql = "UPDATE tasks SET nama='$nama', prioritas='$prioritas', tanggal='$tanggal' WHERE id='$id' AND user_id='$user_id'";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Semua field harus diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Tugas</title>
    <link rel="stylesheet" href="editstyle.css">
</head>
<body>
<div class="container">
    <h2>Edit Tugas</h2>
    <form method="POST">
        <label for="nama">Nama Tugas</label>
        <input type="text" name="nama" id="nama" value="<?= $row['nama']; ?>" required>

        <label for="prioritas">Pilih Prioritas</label>
        <select name="prioritas" id="prioritas">
            <option value="Tinggi" <?= ($row['prioritas'] == 'Tinggi') ? 'selected' : ''; ?>>Tinggi</option>
            <option value="Sedang" <?= ($row['prioritas'] == 'Sedang') ? 'selected' : ''; ?>>Sedang</option>
            <option value="Rendah" <?= ($row['prioritas'] == 'Rendah') ? 'selected' : ''; ?>>Rendah</option>
        </select>

        <label for="tanggal">Tanggal Deadline</label>
        <input type="date" name="tanggal" id="tanggal" value="<?= $row['tanggal']; ?>" required>

        <button type="submit" name="update">Simpan Perubahan</button>
    </form>
    <a href="index.php" class="cancel-link">Batal</a>
</div>
</body>
</html>
