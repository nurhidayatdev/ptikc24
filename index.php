<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#6c27dc" />
    <link rel="icon" href="img/icon.png" />
    <title>Kelas PTIK C 2024 - Teknik Informatika dan Komputer</title>
    <meta name="title" content="PTIK C 24" />
    <meta name="description" content="© 2024 ProtechnotyClass24" />
    <meta property="og:type" content="website" />
    <meta
        property="og:url"
        content="https://ptikc24.vercel.app/.html" />
    <meta
        property="og:title"
        content="PTIK C 24" />
    <meta property="og:description" content="© 2024 ProtechnotyClass24" />
    <meta property="og:image" content="https://iili.io/FpUOxUb.md.png" />

    <meta property="twitter:card" content="summary_large_image" />
    <meta
        property="twitter:url"
        content="https://ptikc24.vercel.app/.html" />
    <meta
        property="twitter:title"
        content="Jadwal Mata Kuliah Kelas PTIK C" />
    <meta property="twitter:description" content="© 2024 ProtechnotyClass24" />
    <meta property="twitter:image" content="https://iili.io/FpUOxUb.md.png" />

    <link href="frontend/tailwind/src/output.css" rel="stylesheet">
    <link href="frontend/tailwind/src/input.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <header class="bg-indigo-950 text-white shadow-lg relative">
        <div class="container mx-auto px-4 py-2 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <img src="img/logo.png" alt="Logo Universitas Negeri Makassar" class="h-10 w-10 mr-3">
                <div>
                    <h1 class="text-lg font-bold">PTIK C 2024</h1>
                    <p class="text-xs">Teknik Informatika dan Komputer - FT UNM</p>
                </div>
            </div>

            <!-- Hamburger Button -->
            <button id="menuToggle" class="md:hidden text-2xl focus:outline-none">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Menu Desktop -->
            <nav class="hidden md:block">
                <ul class="flex space-x-6">
                    <li><a href="#" class="hover:text-indigo-200 transition text-sm">Beranda</a></li>
                    <li><a href="pages/mahasiswa.php" class="hover:text-indigo-200 transition text-sm">Mahasiswa</a></li>
                    <li><a href="pages/jadwal.php" class="hover:text-indigo-200 transition text-sm">Jadwal</a></li>
                    <li><a href="pages/akademik.php" class="hover:text-indigo-200 transition text-sm">Akademik</a></li>
                    <li><a href="pages/kegiatan.php" class="hover:text-indigo-200 transition text-sm">Kegiatan</a></li>
                    <li><a href="backend/login/login.php" class="hover:text-indigo-200 transition text-sm">Login</a></li>
                </ul>
            </nav>
        </div>

        <!-- Menu Mobile (muncul di bawah nav) -->
        <nav id="mobileMenu" class="hidden md:hidden absolute top-full left-0 w-full bg-indigo-950 shadow-md">
            <ul class="flex flex-col space-y-4 p-4">
                <li><a href="#" class="flex items-center space-x-2 hover:text-indigo-200 transition text-sm"><i class="fas fa-home"></i><span>Beranda</span></a></li>
                <li><a href="pages/mahasiswa.php" class="flex items-center space-x-2 hover:text-indigo-200 transition text-sm"><i class="fas fa-users"></i><span>Mahasiswa</span></a></li>
                <li><a href="pages/jadwal.php" class="flex items-center space-x-2 hover:text-indigo-200 transition text-sm"><i class="fas fa-calendar"></i><span>Jadwal</span></a></li>
                <li><a href="pages/akademik.php" class="flex items-center space-x-2 hover:text-indigo-200 transition text-sm"><i class="fas fa-tasks"></i><span>Akademik</span></a></li>
                <li><a href="pages/kegiatan.php" class="flex items-center space-x-2 hover:text-indigo-200 transition text-sm"><i class="fas fa-tasks"></i><span>Kegiatan</span></a></li>
                <li><a href="backend/login/login.php" class="flex items-center space-x-2 hover:text-indigo-200 transition text-sm"><i class="fas fa-tasks"></i><span>Login</span></a></li>
            </ul>
        </nav>
    </header>


    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-indigo-800 to-indigo-950 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-4 fade-in">Selamat Datang di Kelas PTIK C</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto fade-in">Angkatan 2024 - Jurusan Teknik Informatika dan Komputer<br>Fakultas Teknik, Universitas Negeri Makassar</p>
            <button class="bg-white text-indigo-800 px-6 py-3 rounded-lg font-semibold hover:bg-indigo-100 transition">
                Jelajahi Lebih Lanjut
            </button>
        </div>
    </section>

    <!-- Profil Kelas -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Profil Kelas PTIK C 2024</h2>

            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h3 class="text-2xl font-semibold mb-4 text-indigo-800">Tentang Kami</h3>
                    <p class="text-gray-700 mb-4">
                        Kelas PTIK C Angkatan 2024 adalah bagian dari Program Studi Teknik Informatika dan Komputer
                        di Fakultas Teknik, Universitas Negeri Makassar. Kami adalah generasi penerus dalam dunia
                        teknologi informasi yang siap menghadapi tantangan di era digital.
                    </p>
                    <p class="text-gray-700 mb-4">
                        Dengan semangat kolaborasi dan inovasi, kami terus belajar dan berkembang untuk menjadi
                        profesional TI yang kompeten dan berkarakter.
                    </p>
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <div class="bg-indigo-100 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-indigo-800">37</p>
                            <p class="text-gray-700">Mahasiswa</p>
                        </div>
                        <div class="bg-indigo-100 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-indigo-800">3</p>
                            <p class="text-gray-700">Semester</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center">
                    <img src="img/img-1.jpg" alt="Foto bersama kelas PTIK C Angkatan 2024" class="rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Struktur Pengurus Kelas -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Struktur Pengurus Kelas</h2>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Ketua -->
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <img src="img/image.png" alt="Foto Ketua Kelas PTIK C" class="rounded-full mx-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">Shofiyah Rosyadah</h3>
                    <p class="text-indigo-800 font-medium mb-2">Ketua Kelas</p>
                    <p class="text-gray-600">Bertanggung jawab atas koordinasi seluruh kegiatan kelas</p>
                </div>

                <!-- Sekretaris -->
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <img src="img/image.png" alt="Foto Sekretaris Kelas PTIK C" class="rounded-full mx-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">Adelia Magfira Hapati</h3>
                    <p class="text-indigo-800 font-medium mb-2">Sekretaris</p>
                    <p class="text-gray-600">Mengelola administrasi dan dokumentasi kelas</p>
                </div>

                <!-- Bendahara -->
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <img src="img/image.png" alt="Foto Bendahara Kelas PTIK C" class="rounded-full mx-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">Islatul Adha</h3>
                    <p class="text-indigo-800 font-medium mb-2">Bendahara</p>
                    <p class="text-gray-600">Mengelola keuangan dan anggaran kelas</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Slider -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Galeri Kelas</h2>

            <div class="relative max-w-4xl mx-auto">
                <div class="overflow-hidden rounded-lg shadow-xl">
                    <div id="slider" class="slider flex transition-transform duration-500 ease-in-out">
                        <div class="w-full flex-shrink-0">
                            <img src="img/img-1.jpg" alt="ptikc24" class="w-full h-auto">
                        </div>
                        <div class="w-full flex-shrink-0">
                            <img src="img/img-2.jpg" alt="ptikc24" class="w-full h-auto">
                        </div>
                        <div class="w-full flex-shrink-0">
                            <img src="img/img-3.jpg" alt="ptikc24" class="w-full h-auto">
                        </div>
                        <div class="w-full flex-shrink-0">
                            <img src="img/img-4.jpg" alt="ptikc24" class="w-full h-auto">
                        </div>
                        <div class="w-full flex-shrink-0">
                            <img src="img/img-5.jpg" alt="ptikc24" class="w-full h-auto">
                        </div>
                        <div class="w-full flex-shrink-0">
                            <img src="img/img-6.jpg" alt="ptikc24" class="w-full h-auto">
                        </div>
                        <div class="w-full flex-shrink-0">
                            <img src="img/img-7.jpg" alt="ptikc24" class="w-full h-auto">
                        </div>
                    </div>
                </div>

                <button id="prev" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-md hover:bg-gray-100">
                    <i class="fas fa-chevron-left text-indigo-800"></i>
                </button>
                <button id="next" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-md hover:bg-gray-100">
                    <i class="fas fa-chevron-right text-indigo-800"></i>
                </button>

                <div class="flex justify-center mt-4 space-x-2">
                    <button class="indicator w-3 h-3 rounded-full bg-indigo-300"></button>
                    <button class="indicator w-3 h-3 rounded-full bg-indigo-300"></button>
                    <button class="indicator w-3 h-3 rounded-full bg-indigo-300"></button>
                    <button class="indicator w-3 h-3 rounded-full bg-indigo-300"></button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-indigo-950 text-white py-4">
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
                        <li><a href="#" class="hover:text-indigo-200 transition text-xs">Beranda</a></li>
                        <li><a href="jadwal-matkul/jadwal-matkul.html" class="hover:text-indigo-200 transition text-xs">Jadwal Kuliah</a></li>
                        <li><a href="daftar-mahasiswa/daftar-mahasiswa.html" class="hover:text-indigo-200 transition text-xs">Daftar Mahasiswa</a></li>
                        <li><a href="daftar-tugas/daftar-tugas.html" class="hover:text-indigo-200 transition text-xs">Daftar Tugas</a></li>
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
        // Slider functionality
        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.getElementById('slider');
            const slides = document.querySelectorAll('#slider > div');
            const indicators = document.querySelectorAll('.indicator');
            const prevBtn = document.getElementById('prev');
            const nextBtn = document.getElementById('next');

            let currentSlide = 0;
            const slideCount = slides.length;

            // Update slider position
            function updateSlider() {
                slider.style.transform = `translateX(-${currentSlide * 100}%)`;

                // Update indicators
                indicators.forEach((indicator, index) => {
                    if (index === currentSlide) {
                        indicator.classList.add('bg-indigo-700');
                        indicator.classList.remove('bg-indigo-300');
                    } else {
                        indicator.classList.remove('bg-indigo-700');
                        indicator.classList.add('bg-indigo-300');
                    }
                });
            }

            // Next slide
            nextBtn.addEventListener('click', function() {
                currentSlide = (currentSlide + 1) % slideCount;
                updateSlider();
            });

            // Previous slide
            prevBtn.addEventListener('click', function() {
                currentSlide = (currentSlide - 1 + slideCount) % slideCount;
                updateSlider();
            });

            // Auto slide every 5 seconds
            setInterval(function() {
                currentSlide = (currentSlide + 1) % slideCount;
                updateSlider();
            }, 5000);

            // Click on indicator to go to specific slide
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', function() {
                    currentSlide = index;
                    updateSlider();
                });
            });

            // Initialize slider
            updateSlider();
        });
    </script>
</body>

</html>