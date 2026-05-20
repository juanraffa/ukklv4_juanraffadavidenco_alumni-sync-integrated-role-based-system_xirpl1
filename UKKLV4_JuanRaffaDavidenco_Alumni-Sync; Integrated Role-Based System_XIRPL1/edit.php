<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: dashboard_user.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM alumni WHERE id_alumni='$id'");
$d = mysqli_fetch_assoc($data);

if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $angkatan = mysqli_real_escape_string($koneksi, $_POST['angkatan']);
    $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);

    mysqli_query($koneksi, "UPDATE alumni SET 
        nama='$nama',
        angkatan='$angkatan',
        jurusan='$jurusan'
        WHERE id_alumni='$id'
    ");

    header("Location: dashboard_admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Alumni</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-red-900 via-red-700 to-gray-800 flex items-center justify-center">

<div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl p-8">

    <!-- HEADER -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Edit Data Alumni
        </h2>
        <p class="text-sm text-gray-500">
            Perbarui informasi alumni
        </p>
    </div>

    <!-- FORM -->
    <form method="POST" class="space-y-4">

        <!-- Nama -->
        <div>
            <label class="text-sm text-gray-600">Nama Lengkap</label>
            <input type="text" name="nama"
                value="<?= htmlspecialchars($d['nama']) ?>"
                class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
        </div>

        <!-- Tahun -->
        <div>
            <label class="text-sm text-gray-600">Tahun Lulus</label>
            <input type="number" name="angkatan"
                value="<?= htmlspecialchars($d['angkatan']) ?>"
                class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none"
                placeholder="Contoh: 2023">
        </div>

        <!-- Jurusan -->
        <div>
            <label class="text-sm text-gray-600">Jurusan</label>
            <select name="jurusan"
                class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none bg-white">

                <option value="ANM" <?= ($d['jurusan'] == 'ANM') ? 'selected' : '' ?>>ANM (Animasi)</option>
                <option value="TJAT" <?= ($d['jurusan'] == 'TJAT') ? 'selected' : '' ?>>TJAT (Teknik Jaringan Akses Telekomunikai)</option>
                <option value="TKJ" <?= ($d['jurusan'] == 'TKJ') ? 'selected' : '' ?>>TKJ (Teknik Komputer & Jaringan)</option>
                <option value="RPL" <?= ($d['jurusan'] == 'RPL') ? 'selected' : '' ?>>RPL (Rekayasa Perangkat Lunak)</option>

            </select>
        </div>

        <!-- BUTTON -->
        <div class="flex justify-between items-center pt-4">

            <a href="dashboard_admin.php"
                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                Batal
            </a>

            <button type="submit" name="submit"
                class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-md">
                Update
            </button>

        </div>

    </form>

</div>

<!-- FOOTER -->
<div class="absolute bottom-3 text-center w-full text-xs text-gray-300">
    © 2026 Juan Raffa Davidenco, All rights reserved
</div>

</body>
</html>