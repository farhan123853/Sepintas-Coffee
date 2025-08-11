<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
include __DIR__ . '/db.php';
include 'admin_header.php';

$notif = '';
// Proses hapus menu
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM menu WHERE menu_id=$id");
    header('Location: menu_crud.php?notif=delete');
    exit;
}

if (isset($_POST['save'])) {
    $name = $conn->real_escape_string($_POST['name'] ?? '');
    $desc = $conn->real_escape_string($_POST['description'] ?? '');
    $price = intval($_POST['price'] ?? 0);
    $cat = $conn->real_escape_string($_POST['category'] ?? '');
    $img = '';

    if (isset($_POST['menu_id']) && $_POST['menu_id']) {
        $id = intval($_POST['menu_id']);
        if (isset($_FILES['image_file']) && $_FILES['image_file']['size'] > 0) {
            $ext = strtolower(pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                $img_name = 'menu_' . time() . '_' . rand(100, 999) . '.' . $ext;
                move_uploaded_file($_FILES['image_file']['tmp_name'], '../assets/images/' . $img_name);
                $img = 'assets/images/' . $img_name;
            }
        } else {
            $img = $conn->real_escape_string($_POST['image_url'] ?? '');
        }
        $conn->query("UPDATE menu SET name='$name', description='$desc', price=$price, category='$cat', image_url='$img' WHERE menu_id=$id");
    } else {
        if (isset($_FILES['image_file']) && $_FILES['image_file']['size'] > 0) {
            $ext = strtolower(pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                $img_name = 'menu_' . time() . '_' . rand(100, 999) . '.' . $ext;
                move_uploaded_file($_FILES['image_file']['tmp_name'], '../assets/images/' . $img_name);
                $img = 'assets/images/' . $img_name;
            }
        } else {
            $img = $conn->real_escape_string($_POST['image_url'] ?? '');
        }
        $conn->query("INSERT INTO menu (name, description, price, category, image_url) VALUES ('$name','$desc',$price,'$cat','$img')");
    }

    $notif = 'Menu berhasil di tambahkan!';
    echo "<script>window.location='menu_crud.php?notif=1';</script>";
    exit;
}

if (isset($_GET['notif'])) {
    switch ($_GET['notif']) {
        case 'add':
            $notif = ['text' => 'Menu berhasil ditambahkan!', 'color' => 'bg-green-100 text-green-700'];
            break;
        case 'edit':
            $notif = ['text' => 'Menu berhasil diedit!', 'color' => 'bg-blue-100 text-blue-700'];
            break;
        case 'delete':
            $notif = ['text' => 'Menu berhasil dihapus!', 'color' => 'bg-red-100 text-red-700'];
            break;
    }
}

$edit = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $res = $conn->query("SELECT * FROM menu WHERE menu_id=$id");
    $edit = $res->fetch_assoc();
}

$menus = $conn->query("SELECT * FROM menu ORDER BY menu_id DESC");
if (isset($_GET['notif']) && $_GET['notif'] == '1') {
    $notif = 'Menu berhasil disimpan!';
}
?>

<h2 class="text-2xl font-bold mb-6 text-white">Menu Penganturan</h2>
<?php if ($notif): ?>
    <div class="mb-4 p-3 
        <?php echo is_array($notif) ? $notif['color'] : 'bg-green-100 text-green-700'; ?> 
        rounded text-center font-semibold">
        <?php echo is_array($notif) ? $notif['text'] : $notif; ?>
    </div>
<?php endif; ?>


