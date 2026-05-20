<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard_user.php");
    exit;
}

// LOGIKA SEARCH
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tambahan Google Fonts untuk tipografi yang lebih elegan -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- TOPBAR -->
    <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white px-6 py-4 flex justify-between items-center shadow-md border-b border-slate-700 sticky top-0 z-50">
        <div class="font-bold tracking-wider uppercase text-xs sm:text-sm flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            Dashboard Admin Alumni
        </div>
        <a href="logout.php" class="text-xs font-semibold uppercase border border-slate-500 rounded-lg px-4 py-2 hover:bg-white hover:text-slate-900 hover:border-white transition-all duration-350 shadow-sm">Logout</a>
    </div>

    <div class="flex min-h-screen">
        
        <!-- SIDEBAR -->
        <div class="w-60 bg-white border-r border-slate-200 p-6 hidden md:block shadow-sm">
            <ul class="space-y-2 text-sm">
                <li>
                    <a href="dashboard_admin.php" class="flex items-center gap-2 font-semibold text-indigo-600 bg-indigo-50/70 rounded-xl px-4 py-3 border-l-4 border-indigo-600 transition-all">
                        <span>Data Alumni</span>
                    </a>
                </li>
            </ul>
            
            <div class="mt-10 bg-slate-50 border border-slate-100 rounded-2xl p-4 shadow-inner">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Ringkasan</div>
                <div class="text-xs text-slate-500 font-medium">Total Alumni:</div>
                <div class="text-3xl font-extrabold text-slate-900 mt-1"><?= $total ?></div>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="flex-1 p-6 md:p-10 max-w-7xl mx-auto w-full">
            
            <!-- HEADER SECTION -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Daftar Data Alumni</h1>
                    <p class="text-xs text-slate-500 mt-1">Kelola dan pantau informasi seluruh alumni</p>
                </div>
                
                <div class="flex gap-2 w-full sm:w-auto">
                    <a href="dashboard_admin.php" class="flex-1 sm:flex-none text-center bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 px-5 py-2.5 text-xs font-bold rounded-xl transition shadow-sm">
                        RESET
                    </a>
                    <a href="tambah.php" class="flex-1 sm:flex-none text-center bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 text-xs font-bold rounded-xl shadow-md shadow-indigo-100 hover:shadow-none transition-all">
                        TAMBAH DATA
                    </a>
                </div>
            </div>

            <!-- TABLE CARD CONTAINER -->
            <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden">
                
                <!-- SEARCH BAR -->
                <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                    <form method="GET" class="flex gap-2">
                        <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>" 
                            placeholder="Cari nama, jurusan, atau angkatan..." 
                            class="flex-1 border border-slate-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 rounded-xl transition shadow-sm placeholder:text-slate-400">
                        <button type="submit" name="search" class="bg-slate-900 text-white px-6 py-2.5 text-xs font-bold hover:bg-slate-800 rounded-xl transition shadow-sm tracking-wide">
                            CARI
                        </button>
                    </form>
                </div>

                <!-- TABLE ELEMENT -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase text-[11px] font-bold tracking-wider">
                            <tr>
                                <th class="p-4 text-center w-16 text-slate-400">No</th>
                                <th class="p-4">Nama Lengkap</th>
                                <th class="p-4 text-center">Angkatan</th>
                                <th class="p-4">Jurusan</th>
                                <th class="p-4 text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php 
                            $no = 1;
                            if($total > 0):
                                while ($d = mysqli_fetch_array($data)): 
                            ?>
                            <tr class="hover:bg-slate-50/80 transition-colors duration-150">
                                <td class="p-4 text-center text-slate-400 font-mono text-xs"><?= $no++ ?></td>
                                <td class="p-4 font-semibold text-slate-800"><?= htmlspecialchars($d['nama']) ?></td>
                                <td class="p-4 text-center text-slate-600">
                                    <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md text-xs font-medium border border-slate-200/50">
                                        <?= htmlspecialchars($d['angkatan']) ?>
                                    </span>
                                </td>
                                <td class="p-4 text-slate-600 font-medium"><?= htmlspecialchars($d['jurusan']) ?></td>
                                <td class="p-4">
                                    <div class="flex justify-center gap-3 text-xs font-bold tracking-wide">
                                        <a href="edit.php?id=<?= $d['id_alumni'] ?>" class="text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">Edit</a>
                                        <a href="delete.php?id=<?= $d['id_alumni'] ?>" onclick="return confirm('Hapus data?')" class="text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg transition">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; else: ?>
                            <tr>
                                <td colspan="5" class="p-12 text-center text-slate-400 text-xs italic uppercase tracking-widest bg-slate-50/30">
                                    Data Tidak Ditemukan
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- FOOTER -->
            <p class="text-center text-xs text-slate-400 mt-8 font-medium">
                © 2026 Juan Raffa Davidenco, All rights reserved
            </p>

        </div>
    </div>

</body>
</html>