<?php
include '../koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#6c27dc" />
	<link rel="icon" href="../img/icon.png" />
	<title>Akademik - Kelas PTIK C 2024</title>
	<link href="../frontend/tailwind/src/output.css" rel="stylesheet">
	<link href="../frontend/tailwind/src/input.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">
	<header class="bg-indigo-950 text-white shadow-lg relative">
		<div class="container mx-auto px-4 py-2 flex justify-between items-center">
			<div class="flex items-center">
				<img src="../img/logo.png" alt="Logo" class="h-10 w-10 mr-3">
				<div>
					<h1 class="text-lg font-bold">PTIK C 2024</h1>
					<p class="text-xs">Teknik Informatika dan Komputer - FT UNM</p>
				</div>
			</div>

			<button id="menuToggle" class="md:hidden text-2xl focus:outline-none">
				<i class="fas fa-bars"></i>
			</button>

			<nav class="hidden md:block">
				<ul class="flex space-x-6">
					<li><a href="../index.php" class="hover:text-indigo-200 transition text-sm">Beranda</a></li>
					<li><a href="mahasiswa.php" class="hover:text-indigo-200 transition text-sm">Mahasiswa</a></li>
					<li><a href="jadwal.php" class="hover:text-indigo-200 transition text-sm">Jadwal</a></li>
					<li><a href="akademik.php" class="hover:text-indigo-200 transition text-sm">Akademik</a></li>
					<li><a href="kegiatan.php" class="hover:text-indigo-200 transition text-sm">Kegiatan</a></li>
					<li><a href="../backend/login/login.php" class="hover:text-indigo-200 transition text-sm">Login</a></li>
				</ul>
			</nav>
		</div>

		<nav id="mobileMenu" class="hidden md:hidden absolute top-full left-0 w-full bg-indigo-950 shadow-md">
			<ul class="flex flex-col space-y-4 p-4">
				<li><a href="../index.php" class="flex items-center space-x-2 hover:text-indigo-200 transition text-sm"><i class="fas fa-home"></i><span>Beranda</span></a></li>
				<li><a href="mahasiswa.php" class="flex items-center space-x-2 hover:text-indigo-200 transition text-sm"><i class="fas fa-users"></i><span>Mahasiswa</span></a></li>
				<li><a href="jadwal.php" class="flex items-center space-x-2 hover:text-indigo-200 transition text-sm"><i class="fas fa-calendar"></i><span>Jadwal</span></a></li>
				<li><a href="akademik.php" class="flex items-center space-x-2 hover:text-indigo-200 transition text-sm"><i class="fas fa-tasks"></i><span>Akademik</span></a></li>
				<li><a href="kegiatan.php" class="flex items-center space-x-2 hover:text-indigo-200 transition text-sm"><i class="fas fa-tasks"></i><span>Kegiatan</span></a></li>
				<li><a href="../backend/login/login.php" class="flex items-center space-x-2 hover:text-indigo-200 transition text-sm"><i class="fas fa-user"></i><span>Login</span></a></li>
			</ul>
		</nav>
	</header>

	<main class="flex-grow">
		<section class="py-12">
			<div class="container mx-auto px-4">
				<h2 class="text-3xl font-bold mb-6 text-gray-800">Berita & Informasi Akademik</h2>

				<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
					<!-- sample card -->
					<article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
						
						<div class="p-4">
							<h3 class="font-semibold text-lg mb-2">Judul Berita Contoh</h3>
							<p class="text-sm text-gray-600 mb-3">Ringkasan singkat berita atau pengumuman akademik. Klik untuk membaca lebih lanjut.</p>
							<a href="#" class="text-indigo-700 font-medium">Baca lebih lanjut →</a>
						</div>
					</article>

					<article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
						
						<div class="p-4">
							<h3 class="font-semibold text-lg mb-2">Pengumuman Jadwal</h3>
							<p class="text-sm text-gray-600 mb-3">Informasi terkait perubahan jadwal kuliah atau ujian.</p>
							<a href="#" class="text-indigo-700 font-medium">Baca lebih lanjut →</a>
						</div>
					</article>

					<article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
						
						<div class="p-4">
							<h3 class="font-semibold text-lg mb-2">Info Tugas & Kegiatan</h3>
							<p class="text-sm text-gray-600 mb-3">Ringkasan tugas atau kegiatan yang perlu diketahui seluruh mahasiswa.</p>
							<a href="#" class="text-indigo-700 font-medium">Baca lebih lanjut →</a>
						</div>
					</article>
				</div>
			</div>
		</section>
	</main>

	<!-- Footer (sticky to bottom via flex layout) -->
	<footer class="bg-indigo-950 text-white py-4 mt-auto">
		<div class="container mx-auto px-4">
			<div class="grid md:grid-cols-3 gap-8">
				<div>
					<h3 class="text-lg font-bold mb-4">PTIK C 2024</h3>
					<p class="mb-4 text-xs">Jurusan Teknik Informatika dan Komputer</p>
					<p class="text-xs">Fakultas Teknik</p>
					<p class="text-xs">Universitas Negeri Makassar</p>
				</div>

				<div>
					<h3 class="text-lg font-bold mb-4">Tautan Cepat</h3>
					<ul class="space-y-1">
						<li><a href="../index.php" class="hover:text-indigo-200 transition text-xs">Beranda</a></li>
						<li><a href="../jadwal-matkul/jadwal-matkul.html" class="hover:text-indigo-200 transition text-xs">Jadwal Kuliah</a></li>
						<li><a href="../daftar-mahasiswa/daftar-mahasiswa.html" class="hover:text-indigo-200 transition text-xs">Daftar Mahasiswa</a></li>
						<li><a href="../daftar-tugas/daftar-tugas.html" class="hover:text-indigo-200 transition text-xs">Daftar Tugas</a></li>
					</ul>
				</div>

				<div>
					<h3 class="text-lg font-bold mb-4">Kontak</h3>
					<p class="mb-2 text-xs"><i class="fas fa-map-marker-alt mr-2 text-sm"></i> Jl. A.P. Pettarani, Makassar</p>
					<p class="mb-2 text-xs"><i class="fas fa-envelope mr-2 text-sm"></i> ptikc2024@unm.ac.id</p>
					<div class="flex space-x-4 mt-4 text-xs">
						<a href="https://www.instagram.com/ptikc_24" class="hover:text-indigo-200 transition text-xs"><i class="fab fa-instagram text-sm"></i></a>
						<a href="#" class="hover:text-indigo-200 transition text-xs"><i class="fab fa-facebook text-sm"></i></a>
						<a href="#" class="hover:text-indigo-200 transition text-xs"><i class="fab fa-twitter text-sm"></i></a>
					</div>
				</div>
			</div>

			<div class="border-t border-indigo-800 mt-4 pt-4 text-center text-xs">
				<p>© 2025 Kelas PTIK C - Teknik Informatika dan Komputer FT UNM. All rights reserved.</p>
			</div>
		</div>
	</footer>

	<script>
		const menuToggle = document.getElementById('menuToggle');
		const mobileMenu = document.getElementById('mobileMenu');
		const menuIcon = menuToggle.querySelector('i');

		menuToggle.addEventListener('click', () => {
			mobileMenu.classList.toggle('hidden');
			if (mobileMenu.classList.contains('hidden')) {
				menuIcon.classList.remove('fa-xmark');
				menuIcon.classList.add('fa-bars');
			} else {
				menuIcon.classList.remove('fa-bars');
				menuIcon.classList.add('fa-xmark');
			}
		});
	</script>
</body>

</html>

