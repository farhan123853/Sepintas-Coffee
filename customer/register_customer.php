<?php
session_start();
include 'header.php';
include '../admin/db.php'; 

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone    = $_POST['phone'];
    $address  = $_POST['address'];

    $check = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $message = "<p class='text-red-500 font-semibold'>Email sudah digunakan.</p>";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO customers (name, email, password, phone, address) 
        VALUES ('$name', '$email', '$password', '$phone', '$address')");
        if ($insert) {
            $message = "<p class='text-green-500 font-semibold'>Registrasi berhasil. <a href='login_customer.php' class='underline text-blue-600'>Login di sini</a></p>";
        } else {
            $message = "<p class='text-red-500 font-semibold'>Gagal mendaftar.</p>";
        }
    }
}
?>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-red-900 to-black px-4">
    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Daftar Akun</h2>
        
        <?= $message ?>

        <form method="POST" action="" class="space-y-4">
            <input type="text" name="name" placeholder="Nama" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" />

            <input type="email" name="email" placeholder="Email" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" />

            <input type="password" name="password" placeholder="Password" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" />

            <input type="text" name="phone" placeholder="No HP"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" />

            <textarea name="address" placeholder="Alamat"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400"></textarea>

            <button type="submit"
                class="w-full bg-red-700 hover:bg-red-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                Daftar
            </button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
