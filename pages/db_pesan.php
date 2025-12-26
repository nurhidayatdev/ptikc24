<?php
include '../koneksi.php'; // Sesuaikan path koneksi Anda

// Logika Hapus Pesan jika tombol hapus diklik
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM pesan WHERE id = '$id'");
    header("Location: pesan.php"); // Refresh halaman
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pesan Anonim</title>
    <link href="../frontend/tailwind/src/output.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen">

    <div class="container mx-auto px-4 py-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Dinding Pesan Anonim</h1>
                <p class="text-sm text-slate-500">Melihat apa yang dibicarakan secara rahasia di kelas PTIK C.</p>
            </div>
            <a href="../../index.php" class="text-sm bg-white border border-slate-200 px-4 py-2 rounded-lg hover:bg-slate-100 transition inline-block text-center">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
            </a>
        </div>

        <div class="columns-1 sm:columns-2 lg:columns-4 gap-6 space-y-6">
            <?php
            $query = mysqli_query($koneksi, "SELECT * FROM pesan ORDER BY tanggal DESC");
            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
            ?>
                <div class="break-inside-avoid bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-4">
                        <div class="bg-indigo-100 text-indigo-600 p-2 rounded-lg text-xs">
                            <i class="fas fa-user-secret text-lg"></i>
                        </div>
                        <a href="?hapus=<?php echo $row['id']; ?>" 
                           onclick="return confirm('Hapus pesan ini?')"
                           class="text-slate-300 hover:text-red-500 transition">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                    
                    <p class="text-slate-700 leading-relaxed text-sm mb-4">
                        "<?php echo nl2br($row['isi_pesan']); ?>"
                    </p>

                    <div class="pt-4 border-t border-slate-50 flex items-center justify-between">
                        <span class="text-[10px] font-medium text-slate-400 italic">
                            Sent anonymously
                        </span>
                        <span class="text-[10px] text-slate-400">
                            <?php echo date('d M, H:i', strtotime($row['tanggal'])); ?>
                        </span>
                    </div>
                </div>
            <?php 
                } 
            } else {
                echo '<div class="col-span-full text-center py-20 text-slate-400 italic">Belum ada pesan yang masuk...</div>';
            }
            ?>
        </div>
    </div>

</body>
</html>