<?php
include 'config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

// Fetch data loan
$stmt = $pdo->prepare("SELECT * FROM loans WHERE id = ?");
$stmt->execute([$id]);
$loan = $stmt->fetch();

if (!$loan) {
    echo "Data peminjaman tidak ditemukan.";
    exit;
}

// Fetch items for dropdown
$items = $pdo->query("SELECT * FROM items")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = $_POST['item_id'];
    $borrower_name = $_POST['borrower_name'];
    $loan_date = $_POST['loan_date'];
    $return_date = $_POST['return_date'] ?? null;

    $stmt = $pdo->prepare("UPDATE loans SET item_id = ?, borrower_name = ?, loan_date = ?, return_date = ? WHERE id = ?");
    $stmt->execute([$item_id, $borrower_name, $loan_date, $return_date, $id]);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Peminjaman</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container" style="max-width: 700px; margin: 50px auto;">
    <div class="card">
        <h2 style="text-align: center;">Edit Peminjaman</h2>
        <form method="POST">
            <label>Barang:</label>
            <select name="item_id" required>
                <?php foreach ($items as $item): ?>
                    <option value="<?= $item['id'] ?>" <?= $loan['item_id'] == $item['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($item['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label>Nama Peminjam:</label>
            <input type="text" name="borrower_name" value="<?= htmlspecialchars($loan['borrower_name']) ?>" required>
            <label>Tanggal Peminjaman:</label>
            <input type="date" name="loan_date" value="<?= $loan['loan_date'] ?>" required>
            <label>Tanggal Pengembalian:</label>
            <input type="date" name="return_date" value="<?= $loan['return_date'] ?>">
            <button type="submit">Simpan</button>
        </form>
        <div style="margin-top: 10px;">
            <a href="index.php" class="btn-custom">Kembali</a>
        </div>
    </div>
</div>
</body>
</html>
