<?php include '../header.php'; ?>
<div class="min-h-screen bg-gradient-to-b from-red-900 to-black text-black p-6">
    <div class="max-w-xl mx-auto bg-white shadow-xl rounded-2xl p-6">
        <h1 class="text-2xl font-bold mb-4 text-center">Pilih Metode Pembayaran</h1>

        <div class="grid gap-4">
            <a href="bank_transfer.php" class="block bg-red-700 hover:bg-red-800 text-white text-center py-3 rounded-xl font-semibold">
                Transfer Bank
            </a>

            <a href="ewallet.php" class="block bg-purple-600 hover:bg-purple-700 text-white text-center py-3 rounded-xl font-semibold">
                E-Wallet (OVO, DANA, GoPay)
            </a>

            <a href="qris.php" class="block bg-yellow-500 hover:bg-yellow-600 text-black text-center py-3 rounded-xl font-semibold">
                Pembayaran via QRIS
            </a>
        </div>
    </div>
</div>
<?php include '../footer.php'; ?>