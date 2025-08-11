<?php
include_once __DIR__ . '/db.php';
include_once __DIR__ . '/admin_header.php';

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

<div class="flex justify-center items-center min-h-[80vh]">
    <form class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md" method="post" action="register.php">
        <h2 class="text-3xl font-bold mb-8 text-center text-black">Register Admin</h2>

        <?php if ($error): ?>
            <div class="mb-4 text-red-500 text-center"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-center font-semibold"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="mb-5">
            <label for="name" class="block mb-2 font-semibold text-black">Nama</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-amber-500 text-black" required>
        </div>
        <div class="mb-5">
            <label for="email" class="block mb-2 font-semibold text-black">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-amber-500 text-black" required>
        </div>
        <div class="mb-5">
            <label for="password" class="block mb-2 font-semibold text-black">Password</label>
            <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-amber-500 text-black" required>
        </div>
        <div class="mb-8">
            <label for="confirm" class="block mb-2 font-semibold text-black">Konfirmasi Password</label>
            <input type="password" id="confirm" name="confirm" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-amber-500 text-black" required>
        </div>
        <button type="submit" class="w-full bg-[#de8500] hover:bg-[#b96c00] text-white font-bold py-3 px-4 rounded transition text-lg">Register</button>

        <div class="mt-6 text-center text-sm">
            Sudah punya akun? <a href="login.php" class="text-amber-700 hover:underline font-semibold">Login di sini</a>
        </div>
    </form>
</div>

<?php include_once __DIR__ . '/admin_footer.php'; ?>
