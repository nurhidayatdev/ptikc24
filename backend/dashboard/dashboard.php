<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION['user_id'])) {
	header("Location: ../login/login.php");
	exit;
}

$user_id = $_SESSION['user_id'];
$nama_lengkap = $_SESSION['nama_lengkap'] ?? '';
$foto = $_SESSION['foto'] ?? '';

// counts
$counts = [];
$tables = [
	'mahasiswa' => 'db_mahasiswa.php',
	'mata_kuliah' => 'db_matkul.php',
	'dosen' => 'db_dosen.php',
	'jadwal_matkul' => 'db_jadwal.php',
	'absensi' => 'db_absensi.php',
	'krs' => 'krs.php',
	'kas' => 'db_kas.php',
	'users' => 'db_users.php'
];

foreach ($tables as $table => $link) {
	$res = mysqli_query($koneksi, "SELECT COUNT(*) AS cnt FROM $table");
	if ($res) {
		$row = mysqli_fetch_assoc($res);
		$counts[$table] = $row['cnt'] ?? 0;
	} else {
		$counts[$table] = 0;
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#6c27dc" />
	<link rel="icon" href="img/icon.png" />
	<title>Dashboard Ringkasan - PTIK C</title>
	<link href="../../frontend/tailwind/src/output.css" rel="stylesheet">
	<link href="../../frontend/tailwind/src/input.css" rel="stylesheet">
	<style>
		.card-hover:hover { transform: translateY(-4px); }
	</style>
</head>

<body class="bg-slate-100">
	<header class="bg-indigo-950 fixed w-full top-0 z-50">
		<div class="flex justify-between items-center px-6 py-2">
			<div class="flex items-center">
				<img src="../../img/logo.png" alt="logo" class="h-10 w-10 mr-3">
				<span class="text-xl font-bold text-white">Dashboard PTIK C</span>
			</div>
			<div class="hidden lg:flex items-center space-x-4">
				<span class="text-white mr-2"><?= htmlspecialchars($nama_lengkap) ?></span>
				<img src="../img/profile/<?= htmlspecialchars($foto) ?>" alt="profile" class="w-8 h-8 rounded-full">
			</div>
		</div>
	</header>

	<aside id="sidebar" class="fixed left-0 top-0 h-screen w-48 bg-white pt-16 z-40">
		<nav class="px-4">
			<a href="db_mahasiswa.php" class="block px-4 py-2 text-slate-700 rounded hover:bg-slate-100">Daftar Mahasiswa</a>
			<a href="db_matkul.php" class="block px-4 py-2 text-slate-700 rounded hover:bg-slate-100">Mata Kuliah</a>
			<a href="db_dosen.php" class="block px-4 py-2 text-slate-700 rounded hover:bg-slate-100">Dosen</a>
			<a href="db_jadwal.php" class="block px-4 py-2 text-slate-700 rounded hover:bg-slate-100">Jadwal Mata Kuliah</a>
			<a href="db_absensi.php" class="block px-4 py-2 text-slate-700 rounded hover:bg-slate-100">Absensi</a>
			<a href="krs.php" class="block px-4 py-2 text-slate-700 rounded hover:bg-slate-100">KRS</a>
			<a href="db_kas.php" class="block px-4 py-2 text-slate-700 rounded hover:bg-slate-100">Kas Mingguan</a>
			<a href="db_users.php" class="block px-4 py-2 text-slate-700 rounded hover:bg-slate-100">Users</a>
		</nav>
	</aside>

	<main class="ml-0 lg:ml-48 pt-20 p-6">
		<div class="max-w-6xl mx-auto">
			<h1 class="text-2xl font-bold text-slate-800 mb-6">Ringkasan Sistem</h1>

			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
				<a href="db_mahasiswa.php" class="bg-white p-4 rounded shadow card-hover border">
					<div class="text-xs text-slate-500">Mahasiswa</div>
					<div class="text-2xl font-bold text-indigo-900"><?= $counts['mahasiswa'] ?></div>
				</a>

				<a href="db_matkul.php" class="bg-white p-4 rounded shadow card-hover border">
					<div class="text-xs text-slate-500">Mata Kuliah</div>
					<div class="text-2xl font-bold text-indigo-900"><?= $counts['mata_kuliah'] ?></div>
				</a>

				<a href="db_dosen.php" class="bg-white p-4 rounded shadow card-hover border">
					<div class="text-xs text-slate-500">Dosen</div>
					<div class="text-2xl font-bold text-indigo-900"><?= $counts['dosen'] ?></div>
				</a>

				<a href="db_jadwal.php" class="bg-white p-4 rounded shadow card-hover border">
					<div class="text-xs text-slate-500">Jadwal</div>
					<div class="text-2xl font-bold text-indigo-900"><?= $counts['jadwal_matkul'] ?></div>
				</a>

				<a href="db_absensi.php" class="bg-white p-4 rounded shadow card-hover border">
					<div class="text-xs text-slate-500">Absensi (baris)</div>
					<div class="text-2xl font-bold text-indigo-900"><?= $counts['absensi'] ?></div>
				</a>

				<a href="krs.php" class="bg-white p-4 rounded shadow card-hover border">
					<div class="text-xs text-slate-500">KRS (entri)</div>
					<div class="text-2xl font-bold text-indigo-900"><?= $counts['krs'] ?></div>
				</a>

				<a href="db_kas.php" class="bg-white p-4 rounded shadow card-hover border">
					<div class="text-xs text-slate-500">Kas (entri)</div>
					<div class="text-2xl font-bold text-indigo-900"><?= $counts['kas'] ?></div>
				</a>

				<a href="db_users.php" class="bg-white p-4 rounded shadow card-hover border">
					<div class="text-xs text-slate-500">Users</div>
					<div class="text-2xl font-bold text-indigo-900"><?= $counts['users'] ?></div>
				</a>
			</div>

			<div class="mt-8 bg-white p-4 rounded shadow border">
				<h2 class="text-lg font-semibold mb-2">Quick Links</h2>
				<div class="flex flex-wrap gap-2">
					<?php foreach ($tables as $table => $link): ?>
						<a href="<?= $link ?>" class="px-3 py-2 bg-indigo-100 text-indigo-900 rounded text-xs hover:bg-indigo-200"><?= ucfirst(str_replace('_',' ', $table)) ?></a>
					<?php endforeach; ?>
				</div>
			</div>

		</div>
	</main>

	<script>
		// Mobile menu toggle
		const mobileMenuButton = document.getElementById('mobile-menu-button');
		const sidebar = document.getElementById('sidebar');
		if (mobileMenuButton) mobileMenuButton.addEventListener('click', () => sidebar.classList.toggle('-translate-x-full'));
	</script>
</body>

</html>

