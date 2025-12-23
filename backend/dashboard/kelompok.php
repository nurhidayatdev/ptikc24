<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$nama_lengkap = $_SESSION['nama_lengkap'];
$foto = $_SESSION['foto'];

// Handle save
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save') {
    $mata_kuliah_id = intval($_POST['mata_kuliah_id'] ?? 0);
    $groups_json = $_POST['groups_json'] ?? '[]';
    $groups = json_decode($groups_json, true);

    if ($mata_kuliah_id && is_array($groups)) {
        // Remove existing groups for this mata kuliah
        $stmt = mysqli_prepare($koneksi, "DELETE FROM kelompok WHERE matkul_id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $mata_kuliah_id);
        mysqli_stmt_execute($stmt);

        // Insert new groups
        $insert = mysqli_prepare($koneksi, "INSERT INTO kelompok (matkul_id, kelompok_no, anggota) VALUES (?, ?, ?)");
        foreach ($groups as $no => $anggotaArr) {
            $anggotaStr = implode(',', array_map(function($s){ return $s['nim']; }, $anggotaArr));
            $kel_no = $no + 1;
            mysqli_stmt_bind_param($insert, 'iis', $mata_kuliah_id, $kel_no, $anggotaStr);
            mysqli_stmt_execute($insert);
        }

        $_SESSION['flash'] = "Kelompok berhasil disimpan.";
        header("Location: db_kelompok.php");
        exit;
    } else {
        $_SESSION['flash'] = "Data tidak valid.";
        header("Location: db_kelompok.php");
        exit;
    }
}

