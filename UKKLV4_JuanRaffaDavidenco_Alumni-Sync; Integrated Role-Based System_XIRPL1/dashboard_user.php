<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] != 'user') {
    header("Location: dashboard_admin.php");
    exit;
}

// SEARCH
$keyword = '';
if (isset($_GET['search'])) {
    $keyword = mysqli_real_escape_string($koneksi, $_GET['keyword']);
    $query = "SELECT * FROM alumni 
              WHERE nama LIKE '%$keyword%' 
              OR jurusan LIKE '%$keyword%' 
              OR angkatan LIKE '%$keyword%'";
} else {
    $query = "SELECT * FROM alumni";
}

$data = mysqli_query($koneksi, $query);
$total = mysqli_num_rows($data);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: linear-gradient(135deg, #7f1d1d, #b91c1c, #374151);
        }
    </style>
</head>

<body class="min-h-screen">

<!-- NAVBAR (TANPA TAMBAH DATA) -->
<div class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
    <h1 class="text-lg font-bold text-gray-800">
        Dashboard User Alumni
    </h1>

    <a href="logout.php"
        class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700 transition">
        Logout
    </a>
</div>

<!-- CONTENT -->
<div class="max-w-5xl mx-auto mt-8 px-4">

    <!-- INFO -->
    <div class="bg-white rounded-xl shadow p-4 mb-6">
        <p class="text-sm text-gray-500">Total Alumni</p>
        <h2 class="text-2xl font-bold text-red-600"><?= $total ?></h2>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow-xl p-6">

        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            Data Alumni
        </h2>

        <!-- SEARCH -->
        <form method="GET" class="flex flex-col md:flex-row gap-2 mb-4">

            <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>"
                placeholder="Cari nama / jurusan / angkatan..."
                class="flex-1 border px-4 py-2 rounded-lg focus:ring-2 focus:ring-red-500 outline-none">

            <div class="flex gap-2">
                <button type="submit" name="search"
                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm">
                    Search
                </button>

                <a href="dashboard_user.php"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 text-sm">
                    Reset
                </a>
            </div>

        </form>

        <!-- INFO SEARCH -->
        <?php if ($keyword): ?>
        <p class="text-sm text-gray-500 mb-2">
            Hasil pencarian: <span class="font-semibold"><?= htmlspecialchars($keyword) ?></span>
        </p>
        <?php endif; ?>

        <?php if ($total > 0): ?>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-center">

                <thead class="bg-red-700 text-white">
                    <tr>
                        <th class="py-3">No</th>
                        <th>Nama</th>
                        <th>Angkatan</th>
                        <th>Jurusan</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">
                    <?php
                    $no = 1;
                    while ($d = mysqli_fetch_array($data)) {
                    ?>
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-2"><?= $no++ ?></td>
                        <td><?= htmlspecialchars($d['nama']) ?></td>
                        <td><?= htmlspecialchars($d['angkatan']) ?></td>
                        <td><?= htmlspecialchars($d['jurusan']) ?></td>
                    </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>

        <?php else: ?>
        <div class="text-center py-10 text-gray-500">
            <p class="mb-3">Data tidak ditemukan</p>
            <a href="dashboard_user.php"
                class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700">
                Reset
            </a>
        </div>
        <?php endif; ?>

    </div>

    <p class="text-center text-xs text-gray-300 mt-6">
        © 2026 Juan Raffa Davidenco, All rights reserved
    </p>

</div>

</body>
</html>