<div class="mb-8">
    <form method="post" enctype="multipart/form-data" class="bg-white p-6 rounded shadow grid grid-cols-1 md:grid-cols-2 gap-4" onsubmit="return validateMenuForm()">
        <input type="hidden" name="menu_id" value="<?php echo $edit ? $edit['menu_id'] : ''; ?>">
        <div>
            <label class="block mb-1">Nama Menu</label>
            <input type="text" name="name" required class="w-full px-3 py-2 border border-black rounded" value="<?php echo $edit ? $edit['name'] : ''; ?>">
        </div>
        <div>
            <label class="block mb-1">Kategori</label>
            <select name="category" required class="w-full px-3 py-2 border border-black rounded">
                <?php
                $cats = ['coffee', 'non-coffee', 'snack'];
                foreach ($cats as $c): ?>
                    <option value="<?php echo $c; ?>" <?php if ($edit && $edit['category'] == $c) echo 'selected'; ?>>
                        <?php echo ucfirst($c); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="md:col-span-2">
            <label class="block mb-1">Deskripsi</label>
            <textarea name="description" class="w-full px-3 py-2 border border-black rounded"><?php echo $edit ? $edit['description'] : ''; ?></textarea>
        </div>
        <div>
            <label class="block mb-1">Harga (Rp)</label>
            <input type="number" name="price" required class="w-full px-3 py-2 border border-black rounded" value="<?php echo $edit ? $edit['price'] : ''; ?>">
        </div>
        <div>
            <label class="block mb-1">Upload Gambar (PNG/JPG)</label>
            <input type="file" name="image_file" accept=".jpg,.jpeg,.png" class="w-full px-3 py-2 border border-black rounded" onchange="previewImage(event)">
            <div class="mt-2">
                <img id="img-preview" src="<?php echo ($edit && $edit['image_url']) ? $edit['image_url'] : ''; ?>" alt="Preview" class="w-24 h-24 object-cover border border-black rounded" style="<?php echo ($edit && $edit['image_url']) ? '' : 'display:none;'; ?>">
            </div>
        </div>
        <script>
            function previewImage(event) {
                const [file] = event.target.files;
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        var img = document.getElementById('img-preview');
                        img.src = e.target.result;
                        img.style.display = '';
                    };
                    reader.readAsDataURL(file);
                }
            }

            function validateMenuForm() {
                var name = document.querySelector('input[name="name"]').value.trim();
                var category = document.querySelector('select[name="category"]').value;
                var price = document.querySelector('input[name="price"]').value.trim();
                if (!name) {
                    alert('Nama menu wajib diisi!');
                    return false;
                }
                if (!category) {
                    alert('Kategori wajib dipilih!');
                    return false;
                }
                if (!price || isNaN(price) || parseInt(price) <= 0) {
                    alert('Harga harus diisi dan lebih dari 0!');
                    return false;
                }
                return true;
            }
        </script>
        <div class="md:col-span-2 flex gap-2 justify-end mt-6">
            <button type="submit" name="save" class="bg-amber-400 hover:bg-amber-500 text-black px-6 py-2 rounded font-bold shadow">Simpan</button>
            <?php if ($edit): ?><a href="menu_crud.php" class="bg-amber-200 hover:bg-amber-300 text-black px-6 py-2 rounded font-bold shadow inline-block text-center">Batal</a><?php endif; ?>
        </div>
    </form>
</div>
<div class="overflow-x-auto">
    <table class="w-full bg-white rounded shadow border border-black">
        <thead class="bg-brown-100 border-b-2 border-black">
            <tr>
                <th class="py-2 px-4 border-r border-black">Nama</th>
                <th class="py-2 px-4 border-r border-black">Kategori</th>
                <th class="py-2 px-4 border-r border-black">Harga</th>
                <th class="py-2 px-4 border-r border-black">Gambar</th>
                <th class="py-2 px-4">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($m = $menus->fetch_assoc()): ?>
                <tr class="border-b border-black">
                    <td class="py-2 px-4 border-r border-black align-middle"><?php echo $m['name']; ?></td>
                    <td class="py-2 px-4 border-r border-black align-middle"><?php echo ucfirst($m['category']); ?></td>
                    <td class="py-2 px-4 border-r border-black align-middle">Rp<?php echo number_format($m['price'], 0, ',', '.'); ?></td>
                    <td class="py-2 px-4 border-r border-black align-middle"><img src="<?php echo $m['image_url']; ?>" class="w-16 h-16 object-cover rounded mx-auto"></td>
                    <td class="py-2 px-4 align-middle">
                        <a href="?edit=<?php echo $m['menu_id']; ?>" class="text-blue-600 hover:underline">Edit</a> |
                        <a href="?delete=<?php echo $m['menu_id']; ?>" class="text-red-600 hover:underline" onclick="return confirm('Hapus menu ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include 'admin_footer.php'; ?>