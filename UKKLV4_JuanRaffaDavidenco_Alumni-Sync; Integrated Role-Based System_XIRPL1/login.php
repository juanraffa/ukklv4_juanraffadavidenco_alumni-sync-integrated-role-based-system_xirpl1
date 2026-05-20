<?php
session_start();
include 'koneksi.php';

$error = '';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($query);

    if ($user) {
        if ($password === $user['password']) {

            $_SESSION['login'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header("Location: dashboard_admin.php");
            } else {
                header("Location: dashboard_user.php");
            }
            exit;

        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Alumni</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-cover bg-center" style="background-image: url('background.jpeg');">

<!-- OVERLAY -->
<div class="min-h-screen bg-black/50 backdrop-blur-sm flex flex-col items-center justify-center px-4 py-8">

    <!-- CARD -->
    <div class="bg-white/90 backdrop-blur-md p-8 rounded-2xl shadow-2xl w-full max-w-md text-center border border-white/30">

        <!-- LOGO -->
        <div class="flex justify-center mb-4">
            <img src="logotelkom.png" alt="Logo" class="w-20 h-20 object-contain">
        </div>

        <!-- TITLE -->
        <h2 class="text-xl font-bold text-gray-800">
            LOGIN MANAJEMEN DATA ALUMNI
        </h2>

        <p class="text-sm text-gray-600 mb-6">
            SMK Telkom Lampung
        </p>

        <!-- ERROR -->
        <?php if ($error): ?>
            <div class="bg-red-100 text-red-600 p-3 rounded-lg mb-4 text-sm">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <!-- FORM -->
        <form method="POST" class="space-y-4 text-left">

            <input type="text" name="username" placeholder="Username"
                class="w-full border border-gray-300 bg-white/80 px-4 py-2 rounded-lg 
                focus:ring-2 focus:ring-red-400 focus:border-red-400 outline-none transition" required>

            <input type="password" name="password" placeholder="Password"
                class="w-full border border-gray-300 bg-white/80 px-4 py-2 rounded-lg 
                focus:ring-2 focus:ring-red-400 focus:border-red-400 outline-none transition" required>

            <button type="submit" name="login"
                class="w-full bg-red-500 text-white py-2 rounded-lg 
                hover:bg-red-600 transition duration-300 shadow-md">
                Login
            </button>
        </form>

        <!-- REGISTER -->
        <p class="text-sm text-center mt-4">
            Belum punya akun?
            <a href="register.php" class="text-red-500 font-semibold hover:underline">
                Daftar
            </a>
        </p>

    </div>

    <!-- FOOTER -->
    <p class="text-center text-xs text-white/70 mt-6">
        © 2026 Juan Raffa Davidenco, All rights reserved
    </p>

</div>

</body>
</html>