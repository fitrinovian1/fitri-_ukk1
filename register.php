<?php 
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (strlen($password) < 8) {
        $error = "Password harus memiliki minimal 8 karakter.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql_check = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql_check);

        if ($result->num_rows > 0) {
            $error = "Username sudah digunakan. Silakan pilih username lain.";
        } else {
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
            if ($conn->query($sql)) {
                header("Location: login.php?success=Registrasi Berhasil! Silakan Login.");
                exit();
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun</title>
    <link rel="stylesheet" href="styleyss.css">
</head>
<body>
    <div class="register-wrapper">
        <div class="form-box">
            <h2>Buat Akun</h2>
            
            <?php if (isset($error)): ?>
                <div class="error-box"><?= $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="input-container">
                    <input type="text" name="username" required>
                    <label>Username</label>
                    <span></span>
                </div>
                <div class="input-container">
                    <input type="password" name="password" required minlength="8">
                    <label>Password (min. 8 karakter)</label>
                    <span></span>
                </div>
                <button class="submit-btn" type="submit">Daftar</button>
            </form>

            <p class="login-link">Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    </div>
</body>
</html>
