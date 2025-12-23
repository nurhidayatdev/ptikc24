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

// Ambil daftar mata kuliah yang punya kelompok tersimpan
$matkuls_res = mysqli_query($koneksi, "SELECT DISTINCT k.matkul_id AS id, mk.kode_matkul, mk.nama_matkul
	FROM kelompok k
	JOIN mata_kuliah mk ON k.matkul_id = mk.id
	ORDER BY mk.semester, mk.nama_matkul");

$selected_matkul = intval($_GET['matkul_id'] ?? 0);
$groups = [];
$student_map = [];

if ($selected_matkul) {
	$stmt = mysqli_prepare($koneksi, "SELECT kelompok_no, anggota FROM kelompok WHERE matkul_id = ? ORDER BY kelompok_no");
	mysqli_stmt_bind_param($stmt, 'i', $selected_matkul);
	mysqli_stmt_execute($stmt);
	$res = mysqli_stmt_get_result($stmt);
	while ($r = mysqli_fetch_assoc($res)) {
		$groups[] = $r;
	}

	// Kumpulkan semua NIM dari semua kelompok, lalu ambil nama mahasiswa
	$all_nims = [];
	foreach ($groups as $g) {
		$parts = array_filter(array_map('trim', explode(',', $g['anggota'])));
		foreach ($parts as $nim) {
			if ($nim !== '') $all_nims[$nim] = true;
		}
	}

	if (count($all_nims) > 0) {
		$escaped = array_map(function($s) use ($koneksi) { return "'" . mysqli_real_escape_string($koneksi, $s) . "'"; }, array_keys($all_nims));
		$inlist = implode(',', $escaped);
		$res2 = mysqli_query($koneksi, "SELECT nim, nama_lengkap FROM mahasiswa WHERE nim IN ($inlist)");
		while ($r = mysqli_fetch_assoc($res2)) {
			$student_map[$r['nim']] = $r['nama_lengkap'];
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Kelompok Tersimpan - PTIK C</title>
	<link href="../../frontend/tailwind/src/output.css" rel="stylesheet">
	<link href="../../frontend/tailwind/src/input.css" rel="stylesheet">
</head>
<body class="bg-slate-100">
<main class="ml-0 lg:ml-48 pt-20 p-6">
	<div class="bg-white rounded-lg border border-slate-200 p-6">
		<h3 class="text-xl font-bold text-slate-800 mb-4">Kelompok yang Tersimpan</h3>

		<form id="selectForm" method="GET" class="mb-4">
			<label class="text-xs block mb-1">Pilih Mata Kuliah (yang punya kelompok tersimpan)</label>
			<select id="mata_kuliah" name="matkul_id" class="w-full px-3 py-2 border rounded">
				<option value="">-- Pilih --</option>
				<?php while ($mk = mysqli_fetch_assoc($matkuls_res)) : ?>
					<option value="<?= $mk['id'] ?>" <?= ($mk['id'] == $selected_matkul) ? 'selected' : '' ?>><?= htmlspecialchars($mk['kode_matkul'].' - '.$mk['nama_matkul']) ?></option>
				<?php endwhile; ?>
			</select>
		</form>

		<?php if ($selected_matkul): ?>
			<?php if (count($groups) === 0): ?>
				<div class="p-4 bg-yellow-100 text-yellow-800">Tidak ada kelompok tersimpan untuk mata kuliah ini.</div>
			<?php else: ?>
				<div id="groupsContainer" class="flex flex-wrap gap-4 justify-between">
					<?php foreach ($groups as $idx => $g): ?>
						<div class="p-4 border rounded bg-slate-50 w-56">
							<h4 class="font-semibold mb-2">Kelompok <?= htmlspecialchars($g['kelompok_no']) ?></h4>
							<ul class="list-disc pl-5 text-sm">
								<?php
								$parts = array_filter(array_map('trim', explode(',', $g['anggota'])));
								foreach ($parts as $nim):
									$name = $student_map[$nim] ?? $nim;
								?>
									<li><?= htmlspecialchars($name) ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		<?php else: ?>
			<div class="p-3 text-sm text-slate-600">Pilih mata kuliah untuk melihat kelompok yang tersimpan.</div>
		<?php endif; ?>

	</div>
	<footer class="text-xs text-indigo-900 text-center mb-0 pb-0 mt-6">© 2025 Kelas PTIK C</footer>
</main>

<script>
document.getElementById('mata_kuliah').addEventListener('change', function(){ document.getElementById('selectForm').submit(); });
</script>

</body>
</html>

