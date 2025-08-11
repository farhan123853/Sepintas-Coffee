<?php
// Form dan proses register user (ADMIN)
error_reporting(E_ALL);
ini_set('display_errors', 1);


include_once __DIR__ . '/db.php';

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
<section class="py-16 min-h-screen bg-gradient-to-br from-amber-100 via-white to-amber-200 flex items-center justify-center">
    <div class="max-w-md w-full bg-white/90 p-8 rounded-xl shadow-lg border border-amber-200">
        <h2 class="text-3xl font-bold mb-6 text-center text-amber-900">Register User</h2>
        <?php if ($error): ?><div class="mb-4 text-red-500 text-center"><?php echo $error; ?></div><?php endif; ?>
        <?php if ($success): ?><div class="mb-4 text-green-600 text-center"><?php echo $success; ?></div><?php endif; ?>
        <form method="post" autocomplete="off">
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-amber-900">Nama</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-amber-400" value="<?php echo htmlspecialchars($name); ?>">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-amber-900">Email</label>
                <input type="email" name="email" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-amber-400" value="<?php echo htmlspecialchars($email); ?>">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-amber-900">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>
            <div class="mb-6">
                <label class="block mb-1 font-semibold text-amber-900">Konfirmasi Password</label>
                <input type="password" name="confirm" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>
            <button type="submit" class="w-full bg-amber-700 hover:bg-amber-800 text-white px-4 py-2 rounded font-bold transition">Register</button>
        </form>
        <div class="mt-4 text-center text-sm">
            Sudah punya akun? <a href="admin/login.php" class="text-amber-700 hover:underline font-semibold">Login di sini</a>
        </div>
    </div>
</section>