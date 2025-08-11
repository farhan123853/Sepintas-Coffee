<?php
// Tampilkan error (sementara, untuk debug)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Mulai sesi
session_start();

// Hapus semua data sesi
$_SESSION = [];

// Hancurkan sesi
session_destroy();

// Hapus cookie sesi jika disimpan di cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect ke halaman utama (index.php di luar folder customer)
header("Location: ../index.php");
exit;
?>
