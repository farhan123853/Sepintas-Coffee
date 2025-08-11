<?php
session_start();
if (isset($_SESSION['admin'])) {
    if (isset($_GET['login']) && $_GET['login'] == 'success') {
        $login_success = true;
    } else {
        header('Location: dashboard.php');
        exit;
    }
} else {
    $login_success = false;
}
include __DIR__ . '/db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $pass = $_POST['password'];
    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($row = $result->fetch_assoc()) {
        if (password_verify($pass, $row['password_hash'])) {
            $_SESSION['admin'] = $row['user_id'];
            header('Location: dashboard.php?login=success');
            exit;
        } else {
            $error = 'Password salah!';
        }
    } else {
        $error = 'Email tidak ditemukan!';
    }
}
?>
<?php include 'admin_header.php'; ?>
<div class="flex justify-center items-center min-h-[80vh]">
    <form class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md" method="post" action="login.php">
        <h2 class="text-3xl font-bold mb-8 text-center text-black">Admin Login</h2>
        <?php if ($error): ?><div class="mb-4 text-red-500 text-center"><?php echo $error; ?></div><?php endif; ?>
        <?php if (isset($_GET['login']) && $_GET['login'] == 'success'): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-center font-semibold">Login berhasil! Selamat datang di dashboard admin.</div>
        <?php endif; ?>
        <div class="mb-5">
            <label for="email" class="block mb-2 font-semibold text-black">Email</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-amber-500 text-black" required>
        </div>
        <div class="mb-8">
            <label for="password" class="block mb-2 font-semibold text-black">Password</label>
            <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-amber-500 text-black" required>
        </div>
        <button type="submit" class="w-full bg-[#de8500] hover:bg-[#b96c00] text-white font-bold py-3 px-4 rounded transition text-lg">Login</button>
        <?php if (isset($_GET['login']) && $_GET['login'] == 'success'): ?>
            <a href="dashboard.php" class="w-full mt-4 block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-semibold text-center">Ke Dashboard Admin</a>
        <?php endif; ?>
        <div class="mt-6 text-center text-sm">
            Belum punya akun? <a href="register_form.php" class="text-amber-700 hover:underline font-semibold">Register di sini</a>
        </div>
    </form>
</div>
<?php include 'admin_footer.php'; ?>