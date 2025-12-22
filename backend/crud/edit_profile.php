<?php
session_start();
include '../../koneksi.php';

$nama_panggilan = $_SESSION['nama_panggilan'];
$user_id = $_SESSION['user_id'];
$foto = $_SESSION['foto'];
$query = "SELECT id FROM mahasiswa WHERE user_id = ?";
$stmt  = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$mahasiswa = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

$mahasiswa_id = $mahasiswa['id'];


// ambil data user
$query = "
SELECT 
    u.id AS user_id,
    u.role,
    u.password,
    m.nim,
    m.nama_lengkap,
    m.nama_panggilan,
    u.email,
    m.foto,
    m.bio
FROM users u
JOIN mahasiswa m ON m.user_id = u.id
WHERE u.id = ?
LIMIT 1
";

$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);



if (isset($_POST['update'])) {

    $foto_baru = $data['foto']; // default foto lama

    // prefer client-side processed image in foto_data (base64)
    if (!empty($_POST['foto_data'])) {
        $foto_data = $_POST['foto_data'];
        // data URIs look like: data:image/jpeg;base64,....
        if (preg_match('/^data:(image\/[a-zA-Z]+);base64,/', $foto_data, $m)) {
            $mime = $m[1];
            $base64 = substr($foto_data, strpos($foto_data, ',') + 1);
            $decoded = base64_decode($base64);
            if ($decoded === false) {
                die('Gagal decode gambar.');
            }

            // If GD functions available, use them to resize/convert; otherwise write raw bytes
            if (function_exists('imagecreatefromstring')) {
                $src = @imagecreatefromstring($decoded);
                if ($src === false) {
                    die('Format gambar tidak dikenali.');
                }

                // ensure square output (client already crops to square), resize to 512x512
                $size = 512;
                $dst = imagecreatetruecolor($size, $size);
                // preserve transparency for PNG/WebP
                imagesavealpha($dst, true);
                $trans_col = imagecolorallocatealpha($dst, 0, 0, 0, 127);
                imagefill($dst, 0, 0, $trans_col);
                $w = imagesx($src);
                $h = imagesy($src);
                imagecopyresampled($dst, $src, 0, 0, 0, 0, $size, $size, $w, $h);

                // prefer webp if available
                if (function_exists('imagewebp')) {
                    $ext = 'webp';
                    $foto_baru = $nama_panggilan . '.' . $ext;
                    imagewebp($dst, __DIR__ . "/../img/profile/" . $foto_baru, 80);
                } else {
                    $ext = 'jpg';
                    $foto_baru = $nama_panggilan . '.' . $ext;
                    imagejpeg($dst, __DIR__ . "/../img/profile/" . $foto_baru, 85);
                }

                $__img_destroy = 'imagedestroy';
                if (function_exists($__img_destroy)) { $__img_destroy($src); }
                if (function_exists($__img_destroy)) { $__img_destroy($dst); }
            } else {
                // GD not available: determine extension from mime and save raw bytes
                $ext = 'jpg';
                if ($mime === 'image/webp') $ext = 'webp';
                elseif ($mime === 'image/png') $ext = 'png';
                elseif ($mime === 'image/jpeg' || $mime === 'image/jpg') $ext = 'jpg';
                $foto_baru = $nama_panggilan . '.' . $ext;
                $dest = __DIR__ . "/../img/profile/" . $foto_baru;
                file_put_contents($dest, $decoded);
            }
        }

    } elseif (!empty($_FILES['foto_file']['name'])) {

        $nama_file = $_FILES['foto_file']['name'];
        $tmp_file  = $_FILES['foto_file']['tmp_name'];
        $ext       = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ext, $allowed)) {
            // fallback: move uploaded then try to compress using GD
            $foto_baru = $nama_panggilan . '.' . $ext;
            $dest_path = __DIR__ . "/../img/profile/" . $foto_baru;
            move_uploaded_file($tmp_file, $dest_path);
            // attempt to compress/resize
            // attempt to compress/resize if GD available
            if (function_exists('imagecreatefromstring')) {
                $src = @imagecreatefromstring(file_get_contents($dest_path));
                if ($src !== false) {
                    $size = 512;
                    $dst = imagecreatetruecolor($size, $size);
                    imagesavealpha($dst, true);
                    $trans_col = imagecolorallocatealpha($dst, 0, 0, 0, 127);
                    imagefill($dst, 0, 0, $trans_col);
                    $w = imagesx($src);
                    $h = imagesy($src);
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $size, $size, $w, $h);
                    if (function_exists('imagewebp')) {
                        imagewebp($dst, $dest_path, 80);
                    } else {
                        imagejpeg($dst, $dest_path, 85);
                    }
                        $__img_destroy = 'imagedestroy';
                        if (function_exists($__img_destroy)) { $__img_destroy($src); }
                        if (function_exists($__img_destroy)) { $__img_destroy($dst); }
                }
            }
        } else {
            die("Format foto tidak valid!");
        }
    }


    mysqli_query($koneksi, "UPDATE mahasiswa SET 
        nama_lengkap='{$_POST['nama_lengkap']}',
        bio='{$_POST['bio']}',
        foto='$foto_baru'
        WHERE user_id='$user_id'
    ");

    mysqli_query($koneksi, "UPDATE users SET 
        email='{$_POST['email']}',
        password='{$_POST['password']}'
        WHERE id='$user_id'
    ");

      $redirect = "../dashboard/profile.php";
           

          

        
    

    echo "
    <!DOCTYPE html>
    <html>
    <head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Dashboard - SD Inpres Maccini Sombala 1</title>
    <link rel='icon' href='../img/main/icon.png' />
  <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap' rel='stylesheet'>
    <style>
        body { font-family: 'Poppins', sans-serif !important; }
    </style>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
   Swal.fire({
    title: 'Berhasil!',
    text: 'Data berhasil diperbarui!',
    icon: 'success',
    allowOutsideClick: false,
    allowEscapeKey: false,
    confirmButtonText: 'OK'
}).then(() => {
    window.location.href = '$redirect';
});
</script>

    </body>
    </html>";
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <style>
        .rotate-180 {
            transform: rotate(180deg);
        }

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
                            <a href="../dashboard/db_mahasiswa.php"
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
        <div class="bg-white rounded-lg border border-gray-200 p-6">

            <form class="space-y-6" method="POST" enctype="multipart/form-data">
                <div class="border-b border-gray-200 pb-6">
                    

                    
                        <h3 class="text-xl font-bold mb-6">Edit Mahasiswa</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="<?= $data['nama_lengkap']; ?>"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="text" name="email" value="<?= $data['email']; ?>"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="text" name="password" value="<?= $data['password']; ?>"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400" min="8" required>
                        </div>
                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                            <input name="bio" value="<?= $data['bio']; ?>"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400"></input>
                        </div>
                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
                            <input type="file" id="foto-input" name="foto_file" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400">
                            <input type="hidden" name="foto_data" id="foto_data">
                            <input type="hidden" name="current_foto" value="<?= htmlspecialchars($data['foto']); ?>">
                            <br>
                            <div class="flex items-center space-x-4">
                                <img id="current-preview" src="../img/profile/<?php echo htmlspecialchars($data['foto']); ?>" class="img-fluid rounded" style="width:120px; height:120px; object-fit:cover;" />
                                <div>
                                    <button type="button" id="open-cropper" class="px-3 py-1 bg-gray-200 rounded text-sm hidden">Buka Cropper</button>
                                </div>
                            </div>

                            <!-- Cropper modal-ish area -->
                            <div id="cropper-area" class="mt-4 hidden">
                                <div class="flex space-x-4">
                                    <div style="width:320px; height:320px; background:#f3f4f6; display:flex; align-items:center; justify-content:center;">
                                        <img id="crop-image" style="max-width:100%; display:block;" />
                                    </div>
                                    <div class="space-y-2">
                                        <div class="border p-2 rounded" style="width:160px; height:160px; overflow:hidden;">
                                            <div class="preview-wrapper" style="width:100%; height:100%;">
                                                <img id="preview" style="width:100%; height:100%; object-fit:cover; display:block;" />
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button type="button" id="zoom-in" class="px-3 py-1 bg-gray-200 rounded">+</button>
                                            <button type="button" id="zoom-out" class="px-3 py-1 bg-gray-200 rounded">-</button>
                                            <button type="button" id="rotate-left" class="px-3 py-1 bg-gray-200 rounded">⟲</button>
                                            <button type="button" id="rotate-right" class="px-3 py-1 bg-gray-200 rounded">⟳</button>
                                        </div>
                                        <div>
                                            <button type="button" id="apply-crop" class="mt-2 px-3 py-1 bg-indigo-700 text-white rounded">Gunakan Foto</button>
                                            <button type="button" id="cancel-crop" class="mt-2 ml-2 px-3 py-1 bg-gray-200 rounded">Batal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                  
                   
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button"
                        class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                    <button type="submit" name="update"
                        class="px-6 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700">Submit</button>
                </div>
            </form>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
        // Image cropper for profile foto
        (function(){
            const fotoInput = document.getElementById('foto-input');
            const cropperArea = document.getElementById('cropper-area');
            const cropImage = document.getElementById('crop-image');
            const currentPreview = document.getElementById('current-preview');
            const fotoDataInput = document.getElementById('foto_data');
            const applyBtn = document.getElementById('apply-crop');
            const cancelBtn = document.getElementById('cancel-crop');
            const zoomIn = document.getElementById('zoom-in');
            const zoomOut = document.getElementById('zoom-out');
            const rotL = document.getElementById('rotate-left');
            const rotR = document.getElementById('rotate-right');
            let cropper = null;
            const form = document.querySelector('form.space-y-6');

            function initCropper() {
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(cropImage, {
                    aspectRatio: 1,
                    viewMode: 1,
                    background: false,
                    autoCropArea: 1,
                    responsive: true,
                    preview: '.preview-wrapper'
                });
            }

            fotoInput.addEventListener('change', (e) => {
                const file = e.target.files && e.target.files[0];
                if (!file) return;
                const url = URL.createObjectURL(file);
                cropImage.src = url;
                cropperArea.classList.remove('hidden');
                cropImage.onload = () => {
                    initCropper();
                };
            });

            zoomIn.addEventListener('click', () => { if (cropper) cropper.zoom(0.1); });
            zoomOut.addEventListener('click', () => { if (cropper) cropper.zoom(-0.1); });
            rotL.addEventListener('click', () => { if (cropper) cropper.rotate(-90); });
            rotR.addEventListener('click', () => { if (cropper) cropper.rotate(90); });

            cancelBtn.addEventListener('click', () => {
                if (cropper) { cropper.destroy(); cropper = null; }
                cropperArea.classList.add('hidden');
                fotoInput.value = '';
            });

            applyBtn.addEventListener('click', () => {
                if (!cropper) return;
                const canvas = cropper.getCroppedCanvas({ width: 512, height: 512, imageSmoothingQuality: 'high' });
                canvas.toBlob((blob) => {
                    const reader = new FileReader();
                    reader.onloadend = () => {
                        fotoDataInput.value = reader.result; // base64 data URL
                        currentPreview.src = reader.result;
                        if (cropper) { cropper.destroy(); cropper = null; }
                        cropperArea.classList.add('hidden');
                    };
                    reader.readAsDataURL(blob);
                }, 'image/webp', 0.8);
            });

            form.addEventListener('submit', function(e){
                if (cropper && !fotoDataInput.value) {
                    e.preventDefault();
                    const canvas = cropper.getCroppedCanvas({ width: 512, height: 512, imageSmoothingQuality: 'high' });
                    canvas.toBlob((blob) => {
                        const reader = new FileReader();
                        reader.onloadend = () => {
                            fotoDataInput.value = reader.result;
                            if (cropper) { cropper.destroy(); cropper = null; }
                            cropperArea.classList.add('hidden');
                            form.submit();
                        };
                        reader.readAsDataURL(blob);
                    }, 'image/webp', 0.8);
                }
            });
        })();
    </script>
</body>

</html>