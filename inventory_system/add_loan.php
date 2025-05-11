<?php
include 'config.php';

// Fetch items
$items = $pdo->query("SELECT * FROM items")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = $_POST['item_id'];
    $borrower_name = $_POST['borrower_name'];
    $loan_date = $_POST['loan_date'];
    $return_date = $_POST['return_date'] ?? null; // Tambahan

    if (!empty($item_id) && !empty($borrower_name) && !empty($loan_date)) {
        $stmt = $pdo->prepare("INSERT INTO loans (item_id, borrower_name, loan_date, return_date) 
                               VALUES (:item_id, :borrower_name, :loan_date, :return_date)");
        $stmt->execute([
            'item_id' => $item_id,
            'borrower_name' => $borrower_name,
            'loan_date' => $loan_date,
            'return_date' => $return_date ?: null,
        ]);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Peminjaman</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar" style="padding: 10px;">
        <a href="index.php" style="text-decoration: none; font-weight: bold;">Dashboard</a>
    </div>

    <div class="container" style="max-width: 700px; margin: 50px auto;">
        <div class="card" style="padding: 25px;">
            <h2 style="text-align: center; margin-bottom: 20px;">Tambah Peminjaman</h2>
            <form method="POST">
                <div style="margin-bottom: 15px;">
                    <label for="item_id">Barang:</label>
                    <select id="item_id" name="item_id" required
                            style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                        <option value="">Pilih Barang</option>
                        <?php foreach ($items as $item): ?>
                            <option value="<?= $item['id'] ?>"><?= htmlspecialchars($item['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="borrower_name">Nama Peminjam:</label>
                    <input type="text" id="borrower_name" name="borrower_name" required
                           style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="loan_date">Tanggal Peminjaman:</label>
                    <input type="date" id="loan_date" name="loan_date" required
                           style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label for="return_date">Tanggal Pengembalian:</label>
                    <input type="date" id="return_date" name="return_date"
                           style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                </div>
                <div style="text-align: center;">
                    <button type="submit" class="btn-custom">Tambah</button>
                </div>
            </form>
            <div style="margin-top: 20px; text-align: center;">
                <a href="index.php" class="btn-custom" style="text-decoration: none; display: inline-block; padding: 10px 20px;">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>
