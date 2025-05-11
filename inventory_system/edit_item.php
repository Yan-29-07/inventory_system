<?php
include 'config.php';

// Validasi dan ambil data barang
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();

if (!$item) {
    echo "Barang tidak ditemukan.";
    exit;
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
$locations = $pdo->query("SELECT * FROM locations")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $location_id = $_POST['location_id'];

    $update = $pdo->prepare("UPDATE items SET name = ?, category_id = ?, location_id = ? WHERE id = ?");
    $update->execute([$name, $category_id, $location_id, $id]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <h3>Edit Barang</h3>
            <form method="POST">
                <label for="name">Nama:</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($item['name']) ?>" required>

                <label for="category_id">Kategori:</label>
                <select id="category_id" name="category_id" required>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $item['category_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="location_id">Lokasi:</label>
                <select id="location_id" name="location_id" required>
                    <?php foreach ($locations as $loc): ?>
                        <option value="<?= $loc['id'] ?>" <?= $loc['id'] == $item['location_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($loc['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit">Simpan Perubahan</button>
                <a href="index.php" class="btn-custom" style="background-color:#6c757d; margin-left: 10px;">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>
