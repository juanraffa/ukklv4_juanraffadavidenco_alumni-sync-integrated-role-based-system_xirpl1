<?php
include 'koneksi.php';

$success = '';
$error = '';

if (isset($_POST['register'])) {
    $nama      = mysqli_real_escape_string($koneksi, trim($_POST['nama']));
    $angkatan  = mysqli_real_escape_string($koneksi, trim($_POST['angkatan']));
    $jurusan   = mysqli_real_escape_string($koneksi, trim($_POST['jurusan']));
    $username  = mysqli_real_escape_string($koneksi, trim($_POST['username']));
    $password  = trim($_POST['password']);

    if ($nama == '' || $angkatan == '' || $jurusan == '' || $username == '' || $password == '') {
        $error = "Semua field wajib diisi!";
    } else {

        // cek username
        $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Username sudah digunakan!";
        } else {

            // simpan ke USERS
            mysqli_query($koneksi, "INSERT INTO users (username, password, role)
            VALUES ('$username', '$password', 'user')");

            // simpan ke ALUMNI
            mysqli_query($koneksi, "INSERT INTO alumni (nama, angkatan, jurusan)
            VALUES ('$nama', '$angkatan', '$jurusan')");

            $success = "Registrasi berhasil! Silakan login.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register Alumni</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-red-900 via-red-700 to-gray-800">

<div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md">

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
        Register Alumni
    </h2>

    <?php if ($error): ?>
        <div class="bg-red-100 text-red-600 p-3 rounded-lg mb-4 text-sm">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="bg-green-100 text-green-600 p-3 rounded-lg mb-4 text-sm">
            <?= $success ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">

        <!-- Nama -->
        <div>
            <label class="text-sm text-gray-600">Nama Lengkap</label>
            <input type="text" name="nama"
                class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none"
                placeholder="Masukkan nama lengkap">
        </div>

        <!-- Tahun Lulus -->
        <div>
            <label class="text-sm text-gray-600">Tahun Lulus</label>
            <input type="text" name="angkatan"
                class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none"
                placeholder="Contoh: 2027">
        </div>

        <!-- Jurusan -->
        <div>
            <label class="text-sm text-gray-600">Jurusan</label>
            <select name="jurusan"
                class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none bg-white">

                <option value="">Pilih Jurusan</option>
                <option value="ANM">ANM (Animasi)</option>
                <option value="TJAT">TJAT (Teknik Jaringan Akses Telekomunikasi)</option>
                <option value="TKJ">TKJ (Teknik Komputer & Jaringan)</option>
                <option value="RPL">RPL (Rekayasa Perangkat Lunak)</option>

            </select>
        </div>

        <!-- Username -->
        <div>
            <label class="text-sm text-gray-600">Username</label>
            <input type="text" name="username"
                class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none"
                placeholder="Masukkan username">
        </div>

        <!-- Password -->
        <div>
            <label class="text-sm text-gray-600">Password</label>
            <input type="password" name="password"
                class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none"
                placeholder="Masukkan password">
        </div>

        <button type="submit" name="register"
            class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition">
            Daftar
        </button>
    </form>

    <p class="text-sm text-center mt-4">
        Sudah punya akun?
        <a href="login.php" class="text-red-600 font-semibold hover:underline">
            Login
        </a>
    </p>

    <p class="text-center text-xs text-gray-300 mt-6">
        © 2026 Juan Raffa Davidenco, All rights reserved
    </p>

</div>

</body>
</html>