$matkuls = mysqli_query($koneksi, "SELECT DISTINCT jm.matkul_id AS id, mk.kode_matkul, mk.nama_matkul
    FROM jadwal_matkul jm
    JOIN mata_kuliah mk ON jm.matkul_id = mk.id
    ORDER BY mk.semester, mk.nama_matkul");

// Determine selected matkul from GET so we can load only mahasiswa yang mengambil matkul ini (dari krs)
$selected_matkul = intval($_GET['matkul_id'] ?? 0);
$students = [];
if ($selected_matkul) {
    $stmt = mysqli_prepare($koneksi, "SELECT m.nim, m.nama_lengkap FROM krs k JOIN mahasiswa m ON k.mahasiswa_id = m.id WHERE k.matkul_id = ? ORDER BY m.nim");
    mysqli_stmt_bind_param($stmt, 'i', $selected_matkul);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($r = mysqli_fetch_assoc($res)) {
        $students[] = $r;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Kelompok - PTIK C</title>
    <link href="../../frontend/tailwind/src/output.css" rel="stylesheet">
    <link href="../../frontend/tailwind/src/input.css" rel="stylesheet">
</head>
<body class="bg-slate-100">
<?php if (!empty($_SESSION['flash'])): ?>
    <div class="p-4 bg-green-200 text-green-800 text-sm"><?= htmlspecialchars($_SESSION['flash']); ?></div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<main class="ml-0 lg:ml-48 pt-20 p-6">
    <div class="bg-white rounded-lg border border-slate-200 p-6">
        <h3 class="text-xl font-bold text-slate-800 mb-4">Pengaturan Kelompok</h3>

        <form id="selectForm" method="GET" class="mb-4">
            <label class="text-xs block mb-1">Pilih Mata Kuliah</label>
            <select id="mata_kuliah" name="matkul_id" class="w-full px-3 py-2 border rounded">
                <option value="">-- Pilih --</option>
                <?php while ($mk = mysqli_fetch_assoc($matkuls)) : ?>
                    <option value="<?= $mk['id'] ?>" <?= ($mk['id'] == $selected_matkul) ? 'selected' : '' ?>><?= htmlspecialchars($mk['kode_matkul'].' - '.$mk['nama_matkul']) ?></option>
                <?php endwhile; ?>
            </select>
        </form>

        <form id="kelompokForm" method="POST">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="mata_kuliah_id" id="mata_kuliah_hidden" value="<?= $selected_matkul ?>">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="text-xs">Jumlah Orang per Kelompok</label>
                    <input id="per_group" type="number" min="1" value="3" class="w-full px-3 py-2 border rounded" />
                </div>

                <div class="flex items-end gap-2">
                    <button id="acakBtn" type="button" class="bg-yellow-400 px-4 py-2 rounded">Acak</button>
                    <button id="manualBtn" type="button" class="bg-blue-500 text-white px-4 py-2 rounded">Buat Manual</button>
                    <button id="simpanBtn" type="submit" class="bg-indigo-900 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </div>

            <input type="hidden" name="groups_json" id="groups_json" value="[]">

            <div id="groupsContainer" class="flex flex-wrap gap-4 justify-between"></div>
        </form>
    </div>
    <footer class="text-xs text-indigo-900 text-center mb-0 pb-0 mt-6">© 2025 Kelas PTIK C</footer>
</main>

<script>
// Students data from PHP (only those who took selected matkul via KRS)
const students = <?= json_encode($students, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;

function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
}

function makeGroups(perGroup) {
    const copy = students.slice();
    shuffleArray(copy);
    const groups = [];
    for (let i = 0; i < copy.length; i += perGroup) {
        groups.push(copy.slice(i, i + perGroup));
    }
    return groups;
}

function renderGroups(groups) {
    currentGroups = groups;
    const container = document.getElementById('groupsContainer');
    container.innerHTML = '';
    groups.forEach((g, idx) => {
        const div = document.createElement('div');
        div.className = 'p-4 border rounded bg-slate-50 w-56';
        const title = document.createElement('h4');
        title.className = 'font-semibold mb-2';
        title.textContent = 'Kelompok ' + (idx + 1);
        div.appendChild(title);
        const ul = document.createElement('ul');
        ul.className = 'list-disc pl-5 text-sm';
        g.forEach(s => {
            const li = document.createElement('li');
            li.textContent = s.nama_lengkap;
            ul.appendChild(li);
        });
        div.appendChild(ul);
        container.appendChild(div);
    });
    document.getElementById('groups_json').value = JSON.stringify(groups);
}

// Render editable groups for manual creation
let currentGroups = [];
function renderEditable(groups) {
    currentGroups = groups;
    const container = document.getElementById('groupsContainer');
    container.innerHTML = '';

    function getAvailableStudents() {
        const used = {};
        currentGroups.forEach(g => g.forEach(m => { if (m && m.nim) used[m.nim] = true; }));
        return students.filter(s => !used[s.nim]);
    }

    groups.forEach((g, idx) => {
        const div = document.createElement('div');
        div.className = 'p-4 border rounded bg-slate-50 w-56 flex flex-col';
        const title = document.createElement('h4');
        title.className = 'font-semibold mb-2';
        title.textContent = 'Kelompok ' + (idx + 1);
        div.appendChild(title);

        const ul = document.createElement('ul');
        ul.className = 'list-disc pl-5 text-sm mb-2';
        (g || []).forEach((s, si) => {
            const li = document.createElement('li');
            li.className = 'flex justify-between items-center';
            const span = document.createElement('span');
            span.textContent = s.nama_lengkap || s;
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'text-red-600 ml-2 text-xs';
            btn.textContent = 'Hapus';
            btn.addEventListener('click', () => {
                currentGroups[idx].splice(si, 1);
                renderEditable(currentGroups);
            });
            li.appendChild(span);
            li.appendChild(btn);
            ul.appendChild(li);
        });
        div.appendChild(ul);

        // Add from available students
        const avail = getAvailableStudents();
        const select = document.createElement('select');
        select.className = 'w-full px-2 py-1 border rounded text-sm mb-1';
        const opt0 = document.createElement('option'); opt0.value=''; opt0.textContent='Tambah dari daftar...'; select.appendChild(opt0);
        avail.forEach(s => { const o = document.createElement('option'); o.value = s.nim; o.textContent = s.nama_lengkap; select.appendChild(o); });
        const addBtn = document.createElement('button');
        addBtn.type='button';
        addBtn.className='bg-green-600 text-white px-2 py-1 rounded text-sm';
        addBtn.textContent='Tambah';
        addBtn.addEventListener('click', () => {
            const val = select.value;
            if (!val) return;
            const stu = students.find(x=>x.nim===val);
            if (stu) {
                currentGroups[idx].push(stu);
                // reset select so user sees it's added
                select.value = '';
                renderEditable(currentGroups);
            }
        });
        div.appendChild(select);
        div.appendChild(addBtn);

        container.appendChild(div);
    });
    document.getElementById('groups_json').value = JSON.stringify(currentGroups);
}

document.getElementById('acakBtn').addEventListener('click', () => {
    const per = parseInt(document.getElementById('per_group').value) || 1;
    const groups = makeGroups(per);
    currentGroups = groups;
    renderGroups(groups);
});

document.getElementById('manualBtn').addEventListener('click', () => {
    const per = parseInt(document.getElementById('per_group').value) || 1;
    const n = Math.max(1, Math.ceil((students.length || 0) / per));
    const groups = [];
    for (let i = 0; i < n; i++) groups.push([]);
    renderEditable(groups);
});

// Auto-submit select to reload students list
document.getElementById('mata_kuliah').addEventListener('change', function(){
    document.getElementById('selectForm').submit();
});

// Ensure hidden matkul id updates before save
document.getElementById('kelompokForm').addEventListener('submit', function(){
    const selectVal = document.getElementById('mata_kuliah').value || document.getElementById('mata_kuliah_hidden').value;
    document.getElementById('mata_kuliah_hidden').value = selectVal;
});

// When form submits, ensure a matkul is selected and groups_json present
document.getElementById('kelompokForm').addEventListener('submit', function(e){
    const matkul = document.getElementById('mata_kuliah').value;
    if (!matkul) {
        e.preventDefault();
        alert('Pilih mata kuliah terlebih dahulu.');
        return false;
    }
    const groupsVal = document.getElementById('groups_json').value || '[]';
    const groups = JSON.parse(groupsVal);
    if (!Array.isArray(groups) || groups.length === 0) {
        e.preventDefault();
        alert('Belum ada pembagian kelompok. Tekan tombol "Acak" terlebih dahulu.');
        return false;
    }
    // Append selected mata kuliah id into form as name expected by server
    // The select already has name="mata_kuliah_id"
    return true;
});
</script>

</body>
</html>
