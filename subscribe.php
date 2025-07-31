<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);
    // Simpan ke file atau database, di sini hanya simulasi
    file_put_contents('newsletter.txt', $email . "\n", FILE_APPEND);
    header('Location: index.php?subscribed=1');
    exit;
}
header('Location: index.php');
exit;
