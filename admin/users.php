<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
include __DIR__ . '/db.php';
include 'admin_header.php';

// Handle add/edit/delete
if (isset($_POST['save'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $pass = $_POST['password'];
    if ($_POST['user_id']) {
        $id = intval($_POST['user_id']);
        if ($pass) {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $conn->query("UPDATE users SET name='$name', email='$email', password_hash='$hash' WHERE user_id=$id");
        } else {
            $conn->query("UPDATE users SET name='$name', email='$email' WHERE user_id=$id");
        }
    } else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $conn->query("INSERT INTO users (name, email, password_hash) VALUES ('$name', '$email', '$hash')");
    }
    header('Location: users.php');
    exit;
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE user_id=$id");
    header('Location: users.php');
    exit;
}
// Edit mode
$edit = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $res = $conn->query("SELECT * FROM users WHERE user_id=$id");
    $edit = $res->fetch_assoc();
}
// List users
$users = $conn->query("SELECT * FROM users ORDER BY user_id DESC");
?>
<h2 class="text-2xl font-bold mb-6 text-white">Kelola User</h2>
<div class="mb-8">
    <form method="post" class="bg-white p-6 rounded shadow grid grid-cols-1 md:grid-cols-2 gap-4">
        <input type="hidden" name="user_id" value="<?php echo $edit ? $edit['user_id'] : ''; ?>">
        <div>
            <label class="block mb-1">Nama</label>
            <input type="text" name="name" required class="w-full px-3 py-2 border border-black rounded" value="<?php echo $edit ? $edit['name'] : ''; ?>">
        </div>
        <div>
            <label class="block mb-1">Email</label>
            <input type="email" name="email" required class="w-full px-3 py-2 border border-black rounded" value="<?php echo $edit ? $edit['email'] : ''; ?>">
        </div>
        <div class="md:col-span-2">
            <label class="block mb-1">Password <?php if ($edit) echo '(Kosongkan jika tidak ganti)'; ?></label>
            <input type="password" name="password" class="w-full px-3 py-2 border border-black rounded">
        </div>
        <div class="md:col-span-2 flex gap-2 justify-end mt-6">
            <button type="submit" name="save" class="bg-amber-400 hover:bg-amber-500 text-black px-6 py-2 rounded font-bold shadow">Simpan</button>
            <?php if ($edit): ?><a href="users.php" class="bg-amber-200 hover:bg-amber-300 text-black px-6 py-2 rounded font-bold shadow inline-block text-center">Batal</a><?php endif; ?>
        </div>
    </form>
</div>
<div class="overflow-x-auto">
    <table class="w-full bg-white rounded shadow border border-black">
        <thead class="bg-brown-100 border-b-2 border-black">
            <tr>
                <th class="py-2 px-4 border-r border-black">Nama</th>
                <th class="py-2 px-4 border-r border-black">Email</th>
                <th class="py-2 px-4">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($u = $users->fetch_assoc()): ?>
                <tr class="border-b border-black">
                    <td class="py-2 px-4 border-r border-black align-middle"><?php echo $u['name']; ?></td>
                    <td class="py-2 px-4 border-r border-black align-middle"><?php echo $u['email']; ?></td>
                    <td class="py-2 px-4 align-middle">
                        <a href="?edit=<?php echo $u['user_id']; ?>" class="text-blue-600 hover:underline">Edit</a> |
                        <a href="?delete=<?php echo $u['user_id']; ?>" class="text-red-600 hover:underline" onclick="return confirm('Hapus user ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include 'admin_footer.php'; ?>