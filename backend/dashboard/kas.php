<?php
session_start();
include '../../koneksi.php';

// proteksi login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$nama_panggilan = $_SESSION['nama_panggilan'];
$foto = $_SESSION['foto'];
// ambil semua mahasiswa
$mhs = mysqli_query($koneksi, "
    SELECT id, nim, nama_lengkap
    FROM mahasiswa
    ORDER BY nim ASC
");

// simpan/update kas
if (isset($_POST['simpan'])) {
    $minggu = (int) $_POST['minggu'];

    foreach ($_POST['status'] as $mahasiswa_id => $status) {

        $tanggal = ($status === 'lunas') ? date('Y-m-d') : NULL;

        mysqli_query($koneksi, "
            INSERT INTO kas (mahasiswa_id, minggu_ke, status, tanggal_bayar)
            VALUES ($mahasiswa_id, $minggu, '$status', " . ($tanggal ? "'$tanggal'" : "NULL") . ")
            ON DUPLICATE KEY UPDATE
                status='$status',
                tanggal_bayar=" . ($tanggal ? "'$tanggal'" : "NULL") . "
        ");
    }

    header("Location: kas.php?minggu=$minggu");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#6c27dc" />
    <link rel="icon" href="img/icon.png" />
    <title>Kelas PTIK C 2024 - Teknik Informatika dan Komputer</title>
    <link href="../../frontend/tailwind/src/output.css" rel="stylesheet">
    <link href="../../frontend/tailwind/src/input.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        .rotate-180 {
            transform: rotate(180deg);
        }

        /* Tambahan CSS untuk mobile menu */
        @media (max-width: 768px) {
            .mobile-menu-open {
                transform: translateX(0) !important;
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Header dengan z-index lebih tinggi -->
    <header class="bg-gradient-to-r from-blue-700 to-blue-800  fixed w-full top-0 z-50">
        <div class="flex justify-between items-center px-6 py-3">
            <div class="flex items-center">
                <span class="text-xl font-bold text-white">Dashboard PTIK C</span>
            </div>
            <!-- Mobile Menu Button dengan z-index yang sesuai -->
            <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <div class="hidden md:flex items-center space-x-4">
                <div class="relative">
                    <button id="profile-button" class="flex items-center space-x-2">
                        <img src="../img/profile/<?= htmlspecialchars($foto) ?>" alt="Profile" class="w-8 h-8 rounded-full">
                        <span class="text-white"><?= htmlspecialchars($nama_panggilan) ?></span>
                    </button>
                    <div id="profile-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden">
                        <a href="profile.php" class="block px-4 py-2 text-sm hover:bg-gray-100">Profile</a>
                        <a href="../login/login.php" class="block px-4 py-2 text-sm hover:bg-gray-100">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar dengan z-index di bawah header -->
    <aside id="sidebar"
        class="fixed left-0 top-0 h-screen w-64 bg-white transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out z-40">
        <!-- Tambahan padding top agar tidak tertutup header -->
        <div class="pt-16">
            <nav class="mt-6">
                <div class="px-4 space-y-2">
                    <!-- Dashboard Menu -->
                    <a href="../index.html" class="flex items-center px-4 py-2 text-gray-700  rounded-lg">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Beranda</span>
                    </a>

                    <!-- Components Menu -->
                    <div class="space-y-2">
                        <button
                            class="submenu-button flex items-center justify-between w-full px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                <span>Akademik</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu pl-8 space-y-1 hidden overflow-y-auto max-h-52">
                            <a href="db_mahasiswa.php"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">Daftar Mahasiswa</a>

                            <a href="db_matkul.php"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">Daftar Mata Kuliah</a>

                            <a href="db_users.php"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">Daftar Users</a>




                        </div>
                        <button
                            class="flex items-center justify-between w-full px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                <a href="db_absensi.php">
                                    <span>Absensi</span>
                                </a>

                            </div>

                        </button>
                    </div>


                </div>
            </nav>
        </div>
    </aside>

    <main class="ml-0 md:ml-64 pt-20 p-6">
        <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow">

            <h1 class="text-2xl font-bold mb-6">💰 Kas Kelas PTIK C</h1>

            <form method="GET" class="mb-6 flex items-end gap-4">
                <div>
                    <select name="minggu" class="border rounded px-3 py-2" required>
                        <option value="">-- Pilih Minggu --</option>
                        <?php for ($i = 1; $i <= 16; $i++): ?>
                            <option value="<?= $i ?>" <?= ($_GET['minggu'] ?? '') == $i ? 'selected' : '' ?>>
                                Minggu <?= $i ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <button type="submit"
                    class="bg-blue-700 text-white rounded-lg px-4 py-2">
                    🔍 Tampilkan
                </button>
            </form>
            <?php if (isset($_GET['minggu'])): ?>

                <form method="POST">

                    <input type="hidden" name="minggu" value="<?= $_GET['minggu'] ?>">

                    <div class="overflow-x-auto">
                        <table class="w-full border">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="border p-2">No</th>
                                    <th class="border p-2">NIM</th>
                                    <th class="border p-2">Nama</th>
                                    <th class="border p-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $no = 1;
                                $minggu_aktif = $_GET['minggu'];

                                $mhs = mysqli_query($koneksi, "
    SELECT id, nim, nama_lengkap
    FROM mahasiswa
    ORDER BY nim ASC
");

                                while ($row = mysqli_fetch_assoc($mhs)) {

                                    $cek = mysqli_query($koneksi, "
        SELECT status
        FROM kas
        WHERE mahasiswa_id = {$row['id']}
        AND minggu_ke = $minggu_aktif
    ");

                                    $kas = mysqli_fetch_assoc($cek);
                                    $status = $kas['status'] ?? 'belum';
                                ?>
                                    <tr>
                                        <td class="border p-2 text-center"><?= $no++ ?></td>
                                        <td class="border p-2"><?= $row['nim'] ?></td>
                                        <td class="border p-2"><?= $row['nama_lengkap'] ?></td>
                                        <td class="border p-2 text-center">
                                            <select name="status[<?= $row['id'] ?>]"
                                                class="border rounded px-2 py-1">
                                                <option value="Belum" <?= $status == 'Belum' ? 'selected' : '' ?>>Belum</option>
                                                <option value="Lunas" <?= $status == 'Lunas' ? 'selected' : '' ?>>Lunas</option>
                                            </select>
                                        </td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        <button type="submit" name="simpan"
                            class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                            💾 Simpan Kas Mingguan
                        </button>
                    </div>

                </form>

            <?php endif; ?>

        </div>
    </main>
    <script>
        // Mobile menu toggle dengan perbaikan
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');

        mobileMenuButton.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent event bubbling
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('mobile-menu-open');
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 768) { // Only on mobile
                if (!sidebar.contains(e.target) && !mobileMenuButton.contains(e.target)) {
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('mobile-menu-open');
                }
            }
        });

        // Submenu toggles
        const submenuButtons = document.querySelectorAll('.submenu-button');

        submenuButtons.forEach(button => {
            button.addEventListener('click', () => {
                const submenu = button.nextElementSibling;
                const arrow = button.querySelector('svg:last-child');

                submenu.classList.toggle('hidden');
                arrow.classList.toggle('rotate-180');
            });
        });

        // Profile dropdown
        const profileButton = document.getElementById('profile-button');
        const profileDropdown = document.getElementById('profile-dropdown');

        if (profileButton && profileDropdown) {
            profileButton.addEventListener('click', (e) => {
                e.stopPropagation();
                profileDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!profileButton.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });
        }
    </script>
</body>

</html>