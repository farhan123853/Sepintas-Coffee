<?php include '../header.php'; ?>

<div class="min-h-screen bg-gradient-to-b from-red-900 to-black text-black p-6">
    <div class="max-w-xl mx-auto bg-white shadow-xl rounded-2xl p-6">
        <h1 class="text-2xl font-bold mb-4 text-center">Transfer Bank</h1>

        <p class="mb-4 text-center">Silakan transfer ke rekening berikut:</p>

        <div class="bg-gray-100 p-4 rounded-xl mb-6 text-center">
            <p class="font-semibold text-lg">BCA - 1234567890</p>
            <p>a.n. Sepintas Coffee</p>
            <p class="text-sm text-gray-500 mt-2">Total: Rp<?= number_format($_GET['total'] ?? 0, 0, ',', '.'); ?></p>
        </div>

        <form action="proses_bayar.php" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="metode" value="bank_transfer">
            <input type="hidden" name="total" value="<?= $_GET['total'] ?? 0 ?>">

            <label class="block">
                <span class="block font-medium mb-1">Upload Bukti Transfer:</span>
                <input type="file" name="bukti" required class="w-full border rounded p-2">
            </label>

            <button type="submit" class="w-full bg-red-700 hover:bg-red-800 text-white py-2 rounded-xl font-semibold">
                Saya Sudah Bayar
            </button>
        </form>
    </div>
</div>

<?php include '../footer.php'; ?>