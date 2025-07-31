<?php
include 'includes/header.php';
include 'includes/db.php';

$name = $email = $password = $confirm = '';
$error = $success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    if (!$name || !$email || !$password || !$confirm) {
        $error = 'Semua field wajib diisi!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email tidak valid!';
    } elseif ($password !== $confirm) {
        $error = 'Konfirmasi password tidak cocok!';
    } else {
        $cek = $conn->query("SELECT user_id FROM users WHERE email='$email'");
        if ($cek->num_rows > 0) {
            $error = 'Email sudah terdaftar!';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $conn->query("INSERT INTO users (name, email, password_hash) VALUES ('$name', '$email', '$hash')");
            $success = 'Registrasi berhasil! Silakan login.';
            $name = $email = $password = $confirm = '';
        }
    }
}
?>
<section class="py-16 min-h-screen bg-white">
    <div class="max-w-md mx-auto bg-gray-100 p-8 rounded shadow">
        <h2 class="text-2xl font-bold mb-4 text-center">Register User</h2>
        <?php if ($error): ?><div class="mb-4 text-red-500 text-center"><?php echo $error; ?></div><?php endif; ?>
        <?php if ($success): ?><div class="mb-4 text-green-600 text-center"><?php echo $success; ?></div><?php endif; ?>
        <form method="post">
            <div class="mb-4">
                <label class="block mb-1">Nama</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border rounded" value="<?php echo htmlspecialchars($name); ?>">
            </div>
            <div class="mb-4">
                <label class="block mb-1">Email</label>
                <input type="email" name="email" required class="w-full px-4 py-2 border rounded" value="<?php echo htmlspecialchars($email); ?>">
            </div>
            <div class="mb-4">
                <label class="block mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-2 border rounded">
            </div>
            <div class="mb-6">
                <label class="block mb-1">Konfirmasi Password</label>
                <input type="password" name="confirm" required class="w-full px-4 py-2 border rounded">
            </div>
            <button type="submit" class="w-full bg-brown-700 hover:bg-brown-800 text-white px-4 py-2 rounded">Register</button>
        </form>
        <div class="mt-4 text-center text-sm">
            Sudah punya akun? <a href="admin/login.php" class="text-brown-700 hover:underline">Login di sini</a>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>