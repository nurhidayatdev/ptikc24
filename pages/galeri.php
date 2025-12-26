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
	<title>Galeri - Kelas PTIK C 2024</title>
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
					<li><a href="galeri.php" class="hover:text-indigo-200 transition text-sm">Galeri</a></li>
					<li><a href="kegiatan.php" class="hover:text-indigo-200 transition text-sm">Kegiatan</a></li>
				</ul>
			</nav>
		</div>

		<nav id="mobileMenu" class="hidden md:hidden absolute top-full left-0 w-full bg-indigo-950 shadow-md">
			<ul class="flex flex-col space-y-4 p-4">
				<li><a href="../index.php" class="flex items-center space-x-2 hover:text-indigo-200 transition text-sm"><i class="fas fa-home"></i><span>Beranda</span></a></li>
				<li><a href="mahasiswa.php" class="flex items-center space-x-2 hover:text-indigo-200 transition text-sm"><i class="fas fa-users"></i><span>Mahasiswa</span></a></li>
				<li><a href="jadwal.php" class="flex items-center space-x-2 hover:text-indigo-200 transition text-sm"><i class="fas fa-calendar"></i><span>Jadwal</span></a></li>
				<li><a href="akademik.php" class="flex items-center space-x-2 hover:text-indigo-200 transition text-sm"><i class="fas fa-tasks"></i><span>Akademik</span></a></li>
				<li><a href="galeri.php" class="flex items-center space-x-2 hover:text-indigo-200 transition text-sm"><i class="fas fa-images"></i><span>Galeri</span></a></li>
				<li><a href="kegiatan.php" class="flex items-center space-x-2 hover:text-indigo-200 transition text-sm"><i class="fas fa-tasks"></i><span>Kegiatan</span></a></li>
			</ul>
		</nav>
	</header>

	<main class="flex-grow">
		<section class="py-12">
			<div class="container mx-auto px-4">
				<h2 class="text-3xl font-bold mb-6 text-gray-800">Galeri Kegiatan</h2>

				<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
					<!-- Card with slider (sample static content) -->
					<div class="bg-white rounded-xl shadow-md overflow-hidden">
						<div class="relative group">
							<div class="slider overflow-hidden relative" data-slider-id="s1">
								<div class="slides flex transition-transform duration-500">
									<img src="../img/img-1.jpg" class="w-full h-48 object-cover flex-shrink-0" alt="foto1">
									<img src="../img/img-2.jpg" class="w-full h-48 object-cover flex-shrink-0" alt="foto2">
									<img src="../img/img-3.jpg" class="w-full h-48 object-cover flex-shrink-0" alt="foto3">
								</div>
							</div>
							<button data-prev data-slider="s1" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white/80 rounded-full p-2 shadow-md hidden group-hover:block"><i class="fas fa-chevron-left text-indigo-800"></i></button>
							<button data-next data-slider="s1" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white/80 rounded-full p-2 shadow-md hidden group-hover:block"><i class="fas fa-chevron-right text-indigo-800"></i></button>
						</div>
						<div class="p-4">
							<h3 class="font-semibold text-lg mb-1">Nama Kegiatan Contoh</h3>
							<p class="text-sm text-gray-600 mb-3">Deskripsi singkat kegiatan. Diisi dari dashboard nanti.</p>
							
						</div>
					</div>

					<!-- Duplicate sample cards (copyable for dynamic rendering later) -->
					<div class="bg-white rounded-xl shadow-md overflow-hidden">
						<div class="relative group">
							<div class="slider overflow-hidden relative" data-slider-id="s2">
								<div class="slides flex transition-transform duration-500">
									<img src="../img/img-4.jpg" class="w-full h-48 object-cover flex-shrink-0" alt="foto1">
									<img src="../img/img-5.jpg" class="w-full h-48 object-cover flex-shrink-0" alt="foto2">
								</div>
							</div>
							<button data-prev data-slider="s2" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white/80 rounded-full p-2 shadow-md hidden group-hover:block"><i class="fas fa-chevron-left text-indigo-800"></i></button>
							<button data-next data-slider="s2" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white/80 rounded-full p-2 shadow-md hidden group-hover:block"><i class="fas fa-chevron-right text-indigo-800"></i></button>
						</div>
						<div class="p-4">
							<h3 class="font-semibold text-lg mb-1">Kegiatan Seminar</h3>
							<p class="text-sm text-gray-600 mb-3">Ringkasan singkat seminar atau workshop.</p>
							
						</div>
					</div>

					<div class="bg-white rounded-xl shadow-md overflow-hidden">
						<div class="relative group">
							<div class="slider overflow-hidden relative" data-slider-id="s3">
								<div class="slides flex transition-transform duration-500">
									<img src="../img/img-6.jpg" class="w-full h-48 object-cover flex-shrink-0" alt="foto1">
									<img src="../img/img-7.jpg" class="w-full h-48 object-cover flex-shrink-0" alt="foto2">
								</div>
							</div>
							<button data-prev data-slider="s3" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white/80 rounded-full p-2 shadow-md hidden group-hover:block"><i class="fas fa-chevron-left text-indigo-800"></i></button>
							<button data-next data-slider="s3" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white/80 rounded-full p-2 shadow-md hidden group-hover:block"><i class="fas fa-chevron-right text-indigo-800"></i></button>
						</div>
						<div class="p-4">
							<h3 class="font-semibold text-lg mb-1">Kegiatan Lapangan</h3>
							<p class="text-sm text-gray-600 mb-3">Ringkasan singkat kegiatan lapangan atau kunjungan.</p>
							
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>

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

		// Simple per-card slider logic
		document.addEventListener('DOMContentLoaded', function() {
			const sliders = document.querySelectorAll('.slider');
			sliders.forEach(slider => {
				const slides = slider.querySelector('.slides');
				const slideCount = slides.children.length;
				let idx = 0;
				const id = slider.getAttribute('data-slider-id');

				const nextBtn = document.querySelector(`[data-next][data-slider="${id}"]`);
				const prevBtn = document.querySelector(`[data-prev][data-slider="${id}"]`);

				function update() {
					slides.style.transform = `translateX(-${idx * 100}%)`;
				}

				if (nextBtn) nextBtn.addEventListener('click', () => { idx = (idx + 1) % slideCount; update(); });
				if (prevBtn) prevBtn.addEventListener('click', () => { idx = (idx - 1 + slideCount) % slideCount; update(); });

				// auto-play
				setInterval(() => { idx = (idx + 1) % slideCount; update(); }, 4000);
			});
		});
	</script>
</body>

</html>

