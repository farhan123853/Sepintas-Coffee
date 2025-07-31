<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
include '../includes/db.php';
include 'admin_header.php';

// Handle add/edit/delete
// Notifikasi sukses
$notif = '';
if (isset($_POST['save'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $desc = $conn->real_escape_string($_POST['description']);
    $price = intval($_POST['price']);
    $cat = $conn->real_escape_string($_POST['category']);
    $img = '';
    if (isset($_POST['menu_id']) && $_POST['menu_id']) {
        // Edit mode
        $id = intval($_POST['menu_id']);
        if (isset($_FILES['image_file']) && $_FILES['image_file']['size'] > 0) {
            $ext = strtolower(pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                $img_name = 'menu_' . time() . '_' . rand(100, 999) . '.' . $ext;
                move_uploaded_file($_FILES['image_file']['tmp_name'], '../assets/images/' . $img_name);
                $img = 'assets/images/' . $img_name;
            }
        } else {
            $img = $conn->real_escape_string($_POST['image_url']);
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
            $img = $conn->real_escape_string($_POST['image_url']);
        }
        $conn->query("INSERT INTO menu (name, description, price, category, image_url) VALUES ('$name','$desc',$price,'$cat','$img')");
    }
    $notif = 'Menu berhasil disimpan!';
    // Setelah simpan, reload agar form kosong dan notif muncul
    echo "<script>window.location='menu_crud.php?notif=1';</script>";
    exit;
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM menu WHERE menu_id=$id");
    header('Location: menu_crud.php');
    exit;
}
// Edit mode
$edit = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $res = $conn->query("SELECT * FROM menu WHERE menu_id=$id");
    $edit = $res->fetch_assoc();
}
// List menu
$menus = $conn->query("SELECT * FROM menu ORDER BY menu_id DESC");
if (isset($_GET['notif']) && $_GET['notif'] == '1') {
    $notif = 'Menu berhasil disimpan!';
}
?>
<h2 class="text-2xl font-bold mb-6 text-white">Kelola Menu</h2>
<?php if ($notif): ?>
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-center font-semibold"><?php echo $notif; ?></div>
<?php endif; ?>

<div class="mb-8">
    <form method="post" enctype="multipart/form-data" class="bg-white p-6 rounded shadow grid grid-cols-1 md:grid-cols-2 gap-4" onsubmit="return validateMenuForm()">
        <input type="hidden" name="menu_id" value="<?php echo $edit ? $edit['menu_id'] : ''; ?>">
        <div>
            <label class="block mb-1">ID Menu</label>
            <input type="text" name="menu_id_display" value="<?php echo $edit ? $edit['menu_id'] : 'Auto'; ?>" class="w-full px-3 py-2 border border-black rounded bg-gray-100" readonly>
        </div>
        <div>
            <label class="block mb-1">Nama Menu</label>
            <input type="text" name="name" required class="w-full px-3 py-2 border border-black rounded" value="<?php echo $edit ? $edit['name'] : ''; ?>">
        </div>
        <div>
            <label class="block mb-1">Kategori</label>
            <select name="category" required class="w-full px-3 py-2 border border-black rounded">
                <?php $cats = ['coffee', 'non-coffee', 'pastry', 'smoothies'];
                foreach ($cats as $c): ?>
                    <option value="<?php echo $c; ?>" <?php if ($edit && $edit['category'] == $c) echo 'selected'; ?>><?php echo ucfirst($c); ?></option>
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