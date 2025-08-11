<?php
session_start();
include 'header.php';
include '../admin/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$email'");
    $user  = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['customer_id']   = $user['id'];
        $_SESSION['customer_name'] = $user['name'];
        // Arahkan ke halaman beranda utama (di luar folder customer)
        header("Location: ../index.php");
        exit;
    } else {
        echo "<div class='text-red-500 text-center mt-4 font-semibold'>Email atau password salah.</div>";
    }
}
?>

<!-- Background gradient -->
<div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-red-900 via-black to-black">
    <!-- Login card -->
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-red-800">Login Pelanggan</h2>
        <form method="POST" action="" class="space-y-4">
            <input type="email" name="email" placeholder="Email" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-700" />
            <input type="password" name="password" placeholder="Password" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-700" />
            <button type="submit"
                class="w-full bg-red-700 text-white py-2 rounded-lg hover:bg-red-800 transition duration-200 font-semibold">Login</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
